@extends('adminlte::page')

@section('title', 'Thêm xe mới')

@section('content_header')
    <h1>Thêm xe mới</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.cars._form')
            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Lưu</button>
            <a href="{{ route('admin.cars.index') }}" class="btn btn-default">Hủy</a>
        </form>
    </div>
</div>
@stop

@section('js')
<style>
#image-preview-new { user-select: none; }
#image-preview-new > div.dragging { opacity: 0.3; }
#image-preview-new > div.drop-target .card { border: 2px solid #28a745 !important; }
#image-preview-new .card { position: relative; }
#image-preview-new .img-handle { cursor: move; }
</style>
<script>
$(function() {
    var $container = $('#image-preview-new');
    var $input = $('#car-images');
    if (!$container.length || !$input.length) return;

    var selectedFiles = [];

    function setInputFiles(input, files) {
        if (!input || !window.DataTransfer) return;
        var dt = new DataTransfer();
        (files || []).forEach(function(f) { if (f) dt.items.add(f); });
        input.files = dt.files;
    }

    function syncInput() {
        setInputFiles($input[0], selectedFiles);
    }

    function updateMainImage() {
        var $items = $container.children('[data-item]');
        var $first = $items.first();
        $items.find('.card').css('border', '1px solid rgba(0,0,0,.125)');
        $items.find('.main-badge').remove();
        if ($first.length) {
            $first.find('.card').css('border', '2px solid #28a745');
            $first.find('.card').append('<span class="badge badge-success main-badge" style="position:absolute;top:4px;left:4px;z-index:5">Ảnh chính</span>');
        }
    }

    function render() {
        $container.empty();
        selectedFiles.forEach(function(file) {
            var $box = $('<div class="col-md-3 col-4 mb-3" data-item="1"></div>');
            var $card = $('<div class="card"></div>');
            $card.append('<div class="bg-secondary text-white text-center img-handle py-1" style="font-size:12px;user-select:none"><i class="fas fa-grip-vertical"></i></div>');
            var $rel = $('<div style="position:relative"></div>');
            $rel.append('<img src="' + URL.createObjectURL(file) + '" class="img-fluid" style="height:120px;width:100%;object-fit:cover;display:block">');
            $rel.append('<button type="button" class="btn btn-sm btn-danger btn-remove-new" style="position:absolute;top:4px;right:4px;padding:0 6px;font-size:14px;line-height:1" title="Xóa">&times;</button>');
            $card.append($rel);
            $box.append($card);
            $box[0].__file = file;
            $container.append($box);
        });
        updateMainImage();
    }

    function syncFromDom() {
        selectedFiles = $container.children('[data-item]').map(function() { return this.__file; }).get();
        updateMainImage();
        syncInput();
    }

    $input.on('change', function() {
        var files = Array.prototype.slice.call(this.files || []);
        if (window.DataTransfer) this.value = '';
        if (!files.length) return;
        files.forEach(function(f) { selectedFiles.push(f); });
        render();
        syncInput();
    });

    $container.on('click', '.btn-remove-new', function() {
        $(this).closest('[data-item]').remove();
        syncFromDom();
    });

    $container.on('mousedown', '[data-item]', function(e) {
        if (e.button !== 0) return;
        if ($(e.target).closest('.btn-remove-new').length) return;
        e.preventDefault();

        var dragEl = this;
        var startX = e.clientX, startY = e.clientY;
        var clone = this.cloneNode(true);
        clone.style.position = 'fixed';
        clone.style.pointerEvents = 'none';
        clone.style.zIndex = 9999;
        clone.style.opacity = '0.8';
        clone.style.width = this.offsetWidth + 'px';
        clone.style.transform = 'rotate(2deg)';
        document.body.appendChild(clone);

        var rect = this.getBoundingClientRect();
        var offsetX = e.clientX - rect.left;
        var offsetY = e.clientY - rect.top;
        clone.style.left = rect.left + 'px';
        clone.style.top = rect.top + 'px';

        $(this).addClass('dragging');
        var moved = false;
        var overEl = null;

        function onMove(ev) {
            if (!moved && (Math.abs(ev.clientX - startX) > 5 || Math.abs(ev.clientY - startY) > 5)) {
                moved = true;
            }
            if (!moved) return;
            clone.style.left = (ev.clientX - offsetX) + 'px';
            clone.style.top = (ev.clientY - offsetY) + 'px';

            overEl = null;
            $container.find('.drop-target').removeClass('drop-target');
            $container.children('[data-item]').each(function() {
                var r = this.getBoundingClientRect();
                if (ev.clientX >= r.left && ev.clientX <= r.right && ev.clientY >= r.top && ev.clientY <= r.bottom) {
                    if (this !== dragEl) {
                        overEl = this;
                        $(this).addClass('drop-target');
                    }
                    return false;
                }
            });
        }

        function onUp() {
            document.removeEventListener('mousemove', onMove);
            document.removeEventListener('mouseup', onUp);
            clone.remove();
            $container.find('.drop-target, .dragging').removeClass('drop-target dragging');

            if (moved && overEl && overEl !== dragEl) {
                var all = $container.children('[data-item]').toArray();
                var fromIdx = all.indexOf(dragEl);
                var toIdx = all.indexOf(overEl);
                if (fromIdx < toIdx) {
                    $(overEl).after(dragEl);
                } else {
                    $(overEl).before(dragEl);
                }
                syncFromDom();
            }
        }

        document.addEventListener('mousemove', onMove);
        document.addEventListener('mouseup', onUp);
    });

    $input.closest('form').on('submit', syncInput);
});
</script>
@stop
