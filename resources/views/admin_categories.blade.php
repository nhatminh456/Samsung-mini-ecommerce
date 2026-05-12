@extends('base')

@section('title', 'Quản Lí Danh Mục')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2>Quản Lí Danh Mục</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="/admin/category/add" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Thêm Danh Mục</a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('danger'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('danger') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card bg-dark text-light border-secondary">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th>Tên Danh Mục</th>
                        <th width="20%" class="text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->tenDM }}</td>
                        <td class="text-center">
                            <a href="/admin/category/edit/{{ $category->id }}" class="btn btn-sm btn-outline-info">Sửa</a>
                            
                            <form action="/admin/category/delete/{{ $category->id }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection