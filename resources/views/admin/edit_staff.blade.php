@extends('layouts.app')

@section('title', 'Chỉnh sửa nhân viên - Khách sạn Miền Tây')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Chỉnh sửa nhân viên: {{ $staff->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/admin/staff/{{ $staff->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ và tên *</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $staff->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $staff->email }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ $staff->phone }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Chức vụ *</label>
                                    <select class="form-select" id="position" name="position" required>
                                        <option value="">Chọn chức vụ</option>
                                        <option value="receptionist" {{ $staff->position == 'receptionist' ? 'selected' : '' }}>Lễ tân</option>
                                        <option value="housekeeper" {{ $staff->position == 'housekeeper' ? 'selected' : '' }}>Nhân viên dọn phòng</option>
                                        <option value="manager" {{ $staff->position == 'manager' ? 'selected' : '' }}>Quản lý</option>
                                        <option value="maintenance" {{ $staff->position == 'maintenance' ? 'selected' : '' }}>Bảo trì</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ $staff->address }}</textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="/admin/staff" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Cập nhật nhân viên
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

