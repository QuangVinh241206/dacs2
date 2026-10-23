# DACS2 - Website bán hàng

DACS2 là website thương mại điện tử được xây dựng bằng Laravel. Ứng dụng hỗ
trợ khách hàng xem và tìm kiếm sản phẩm, quản lý giỏ hàng, đặt hàng, đánh giá
sản phẩm và thanh toán trực tuyến qua PayOS. Quản trị viên có khu vực riêng để
quản lý sản phẩm, danh mục, biến thể, hình ảnh, mã giảm giá, người dùng và đơn
hàng.

## Chức năng chính

### Khách hàng

- Đăng ký, đăng nhập, đăng xuất và đặt lại mật khẩu.
- Xem sản phẩm mới, sản phẩm giảm giá, chi tiết sản phẩm và các biến thể.
- Thêm sản phẩm yêu thích, thêm/cập nhật/xóa sản phẩm trong giỏ hàng.
- Đặt hàng, áp dụng mã giảm giá và theo dõi trạng thái đơn hàng.
- Thanh toán trực tuyến qua PayOS.
- Xem lịch sử mua hàng và đánh giá sản phẩm.
- Quản lý thông tin cá nhân và đổi mật khẩu.
- Trao đổi với chức năng chat được tích hợp trong ứng dụng.

### Quản trị viên

Truy cập khu vực quản trị tại `/admin` sau khi đăng nhập bằng tài khoản có
`role` là `admin`. Các chức năng gồm:

- Dashboard và thống kê.
- CRUD sản phẩm, danh mục và mã giảm giá.
- Quản lý biến thể, hình ảnh và ảnh đại diện của sản phẩm.
- Quản lý người dùng, đơn hàng và trạng thái đơn hàng.
- Khôi phục hoặc xóa vĩnh viễn dữ liệu đã đưa vào thùng rác.
- Cập nhật thông tin tài khoản quản trị.

## Công nghệ sử dụng

- PHP `^8.2`
- Laravel `^12.0`
- MySQL (cấu hình mặc định trong `.env.example`)
- Vite `^7` và Tailwind CSS `^4`
- Node.js và npm
- PayOS cho thanh toán trực tuyến (tùy chọn khi phát triển)

## Yêu cầu môi trường

Trước khi cài đặt, cần chuẩn bị:

- PHP 8.2 trở lên, bật các extension cần thiết cho Laravel và PDO MySQL.
- Composer.
- Node.js và npm.
- MySQL đang chạy trên máy local.
- Git nếu muốn clone mã nguồn.

Có thể kiểm tra nhanh phiên bản:

```powershell
php -v
composer --version
node -v
npm -v
```

## Cài đặt và cấu hình

Mở PowerShell tại thư mục dự án rồi thực hiện:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
npm install
```

Tạo cơ sở dữ liệu MySQL, mặc định là `dacs2`, sau đó mở `.env` và cập nhật
thông tin kết nối:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dacs2
DB_USERNAME=root
DB_PASSWORD=
```

Chạy migration:

```powershell
php artisan migrate
```

Nếu muốn tạo dữ liệu mẫu cho sản phẩm, danh mục, mã giảm giá, người dùng và
đơn hàng, chạy:

```powershell
php artisan db:seed
```

Hoặc có thể gộp hai bước trên:

```powershell
php artisan migrate --seed
```

Để các tệp người dùng lưu trong `storage/app/public` có thể được truy cập từ
web, tạo symbolic link:

```powershell
php artisan storage:link
```

## Chạy dự án

### Chế độ phát triển

Lệnh sau khởi chạy Laravel, queue worker và Vite cùng lúc:

```powershell
composer run dev
```

Sau đó mở [http://localhost:8000](http://localhost:8000). Nếu cổng mặc định
đang được sử dụng, có thể chạy riêng Laravel ở cổng khác:

```powershell
php artisan serve --port=8080
```

Trong trường hợp chạy riêng backend và frontend, mở hai cửa sổ PowerShell:

```powershell
php artisan serve
npm run dev
```

### Build frontend

Tạo bundle frontend dùng cho môi trường triển khai:

```powershell
npm run build
```

## Tài khoản dữ liệu mẫu

Các tài khoản dưới đây được tạo bởi `php artisan db:seed` và chỉ nên dùng cho
môi trường phát triển:

| Vai trò | Email | Mật khẩu |
| --- | --- | --- |
| Quản trị viên | `admin@example.com` | `123456` |
| Người dùng | `nguyenvanan@example.com` | `password` |

Hãy đổi hoặc xóa các tài khoản mẫu trước khi triển khai thật. Không sử dụng
mật khẩu mẫu trong môi trường production.

## Cấu hình PayOS

Để bật thanh toán PayOS, điền các biến sau trong `.env` bằng thông tin lấy từ
tài khoản PayOS:

```dotenv
PAYOS_BASE_URL=https://api-merchant.payos.vn
PAYOS_CLIENT_ID=
PAYOS_API_KEY=
PAYOS_CHECKSUM_KEY=
```

Không đưa các khóa PayOS, `APP_KEY` hoặc thông tin đăng nhập cơ sở dữ liệu vào
Git. Khi thay đổi biến môi trường, có thể xóa cache cấu hình bằng:

```powershell
php artisan config:clear
```

URL webhook PayOS cần trỏ đến endpoint:

```text
/user/checkout/payos/webhook
```

Địa chỉ webhook phải có thể truy cập từ Internet khi kiểm thử thanh toán trên
môi trường local (có thể dùng công cụ tạo tunnel phù hợp).

## Kiểm thử và định dạng mã nguồn

Chạy toàn bộ test:

```powershell
composer test
```

Kiểm tra và tự động định dạng mã PHP bằng Laravel Pint:

```powershell
vendor\bin\pint.bat
```

## Cấu trúc thư mục đáng chú ý

```text
app/                 Controller, model, middleware và service
database/migrations/ Định nghĩa cấu trúc cơ sở dữ liệu
database/seeders/   Dữ liệu mẫu
resources/views/    Giao diện Blade cho khách hàng và quản trị
resources/js/        Mã JavaScript nguồn
resources/css/      CSS nguồn
routes/web.php      Các route của ứng dụng
public/              Tài nguyên public và file build
storage/             Log và file được người dùng tải lên
```

## Lưu ý khi phát triển và triển khai

- Không bật `APP_DEBUG=true` trên production. Dùng `APP_ENV=production` và
  tạo `APP_KEY` riêng cho môi trường đó.
- Sao lưu cơ sở dữ liệu trước khi chạy các lệnh migration có thay đổi dữ liệu.
- `php artisan migrate:fresh --seed` sẽ xóa toàn bộ bảng và tạo lại dữ liệu
  mẫu; chỉ dùng trong môi trường phát triển hoặc kiểm thử.
- Queue, session và cache hiện được cấu hình sử dụng database. Vì vậy cần
  chạy migration đầy đủ trước khi sử dụng các chức năng này.
- Kiểm tra quyền ghi của `storage/` và `bootstrap/cache/` khi triển khai.
- Sau khi thay đổi route, cấu hình hoặc frontend, hãy kiểm tra log trong
  `storage/logs/laravel.log` và chạy lại lệnh build/test tương ứng.
- Không chỉnh sửa trực tiếp các thư mục `vendor/` và `node_modules/`; hãy thay
  đổi dependency trong `composer.json` hoặc `package.json`, sau đó cài đặt lại.

## Giấy phép

Dự án sử dụng Laravel và các thư viện mã nguồn mở tương ứng. Vui lòng kiểm tra
giấy phép của từng dependency trước khi phân phối hoặc triển khai thương mại.
