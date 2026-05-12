@extends('base')

@section('title', 'Thêm sản phẩm mới - Admin')

@section('content')
<div class="container my-5">
    <h2 class="mb-4"><i class="fas fa-plus"></i> Thêm sản phẩm mới</h2>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('/admin/product/add') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm: *</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá (VNĐ): *</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục: *</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image_url" class="form-label">URL ảnh sản phẩm:</label>
                            <input type="text" class="form-control" id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="https://example.com/image.jpg">
                            <small class="text-muted">Dán link ảnh online hoặc upload file bên dưới.</small>
                        </div>

                        <div class="mb-3">
                            <label for="image_file" class="form-label">Upload ảnh từ máy:</label>
                            <input type="file" class="form-control" id="image_file" name="image_file" accept=".jpg,.jpeg,.png,.gif,.webp,.bmp">
                            <small class="text-muted">Nếu chọn file, hệ thống sẽ ưu tiên file thay vì URL.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">Số lượng kho: *</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả sản phẩm:</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu sản phẩm
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