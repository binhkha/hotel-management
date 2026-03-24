@extends('layouts.app')

@section('title', 'Quản lý đơn đặt phòng - Khách sạn Miền Tây')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-list me-2"></i>Quản lý đơn đặt phòng
                    </h4>
                    <span class="badge bg-light text-dark">{{ count($bookings) }} đơn</span>
                </div>
                <div class="card-body">
                    @if(count($bookings) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Phòng</th>
                                        <th>Ngày check-in</th>
                                        <th>Ngày check-out</th>
                                        <th>Số đêm</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày đặt</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr data-booking-id="{{ $booking->id }}">
                                        <td>
                                            <span class="badge bg-secondary">#{{ $booking->id }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $booking->customer_name }}</strong><br>
                                                <small class="text-muted">{{ $booking->customer_phone }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $booking->room->name }}</span>
                                        </td>
                                        <td>{{ $booking->checkin->format('d/m/Y') }}</td>
                                        <td>{{ $booking->checkout->format('d/m/Y') }}</td>
                                        <td>{{ $booking->nights }} đêm</td>
                                        <td>
                                            <strong class="text-danger">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</strong>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm status-select" 
                                                    data-booking-id="{{ $booking->id }}"
                                                    style="width: auto;">
                                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                                    Chờ xác nhận
                                                </option>
                                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>
                                                    Đã xác nhận
                                                </option>
                                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                                    Đã hủy
                                                </option>
                                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>
                                                    Hoàn thành
                                                </option>
                                            </select>
                                        </td>
                                        <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-info" 
                                                    onclick="viewBookingDetails({{ $booking->id }})"
                                                    title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" 
                                                    onclick="deleteBooking({{ $booking->id }})"
                                                    title="Xóa đơn">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có đơn đặt phòng nào</h5>
                            <p class="text-muted">Các đơn đặt phòng sẽ xuất hiện ở đây khi khách hàng đặt phòng.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Chi tiết đơn đặt phòng -->
<div class="modal fade" id="bookingDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết đơn đặt phòng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="bookingDetailsContent">
                <!-- Nội dung sẽ được load bằng JavaScript -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Cập nhật trạng thái đơn đặt phòng
document.addEventListener('DOMContentLoaded', function() {
    const statusSelects = document.querySelectorAll('.status-select');
    
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const bookingId = this.dataset.bookingId;
            const status = this.value;
            
            fetch(`/admin/bookings/${bookingId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', 'Cập nhật trạng thái thành công!');
                } else {
                    showAlert('error', data.message || 'Có lỗi xảy ra khi cập nhật trạng thái!');
                }
            })
            .catch(error => {
                showAlert('error', 'Có lỗi xảy ra khi cập nhật trạng thái!');
            });
        });
    });
});

// Xem chi tiết đơn đặt phòng
function viewBookingDetails(bookingId) {
    // Lấy dữ liệu từ bảng hiện tại
    const row = document.querySelector(`tr[data-booking-id="${bookingId}"]`) || 
                document.querySelector(`select[data-booking-id="${bookingId}"]`).closest('tr');
    
    if (row) {
        const customerName = row.querySelector('td:nth-child(2) strong').textContent;
        const customerPhone = row.querySelector('td:nth-child(2) small').textContent;
        const roomName = row.querySelector('td:nth-child(3) .badge').textContent;
        const checkin = row.querySelector('td:nth-child(4)').textContent;
        const checkout = row.querySelector('td:nth-child(5)').textContent;
        const nights = row.querySelector('td:nth-child(6)').textContent;
        const totalPrice = row.querySelector('td:nth-child(7) strong').textContent;
        const status = row.querySelector('td:nth-child(8) select').value;
        const bookingDate = row.querySelector('td:nth-child(9)').textContent;
        
        const content = `
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary">Thông tin phòng</h6>
                    <ul class="list-unstyled">
                        <li><strong>Phòng:</strong> ${roomName}</li>
                        <li><strong>Ngày nhận phòng:</strong> ${checkin}</li>
                        <li><strong>Ngày trả phòng:</strong> ${checkout}</li>
                        <li><strong>Số đêm:</strong> ${nights}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary">Thông tin khách hàng</h6>
                    <ul class="list-unstyled">
                        <li><strong>Họ tên:</strong> ${customerName}</li>
                        <li><strong>Số điện thoại:</strong> ${customerPhone}</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary">Chi tiết thanh toán</h6>
                    <ul class="list-unstyled">
                        <li><strong>Tổng tiền:</strong> <span class="text-danger fw-bold">${totalPrice}</span></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary">Thông tin bổ sung</h6>
                    <ul class="list-unstyled">
                        <li><strong>Mã đơn:</strong> #${bookingId}</li>
                        <li><strong>Ngày đặt:</strong> ${bookingDate}</li>
                        <li><strong>Trạng thái:</strong> 
                            <span class="badge bg-${getStatusBadgeColor(status)}">${getStatusText(status)}</span>
                        </li>
                    </ul>
                </div>
            </div>
        `;
        
        document.getElementById('bookingDetailsContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('bookingDetailsModal')).show();
    }
}

// Xóa đơn đặt phòng
function deleteBooking(bookingId) {
    if (confirm('Bạn có chắc chắn muốn xóa đơn đặt phòng này?')) {
        fetch(`/admin/bookings/${bookingId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            showAlert('error', 'Có lỗi xảy ra khi xóa đơn đặt phòng!');
        });
    }
}

// Helper functions
function getStatusText(status) {
    const statusMap = {
        'pending': 'Chờ xác nhận',
        'confirmed': 'Đã xác nhận',
        'cancelled': 'Đã hủy',
        'completed': 'Hoàn thành'
    };
    return statusMap[status] || status;
}

function getStatusBadgeColor(status) {
    const colorMap = {
        'pending': 'warning',
        'confirmed': 'success',
        'cancelled': 'danger',
        'completed': 'info'
    };
    return colorMap[status] || 'secondary';
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Thêm alert vào đầu container
    const container = document.querySelector('.container');
    container.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Tự động ẩn sau 3 giây
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 3000);
}
</script>
@endsection 