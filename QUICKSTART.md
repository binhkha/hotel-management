# ⚡ QUICK START - CÀI ĐẶT NHANH

## 🚀 Cài đặt trong 5 phút

### **1. Tải và cài đặt**
```bash
# Copy dự án vào thư mục mong muốn
cd hotel-management
composer install
npm install
```

### **2. Cấu hình nhanh**
```bash
cp .env.example .env
php artisan key:generate
```

### **3. Cấu hình database trong .env**
```env
DB_DATABASE=hotel_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

### **4. Tạo database và chạy migration**
```bash
# Tạo database 'hotel_management' trong phpMyAdmin
php artisan migrate --seed
```

### **5. Chạy server**
```bash
php artisan serve
```

**Website: http://127.0.0.1:8000**

## 🔑 Đăng nhập nhanh
- **Admin**: admin@hotel.com / 123456 ✅
- **Tài khoản mới**: Đăng ký tự do

## 📱 Test nhanh
1. Đặt phòng → Kiểm tra thông báo
2. Đăng nhập admin → Quản lý đơn đặt phòng
3. Kiểm tra dữ liệu hiển thị

## 🚨 Nếu gặp lỗi
```bash
composer dump-autoload
php artisan config:clear
php artisan migrate:fresh --seed
```

---

**Xem INSTALL.md để biết chi tiết đầy đủ! 📖**
