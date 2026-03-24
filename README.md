# 🏨 HỆ THỐNG QUẢN LÝ KHÁCH SẠN MIỀN TÂY

Hệ thống quản lý khách sạn được xây dựng bằng Laravel 9, hỗ trợ đặt phòng trực tuyến, quản lý phòng, quản lý nhân viên và quản lý đơn đặt phòng.

## 🚀 YÊU CẦU HỆ THỐNG

- **PHP**: 8.0 hoặc cao hơn
- **Composer**: Phiên bản mới nhất
- **Laravel**: 9.52.20
- **Database**: MySQL 5.7+ hoặc MariaDB 10.2+
- **Web Server**: WAMP/XAMPP hoặc Apache/Nginx
- **Node.js**: 14+ (cho Vite build)

## 📦 CÀI ĐẶT DỰ ÁN TRÊN MÁY MỚI

### **Bước 1: Tải dự án**

```bash
# Copy dự án vào thư mục C:\wamp64\www\
# Hoặc giải nén file zip vào thư mục mong muốn
cd hotel-management
```

### **Bước 2: Cài đặt dependencies**

```bash
composer install
npm install
```

### **Bước 3: Cấu hình môi trường**

```bash
cp .env.example .env
php artisan key:generate
```

### **Bước 4: Chỉnh sửa file `.env`**

```env
APP_NAME="Khách sạn Miền Tây"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_management
DB_USERNAME=root
DB_PASSWORD=your_password_here

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### **Bước 5: Tạo database**

Truy cập phpMyAdmin (http://localhost/phpmyadmin) và tạo database `hotel_management`

### **Bước 6: Chạy migration và seeder**

```bash
# Chạy tất cả migration
php artisan migrate

# Chạy seeder để tạo dữ liệu mẫu
php artisan db:seed

# Hoặc chạy cả hai cùng lúc
php artisan migrate:fresh --seed
```

### **Bước 7: Tạo symbolic link cho storage**

```bash
php artisan storage:link
```

### **Bước 8: Build assets (nếu cần)**

```bash
npm run build
```

### **Bước 9: Chạy server**

```bash
php artisan serve
```

Website sẽ chạy tại: **http://127.0.0.1:8000**

## 🔑 THÔNG TIN ĐĂNG NHẬP

phpMyAdmin usernam: root
password trống

### **Admin**

- **Email**: admin@hotel.com
- **Password**: 123456

### **Tài khoản mẫu**

- **Chỉ có admin**: admin@hotel.com / 123456 ✅
- **Các user khác**: Sẽ được tạo khi đăng ký và đặt phòng

### **Tài khoản mới**

- Đăng ký tài khoản mới sẽ có role `user` (không phải admin)
- Chỉ email `admin@hotel.com` mới có quyền admin

## 🏗️ CẤU TRÚC DỰ ÁN

```
hotel-management/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php           # Xử lý trang chủ
│   │   ├── AdminController.php          # Quản lý admin (phòng, đơn đặt)
│   │   ├── AuthController.php           # Xử lý đăng nhập/đăng ký
│   │   ├── RoomController.php           # Xử lý chi tiết phòng
│   │   ├── SearchRoomController.php     # Xử lý tìm kiếm phòng
│   │   ├── BookingController.php        # Xử lý đặt phòng
│   │   ├── BookingHistoryController.php # Xử lý lịch sử đặt phòng (MỚI)
│   │   └── StaffController.php          # Quản lý nhân viên
│   └── Models/
│       ├── Room.php                     # Model phòng
│       ├── User.php                     # Model người dùng
│       └── Booking.php                  # Model đơn đặt phòng (MỚI)
├── database/
│   ├── migrations/                      # Cấu trúc database
│   │   ├── create_users_table.php       # Bảng người dùng
│   │   ├── create_rooms_table.php       # Bảng phòng
│   │   ├── add_phone_to_users_table.php # Thêm số điện thoại
│   │   ├── add_role_position_address_to_users_table.php # Thêm role, position, address
│   │   └── create_bookings_table.php    # Bảng đơn đặt phòng (MỚI)
│   └── seeders/
│       ├── DatabaseSeeder.php           # Seeder chính
│       ├── RoomSeeder.php               # Dữ liệu mẫu phòng
│       └── BookingSeeder.php            # Dữ liệu mẫu đơn đặt phòng (MỚI)
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php                # Layout chính
│   ├── admin/
│   │   ├── rooms.blade.php              # Trang quản lý phòng
│   │   ├── bookings.blade.php           # Trang quản lý đơn đặt phòng
│   │   ├── add_staff.blade.php          # Trang thêm nhân viên
│   │   ├── staff_list.blade.php         # Trang danh sách nhân viên
│   │   └── edit_staff.blade.php         # Trang chỉnh sửa nhân viên
│   ├── home.blade.php                   # Trang chủ
│   ├── search-room.blade.php            # Trang tìm phòng
│   ├── room-detail.blade.php            # Chi tiết phòng
│   ├── profile.blade.php                # Tài khoản cá nhân
│   └── booking/
│       ├── confirmation.blade.php       # Xác nhận đặt phòng
│       ├── history.blade.php            # Lịch sử đặt phòng (MỚI)
│       └── detail.blade.php             # Chi tiết đơn đặt phòng (MỚI)
├── routes/
│   └── web.php                          # Định nghĩa routes (bao gồm lịch sử đặt phòng)
└── public/
    ├── css/
    │   └── custom.css                   # CSS tùy chỉnh
    └── images/                          # Hình ảnh phòng và logo
```

## 🎯 TÍNH NĂNG CHÍNH

### **🔍 Tìm kiếm và đặt phòng**

- Tìm kiếm phòng theo ngày, số khách
- Xem chi tiết phòng với hình ảnh
- Đặt phòng không cần đăng nhập
- Xác nhận đặt phòng
- **Lưu trữ dữ liệu đặt phòng vào database (MỚI)**
- **Lịch sử đặt phòng với tìm kiếm và lọc (MỚI)**
- **Xuất dữ liệu đặt phòng ra CSV (MỚI)**

### **👨‍💼 Quản lý Admin**

- **Quản lý phòng**: Thêm, sửa, xóa, thay đổi trạng thái
- **Quản lý đơn đặt phòng**: Xem, cập nhật trạng thái, xóa (MỚI)
- **Quản lý nhân viên**: Thêm, sửa, xóa nhân viên với các vị trí khác nhau
- **Xem lịch sử đặt phòng**: Thống kê, tìm kiếm, lọc theo trạng thái và ngày (MỚI)

### **👥 Quản lý nhân viên**

- **Vị trí**: Lễ tân, Nhân viên dọn phòng, Quản lý, Bảo trì
- **Thông tin**: Tên, email, số điện thoại, địa chỉ
- **Phân quyền**: Chỉ admin mới có thể quản lý nhân viên

### **🔐 Xác thực và phân quyền**

- Đăng ký tài khoản mới
- Đăng nhập/đăng xuất
- Phân quyền admin dựa trên email
- Session-based authentication

## 🛠️ CÔNG NGHỆ SỬ DỤNG

- **Backend**: Laravel 9, PHP 8.0+
- **Frontend**: Bootstrap 5, Font Awesome, Blade Templates
- **Database**: MySQL với Eloquent ORM
- **JavaScript**: Vanilla JS với Fetch API
- **Styling**: Custom CSS với responsive design

## 📱 GIAO DIỆN

- **Responsive design** cho mọi thiết bị
- **Modern UI** với Bootstrap 5
- **Icon Font Awesome** cho trải nghiệm người dùng tốt
- **Color scheme** xanh lá phù hợp với chủ đề khách sạn

## 🚨 LƯU Ý QUAN TRỌNG

### **Bảo mật**

- Chỉ email `admin@hotel.com` mới có quyền admin
- Tài khoản mới đăng ký không thể trở thành admin
- CSRF protection cho tất cả form

### **Database**

- Đảm bảo MySQL service đang chạy
- Database `hotel_management` phải tồn tại trước khi migrate
- Backup dữ liệu trước khi chạy `migrate:fresh`
- **Bảng `bookings` sẽ được tạo tự động khi chạy migration**

### **File uploads**

- Hình ảnh phòng được lưu trong `public/images/`
- Đảm bảo thư mục có quyền ghi

## 🔧 TROUBLESHOOTING

### **Lỗi database connection**

```bash
# Kiểm tra MySQL service
# Windows: Services > MySQL
# Linux: sudo systemctl status mysql

# Kiểm tra kết nối
php artisan tinker
DB::connection()->getPdo();
```

### **Lỗi permission**

```bash
# Cấp quyền cho storage và bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### **Lỗi 500 Internal Server Error**

```bash
# Xem log lỗi
tail -f storage/logs/laravel.log

# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### **Lỗi migration**

```bash
# Nếu có lỗi khi migrate, thử:
php artisan migrate:rollback
php artisan migrate

# Hoặc reset hoàn toàn:
php artisan migrate:fresh --seed
```

## 📋 CHECKLIST CÀI ĐẶT

- [ ] Clone dự án thành công
- [ ] Cài đặt Composer dependencies
- [ ] Cài đặt NPM dependencies
- [ ] Tạo file .env từ .env.example
- [ ] Generate APP_KEY
- [ ] Cấu hình database trong .env
- [ ] Tạo database `hotel_management`
- [ ] Chạy migration thành công
- [ ] Chạy seeder thành công
- [ ] Tạo storage link
- [ ] Build assets (nếu cần)
- [ ] Chạy server thành công
- [ ] Truy cập website tại http://127.0.0.1:8000
- [ ] Đăng nhập admin thành công
- [ ] Test đặt phòng thành công
- [ ] Kiểm tra dữ liệu trong trang quản lý

## 📞 HỖ TRỢ

Nếu gặp vấn đề, hãy kiểm tra:

1. **Log files**: `storage/logs/laravel.log`
2. **Database connection**: Đảm bảo MySQL đang chạy
3. **File permissions**: Thư mục storage và bootstrap/cache
4. **Environment variables**: Kiểm tra file `.env`
5. **Migration status**: `php artisan migrate:status`

## 📄 LICENSE

Dự án này được phát triển cho mục đích học tập và demo. Vui lòng liên hệ tác giả để sử dụng thương mại.

---

**© 2025 Khách sạn Miền Tây. Bảo lưu mọi quyền.**


git init → tạo repo
git add . → chọn file để upload
git commit → đóng gói lại
git push → đẩy lên GitHub

