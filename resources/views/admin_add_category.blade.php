@extends('base')

@section('title', 'Thêm Danh Mục')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card bg-dark text-light border-secondary">
            <div class="card-header border-secondary">
                <h4 class="mb-0">Thêm Danh Mục Mới</h4>
            </div>
            <div class="card-body">
                <form action="/admin/category/add" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="tenDM" class="form-label">Tên Danh Mục</label>
                        <input type="text" class="form-control bg-dark text-light border-secondary @error('tenDM') is-invalid @enderror" 
                               id="tenDM" name="tenDM" value="{{ old('tenDM') }}" required>
                        @error('tenDM')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/admin/categories" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Thêm Danh Mục</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection