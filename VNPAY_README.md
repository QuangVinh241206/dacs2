# VNPay QR Payment Integration

## Cấu hình VNPay

1. Đăng ký tài khoản VNPay tại: https://sandbox.vnpayment.vn/
2. Lấy TMN Code và Hash Secret từ VNPay
3. Cập nhật file `.env`:

```env
VNPAY_TMN_CODE=YOUR_TMNCODE
VNPAY_HASH_SECRET=YOUR_HASHSECRET
VNPAY_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
```

## Quy trình thanh toán

1. Người dùng chọn sản phẩm và thêm vào giỏ hàng
2. Tại trang checkout, người dùng nhập thông tin và chọn phương thức thanh toán
3. Nếu chọn "Chuyển khoản QR":
    - Hệ thống tạo URL thanh toán VNPay
    - Chuyển hướng người dùng đến trang thanh toán VNPay
    - Sau khi thanh toán, VNPay sẽ redirect về `checkout/vnpay/return`
    - Hệ thống cập nhật trạng thái đơn hàng dựa trên kết quả thanh toán

## Các trạng thái đơn hàng

-   `pending`: Chờ xử lý
-   `paid`: Đã thanh toán
-   `payment_failed`: Thanh toán thất bại
-   `shipped`: Đang giao hàng
-   `delivered`: Đã giao hàng

## API Endpoints

-   `POST /checkout`: Tạo đơn hàng
-   `GET /checkout/vnpay/return`: Xử lý kết quả thanh toán VNPay
-   `GET /orders/{id}`: Xem chi tiết đơn hàng

## Lưu ý

-   Đảm bảo đã cài đặt PHP extension cho hash_hmac
-   Trong production, sử dụng URL thật của VNPay thay vì sandbox
-   Kiểm tra kỹ các thông tin TMN Code và Hash Secret
