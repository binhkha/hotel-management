@extends('layouts.app')

@section('title', $room->name . ' - Khách sạn Miền Tây')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Hình ảnh phòng -->
        <div class="col-md-6">
            <div class="card">
                <img src="{{ asset('images/' . $room->image) }}" class="card-img-top" 
                     style="height: 400px; object-fit: cover;" alt="{{ $room->name }}">
            </div>
        </div>

        <!-- Thông tin phòng -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">{{ $room->name }}</h2>
                    <div class="mb-3">
                        <span class="badge bg-primary me-2">{{ ucfirst($room->type) }}</span>
                        <span class="badge bg-success">Tối đa {{ $room->max_guests }} khách</span>
                        @if($room->status === 'available')
                            <span class="badge bg-success">Trống</span>
                        @elseif($room->status === 'occupied')
                            <span class="badge bg-danger">Đã thuê</span>
                        @else
                            <span class="badge bg-warning">Bảo trì</span>
                        @endif
                    </div>
                    
                    <h4 class="text-primary mb-3">{{ number_format($room->price, 0, ',', '.') }} VNĐ/đêm</h4>
                    
                    <p class="card-text">{{ $room->description }}</p>
                    
                    <hr>
                    
                    <h5>Tiện nghi phòng:</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-wifi text-primary me-2"></i>WiFi miễn phí</li>
                        <li><i class="fas fa-tv text-primary me-2"></i>Tivi màn hình phẳng</li>
                        <li><i class="fas fa-snowflake text-primary me-2"></i>Điều hòa</li>
                        <li><i class="fas fa-shower text-primary me-2"></i>Phòng tắm riêng</li>
                        <li><i class="fas fa-bed text-primary me-2"></i>Giường đôi</li>
                        <li><i class="fas fa-coffee text-primary me-2"></i>Mini bar</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Form đặt phòng -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Đặt phòng</h4>
                </div>
                @if($room->status !== 'available')
                    <div class="alert alert-warning m-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        @if($room->status === 'occupied')
                            Phòng này đã có người thuê, vui lòng chọn phòng khác!
                        @else
                            Phòng này đang bảo trì, vui lòng chọn phòng khác!
                        @endif
                    </div>
                @endif
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form action="/book-room" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="checkin" class="form-label">Ngày nhận phòng *</label>
                                    <input type="date" class="form-control" id="checkin" name="checkin" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="checkout" class="form-label">Ngày trả phòng *</label>
                                    <input type="date" class="form-control" id="checkout" name="checkout" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="guests" class="form-label">Số khách *</label>
                                    <select class="form-select" id="guests" name="guests" required>
                                        @for($i = 1; $i <= $room->max_guests; $i++)
                                            <option value="{{ $i }}">{{ $i }} người</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nights" class="form-label">Số đêm</label>
                                    <input type="number" class="form-control" id="nights" name="nights" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Họ tên *</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label">Số điện thoại *</label>
                                    <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                                </div>
                            </div>
                        </div>

                        @if(session('user_logged_in'))
                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="customer_email" name="customer_email" 
                                   value="{{ session('user_email') }}" readonly>
                            <small class="text-muted">Email sẽ được sử dụng từ tài khoản đăng nhập</small>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Vui lòng <a href="#" onclick="showLoginModal()">đăng nhập</a> để đặt phòng!
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" 
                                      placeholder="Yêu cầu đặc biệt (nếu có)"></textarea>
                        </div>

                        <div class="alert alert-info">
                            <h6>Tổng tiền: <span id="total-price">{{ number_format($room->price, 0, ',', '.') }}</span> VNĐ</h6>
                            <small>* Giá có thể thay đổi tùy theo số đêm và số khách</small>
                        </div>

                        @if(session('user_logged_in'))
                            <button type="submit" class="btn btn-primary btn-lg" {{ $room->status !== 'available' ? 'disabled' : '' }}>
                                {{ $room->status === 'available' ? 'Đặt phòng ngay' : 'Không thể đặt phòng' }}
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary btn-lg" disabled>
                                Vui lòng đăng nhập để đặt phòng
                            </button>
                        @endif
                        
                        <!-- Debug info -->
                        <div class="mt-3">
                            <small class="text-muted">
                                Room ID: {{ $room->id }} | 
                                Status: {{ $room->status }} | 
                                Max Guests: {{ $room->max_guests }}
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkinInput = document.getElementById('checkin');
    const checkoutInput = document.getElementById('checkout');
    const nightsInput = document.getElementById('nights');
    const totalPriceSpan = document.getElementById('total-price');
    const roomPrice = {{ $room->price }};
    
    // Debug: Log room info
    console.log('Room info:', {
        id: {{ $room->id }},
        status: '{{ $room->status }}',
        maxGuests: {{ $room->max_guests }},
        price: {{ $room->price }}
    });
    
    // Set minimum date
    const today = new Date().toISOString().split('T')[0];
    checkinInput.min = today;
    checkoutInput.min = today;
    
    // Calculate nights and total price
    function calculateTotal() {
        if (checkinInput.value && checkoutInput.value) {
            const checkin = new Date(checkinInput.value);
            const checkout = new Date(checkoutInput.value);
            const nights = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));
            
            if (nights > 0) {
                nightsInput.value = nights;
                const total = nights * roomPrice;
                totalPriceSpan.textContent = total.toLocaleString('vi-VN');
            } else {
                nightsInput.value = '';
                totalPriceSpan.textContent = roomPrice.toLocaleString('vi-VN');
            }
        }
    }
    
    // Update checkout minimum date when checkin changes
    checkinInput.addEventListener('change', function() {
        checkoutInput.min = this.value;
        if (checkoutInput.value && checkoutInput.value < this.value) {
            checkoutInput.value = this.value;
        }
        calculateTotal();
    });
    
    checkoutInput.addEventListener('change', calculateTotal);
    
    // Debug: Form submission
    const form = document.getElementById('bookingForm');
    form.addEventListener('submit', function(e) {
        console.log('Form submitting...');
        console.log('Form data:', new FormData(form));
        
        // Log all form fields
        const formData = new FormData(form);
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
    });
});

// Hiển thị modal đăng nhập
function showLoginModal() {
    // Trigger click vào nút đăng nhập trên navbar
    const loginButton = document.querySelector('a[href="#loginModal"]');
    if (loginButton) {
        loginButton.click();
    } else {
        // Fallback: redirect về trang chủ
        window.location.href = '/';
    }
}
</script>
@endsection 