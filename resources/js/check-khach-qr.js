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

(function() {
    var scanBtn = document.getElementById('qr-scan-btn');
    var uploadBtn = document.getElementById('qr-upload-btn');
    var uploadFile = document.getElementById('qr-upload-file');
    var stopBtn = document.getElementById('qr-stop-btn');
    var captureBtn = document.getElementById('qr-capture-btn');
    var flashBtn = document.getElementById('qr-flash-btn');
    var reader = document.getElementById('qr-reader');
    var videoEl = document.getElementById('qr-video');
    var controls = document.getElementById('qr-controls');
    var statusEl = document.getElementById('qr-status');
    var scanning = false;
    var torchOn = false;
    var mediaStream = null;

    function setStatus(msg, isError) {
        if (!statusEl) return;
        statusEl.textContent = msg || '';
        statusEl.classList.toggle('hidden', !msg);
        statusEl.classList.toggle('text-[#e02923]', !!isError);
        statusEl.classList.toggle('text-app-muted', !isError);
    }

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

    function fillForm(info) {
        var nameEl = document.getElementById('report-name');
        var cccdEl = document.getElementById('report-cccd');
        var licenseEl = document.getElementById('report-license');
        var dobEl = document.getElementById('report-dob');
        var genderEl = document.getElementById('report-gender');
        var addressEl = document.getElementById('report-address');
        var issueEl = document.getElementById('report-issue-date');
        if (info.name && nameEl) nameEl.value = info.name;
        if (info.cccd && cccdEl) cccdEl.value = info.cccd;
        if (info.license && licenseEl) licenseEl.value = info.license;
        if (info.dob && dobEl) dobEl.value = info.dob;
        if (info.gender && genderEl) genderEl.value = info.gender;
        if (info.address && addressEl) addressEl.value = info.address;
        if (info.issueDate && issueEl) issueEl.value = info.issueDate;
    }

    function handleDecoded(rawText) {
        var decoded = decodeCccdQr(rawText);
        if (!decoded) {
            setStatus('Không giải mã được dữ liệu thẻ, vui lòng thử lại.', true);
            return;
        }
        if (decoded.indexOf('VNM_CC') >= 0 || decoded.indexOf('|') >= 0) {
            var info = parseCccd(decoded);
            if (info.name || info.cccd) {
                fillForm(info);
                setStatus('Đã đọc QR: ' + (info.name || '') + (info.cccd ? ' - ' + info.cccd : ''));
            } else {
                setStatus('QR không chứa thông tin CCCD hợp lệ.', true);
            }
        } else {
            setStatus('Đây không phải QR thẻ CCCD/Căn cước.', true);
        }
    }

    function getScreenRotation() {
        var angle = 0;
        if (window.screen && window.screen.orientation && typeof window.screen.orientation.angle === 'number') {
            angle = window.screen.orientation.angle;
        } else if (typeof window.orientation === 'number') {
            angle = window.orientation;
        }
        angle = ((angle % 360) + 360) % 360;
        if (angle === 90 || angle === 180 || angle === 270) return angle;
        return 0;
    }

    function drawVideoFrame(canvas, video) {
        var rotation = getScreenRotation();
        var rawWidth = video.videoWidth || 0;
        var rawHeight = video.videoHeight || 0;
        var displayWidth = video.clientWidth || 0;
        var displayHeight = video.clientHeight || 0;
        var rawLandscape = rawWidth >= rawHeight;
        var displayPortrait = displayHeight > displayWidth;

        // Mobile browsers often expose a landscape raw frame even when the user
        // is holding the device upright. In that case we rotate the captured
        // image so the saved CCCD preview matches what the user saw on screen.
        if (rotation === 0 && rawLandscape && displayPortrait) rotation = 90;

        var swapSides = rotation === 90 || rotation === 270;
        canvas.width = swapSides ? rawHeight : rawWidth;
        canvas.height = swapSides ? rawWidth : rawHeight;

        var ctx = canvas.getContext('2d');
        if (!ctx) return false;

        ctx.save();
        if (rotation === 90) {
            ctx.translate(canvas.width, 0);
            ctx.rotate(Math.PI / 2);
        } else if (rotation === 180) {
            ctx.translate(canvas.width, canvas.height);
            ctx.rotate(Math.PI);
        } else if (rotation === 270) {
            ctx.translate(0, canvas.height);
            ctx.rotate(-Math.PI / 2);
        }
        ctx.drawImage(video, 0, 0, rawWidth, rawHeight);
        ctx.restore();
        return true;
    }

    function captureCameraFrame() {
        var video = videoEl || (reader ? reader.querySelector('video') : null);
        if (!video || !video.videoWidth) return Promise.resolve(null);
        var canvas = document.createElement('canvas');
        var vw = video.videoWidth;
        var vh = video.videoHeight;
        var targetRatio = 16 / 10;
        var sx = 0;
        var sy = 0;
        var sw = vw;
        var sh = vh;
        if (vw / vh > targetRatio) {
            sw = Math.round(vh * targetRatio);
            sx = Math.round((vw - sw) / 2);
        } else {
            sh = Math.round(vw / targetRatio);
            sy = Math.round((vh - sh) / 2);
        }
        canvas.width = sw;
        canvas.height = sh;
        var ctx = canvas.getContext('2d');
        if (!ctx) return Promise.resolve(null);
        ctx.drawImage(video, sx, sy, sw, sh, 0, 0, sw, sh);
        return new Promise(function(resolve) {
            canvas.toBlob(function(blob) {
                if (!blob) return resolve(null);
                resolve(new File([blob], 'qr-capture-' + Date.now() + '.jpg', { type: 'image/jpeg' }));
            }, 'image/jpeg', 0.9);
        });
    }

    function startScan() {
        if (scanning) return;
        if (!reader) return;
        if (!window.isSecureContext) {
            setStatus('Camera chỉ hoạt động trên HTTPS hoặc localhost.', true);
            return;
        }
        if (scanBtn) scanBtn.disabled = true;
        reader.classList.remove('hidden');
        setStatus('Đang khởi động camera...');

        navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: { ideal: 'environment' }
            },
            audio: false
        }).then(function(stream) {
            mediaStream = stream;
            scanning = true;
            if (controls) controls.classList.remove('hidden');
            if (videoEl) {
                videoEl.srcObject = stream;
                videoEl.play().catch(function() {});
            }
            setStatus('Đưa CCCD vào khung ngang rồi bấm Chụp.');
        }).catch(function(err) {
            scanning = false;
            reader.classList.add('hidden');
            if (scanBtn) scanBtn.disabled = false;
            var msg = 'Không thể bật camera.';
            var e = String(err || '');
            if (/NotAllowedError/i.test(e)) {
                msg = 'Bạn cần cấp quyền truy cập camera.';
            } else if (/NotFoundError/i.test(e)) {
                msg = 'Không tìm thấy camera trên thiết bị.';
            } else if (/NotReadableError/i.test(e)) {
                msg = 'Camera đang được ứng dụng khác sử dụng.';
            }
            setStatus(msg, true);
        });
    }

    function stopScan() {
        scanning = false;
        torchOn = false;
        if (mediaStream) {
            mediaStream.getTracks().forEach(function(track) { track.stop(); });
            mediaStream = null;
        }
        if (videoEl) {
            try { videoEl.pause(); } catch (e) {}
            videoEl.srcObject = null;
        }
        if (reader) reader.classList.add('hidden');
        if (controls) controls.classList.add('hidden');
        if (scanBtn) scanBtn.disabled = false;
        setStatus('');
    }

    function toggleFlash() {
        if (!mediaStream) return;
        torchOn = !torchOn;
        var track = mediaStream.getVideoTracks()[0];
        if (!track) return;
        track.applyConstraints({ advanced: [{ torch: torchOn }] }).catch(function() {
            torchOn = !torchOn;
            setStatus('Thiết bị này không hỗ trợ đèn flash.', true);
        });
    }

    /* ====================== Upload pipeline (3 tầng) ====================== */

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

    function loadImage(file) {
        return new Promise(function(resolve, reject) {
            var url = URL.createObjectURL(file);
            var img = new Image();
            img.onload = function() { resolve({ img: img, url: url }); };
            img.onerror = function() { URL.revokeObjectURL(url); reject(new Error('load')); };
            img.src = url;
        });
    }

    async function robustDecode(img) {
        var nw = img.naturalWidth || img.width;
        var nh = img.naturalHeight || img.height;

        var nativeText = await nativeDetect(img);
        if (nativeText) return nativeText;

        await yieldPaint();
        setStatus('Đang phân tích ảnh...');
        var scaleText = scanScales(img, nw, nh);
        if (scaleText) return scaleText;

        await yieldPaint();
        setStatus('Đang tìm vùng QR trong ảnh...');
        var tileText = scanTiles(img, nw, nh);
        if (tileText) return tileText;

        return null;
    }

    async function recognizeInfoGemini(file) {
        setStatus('Đang đọc thông tin...');
        var fd = new FormData();
        fd.append('image', file);

        var geminiUrl = window.__CHECK_KHACH_GEMINI_OCR_URL || '/check/ocr-gemini';
        var res = await fetch(geminiUrl, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: fd
        });

        var data = await res.json().catch(function() { return {}; });
        if (res.status === 429) {
            throw new Error('Bạn đã thử quá nhiều lần trong thời gian ngắn, vui lòng đợi vài phút rồi thử lại.');
        }
        if (!res.ok || !data.success) {
            throw new Error(data.message || 'gemini-failed');
        }

        return mapOcrFields(data.fields || {});
    }

    function mapOcrFields(fields) {
        if (!fields.name && !fields.cccd) return null;
        return {
            name: fields.name || '',
            cccd: fields.cccd || '',
            license: fields.license || '',
            dob: fields.dob || '',
            gender: fields.gender || '',
            address: fields.address || '',
            issueDate: fields.issue_date || '',
        };
    }

    async function recognizeInfoOpenAI(file) {
        setStatus('Đang đọc thông tin bằng ChatGPT...');
        var fd = new FormData();
        fd.append('image', file);

        var openaiUrl = window.__CHECK_KHACH_OPENAI_OCR_URL || '/check/ocr-openai';
        var res = await fetch(openaiUrl, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: fd
        });

        var data = await res.json().catch(function() { return {}; });
        if (res.status === 429) {
            throw new Error('Bạn đã thử quá nhiều lần trong thời gian ngắn, vui lòng đợi vài phút rồi thử lại.');
        }
        if (!res.ok || !data.success) {
            throw new Error(data.message || 'openai-failed');
        }

        return mapOcrFields(data.fields || {});
    }

    async function recognizeInfo(file) {
        var openaiEnabled = !!(window.__CHECK_KHACH_OPENAI_OCR_URL);
        if (openaiEnabled) {
            try {
                var info = await recognizeInfoOpenAI(file);
                if (info) return info;
            } catch (e) {
                if (e && e.message === 'Bạn đã thử quá nhiều lần trong thời gian ngắn, vui lòng đợi vài phút rồi thử lại.') throw e;
            }
        }
        return recognizeInfoGemini(file);
    }

    async function processCapturedFile(file) {
        if (!file) return;
        setStatus('Đang đọc mã QR từ ảnh...');

        try {
            var loaded = await loadImage(file);
            var rawText = await robustDecode(loaded.img);
            if (rawText) {
                URL.revokeObjectURL(loaded.url);
                handleDecoded(rawText);
                if (window.addReportImage) window.addReportImage(file);
                return;
            }

            setStatus('Đang đọc thông tin...');
            var info = await recognizeInfo(file);
            URL.revokeObjectURL(loaded.url);
            if (info) {
                fillForm(info);
                if (window.addReportImage) window.addReportImage(file);
                setStatus('Đã đọc thông tin từ ảnh: ' + (info.name || '') + (info.cccd ? ' - ' + info.cccd : ''));
            } else {
                setStatus('Không nhận dạng được thông tin trên thẻ, vui lòng nhập tay.', true);
            }
        } catch (err) {
            setStatus((err && err.message) ? err.message : 'Không đọc được ảnh, vui lòng thử ảnh khác.', true);
        }
    }

    async function onScanFileSelected(e) {
        var input = e.target;
        var file = input && input.files && input.files[0];
        if (!file) return;
        input.value = '';
        if (scanning) stopScan();
        await processCapturedFile(file);
    }

    if (scanBtn) scanBtn.addEventListener('click', startScan);
    if (uploadBtn) uploadBtn.addEventListener('click', function() {
        if (uploadFile) uploadFile.click();
    });
    if (captureBtn) captureBtn.addEventListener('click', async function() {
        if (!scanning) return;
        var shot = await captureCameraFrame();
        if (!shot) {
            setStatus('Không chụp được ảnh từ camera.', true);
            return;
        }
        stopScan();
        await processCapturedFile(shot);
    });
    if (uploadFile) uploadFile.addEventListener('change', onScanFileSelected);
    if (stopBtn) stopBtn.addEventListener('click', stopScan);
    if (flashBtn) flashBtn.addEventListener('click', toggleFlash);

    document.addEventListener('paste', async function(e) {
        var items = e.clipboardData && e.clipboardData.items;
        if (!items) return;
        for (var i = 0; i < items.length; i++) {
            var item = items[i];
            if (item.kind === 'file' && item.type.indexOf('image/') === 0) {
                var blob = item.getAsFile();
                if (!blob) continue;
                var ext = (blob.type.split('/')[1] || 'png').replace('jpeg', 'jpg');
                var file = new File([blob], 'cccd-paste-' + Date.now() + '.' + ext, { type: blob.type });
                e.preventDefault();
                if (scanning) stopScan();
                await processCapturedFile(file);
                break;
            }
        }
    });
})();
