@extends('layouts.app')

@section('title', 'Trang chủ - Khách sạn Miền Tây')

@section('content')
<!-- SLIDE -->
<div id="mainCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
            <div class="banner-container">
                <img src="/images/23.jpg" class="banner-img" alt="Banner 1">
                <div class="banner-overlay">
                    <h2>Chào mừng đến Khách sạn Miền Tây</h2>
                    <p>Trải nghiệm nghỉ dưỡng đẳng cấp và tiện nghi</p>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
            <div class="banner-container">
                <img src="{{ asset('images/25.jpg') }}" class="banner-img" alt="Banner 2">
                <div class="banner-overlay">
                    <h2>Phòng sang trọng & hiện đại</h2>
                    <p>Đặt ngay hôm nay để nhận ưu đãi hấp dẫn!</p>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item">
            <div class="banner-container">
                <img src="/images/24.jpg" class="banner-img" alt="Banner 3">
                <div class="banner-overlay">
                    <h2>Dịch vụ 5 sao</h2>
                    <p>Trải nghiệm dịch vụ khách hàng chuyên nghiệp</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Điều khiển -->
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>

    <!-- Indicators -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
    </div>
</div>

<!-- GIỚI THIỆU -->
<section class="container mb-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="mb-4">Về chúng tôi</h3>
            <p class="lead">Khách sạn Miền Tây tự hào là điểm đến lý tưởng cho những ai yêu thích sự sang trọng và tiện nghi.</p>
            <p>Với vị trí đắc địa tại trung tâm thành phố, chúng tôi mang đến cho quý khách:</p>
            <ul class="list-unstyled">
                <li><i class="fas fa-check text-primary me-2"></i>Phòng nghỉ cao cấp với view đẹp</li>
                <li><i class="fas fa-check text-primary me-2"></i>Dịch vụ 24/7 chuyên nghiệp</li>
                <li><i class="fas fa-check text-primary me-2"></i>Nhà hàng phục vụ ẩm thực đa dạng</li>
                <li><i class="fas fa-check text-primary me-2"></i>Hồ bơi và phòng gym hiện đại</li>
            </ul>
            <a href="/search-room" class="btn btn-primary">Đặt phòng ngay</a>
        </div>
        <div class="col-md-6">
            <img src="/images/room1.jpg" class="img-fluid rounded" alt="Khách sạn">
        </div>
    </div>
</section>

<!-- DANH SÁCH PHÒNG NỔI BẬT -->
<section class="container mb-5">
    <h3 class="mb-4 text-center">Phòng nổi bật</h3>
    <div class="row">
        @foreach($featuredRooms as $room)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="{{ asset('images/' . $room->image) }}" class="card-img-top" alt="{{ $room->name }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $room->name }}</h5>
                    <p class="card-text">{{ Str::limit($room->description, 80) }}</p>
                    <p class="card-text"><strong>Giá: {{ number_format($room->price, 0, ',', '.') }} VNĐ/đêm</strong></p>
                    <a href="/room/{{ $room->id }}" class="btn btn-primary mt-auto">Xem chi tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-4">
        <a href="/search-room" class="btn btn-outline-primary btn-lg">Xem tất cả phòng</a>
    </div>
</section>

<!-- TIỆN ÍCH -->
<section class="container mb-5">
    <h3 class="mb-4 text-center">Tiện ích khách sạn</h3>
    <div class="row">
        <div class="col-md-4 text-center mb-4">
            <div class="p-4">
                <i class="fas fa-wifi fa-3x text-primary mb-3"></i>
                <h5>WiFi miễn phí</h5>
                <p>Kết nối internet tốc độ cao trong toàn khách sạn</p>
            </div>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="p-4">
                <i class="fas fa-swimming-pool fa-3x text-primary mb-3"></i>
                <h5>Hồ bơi</h5>
                <p>Hồ bơi ngoài trời với view thành phố tuyệt đẹp</p>
            </div>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="p-4">
                <i class="fas fa-utensils fa-3x text-primary mb-3"></i>
                <h5>Nhà hàng</h5>
                <p>Phục vụ ẩm thực đa dạng từ Á đến Âu</p>
            </div>
        </div>
    </div>
</section>
@endsection
