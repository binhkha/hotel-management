@extends('layouts.app')

@section('title', 'Xác nhận đặt phòng - Khách sạn Miền Tây')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-check-circle me-2"></i>Đặt phòng thành công!
                    </h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-hotel fa-4x text-primary mb-3"></i>
                        <h5>Cảm ơn bạn đã chọn Khách sạn Miền Tây!</h5>
                        <p class="text-muted">Thông tin đặt phòng của bạn đã được ghi nhận.</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Thông tin phòng</h6>
                            <ul class="list-unstyled">
                                <li><strong>Phòng:</strong> {{ $booking->room->name }}</li>
                                <li><strong>Ngày nhận phòng:</strong> {{ $booking->checkin->format('d/m/Y') }}</li>
                                <li><strong>Ngày trả phòng:</strong> {{ $booking->checkout->format('d/m/Y') }}</li>
                                <li><strong>Số đêm:</strong> {{ $booking->nights }} đêm</li>
                                <li><strong>Số khách:</strong> {{ $booking->guests }} người</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Thông tin khách hàng</h6>
                            <ul class="list-unstyled">
                                <li><strong>Họ tên:</strong> {{ $booking->customer_name }}</li>
                                <li><strong>Số điện thoại:</strong> {{ $booking->customer_phone }}</li>
                                @if($booking->customer_email)
                                    <li><strong>Email:</strong> {{ $booking->customer_email }}</li>
                                @endif
                                @if($booking->notes)
                                    <li><strong>Ghi chú:</strong> {{ $booking->notes }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Chi tiết thanh toán</h6>
                            <ul class="list-unstyled">
                                <li><strong>Giá/đêm:</strong> {{ number_format($booking->price_per_night, 0, ',', '.') }} VNĐ</li>
                                <li><strong>Số đêm:</strong> {{ $booking->nights }} đêm</li>
                                <li><strong>Tổng tiền:</strong> <span class="text-danger fw-bold">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</span></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Thông tin bổ sung</h6>
                            <ul class="list-unstyled">
                                <li><strong>Mã đơn:</strong> #{{ $booking->id }}</li>
                                <li><strong>Ngày đặt:</strong> {{ $booking->created_at->format('d/m/Y H:i') }}</li>
                                <li><strong>Trạng thái:</strong> <span class="badge bg-warning">Chờ xác nhận</span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <h6><i class="fas fa-info-circle me-2"></i>Lưu ý quan trọng:</h6>
                        <ul class="mb-0">
                            <li>Chúng tôi sẽ liên hệ với bạn trong vòng 24 giờ để xác nhận đặt phòng</li>
                            <li>Vui lòng chuẩn bị giấy tờ tùy thân khi check-in</li>
                            <li>Giờ check-in: 14:00, Giờ check-out: 12:00</li>
                            <li>Mọi thắc mắc vui lòng liên hệ: 0123 456 789</li>
                        </ul>
                    </div>

                    <div class="text-center mt-4">
                        <a href="/" class="btn btn-primary me-2">
                            <i class="fas fa-home me-2"></i>Về trang chủ
                        </a>
                        <a href="/search-room" class="btn btn-outline-primary">
                            <i class="fas fa-search me-2"></i>Tìm phòng khác
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 