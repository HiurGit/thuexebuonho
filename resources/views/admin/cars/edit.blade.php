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
</style>
<script>
$(function() {
    var $container = $('#sortable-images');
    if (!$container.length) return;

    function updateMainImage() {
        var $items = $container.children('[data-id]');
        var $first = $items.first();
        $items.find('.card').css('border', '1px solid rgba(0,0,0,.125)');
        $items.find('.main-badge').remove();
        if ($first.length) {
            $first.find('.card').css('border', '2px solid #28a745');
            $first.find('.card').append('<span class="badge badge-success main-badge" style="position:absolute;top:4px;left:4px">Ảnh chính</span>');
        }
    }

    $container.children('[data-id]').each(function() {
        this.addEventListener('mousedown', function(e) {
            if (e.button !== 0) return;
            if (e.target.closest('.btn-del-img')) return;
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
            clone.style.left = (e.clientX - (e.clientX - rect.left)) + 'px';
            clone.style.top = (e.clientY - (e.clientY - rect.top)) + 'px';
            var offsetX = e.clientX - rect.left;
            var offsetY = e.clientY - rect.top;

            $(this).addClass('dragging');

            var moved = false;
            var overEl = null;

            function onMove(ev) {
                if ($(dragEl).closest('body').length === 0) return;
                if (!moved && (Math.abs(ev.clientX - startX) > 5 || Math.abs(ev.clientY - startY) > 5)) {
                    moved = true;
                }
                if (!moved) return;
                clone.style.left = (ev.clientX - offsetX) + 'px';
                clone.style.top = (ev.clientY - offsetY) + 'px';

                overEl = null;
                $container.find('.drop-target').removeClass('drop-target');
                $container.children('[data-id]').each(function() {
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

            function onUp(ev) {
                document.removeEventListener('mousemove', onMove);
                document.removeEventListener('mouseup', onUp);
                clone.remove();
                $container.find('.drop-target, .dragging').removeClass('drop-target dragging');

                if (moved && overEl && overEl !== dragEl) {
                    var all = $container.children('[data-id]').toArray();
                    var fromIdx = all.indexOf(dragEl);
                    var toIdx = all.indexOf(overEl);
                    if (fromIdx < toIdx) {
                        $(overEl).after(dragEl);
                    } else {
                        $(overEl).before(dragEl);
                    }
                    $container.children('[data-id]').each(function(i) {
                        $(this).find('.img-sort-input').val($(this).data('id'));
                    });
                    updateMainImage();
                }
            }

            document.addEventListener('mousemove', onMove);
            document.addEventListener('mouseup', onUp);
        });
    });

    $(document).on('click', '.btn-del-img', function() {
        if (!confirm('Xóa ảnh này?')) return;
        var id = $(this).data('id'), url = $(this).data('url');
        $.ajax({
            url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
            success: function() {
                $('#existing-img-' + id).fadeOut(400, function() {
                    $(this).remove();
                    updateMainImage();
                });
            }
        });
    });

    $('#car-images').on('change', function() {
        var files = this.files;
        var $preview = $('#image-preview-new').empty();
        if (!files.length) return;
        $.each(files, function(i, file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $preview.append(
                    '<div class="col-md-3 col-4 mb-3">' +
                        '<div class="card">' +
                            '<img src="' + e.target.result + '" class="img-fluid" style="height:120px;width:100%;object-fit:cover">' +
                            (i === 0 ? '<div class="card-footer p-1 text-center"><span class="badge badge-success">Ảnh chính</span></div>' : '') +
                        '</div>' +
                    '</div>'
                );
            };
            reader.readAsDataURL(file);
        });
    });
});
</script>
@stop
