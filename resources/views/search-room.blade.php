@extends('layouts.app')

@section('title', 'Tìm kiếm phòng - Khách sạn Miền Tây')

@section('content')
<div class="container mt-4">
    <!-- Form tìm kiếm -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Tìm kiếm phòng</h4>
                </div>
                <div class="card-body">
                    <form action="/search-room" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="checkin" class="form-label">Ngày nhận phòng</label>
                            <input type="date" class="form-control" id="checkin" name="checkin" 
                                   value="{{ request('checkin') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="checkout" class="form-label">Ngày trả phòng</label>
                            <input type="date" class="form-control" id="checkout" name="checkout" 
                                   value="{{ request('checkout') }}" required>
                        </div>
                        <div class="col-md-2">
                            <label for="guests" class="form-label">Số khách</label>
                            <select class="form-select" id="guests" name="guests">
                                <option value="">Tất cả</option>
                                <option value="1" {{ request('guests') == '1' ? 'selected' : '' }}>1 người</option>
                                <option value="2" {{ request('guests') == '2' ? 'selected' : '' }}>2 người</option>
                                <option value="3" {{ request('guests') == '3' ? 'selected' : '' }}>3 người</option>
                                <option value="4" {{ request('guests') == '4' ? 'selected' : '' }}>4 người</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="type" class="form-label">Loại phòng</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">Tất cả</option>
                                <option value="standard" {{ request('type') == 'standard' ? 'selected' : '' }}>Standard</option>
                                <option value="superior" {{ request('type') == 'superior' ? 'selected' : '' }}>Superior</option>
                                <option value="deluxe" {{ request('type') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                                <option value="suite" {{ request('type') == 'suite' ? 'selected' : '' }}>Suite</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Kết quả tìm kiếm -->
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Kết quả tìm kiếm ({{ $rooms->count() }} phòng)</h3>
        </div>
    </div>

    <div class="row">
        @forelse ($rooms as $room)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="{{ asset('images/' . $room->image) }}" class="card-img-top" alt="{{ $room->name }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $room->name }}</h5>
                    <p class="card-text">{{ $room->description }}</p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary">{{ ucfirst($room->type) }}</span>
                            <span class="text-muted">Tối đa {{ $room->max_guests }} khách</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="text-primary mb-0">{{ number_format($room->price, 0, ',', '.') }} VNĐ/đêm</h6>
                            <a href="/room/{{ $room->id }}" class="btn btn-outline-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <h5>Không tìm thấy phòng phù hợp</h5>
                <p>Vui lòng thử lại với tiêu chí khác hoặc liên hệ với chúng tôi để được tư vấn.</p>
                <a href="/search-room" class="btn btn-primary">Tìm kiếm lại</a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
// Set minimum date for check-in and check-out
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const checkinInput = document.getElementById('checkin');
    const checkoutInput = document.getElementById('checkout');
    
    checkinInput.min = today;
    checkoutInput.min = today;
    
    // Update checkout minimum date when checkin changes
    checkinInput.addEventListener('change', function() {
        checkoutInput.min = this.value;
        if (checkoutInput.value && checkoutInput.value < this.value) {
            checkoutInput.value = this.value;
        }
    });
});
</script>
@endsection
