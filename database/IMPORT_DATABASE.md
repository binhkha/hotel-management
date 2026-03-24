# 📋 HƯỚNG DẪN IMPORT DATABASE CHO MÁY KHÁC

## 🎯 **MỤC ĐÍCH**
File này hướng dẫn cách import database mẫu vào máy khác để test dự án hotel-management.

## 🗄️ **CÁC BƯỚC THỰC HIỆN**

### **Bước 1: Tạo database**
1. Mở phpMyAdmin (http://localhost/phpmyadmin)
2. Tạo database mới tên: `hotel_management`
3. Chọn collation: `utf8mb4_unicode_ci`

### **Bước 2: Import cấu trúc database**
```bash
# Chạy migration để tạo cấu trúc bảng
php artisan migrate
```

### **Bước 3: Import dữ liệu mẫu**
```bash
# Chạy seeder để tạo dữ liệu mẫu
php artisan db:seed
```

## 📊 **DỮ LIỆU MẪU SẼ ĐƯỢC TẠO**

### **👥 Users (1 tài khoản)**
- **Admin**: admin@hotel.com / 123456 ✅

### **🏨 Rooms (6 phòng)**
- Phòng Standard, Deluxe, Suite với các mức giá khác nhau
- Hình ảnh mẫu và mô tả chi tiết
- Trạng thái: available, occupied, maintenance

### **📅 Bookings (2 đơn đặt phòng mẫu)**
- 1 đơn đã xác nhận (confirmed)
- 1 đơn chờ xác nhận (pending)
- Thông tin khách hàng mẫu để test

## 🔧 **LỆNH HỮU ÍCH**

```bash
# Xem trạng thái migration
php artisan migrate:status

# Reset database và chạy seeder
php artisan migrate:fresh --seed

# Chạy seeder cụ thể
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=RoomSeeder
php artisan db:seed --class=BookingSeeder

# Xem dữ liệu trong database
php artisan tinker
# Trong tinker:
# App\Models\User::count()
# App\Models\Room::count()
# App\Models\Booking::count()
```

## 🚨 **LƯU Ý QUAN TRỌNG**

1. **Đảm bảo MySQL đang chạy** trước khi chạy migration
2. **Kiểm tra file .env** có thông tin database đúng
3. **Chạy migration trước** rồi mới chạy seeder
4. **Nếu có lỗi**, kiểm tra log trong `storage/logs/laravel.log`

## ✅ **KIỂM TRA SAU KHI IMPORT**

1. **Truy cập website**: http://127.0.0.1:8000
2. **Đăng nhập admin**: admin@hotel.com / 123456
3. **Kiểm tra quản lý phòng**: Có 5 phòng hiển thị
4. **Kiểm tra quản lý đơn đặt phòng**: Có 2 đơn mẫu
5. **Test đặt phòng**: Tạo đơn đặt phòng mới

## 📞 **HỖ TRỢ**

Nếu gặp vấn đề:
1. Kiểm tra log: `storage/logs/laravel.log`
2. Kiểm tra cấu hình database trong `.env`
3. Đảm bảo MySQL service đang chạy
4. Kiểm tra quyền truy cập database

---

**Chúc bạn import database thành công! 🎉**
