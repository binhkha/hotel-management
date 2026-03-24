<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Đặt Phòng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Test Đặt Phòng</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="/book-room" method="POST">
                            @csrf
                            <input type="hidden" name="room_id" value="1">
                            
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
                                            <option value="1">1 người</option>
                                            <option value="2">2 người</option>
                                            <option value="3">3 người</option>
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

                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email">
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Ghi chú</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Test Đặt Phòng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkinInput = document.getElementById('checkin');
            const checkoutInput = document.getElementById('checkout');
            const nightsInput = document.getElementById('nights');
            
            // Set minimum date
            const today = new Date().toISOString().split('T')[0];
            checkinInput.min = today;
            checkoutInput.min = today;
            
            // Calculate nights
            function calculateNights() {
                if (checkinInput.value && checkoutInput.value) {
                    const checkin = new Date(checkinInput.value);
                    const checkout = new Date(checkoutInput.value);
                    const nights = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));
                    
                    if (nights > 0) {
                        nightsInput.value = nights;
                    } else {
                        nightsInput.value = '';
                    }
                }
            }
            
            checkinInput.addEventListener('change', function() {
                checkoutInput.min = this.value;
                if (checkoutInput.value && checkoutInput.value < this.value) {
                    checkoutInput.value = this.value;
                }
                calculateNights();
            });
            
            checkoutInput.addEventListener('change', calculateNights);
        });
    </script>
</body>
</html>
