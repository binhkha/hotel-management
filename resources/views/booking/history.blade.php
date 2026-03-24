@extends('layouts.app')

@section('title', 'Lịch sử đặt phòng')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-history me-2"></i>
                    @if($isAdmin)
                        Quản lý đơn đặt phòng
                    @else
                        Lịch sử đặt phòng của tôi
                    @endif
                </h2>
                <div>
                    @if($isAdmin)
                        <a href="{{ route('booking.export') }}" class="btn btn-success me-2">
                            <i class="fas fa-download me-2"></i>Xuất CSV
                        </a>
                    @endif
                    <a href="{{ url('/') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>
            </div>

            <!-- Thống kê -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h4>{{ $stats['total'] }}</h4>
                            <p class="mb-0">
                                @if($isAdmin)
                                    Tổng đơn đặt phòng
                                @else
                                    Đơn đặt phòng của tôi
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h4>{{ $stats['pending'] }}</h4>
                            <p class="mb-0">Chờ xác nhận</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h4>{{ $stats['confirmed'] }}</h4>
                            <p class="mb-0">Đã xác nhận</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <h4>{{ $stats['cancelled'] }}</h4>
                            <p class="mb-0">Đã hủy</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form tìm kiếm và lọc -->
            @if($isAdmin)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-search me-2"></i>Tìm kiếm và lọc</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('booking.history') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="search" class="form-label">Tìm kiếm</label>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           value="{{ request('search') }}" placeholder="Tên, email, SĐT...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">Tất cả</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="date_from" class="form-label">Từ ngày</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from" 
                                           value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="date_to" class="form-label">Đến ngày</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to" 
                                           value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search me-2"></i>Tìm kiếm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Danh sách đơn đặt phòng -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        @if($isAdmin)
                            Danh sách tất cả đơn đặt phòng
                        @else
                            Danh sách đơn đặt phòng của tôi
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if($bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Khách hàng</th>
                                        <th>Phòng</th>
                                        <th>Ngày nhận</th>
                                        <th>Ngày trả</th>
                                        <th>Số khách</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td><strong>#{{ $booking->id }}</strong></td>
                                        <td>
                                            <div>
                                                <strong>{{ $booking->customer_name }}</strong><br>
                                                <small class="text-muted">{{ $booking->customer_email }}</small><br>
                                                <small class="text-muted">{{ $booking->customer_phone }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $booking->room->name ?? 'N/A' }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($booking->checkin)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->checkout)->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $booking->guests }} người</span>
                                        </td>
                                        <td>
                                            <strong class="text-success">{{ number_format($booking->total_price) }} VNĐ</strong>
                                        </td>
                                        <td>
                                            @switch($booking->status)
                                                @case('pending')
                                                    <span class="badge bg-warning">Chờ xác nhận</span>
                                                    @break
                                                @case('confirmed')
                                                    <span class="badge bg-success">Đã xác nhận</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger">Đã hủy</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-info">Hoàn thành</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ $booking->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('booking.detail', $booking->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $bookings->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5>Không có đơn đặt phòng nào</h5>
                            <p class="text-muted">Không tìm thấy đơn đặt phòng nào phù hợp với tiêu chí tìm kiếm.</p>
                            <a href="{{ route('booking.history') }}" class="btn btn-primary">
                                <i class="fas fa-refresh me-2"></i>Xem tất cả
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form khi thay đổi status
    document.getElementById('status').addEventListener('change', function() {
        this.form.submit();
    });

    // Auto-submit form khi thay đổi ngày
    document.getElementById('date_from').addEventListener('change', function() {
        if (document.getElementById('date_to').value) {
            this.form.submit();
        }
    });

    document.getElementById('date_to').addEventListener('change', function() {
        if (document.getElementById('date_from').value) {
            this.form.submit();
        }
    });
});
</script>
@endsection
