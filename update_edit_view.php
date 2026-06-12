<?php
$content = <<<'EOD'
@extends('base')

@section('title', 'Sửa sản phẩm - Admin')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-edit"></i> Sửa sản phẩm: <span class="text-primary">{{ $product->name }}</span></h2>
        <a href="{{ url('/admin/products') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>
    </div>
    
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="POST" action="{{ url('/admin/product/edit/' . $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <h5 class="text-primary mb-3 border-bottom pb-2"><i class="fas fa-info-circle"></i> 1. Thông tin chung</h5>
                <div class="row">
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label fw-bold">ID:</label>
                            <input type="text" class="form-control bg-light" value="{{ $product->id }}" disabled>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên dòng máy: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Danh mục: <span class="text-danger">*</span></label>
                            <select class="form-select" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (old('category_id', $product->category_id) == $cat->id) ? 'selected' : '' }}>
                                    {{ $cat->name ?? $cat->tenDM }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="bestSeller" name="bestSeller" value="1" {{ $product->is_bestseller ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-danger" for="bestSeller"><i class="fas fa-fire"></i> Đánh dấu là sản phẩm Best Seller</label>
                        </div>
                    </div>
                </div>

                <h5 class="text-success mt-4 mb-3 border-bottom pb-2"><i class="fas fa-box"></i> 2. Phiên bản & Ảnh theo màu</h5>
                
                <div id="variants-container">
                    @foreach($product->variants as $variant)
                    <div class="variant-row card border-primary mb-3">
                        <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between">
                            <span>Phiên bản đã có (ID: {{ $variant->id }})</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Màu sắc:</label>
                                    <input type="text" class="form-control" name="variants[{{ $variant->id }}][color]" value="{{ $variant->color }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Dung lượng:</label>
                                    <input type="text" class="form-control" name="variants[{{ $variant->id }}][storage]" value="{{ $variant->storage }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Giá (VNĐ): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="variants[{{ $variant->id }}][price]" required min="1" value="{{ $variant->price }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Số lượng kho:</label>
                                    <input type="number" class="form-control" name="variants[{{ $variant->id }}][stock_quantity]" min="0" value="{{ $variant->stock_quantity }}">
                                </div>
                            </div>
                            
                            @if($variant->images->count() > 0)
                            <div class="mt-3">
                                <label class="form-label fw-bold">Ảnh hiện tại:</label>
                                <div class="d-flex flex-wrap gap-2 mb-2 p-2 border rounded bg-light">
                                    @foreach($variant->images as $img)
                                    <div class="position-relative">
                                        <img src="{{ asset($img->image_path) }}" alt="Product Image" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="mt-3">
                                <label class="form-label fw-bold">Thêm ảnh mới cho phiên bản này:</label>
                                <div class="btn-group mb-2 d-block" role="group">
                                    <button type="button" class="btn btn-sm btn-primary tab-btn active" onclick="switchTab(this, 'upload', '{{ $variant->id }}')">
                                        <i class="fas fa-upload"></i> Upload file
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary tab-btn" onclick="switchTab(this, 'url', '{{ $variant->id }}')">
                                        <i class="fas fa-link"></i> Nhập URL
                                    </button>
                                </div>

                                <div class="tab-panel tab-upload" data-variant="{{ $variant->id }}">
                                    <input type="file" class="form-control" name="variant_images[{{ $variant->id }}][]" accept="image/*" multiple>
                                </div>

                                <div class="tab-panel tab-url d-none" data-variant="{{ $variant->id }}">
                                    <div class="url-list" id="url-list-{{ $variant->id }}">
                                        <div class="input-group mb-2 url-item">
                                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                                            <input type="url" class="form-control url-input" name="variant_image_urls[{{ $variant->id }}][]" placeholder="https://example.com/anh.jpg" oninput="previewUrl(this)">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeUrlItem(this)"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mb-2" onclick="addUrlInput('{{ $variant->id }}')"><i class="fas fa-plus"></i> Thêm URL</button>
                                    <div class="url-preview d-flex flex-wrap gap-2 mt-2" id="url-preview-{{ $variant->id }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mb-4">
                    <button type="button" class="btn btn-outline-success" onclick="addVariant()">
                        <i class="fas fa-plus"></i> Thêm phiên bản mới
                    </button>
                </div>

                <h5 class="text-info mt-2 mb-3 border-bottom pb-2"><i class="fas fa-align-left"></i> 3. Mô tả sản phẩm</h5>
                <div class="mb-4 mt-2">
                    <textarea class="form-control" name="description" rows="5" placeholder="Nhập mô tả chi tiết...">{{ old('description', $product->description ?? '') }}</textarea>
                </div>
                
                <div class="d-flex justify-content-center gap-3 mt-5">
                    <button type="submit" class="btn btn-warning px-5 fw-bold text-dark">
                        <i class="fas fa-save"></i> Lưu Thay Đổi
                    </button>
                    <a href="{{ url('/admin/products') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.url-preview img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #dee2e6;
}
</style>

<script>
let newVariantCount = 0;

function switchTab(btn, type, id) {
    const variantCard = btn.closest('.card-body');
    variantCard.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('active', 'btn-primary', 'btn-success');
        if (b.textContent.includes('Upload')) {
            b.classList.add(id.toString().startsWith('new_') ? 'btn-outline-success' : 'btn-outline-primary');
        } else {
            b.classList.add(id.toString().startsWith('new_') ? 'btn-outline-success' : 'btn-outline-primary');
        }
    });
    btn.classList.add('active');
    btn.classList.remove('btn-outline-primary', 'btn-outline-success');
    btn.classList.add(id.toString().startsWith('new_') ? 'btn-success' : 'btn-primary');

    variantCard.querySelectorAll('.tab-panel').forEach(p => p.classList.add('d-none'));
    variantCard.querySelector(`.tab-${type}`).classList.remove('d-none');
}

function previewUrl(input) {
    const panel = input.closest('.tab-url');
    const id = panel.dataset.variant;
    const container = document.getElementById(`url-preview-${id}`);
    
    container.innerHTML = '';
    const inputs = panel.querySelectorAll('.url-input');
    inputs.forEach(ipt => {
        const val = ipt.value.trim();
        if (val) {
            container.innerHTML += `<img src="${val}" onerror="this.outerHTML=''">`;
        }
    });
}

function addUrlInput(id) {
    const list = document.getElementById(`url-list-${id}`);
    const namePrefix = id.toString().startsWith('new_') ? 'new_variant_image_urls' : 'variant_image_urls';
    const indexStr = id.toString().replace('new_', '');
    const finalName = id.toString().startsWith('new_') ? `new_variant_image_urls[${indexStr}][]` : `variant_image_urls[${id}][]`;

    const html = `
        <div class="input-group mb-2 url-item">
            <span class="input-group-text"><i class="fas fa-image"></i></span>
            <input type="url" class="form-control url-input" name="${finalName}" placeholder="https://example.com/anh.jpg" oninput="previewUrl(this)">
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeUrlItem(this)"><i class="fas fa-times"></i></button>
        </div>
    `;
    list.insertAdjacentHTML('beforeend', html);
}

function removeUrlItem(btn) {
    const item = btn.closest('.url-item');
    const panel = item.closest('.tab-url');
    item.remove();
    const firstInput = panel.querySelector('.url-input');
    if (firstInput) previewUrl(firstInput);
}

function addVariant() {
    const id = `new_${newVariantCount}`;
    const container = document.getElementById('variants-container');
    const html = `
        <div class="variant-row card border-success mb-3">
            <div class="card-header bg-success text-white fw-bold d-flex justify-content-between">
                <span>Phiên bản thêm mới</span>
                <button type="button" class="btn btn-sm btn-danger px-2 py-0" onclick="this.closest('.variant-row').remove()"><i class="fas fa-trash"></i> Xóa</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Màu sắc:</label>
                        <input type="text" class="form-control" name="new_variants[${newVariantCount}][color]" placeholder="VD: Xanh">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Dung lượng:</label>
                        <input type="text" class="form-control" name="new_variants[${newVariantCount}][storage]" placeholder="VD: 512GB">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Giá (VNĐ): <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="new_variants[${newVariantCount}][price]" required min="1">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Số lượng kho:</label>
                        <input type="number" class="form-control" name="new_variants[${newVariantCount}][stock_quantity]" value="0" min="0">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label fw-bold">Ảnh cho phiên bản này:</label>
                    
                    <div class="btn-group mb-2 d-block" role="group">
                        <button type="button" class="btn btn-sm btn-success tab-btn active" onclick="switchTab(this, 'upload', '${id}')">
                            <i class="fas fa-upload"></i> Upload file
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success tab-btn" onclick="switchTab(this, 'url', '${id}')">
                            <i class="fas fa-link"></i> Nhập URL
                        </button>
                    </div>

                    <div class="tab-panel tab-upload" data-variant="${id}">
                        <input type="file" class="form-control" name="new_variant_images[${newVariantCount}][]" accept="image/*" multiple>
                    </div>

                    <div class="tab-panel tab-url d-none" data-variant="${id}">
                        <div class="url-list" id="url-list-${id}">
                            <div class="input-group mb-2 url-item">
                                <span class="input-group-text"><i class="fas fa-image"></i></span>
                                <input type="url" class="form-control url-input" name="new_variant_image_urls[${newVariantCount}][]" placeholder="https://example.com/anh.jpg" oninput="previewUrl(this)">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeUrlItem(this)"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="addUrlInput('${id}')"><i class="fas fa-plus"></i> Thêm URL</button>
                        <div class="url-preview d-flex flex-wrap gap-2 mt-2" id="url-preview-${id}"></div>
                    </div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    newVariantCount++;
}
</script>
@endsection
EOD;
file_put_contents('resources/views/admin_edit_product.blade.php', $content);
?>
