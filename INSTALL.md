# 📋 HƯỚNG DẪN CÀI ĐẶT CHI TIẾT

## 🎯 YÊU CẦU TRƯỚC KHI CÀI ĐẶT

### **Phần mềm cần thiết:**
- **WAMP/XAMPP** hoặc **Laragon** (Windows)
- **PHP 8.0+** với các extension: `php-mysql`, `php-mbstring`, `php-xml`, `php-curl`
- **Composer** (https://getcomposer.org/)
- **Node.js 14+** (https://nodejs.org/)


### **Kiểm tra yêu cầu:**
```bash
# Kiểm tra PHP version
php -v

# Kiểm tra Composer
composer -V

# Kiểm tra Node.js
node -v

# Kiểm tra NPM
npm -v
```

## 🚀 CÁC BƯỚC CÀI ĐẶT

### **Bước 1: Khởi động WAMP/XAMPP**
1. Mở WAMP/XAMPP
2. Start Apache và MySQL services
3. Đảm bảo cả hai đều có màu xanh

### **Bước 2: Tải dự án**
```bash
# Mở Command Prompt/Terminal
cd C:\wamp64\www
# Copy dự án vào thư mục này
# Hoặc giải nén file zip vào thư mục hotel-management
cd hotel-management
```

### **Bước 3: Cài đặt Composer dependencies**
```bash
composer install
```
**Lưu ý:** Nếu gặp lỗi memory limit, chạy:
```bash
php -d memory_limit=-1 composer install
```

### **Bước 4: Cài đặt NPM dependencies**
```bash
npm install
```

### **Bước 5: Tạo file .env**
```bash
# Copy file .env.example thành .env
copy .env.example .env

# Hoặc trên Linux/Mac:
cp .env.example .env
```

### **Bước 6: Generate APP_KEY**
```bash
php artisan key:generate
```

### **Bước 7: Cấu hình database**
1. Mở file `.env`
2. Chỉnh sửa thông tin database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_management
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### **Bước 8: Tạo database**
1. Mở trình duyệt, truy cập: `http://localhost/phpmyadmin`
2. Đăng nhập với username: `root`, password: `your_password`
3. Tạo database mới tên: `hotel_management`
4. Chọn collation: `utf8mb4_unicode_ci`

### **Bước 9: Chạy migration**
```bash
php artisan migrate
```

### **Bước 10: Chạy seeder**
```bash
php artisan db:seed
```

### **Bước 11: Tạo storage link**
```bash
php artisan storage:link
```

### **Bước 12: Build assets**
```bash
npm run build
```

### **Bước 13: Chạy server**
```bash
php artisan serve
```

## 🔍 KIỂM TRA CÀI ĐẶT

### **Kiểm tra website:**
1. Mở trình duyệt
2. Truy cập: `http://127.0.0.1:8000`
3. Kiểm tra trang chủ hiển thị đúng

### **Kiểm tra đăng nhập admin:**
1. Click "Tài khoản" → "Đăng nhập"
2. Email: `admin@hotel.com`
3. Password: `123456`
4. Kiểm tra đăng nhập thành công

### **Tài khoản mẫu để test:**
- **Admin**: admin@hotel.com / 123456 ✅
- **Các user khác**: Sẽ được tạo khi đăng ký và đặt phòng

### **Kiểm tra quản lý:**
1. Sau khi đăng nhập admin
2. Click "Tài khoản" → "Quản lý phòng"
3. Kiểm tra trang quản lý hiển thị đúng

## 🚨 XỬ LÝ LỖI THƯỜNG GẶP

### **Lỗi 1: Composer memory limit**
```bash
# Giải pháp:
php -d memory_limit=-1 composer install
```

### **Lỗi 2: Database connection failed**
```bash
# Kiểm tra:
# 1. MySQL service đang chạy
# 2. Thông tin database trong .env đúng
# 3. Database đã được tạo
# 4. Username/password đúng
```

### **Lỗi 3: Migration failed**
```bash
# Giải pháp:
php artisan migrate:rollback
php artisan migrate

# Hoặc reset hoàn toàn:
php artisan migrate:fresh --seed
```

### **Lỗi 4: Permission denied**
```bash
# Windows: Chạy Command Prompt với quyền Administrator
# Linux/Mac:
chmod -R 775 storage bootstrap/cache
```

### **Lỗi 5: Class not found**
```bash
# Giải pháp:
composer dump-autoload
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 📱 TEST TÍNH NĂNG

### **Test đặt phòng:**
1. Vào trang chủ
2. Click "Tìm phòng"
3. Chọn ngày và số khách
4. Click "Tìm kiếm"
5. Chọn phòng và click "Xem chi tiết"
6. Điền form đặt phòng
7. Click "Đặt phòng ngay"
8. Kiểm tra thông báo thành công

### **Test quản lý admin:**
1. Đăng nhập admin
2. Vào "Quản lý đơn đặt phòng"
3. Kiểm tra đơn đặt phòng hiển thị
4. Test cập nhật trạng thái
5. Test xóa đơn đặt phòng

## 🔧 LỆNH HỮU ÍCH

```bash
# Xem trạng thái migration
php artisan migrate:status

# Xem danh sách routes
php artisan route:list

# Xem danh sách commands
php artisan list

# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Tạo controller mới
php artisan make:controller ControllerName

# Tạo model mới
php artisan make:model ModelName

# Tạo migration mới
php artisan make:migration create_table_name
```

## 📞 HỖ TRỢ

Nếu gặp vấn đề:
1. Kiểm tra log: `storage/logs/laravel.log`
2. Kiểm tra yêu cầu hệ thống
3. Kiểm tra cấu hình database
4. Kiểm tra file permissions
5. Liên hệ hỗ trợ kỹ thuật

---

**Chúc bạn cài đặt thành công! 🎉**
