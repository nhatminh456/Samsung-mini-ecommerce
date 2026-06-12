@extends('base')

@section('title', 'Thêm sản phẩm mới - Admin')

@section('content')
<div class="container my-5">
    <h2 class="mb-4"><i class="fas fa-plus"></i> Thêm sản phẩm mới</h2>
    
    <div class="card shadow-sm">
        <div class="card-body">
          <form method="POST" action="{{ url('/admin/product/add') }}" enctype="multipart/form-data">
                @csrf
                
                <h5 class="text-primary mb-3 border-bottom pb-2"><i class="fas fa-info-circle"></i> 1. Thông tin chung</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên dòng máy: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="VD: Samsung Galaxy S24 Ultra">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Danh mục: <span class="text-danger">*</span></label>
                            <select class="form-select" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="bestSeller" name="bestSeller" value="1">
                            <label class="form-check-label fw-bold text-danger" for="bestSeller"><i class="fas fa-fire"></i> Đánh dấu là sản phẩm Best Seller</label>
                        </div>
                    </div>
                </div>

                <h5 class="text-success mt-4 mb-3 border-bottom pb-2"><i class="fas fa-box"></i> 2. Phiên bản & Ảnh theo màu</h5>
                
                <div id="variants-container">
                    <div class="variant-row card border-success mb-3">
                        <div class="card-header bg-success text-white fw-bold">Phiên bản #1</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Màu sắc:</label>
                                    <input type="text" class="form-control" name="variants[0][color]" placeholder="VD: Xám Titan">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Dung lượng:</label>
                                    <input type="text" class="form-control" name="variants[0][storage]" placeholder="VD: 256GB">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Giá (VNĐ): <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="variants[0][price]" required min="1">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Số lượng kho:</label>
                                    <input type="number" class="form-control" name="variants[0][stock_quantity]" value="0" min="0">
                                </div>
                            </div>

                            {{-- Phần ảnh với 2 tab: Upload file / Nhập URL --}}
                            <div class="mt-3">
                                <label class="form-label fw-bold">Ảnh cho phiên bản này:</label>
                                
                                {{-- Tab toggle --}}
                                <div class="btn-group mb-2" role="group">
                                    <button type="button" class="btn btn-sm btn-success tab-btn active" onclick="switchTab(this, 'upload', 0)">
                                        <i class="fas fa-upload"></i> Upload file
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-success tab-btn" onclick="switchTab(this, 'url', 0)">
                                        <i class="fas fa-link"></i> Nhập URL
                                    </button>
                                </div>

                                {{-- Panel upload file --}}
                                <div class="tab-panel tab-upload" data-variant="0">
                                    <input type="file" class="form-control" name="variant_images[0][]" accept="image/*" multiple>
                                    <small class="text-muted">Ctrl/Cmd để chọn nhiều ảnh.</small>
                                </div>

                                {{-- Panel nhập URL --}}
                                <div class="tab-panel tab-url d-none" data-variant="0">
                                    <div class="url-list" id="url-list-0">
                                        <div class="input-group mb-2 url-item">
                                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                                            <input type="url"
                                                   class="form-control url-input"
                                                   name="variant_image_urls[0][]"
                                                   placeholder="https://example.com/anh-san-pham.jpg"
                                                   oninput="previewUrl(this)">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeUrlItem(this)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="addUrlInput(0)">
                                        <i class="fas fa-plus"></i> Thêm URL
                                    </button>
                                    {{-- Preview ảnh từ URL --}}
                                    <div class="url-preview d-flex flex-wrap gap-2 mt-2" id="url-preview-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-outline-success mb-4" onclick="addVariant()">
                    <i class="fas fa-plus"></i> Thêm phiên bản
                </button>

                <h5 class="text-info mt-2 mb-3 border-bottom pb-2"><i class="fas fa-align-left"></i> 3. Mô tả sản phẩm</h5>
                <div class="mb-4">
                    <textarea class="form-control" name="description" rows="5" placeholder="Nhập mô tả tính năng...">{{ old('description') }}</textarea>
                </div>
                
                <div class="d-flex gap-2 justify-content-center mt-4">
                    <button type="submit" class="btn btn-success px-5">
                        <i class="fas fa-save"></i> Lưu sản phẩm
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
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
    border: 2px solid #dee2e6;
    transition: border-color .2s;
}
.url-preview img:hover {
    border-color: #198754;
}
.url-preview .preview-wrap {
    position: relative;
}
.url-preview .preview-wrap .remove-preview {
    position: absolute;
    top: -6px;
    right: -6px;
    width: 18px;
    height: 18px;
    font-size: 10px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    background: #dc3545;
    color: white;
    border: none;
    line-height: 1;
}
.url-preview .broken {
    width: 80px;
    height: 80px;
    border-radius: 6px;
    border: 2px dashed #dc3545;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #dc3545;
    font-size: 11px;
    text-align: center;
    background: #fff5f5;
}
</style>

<script>
let variantCount = 1;

/* ===================== TAB SWITCH ===================== */
function switchTab(btn, type, idx) {
    const variantCard = btn.closest('.card-body');

    // Toggle active trên nút
    variantCard.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('active');
        b.classList.add('btn-outline-success');
        b.classList.remove('btn-success');
    });
    btn.classList.add('active', 'btn-success');
    btn.classList.remove('btn-outline-success');

    // Ẩn/hiện panel
    variantCard.querySelectorAll('.tab-panel').forEach(p => p.classList.add('d-none'));
    variantCard.querySelector(`.tab-${type}`).classList.remove('d-none');

    // Nếu chuyển sang URL thì disable input file (không submit)
    const fileInput = variantCard.querySelector(`input[name="variant_images[${idx}][]"]`);
    if (fileInput) fileInput.disabled = (type === 'url');
}

/* ===================== THÊM URL INPUT ===================== */
function addUrlInput(idx) {
    const list = document.getElementById(`url-list-${idx}`);
    const item = document.createElement('div');
    item.className = 'input-group mb-2 url-item';
    item.innerHTML = `
        <span class="input-group-text"><i class="fas fa-image"></i></span>
        <input type="url"
               class="form-control url-input"
               name="variant_image_urls[${idx}][]"
               placeholder="https://example.com/anh-san-pham.jpg"
               oninput="previewUrl(this)">
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeUrlItem(this)">
            <i class="fas fa-times"></i>
        </button>`;
    list.appendChild(item);
}

/* ===================== XÓA URL ITEM ===================== */
function removeUrlItem(btn) {
    const item = btn.closest('.url-item');
    const input = item.querySelector('.url-input');
    // Xoá preview tương ứng nếu có
    const previewId = input.dataset.previewId;
    if (previewId) {
        const el = document.getElementById(previewId);
        if (el) el.remove();
    }
    item.remove();
}

/* ===================== PREVIEW URL ===================== */
function previewUrl(input) {
    const url = input.value.trim();
    // Lấy container preview (tìm theo variant index từ name)
    const urlList = input.closest('.url-list');
    const variantBody = input.closest('.card-body');
    const previewContainer = variantBody.querySelector('.url-preview');

    // Xoá preview cũ của input này
    if (input.dataset.previewId) {
        const old = document.getElementById(input.dataset.previewId);
        if (old) old.remove();
    }

    if (!url) return;

    const id = 'prev-' + Math.random().toString(36).substr(2, 8);
    input.dataset.previewId = id;

    const wrap = document.createElement('div');
    wrap.className = 'preview-wrap';
    wrap.id = id;

    const img = document.createElement('img');
    img.src = url;
    img.alt = 'preview';
    img.title = url;
    img.onerror = function () {
        wrap.innerHTML = '<div class="broken"><i class="fas fa-exclamation-triangle"></i><br>URL lỗi</div>';
    };

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'remove-preview';
    removeBtn.innerHTML = '&times;';
    removeBtn.onclick = () => {
        wrap.remove();
        input.value = '';
        delete input.dataset.previewId;
    };

    wrap.appendChild(img);
    wrap.appendChild(removeBtn);
    previewContainer.appendChild(wrap);
}

/* ===================== THÊM PHIÊN BẢN ===================== */
function addVariant() {
    const container = document.getElementById('variants-container');
    const idx = variantCount;
    const num = idx + 1;

    const html = `
    <div class="variant-row card border-primary mb-3">
        <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
            Phiên bản #${num}
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.variant-row').remove()">
                <i class="fas fa-trash"></i> Xóa
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Màu sắc:</label>
                    <input type="text" class="form-control" name="variants[${idx}][color]" placeholder="VD: Đen Onyx">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Dung lượng:</label>
                    <input type="text" class="form-control" name="variants[${idx}][storage]" placeholder="VD: 512GB">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Giá (VNĐ):</label>
                    <input type="number" class="form-control" name="variants[${idx}][price]" min="1">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Số lượng kho:</label>
                    <input type="number" class="form-control" name="variants[${idx}][stock_quantity]" value="0" min="0">
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label fw-bold">Ảnh cho phiên bản này:</label>
                <div class="btn-group mb-2" role="group">
                    <button type="button" class="btn btn-sm btn-primary tab-btn active" onclick="switchTab(this, 'upload', ${idx})">
                        <i class="fas fa-upload"></i> Upload file
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-primary tab-btn" onclick="switchTab(this, 'url', ${idx})">
                        <i class="fas fa-link"></i> Nhập URL
                    </button>
                </div>

                <div class="tab-panel tab-upload" data-variant="${idx}">
                    <input type="file" class="form-control" name="variant_images[${idx}][]" accept="image/*" multiple>
                    <small class="text-muted">Ctrl/Cmd để chọn nhiều ảnh.</small>
                </div>

                <div class="tab-panel tab-url d-none" data-variant="${idx}">
                    <div class="url-list" id="url-list-${idx}">
                        <div class="input-group mb-2 url-item">
                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                            <input type="url"
                                   class="form-control url-input"
                                   name="variant_image_urls[${idx}][]"
                                   placeholder="https://example.com/anh-san-pham.jpg"
                                   oninput="previewUrl(this)">
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeUrlItem(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mb-2" onclick="addUrlInput(${idx})">
                        <i class="fas fa-plus"></i> Thêm URL
                    </button>
                    <div class="url-preview d-flex flex-wrap gap-2 mt-2" id="url-preview-${idx}"></div>
                </div>
            </div>
        </div>
    </div>`;

    container.insertAdjacentHTML('beforeend', html);
    variantCount++;
}
</script>
@endsection