<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Khách sạn Miền Tây')</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    @yield('styles')
</head>
<body>
    <!-- Header -->
    <header style="background-color: #234F16;" class="py-2 mb-4 border-bottom text-white">
        <div class="container d-flex justify-content-between align-items-center">
            <img src="/images/logo.jpg" alt="logo" style="max-height: 60px; width: auto;">
            <h2 class="mb-0">Khách sạn Miền Tây</h2>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-home me-2"></i>Trang chủ
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/search-room">
                            <i class="fas fa-search me-1"></i>Tìm phòng
                        </a>
                    </li>
                    @if(session('user_logged_in'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('booking.history') }}">
                            <i class="fas fa-history me-1"></i>Lịch sử
                        </a>
                    </li>
                    @endif
                </ul>
                
                <ul class="navbar-nav">
                    @if(session('user_logged_in'))
                        <!-- Đã đăng nhập -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ session('user_name', 'Tài khoản') }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/profile">
                                    <i class="fas fa-user-circle me-2"></i>Thông tin cá nhân
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('booking.history') }}">
                                    <i class="fas fa-history me-2"></i>Lịch sử đặt phòng
                                </a></li>
                                @if(session('user_email') === 'admin@hotel.com')
                                    <!-- Chỉ admin mới thấy menu quản lý -->
                                    <li><a class="dropdown-item" href="/admin/rooms">
                                        <i class="fas fa-bed me-2"></i>Quản lý phòng
                                    </a></li>
                                    <li><a class="dropdown-item" href="/admin/bookings">
                                        <i class="fas fa-list me-2"></i>Quản lý đơn đặt phòng
                                    </a></li>
                                    <li><a class="dropdown-item" href="/admin/staff">
                                        <i class="fas fa-users me-2"></i>Danh sách nhân viên
                                    </a></li>
                                    <li><a class="dropdown-item" href="/admin/staff/create">
                                        <i class="fas fa-user-plus me-2"></i>Thêm nhân viên
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><a class="dropdown-item" href="/logout">
                                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                </a></li>
                            </ul>
                        </li>
                    @else
                        <!-- Chưa đăng nhập -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>Tài khoản
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                                </a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">
                                    <i class="fas fa-user-plus me-2"></i>Đăng ký
                                </a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Khách sạn Miền Tây</h5>
                    <p>Trải nghiệm nghỉ dưỡng đẳng cấp và tiện nghi</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <p>Địa chỉ: 123 Đường ABC, Quận Ninh Kiều, TP. Cần Thơ<br>
                    Điện thoại: 0123 456 789<br>
                    Email: info@khachsannmientay.com</p>
                </div>
                <div class="col-md-4">
                    <h5>Theo dõi chúng tôi</h5>
                    <p>Facebook: Khách sạn Miền Tây<br>
                    Instagram: @khachsannmientay</p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; 2025 Khách sạn Miền Tây. Bảo lưu mọi quyền.</p>
            </div>
        </div>
    </footer>

    <!-- Modal Đăng nhập -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đăng nhập</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="/login" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                    </form>
                    <hr>
                    <p class="text-center mb-0">
                        Chưa có tài khoản? 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">
                            Đăng ký ngay
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Đăng ký -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đăng ký tài khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="/register" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                        </div>
                        <div class="mb-3">
                            <label for="reg_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="reg_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="reg_password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="reg_password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="confirm_password" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                    </form>
                    <hr>
                    <p class="text-center mb-0">
                        Đã có tài khoản? 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
                            Đăng nhập
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html> 