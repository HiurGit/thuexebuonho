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
<script>
$(function() {
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
