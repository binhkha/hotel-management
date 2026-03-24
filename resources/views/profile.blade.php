@extends('layouts.app')

@section('title', 'Thông tin cá nhân - Khách sạn Miền Tây')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        Thông tin cá nhân
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Avatar Section -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <div class="rounded-circle border border-3 border-primary d-flex align-items-center justify-content-center bg-light"
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-user fa-4x text-muted"></i>
                                </div>
                                
                                <label for="avatar" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 cursor-pointer"
                                       style="cursor: pointer; width: 40px; height: 40px;">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="avatar" name="avatar" class="d-none" accept="image/*">
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">Click vào camera để thay đổi avatar</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ tên *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', '') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', '') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', '') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                           id="address" name="address" value="{{ old('address', '') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Staff info section (hidden for now) -->
                        <div class="row" style="display: none;">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Vai trò</label>
                                    <input type="text" class="form-control" value="" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Chức vụ</label>
                                    <input type="text" class="form-control" value="" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Password section (hidden for now) -->
                        <div style="display: none;">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                                <small class="text-muted">Chỉ điền nếu muốn thay đổi mật khẩu</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ url('/') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Quay lại
                            </a>
                            <div>
                                <a href="{{ route('booking.history') }}" class="btn btn-info me-2">
                                    <i class="fas fa-history me-2"></i>
                                    Lịch sử đặt phòng
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    Cập nhật thông tin
                                </button>
                            </div>
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
    // Preview avatar khi chọn file
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = avatarInput.parentElement.querySelector('img') || avatarInput.parentElement.querySelector('.bg-light');
    
    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (avatarPreview.tagName === 'IMG') {
                        avatarPreview.src = e.target.result;
                    } else {
                        // Thay thế div placeholder bằng img
                        const newImg = document.createElement('img');
                        newImg.src = e.target.result;
                        newImg.alt = 'Avatar';
                        newImg.className = 'rounded-circle border border-3 border-primary';
                        newImg.style = 'width: 150px; height: 150px; object-fit: cover;';
                        avatarPreview.parentElement.replaceChild(newImg, avatarPreview);
                    }
                };
                reader.readAsDataURL(file);
            } else {
                alert('Vui lòng chọn file hình ảnh!');
                avatarInput.value = '';
            }
        }
    });
});
</script>
@endsection
