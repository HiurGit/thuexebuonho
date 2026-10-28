@extends('adminlte::page')
 
@section('title', 'Sửa xe: ' . $car->name)

@section('content_header')
    <h1>Sửa xe: {{ $car->name }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.cars.update', $car) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.cars._form')
            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Cập nhật</button>
            <a href="{{ route('admin.cars.index') }}" class="btn btn-default">Hủy</a>
        </form>
    </div>
</div>
@stop

@section('js')
<style>
#sortable-images { user-select: none; }
#sortable-images > div.dragging { opacity: 0.3; }
#sortable-images > div.drop-target .card { border: 2px solid #28a745 !important; }
#sortable-images .card { position: relative; }
#sortable-images .img-handle { cursor: move; }
</style>
<script>
$(function() {
    var $container = $('#sortable-images');
    var $input = $('#car-images');
    if (!$container.length || !$input.length) return;

    var newFiles = [];

    function setInputFiles(input, files) {
        if (!input || !window.DataTransfer) return;
        var dt = new DataTransfer();
        (files || []).forEach(function(f) { if (f) dt.items.add(f); });
        input.files = dt.files;
    }

    function updateMainImage() {
        var $items = $container.children('[data-key]');
        var $first = $items.first();
        $items.find('.card').css('border', '1px solid rgba(0,0,0,.125)');
        $items.find('.main-badge').remove();
        if ($first.length) {
            $first.find('.card').css('border', '2px solid #28a745');
            $first.find('.card').append('<span class="badge badge-success main-badge" style="position:absolute;top:4px;left:4px;z-index:5">Ảnh chính</span>');
        }
    }

    function syncSortInputs() {
        var newIdx = 0;
        var orderedNew = [];
        $container.children('[data-key]').each(function() {
            var $tile = $(this);
            if ($tile.attr('data-new') === '1') {
                var key = 'new:' + newIdx;
                $tile.attr('data-key', key);
                $tile.find('.img-sort-input').val(key);
                orderedNew.push($tile[0].__file);
                newIdx++;
            } else {
                var id = $tile.attr('data-id');
                var key = 'existing:' + id;
                $tile.attr('data-key', key);
                $tile.find('.img-sort-input').val(key);
            }
        });
        newFiles = orderedNew;
        setInputFiles($input[0], newFiles);
    }

    function addNewTiles(files) {
        files.forEach(function(file) {
            var $box = $('<div class="col-md-3 col-4 mb-3" data-key="new:0" data-new="1"></div>');
            var $card = $('<div class="card"></div>');
            $card.append('<div class="bg-secondary text-white text-center img-handle py-1" style="font-size:12px;user-select:none"><i class="fas fa-grip-vertical"></i></div>');
            var $rel = $('<div style="position:relative"></div>');
            $rel.append('<img src="' + URL.createObjectURL(file) + '" class="img-fluid" style="height:120px;width:100%;object-fit:cover;display:block">');
            $rel.append('<button type="button" class="btn btn-sm btn-danger btn-del-new" style="position:absolute;top:4px;right:4px;padding:0 6px;font-size:14px;line-height:1" title="Xóa">&times;</button>');
            $card.append($rel);
            $card.append('<input type="hidden" name="image_order[]" value="new:0" class="img-sort-input">');
            $box.append($card);
            $box[0].__file = file;
            $container.append($box);
        });
        syncSortInputs();
        updateMainImage();
    }

    $input.on('change', function() {
        var files = Array.prototype.slice.call(this.files || []);
        if (window.DataTransfer) this.value = '';
        if (!files.length) return;
        addNewTiles(files);
    });

    $container.on('click', '.btn-del-new', function() {
        $(this).closest('[data-key]').remove();
        syncSortInputs();
        updateMainImage();
    });

    $(document).on('click', '.btn-del-img', function() {
        if (!confirm('Xóa ảnh này?')) return;
        var url = $(this).data('url');
        var $tile = $(this).closest('[data-key]');
        $.ajax({
            url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
            success: function() {
                $tile.fadeOut(400, function() {
                    $(this).remove();
                    syncSortInputs();
                    updateMainImage();
                });
            }
        });
    });

    $container.on('mousedown', '[data-key]', function(e) {
        if (e.button !== 0) return;
        if ($(e.target).closest('.btn-del-img, .btn-del-new').length) return;
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
            $container.children('[data-key]').each(function() {
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
                var all = $container.children('[data-key]').toArray();
                var fromIdx = all.indexOf(dragEl);
                var toIdx = all.indexOf(overEl);
                if (fromIdx < toIdx) {
                    $(overEl).after(dragEl);
                } else {
                    $(overEl).before(dragEl);
                }
                syncSortInputs();
                updateMainImage();
            }
        }

        document.addEventListener('mousemove', onMove);
        document.addEventListener('mouseup', onUp);
    });

    $container.closest('form').on('submit', syncSortInputs);

    syncSortInputs();
    updateMainImage();
});
</script>
@stop
