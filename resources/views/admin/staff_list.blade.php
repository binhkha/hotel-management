@extends('layouts.app')

@section('title', 'Danh sách nhân viên - Khách sạn Miền Tây')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2"></i>Danh sách nhân viên
                    </h5>
                    <div>
                        <a href="/admin/staff/create" class="btn btn-light btn-sm">
                            <i class="fas fa-plus me-2"></i>Thêm nhân viên
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($staff) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ và tên</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Chức vụ</th>
                                        <th>Địa chỉ</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staff as $member)
                                    <tr>
                                        <td>{{ $member->id }}</td>
                                        <td>
                                            <strong>{{ $member->name }}</strong>
                                        </td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ $member->phone ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $member->position_name }}</span>
                                        </td>
                                        <td>{{ Str::limit($member->address ?? 'N/A', 50) }}</td>
                                        <td>{{ $member->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="/admin/staff/{{ $member->id }}/edit" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteStaff({{ $member->id }}, '{{ $member->name }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5>Chưa có nhân viên nào</h5>
                            <p class="text-muted">Hãy thêm nhân viên đầu tiên để bắt đầu quản lý.</p>
                            <a href="/admin/staff/create" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Thêm nhân viên
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteStaff(id, name) {
    if (confirm(`Bạn có chắc muốn xóa nhân viên "${name}"?`)) {
        fetch(`/admin/staff/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa nhân viên!');
        });
    }
}
</script>
@endsection

