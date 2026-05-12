@extends('base')

@section('title', 'Sửa sản phẩm - Admin')

@section('content')
<div class="container my-5">
    <h2 class="mb-4"><i class="fas fa-edit"></i> Sửa sản phẩm: {{ $product->name }}</h2>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('/admin/product/edit/' . $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">ID sản phẩm:</label>
                            <input type="text" class="form-control" value="{{ $product->id }}" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm: *</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá (VNĐ): *</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục: *</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image_url" class="form-label">URL ảnh sản phẩm:</label>
                            <input type="text" class="form-control" id="image_url" name="image_url" value="{{ old('image_url', $product->image_url ?? '') }}">
                            <small class="text-muted">Giữ nguyên URL hiện tại hoặc upload file mới bên dưới.</small>
                        </div>

                        <div class="mb-3">
                            <label for="image_file" class="form-label">Upload ảnh mới từ máy:</label>
                            <input type="file" class="form-control" id="image_file" name="image_file" accept=".jpg,.jpeg,.png,.gif,.webp,.bmp">
                            <small class="text-muted">Nếu chọn file, ảnh mới sẽ ghi đè nguồn ảnh hiện tại.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">Số lượng kho: *</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}">
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả sản phẩm:</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                    <a href="{{ url('/admin/products') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection