import { inflate, inflateRaw, ungzip } from 'pako';
import {
    BarcodeFormat,
    BinaryBitmap,
    DecodeHintType,
    GlobalHistogramBinarizer,
    HybridBinarizer,
    InvertedLuminanceSource,
    QRCodeReader,
    RGBLuminanceSource,
} from '@zxing/library';

function base64ToBytes(b64) {
    var bin = atob(b64);
    var bytes = new Uint8Array(bin.length);
    for (var i = 0; i < bin.length; i++) bytes[i] = bin.charCodeAt(i);
    return bytes;
}

function utf8Decode(bytes) {
    try {
        return new TextDecoder('utf-8').decode(bytes);
    } catch (e) {
        return decodeURIComponent(escape(String.fromCharCode.apply(null, bytes)));
    }
}

function decodeCccdQr(raw) {
    if (!raw) return null;
    var text = raw.trim();
    var candidates = [];

    if (text.indexOf('|') >= 0) candidates.push(text);

    if (text.indexOf('VNM_CC') >= 0) candidates.push(text);

    try {
        var bytes = base64ToBytes(text);
        var attempts = [
            ['inflate', bytes],
            ['inflate', bytes.subarray(1)],
            ['inflate', bytes.subarray(2)],
            ['inflateRaw', bytes],
            ['inflateRaw', bytes.subarray(1)],
            ['ungzip', bytes],
            ['ungzip', bytes.subarray(1)],
        ];
        for (var i = 0; i < attempts.length; i++) {
            try {
                var out;
                if (attempts[i][0] === 'inflate') out = inflate(attempts[i][1]);
                else if (attempts[i][0] === 'inflateRaw') out = inflateRaw(attempts[i][1]);
                else out = ungzip(attempts[i][1]);
                var s = utf8Decode(out);
                if (s && s.length > 0) candidates.push(s);
            } catch (e) {}
        }
    } catch (e) {}

    for (var j = 0; j < candidates.length; j++) {
        if (candidates[j].indexOf('VNM_CC') >= 0) return candidates[j];
    }
    for (var k = 0; k < candidates.length; k++) {
        if (candidates[k].indexOf('|') >= 0) return candidates[k];
    }
    return candidates.length ? candidates[0] : null;
}

function parseCccd(decoded) {
    var fields = (decoded || '').split('|');
    var out = { name: '', cccd: '', dob: '', gender: '', address: '', issueDate: '' };
    var clean = [];
    for (var i = 0; i < fields.length; i++) clean.push((fields[i] || '').trim());

    function fmt8(s) {
        return s.slice(0, 2) + '/' + s.slice(2, 4) + '/' + s.slice(4, 8);
    }

    if (/^[0-9]{12}$/.test(clean[0])) {
        out.cccd = clean[0];
        if (clean[2]) out.name = clean[2];
        if (/^\d{8}$/.test(clean[3])) out.dob = fmt8(clean[3]);
        else if (/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(clean[3])) out.dob = clean[3];
        if (/^(Nam|Nữ|Male|Female)$/i.test(clean[4])) {
            out.gender = clean[4] === 'Male' ? 'Nam' : clean[4] === 'Female' ? 'Nữ' : clean[4];
        }
        if (clean[5] && !/^[0-9]{8}$/.test(clean[5])) out.address = clean[5];
        for (var j = 6; j < clean.length; j++) {
            if (/^\d{8}$/.test(clean[j]) && !out.issueDate) out.issueDate = fmt8(clean[j]);
        }
        return out;
    }

    var used = {};
    for (var k = 0; k < clean.length; k++) {
        var f = clean[k];
        if (!f || used[f]) continue;
        if (/^[0-9]{12}$/.test(f) && !out.cccd) { out.cccd = f; used[f] = 1; continue; }
        if (/^[0-9]{9}$/.test(f)) { used[f] = 1; continue; }
        if (/^\d{8}$/.test(f) && !out.dob) { out.dob = fmt8(f); used[f] = 1; continue; }
        if (/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(f) && !out.dob) { out.dob = f; used[f] = 1; continue; }
        if (/^(Nam|Nữ|Male|Female)$/i.test(f) && !out.gender) {
            out.gender = f === 'Male' ? 'Nam' : f === 'Female' ? 'Nữ' : f;
            used[f] = 1;
            continue;
        }
        if (!out.name && !/^[0-9]{6,12}$/.test(f) && !/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(f)) {
            out.name = f;
            used[f] = 1;
        }
    }
    for (var m = 0; m < clean.length; m++) {
        var g = clean[m];
        if (!g || used[g]) continue;
        if (/^[0-9]{6,12}$/.test(g)) continue;
        if (/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(g)) continue;
        if (/^(Nam|Nữ|Male|Female)$/i.test(g)) continue;
        if (g.length < 5) continue;
        out.address = g;
        used[g] = 1;
        break;
    }
    for (var n = 0; n < clean.length; n++) {
        var h = clean[n];
        if (h && /^\d{8}$/.test(h) && !used[h] && !out.issueDate) {
            out.issueDate = fmt8(h);
            used[h] = 1;
        }
    }

    return out;
}

function makeQRHints() {
    return new Map([
        [DecodeHintType.TRY_HARDER, true],
        [DecodeHintType.POSSIBLE_FORMATS, [BarcodeFormat.QR_CODE]],
    ]);
}

function decodeLuminance(lumArray, width, height, invert, binarizerName) {
    var lum = new RGBLuminanceSource(lumArray, width, height);
    if (invert) lum = new InvertedLuminanceSource(lum);
    var bmp = new BinaryBitmap(
        binarizerName === 'global' ? new GlobalHistogramBinarizer(lum) : new HybridBinarizer(lum)
    );
    var result = new QRCodeReader().decode(bmp, makeQRHints());
    return result ? result.getText() : null;
}

function grayscaleFromCanvas(canvas) {
    var ctx = canvas.getContext('2d', { willReadFrequently: true });
    var w = canvas.width;
    var h = canvas.height;
    var data = ctx.getImageData(0, 0, w, h).data;
    var lum = new Uint8ClampedArray(w * h);
    for (var i = 0, j = 0; i < data.length; i += 4, j++) {
        var a = data[i + 3];
        if (a === 0) { lum[j] = 255; continue; }
        lum[j] = (306 * data[i] + 601 * data[i + 1] + 117 * data[i + 2] + 0x200) >> 10;
    }
    return lum;
}

function autocontrast(lum, w, h) {
    var n = w * h;
    var hist = new Uint32Array(256);
    for (var i = 0; i < n; i++) hist[lum[i]]++;
    var lo = 0, hi = 255, acc = 0;
    for (var k = 0; k < 256; k++) { acc += hist[k]; if (acc >= n * 0.01) { lo = k; break; } }
    acc = 0;
    for (var k2 = 255; k2 >= 0; k2--) { acc += hist[k2]; if (acc >= n * 0.01) { hi = k2; break; } }
    var range = (hi - lo) > 0 ? (hi - lo) : 1;
    var out = new Uint8ClampedArray(n);
    for (var j = 0; j < n; j++) {
        var v = lum[j];
        out[j] = v <= lo ? 0 : (v >= hi ? 255 : (((v - lo) * 255 / range) | 0));
    }
    return out;
}

function renderToCanvas(img, sx, sy, sw, sh, scale) {
    var cw = Math.max(1, Math.round(sw * scale));
    var ch = Math.max(1, Math.round(sh * scale));
    var canvas = document.createElement('canvas');
    canvas.width = cw;
    canvas.height = ch;
    var ctx = canvas.getContext('2d', { willReadFrequently: true });
    ctx.imageSmoothingEnabled = false;
    ctx.drawImage(img, sx, sy, sw, sh, 0, 0, cw, ch);
    return canvas;
}

function tryDecodeCanvas(canvas, opts) {
    var binarizers = (opts && opts.binarizers) || ['hybrid', 'global'];
    var invertMax = (opts && opts.invert) ? 1 : 0;
    var withContrast = !!(opts && opts.contrast);
    var lum = grayscaleFromCanvas(canvas);
    var variants = [lum];
    if (withContrast) variants.push(autocontrast(lum, canvas.width, canvas.height));
    for (var v = 0; v < variants.length; v++) {
        for (var inv = 0; inv <= invertMax; inv++) {
            for (var b = 0; b < binarizers.length; b++) {
                try {
                    var text = decodeLuminance(variants[v], canvas.width, canvas.height, inv === 1, binarizers[b]);
                    if (text) return text;
                } catch (e) {}
            }
        }
    }
    return null;
}

function nativeDetect(img) {
    if (!('BarcodeDetector' in window)) return Promise.resolve(null);
    return new Promise(function(resolve) {
        try {
            var detector = new window.BarcodeDetector({ formats: ['qr_code'] });
            detector.detect(img).then(function(detections) {
                for (var i = 0; i < detections.length; i++) {
                    if (detections[i].rawValue) { resolve(detections[i].rawValue); return; }
                }
                resolve(null);
            }).catch(function() { resolve(null); });
        } catch (e) { resolve(null); }
    });
}

function yieldPaint() {
    return new Promise(function(resolve) { setTimeout(resolve, 30); });
}

function scanScales(img, nw, nh) {
    var maxDim = Math.max(nw, nh);
    var scales;
    if (maxDim > 5000) scales = [0.75, 0.5, 0.35, 0.25];
    else if (maxDim > 2400) scales = [1, 0.75, 0.5];
    else if (maxDim > 1600) scales = [1, 0.75];
    else scales = [1];

    for (var s = 0; s < scales.length; s++) {
        var scale = scales[s];
        var w = Math.round(nw * scale);
        var h = Math.round(nh * scale);
        if (w * h > 6000 * 6000) continue;
        var canvas = renderToCanvas(img, 0, 0, nw, nh, scale);
        var text = tryDecodeCanvas(canvas, { binarizers: ['hybrid', 'global'] });
        if (text) return text;
    }

    var bestScale = Math.min(1, 2000 / maxDim);
    var cw2 = Math.round(nw * bestScale);
    var ch2 = Math.round(nh * bestScale);
    if (cw2 * ch2 <= 6000 * 6000) {
        var canvas2 = renderToCanvas(img, 0, 0, nw, nh, bestScale);
        var text2 = tryDecodeCanvas(canvas2, { binarizers: ['hybrid', 'global'], contrast: true, invert: true });
        if (text2) return text2;
    }
    return null;
}

function tileParams(size) {
    var tile = 700;
    if (size <= tile) return null;
    var target = 60;
    var step = Math.ceil(Math.sqrt(((size - tile) * (size - tile)) / target));
    if (step < 200) step = 200;
    var starts = [];
    for (var p = 0; p + tile <= size; p += step) starts.push(p);
    var last = size - tile;
    if (starts[starts.length - 1] < last) starts.push(last);
    return { tile: tile, starts: starts };
}

function scanTiles(img, nw, nh) {
    var px = tileParams(nw);
    var py = tileParams(nh);
    if (!px || !py) {
        var smallCanvas = renderToCanvas(img, 0, 0, nw, nh, Math.min(3, Math.max(1, Math.floor(1200 / Math.max(nw, nh)))));
        var smallText = tryDecodeCanvas(smallCanvas, { binarizers: ['hybrid', 'global'], contrast: true, invert: true });
        if (smallText) return smallText;
        return null;
    }
    var tile = px.tile;
    for (var yi = 0; yi < py.starts.length; yi++) {
        var y = py.starts[yi];
        for (var xi = 0; xi < px.starts.length; xi++) {
            var x = px.starts[xi];
            var c1 = renderToCanvas(img, x, y, tile, tile, 1);
            var t1 = tryDecodeCanvas(c1, { binarizers: ['hybrid', 'global'] });
            if (t1) return t1;
        }
    }
    for (var yi2 = 0; yi2 < py.starts.length; yi2++) {
        var y2 = py.starts[yi2];
        for (var xi2 = 0; xi2 < px.starts.length; xi2++) {
            var x2 = px.starts[xi2];
            var c2 = renderToCanvas(img, x2, y2, tile, tile, 2);
            var t2 = tryDecodeCanvas(c2, { binarizers: ['hybrid', 'global'], contrast: true, invert: true });
            if (t2) return t2;
        }
    }
    return null;
}

function robustDecode(img) {
    var nw = img.naturalWidth || img.width;
    var nh = img.naturalHeight || img.height;

    return nativeDetect(img).then(function(nativeText) {
        if (nativeText) return nativeText;
        return yieldPaint().then(function() {
            var scaleText = scanScales(img, nw, nh);
            if (scaleText) return scaleText;
            return yieldPaint().then(function() {
                var tileText = scanTiles(img, nw, nh);
                return tileText || null;
            });
        });
    });
}

function loadImage(file) {
    return new Promise(function(resolve, reject) {
        var url = URL.createObjectURL(file);
        var img = new Image();
        img.onload = function() { resolve({ img: img, url: url }); };
        img.onerror = function() { URL.revokeObjectURL(url); reject(new Error('load')); };
        img.src = url;
    });
}

function decodeFile(file) {
    if (!file) return Promise.resolve(null);
    return loadImage(file).then(function(loaded) {
        URL.revokeObjectURL(loaded.url);
        return robustDecode(loaded.img).then(function(rawText) {
            if (!rawText) return null;
            var decoded = decodeCccdQr(rawText);
            if (!decoded) return null;
            var info = parseCccd(decoded);
            if (!info.cccd && !info.name) return null;
            return info;
        });
    }).catch(function() { return null; });
}

window.__ContractCardReader = {
    decode: decodeFile,
    parse: decodeCccdQr,
};