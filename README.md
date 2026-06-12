# HỆ THỐNG E-COMMERCE SẢN PHẨM SAMSUNG

> Dự án Website kinh doanh điện thoại và phụ kiện Samsung, tích hợp Chatbot AI (Gemini RAG) và thanh toán tự động VietQR.

## 1. Công nghệ sử dụng

- **Backend:** Laravel 12, PHP
- **Frontend:** Blade Template, CSS, JavaScript
- **Database:** MySQL 8.0

## 2. Yêu cầu hệ thống (Prerequisites)

Để chạy được dự án, máy tính của bạn cần cài đặt sẵn các phần mềm sau:

- **PHP:** >= 8.1
- **Composer**
- **MySQL:** >= 8.0
- **Node.js & NPM**

## 3. Hướng dẫn cài đặt (Installation)

**Bước 1: Tải mã nguồn từ GitHub về máy**
Mở Terminal/Command Prompt và chạy các lệnh sau:

```bash
git clone https://github.com/nhatminh456/Samsung-mini-ecommerce.git
cd Samsung-mini-ecommerce

```

**Bước 2: Cài đặt các thư viện (Dependencies)**

```bash
composer install
npm install

```

**Bước 3: Cấu hình môi trường**
Copy file môi trường mẫu và tạo key bảo mật cho ứng dụng:

```bash
cp .env.example .env
php artisan key:generate

```

**Bước 4: Cấu hình Cơ sở dữ liệu (Database)**
Mở file `.env` vừa được tạo ra và cập nhật các thông tin kết nối MySQL của bạn:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=samsum_db
DB_USERNAME=root
DB_PASSWORD=

```

**Bước 5: Nhập dữ liệu (Import Database)**

1. Mở phần mềm **MySQL Workbench**.
2. Chọn menu **Server** > **Data Import**.
3. Chọn file database được lưu sẵn trong dự án: `database/samsum_db.sql`.
4. Bấm **Start Import** để nạp dữ liệu vào bảng.

**Bước 6: Khởi chạy dự án**

```bash
php artisan serve

```

_Truy cập vào địa chỉ `http://localhost:8000` trên trình duyệt để trải nghiệm website._

## 4. Các tính năng nổi bật (Features)

### Giao diện Khách hàng (Client)

- Đăng ký & Đăng nhập hệ thống.
- Xem Trang chủ và Danh mục sản phẩm.
- Xem chi tiết cấu hình sản phẩm.
- Thêm sản phẩm vào Giỏ hàng.
- Thanh toán đơn hàng (Tích hợp VietQR).
- Theo dõi Lịch sử mua hàng.
- **Chatbot hỗ trợ thông minh** (Tư vấn trực tiếp dựa trên dữ liệu sản phẩm).

### Giao diện Quản trị (Admin)

- Dashboard thống kê tổng quan.
- Quản lý Sản phẩm (Thêm/Sửa/Xóa).
- Quản lý Danh mục.
- Quản lý Người dùng.
- Quản lý Đơn hàng.

## 5. Tài khoản dùng thử (Test Accounts)

| Vai trò        | Email đăng nhập       | Mật khẩu |
| -------------- | --------------------- | -------- |
| **Admin**      | nhatminh456@gmail.com | 123456   |
| **Khách hàng** | cohue@gmail.com       | 123456   |
