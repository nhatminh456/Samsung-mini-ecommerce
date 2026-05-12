---------------------------------------------------
1. Yêu cầu hệ thống
PHP >= 8.1
Composer
MySQL >= 8.0
Node.js & NPM
---

---

2. Cách lấy project từ github về máy.
   Bước 1: git clone https://github.com/nhatminh456/Samsung-mini-ecommerce.git
   Bước 2: cd vào thư mục

---

---

3. Cài đặt dependencies
   composer install
   npm install

---

4. Cấu hình môi trường
   cp .env.example .env
   php artisan key:generate

---

5. Mở file .env và cập nhật thông tin database:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=samsum_db
   DB_USERNAME=root
   DB_PASSWORD=

---

6.  Import database
    Mở MySQL Workbench
    Server > Data Import trong MySQL Workbench, chọn file database/samsum_db.sql và bấm Start Import.

---

7. Chạy dự án
   php artisan serve

---

8. Tính năng
   Khách hàng

Đăng ký / Đăng nhập
Trang chủ & Danh mục
Chi tiết sản phẩm
Giỏ hàng
Thanh toán
Lịch sử đơn hàng
Chatbot hỗ trợ

---

Admin
Dashboard
Quản lý sản phẩm
Quản lý danh mục
Quản lý người dùng
Quản lý đơn hàng

---

Công nghệ sử dụng
Backend: Laravel 12, PHP
Frontend: Blade Template, CSS, JavaScript
Database: MySQL 8.0
