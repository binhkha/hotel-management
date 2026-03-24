@extends('layouts.app')

@section('title', 'Chi tiết đơn đặt phòng #' . $booking->id)

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>
                            @if($isAdmin)
                                Quản lý đơn đặt phòng #{{ $booking->id }}
                            @else
                                Chi tiết đơn đặt phòng #{{ $booking->id }}
                            @endif
                        </h4>
                        <div>
                            <a href="{{ route('booking.history') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Thông tin khách hàng -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-user me-2"></i>Thông tin khách hàng
                            </h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Họ tên:</td>
                                    <td>{{ $booking->customer_name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email:</td>
                                    <td>{{ $booking->customer_email }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Số điện thoại:</td>
                                    <td>{{ $booking->customer_phone }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Ghi chú:</td>
                                    <td>{{ $booking->notes ?: 'Không có' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-calendar me-2"></i>Thông tin đặt phòng
                            </h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Ngày nhận phòng:</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->checkin)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Ngày trả phòng:</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->checkout)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Số đêm:</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->checkin)->diffInDays(\Carbon\Carbon::parse($booking->checkout)) }} đêm</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Số khách:</td>
                                    <td>{{ $booking->guests }} người</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Thông tin phòng -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-bed me-2"></i>Thông tin phòng
                            </h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h6 class="fw-bold">{{ $booking->room->name ?? 'N/A' }}</h6>
                                            <p class="text-muted mb-2">{{ $booking->room->description ?? 'Không có mô tả' }}</p>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <small class="text-muted">
                                                        <i class="fas fa-users me-1"></i>
                                                        Tối đa: {{ $booking->room->max_guests ?? 'N/A' }} người
                                                    </small>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted">
                                                        <i class="fas fa-tag me-1"></i>
                                                        Loại: {{ $booking->room->type ?? 'N/A' }}
                                                    </small>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted">
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        Tầng: {{ $booking->room->floor ?? 'N/A' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <h5 class="text-success mb-0">
                                                {{ number_format($booking->room->price ?? 0) }} VNĐ
                                            </h5>
                                            <small class="text-muted">/đêm</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin thanh toán -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-credit-card me-2"></i>Thông tin thanh toán
                            </h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold">Giá phòng/đêm:</td>
                                                    <td class="text-end">{{ number_format($booking->room->price ?? 0) }} VNĐ</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Số đêm:</td>
                                                    <td class="text-end">{{ \Carbon\Carbon::parse($booking->checkin)->diffInDays(\Carbon\Carbon::parse($booking->checkout)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Số khách:</td>
                                                    <td class="text-end">{{ $booking->guests }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold">Tổng tiền:</td>
                                                    <td class="text-end">
                                                        <h5 class="text-success mb-0">{{ number_format($booking->total_price) }} VNĐ</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Trạng thái:</td>
                                                    <td class="text-end">
                                                        @switch($booking->status)
                                                            @case('pending')
                                                                <span class="badge bg-warning fs-6">Chờ xác nhận</span>
                                                                @break
                                                            @case('confirmed')
                                                                <span class="badge bg-success fs-6">Đã xác nhận</span>
                                                                @break
                                                            @case('cancelled')
                                                                <span class="badge bg-danger fs-6">Đã hủy</span>
                                                                @break
                                                            @case('completed')
                                                                <span class="badge bg-info fs-6">Hoàn thành</span>
                                                                @break
                                                            @default
                                                                <span class="badge bg-secondary fs-6">{{ $booking->status }}</span>
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Ngày tạo:</td>
                                                    <td class="text-end">{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thao tác -->
                    <div class="row">
                        <div class="col-12 text-center">
                            <a href="{{ route('booking.history') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                            @if($isAdmin)
                                <a href="{{ route('booking.export') }}" class="btn btn-success me-2">
                                    <i class="fas fa-download me-2"></i>Xuất CSV
                                </a>
                                @if($booking->status === 'pending')
                                    <button class="btn btn-warning me-2" onclick="updateStatus('confirmed')">
                                        <i class="fas fa-check me-2"></i>Xác nhận
                                    </button>
                                    <button class="btn btn-danger" onclick="updateStatus('cancelled')">
                                        <i class="fas fa-times me-2"></i>Từ chối
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if($isAdmin)
<script>
function updateStatus(status) {
    if (confirm('Bạn có chắc muốn cập nhật trạng thái đơn đặt phòng này?')) {
        console.log('Updating status to:', status);
        console.log('Booking ID:', {{ $booking->id }});
        
        // Gửi request cập nhật trạng thái
        fetch(`/admin/bookings/{{ $booking->id }}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: status,
                _method: 'PUT'
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                alert('Cập nhật trạng thái thành công!');
                location.reload();
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi cập nhật trạng thái!');
        });
    }
}
</script>
@endif
@endsection
