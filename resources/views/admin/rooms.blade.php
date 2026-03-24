@extends('layouts.app')

@section('title', 'Quản lý phòng - Khách sạn Miền Tây')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Quản lý phòng</h4>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                        <i class="fas fa-plus me-2"></i>Thêm phòng mới
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên phòng</th>
                                    <th>Loại</th>
                                    <th>Số khách tối đa</th>
                                    <th>Giá (VNĐ)</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                <tr>
                                    <td>{{ $room->id }}</td>
                                    <td>
                                        <img src="{{ asset('images/' . $room->image) }}" 
                                             alt="{{ $room->name }}" 
                                             style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                    </td>
                                    <td>{{ $room->name }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ ucfirst($room->type) }}</span>
                                    </td>
                                    <td>{{ $room->max_guests }} người</td>
                                    <td>{{ number_format($room->price, 0, ',', '.') }}</td>
                                    <td>
                                        <select class="form-select form-select-sm status-select" 
                                                data-room-id="{{ $room->id }}"
                                                style="width: auto;">
                                            <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>
                                                Trống
                                            </option>
                                            <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>
                                                Đã thuê
                                            </option>
                                            <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>
                                                Bảo trì
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="editRoom({{ $room->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteRoom({{ $room->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm phòng -->
<div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm phòng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/rooms" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên phòng</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type" class="form-label">Loại phòng</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="">Chọn loại phòng</option>
                                    <option value="standard">Standard</option>
                                    <option value="superior">Superior</option>
                                    <option value="deluxe">Deluxe</option>
                                    <option value="suite">Suite</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_guests" class="form-label">Số khách tối đa</label>
                                <input type="number" class="form-control" id="max_guests" name="max_guests" min="1" max="10" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Giá (VNĐ)</label>
                                <input type="number" class="form-control" id="price" name="price" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Hình ảnh</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm phòng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Cập nhật trạng thái phòng
document.addEventListener('DOMContentLoaded', function() {
    const statusSelects = document.querySelectorAll('.status-select');
    
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const roomId = this.dataset.roomId;
            const status = this.value;
            
            fetch(`/admin/rooms/${roomId}/status`, {
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
                    showAlert('success', data.message);
                } else {
                    showAlert('error', data.message);
                }
            })
            .catch(error => {
                showAlert('error', 'Có lỗi xảy ra khi cập nhật trạng thái!');
            });
        });
    });
});

function editRoom(id) {
    alert('Chức năng sửa phòng sẽ được phát triển sau');
}

function deleteRoom(id) {
    if (confirm('Bạn có chắc chắn muốn xóa phòng này?')) {
        // Gửi request xóa phòng
        fetch(`/admin/rooms/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
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
