<footer class="bg-gray-900 text-white pt-12 pb-6">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
                <a href="#" class="text-2xl font-['Pacifico'] text-white mb-4 inline-block">Giường Đẹp</a>
                <p class="text-gray-400 mb-4">Chuyên cung cấp các sản phẩm giường ngủ và nội thất phòng ngủ chất lượng
                    cao với giá cả hợp lý.</p>
                <div class="flex space-x-4">
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 hover:bg-primary transition">
                        <i class="ri-facebook-fill"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 hover:bg-primary transition">
                        <i class="ri-instagram-line"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 hover:bg-primary transition">
                        <i class="ri-youtube-line"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-800 hover:bg-primary transition">
                        <i class="ri-tiktok-line"></i>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Tài khoản</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('user.account.index') }}" class="text-gray-400 hover:text-white transition">Tài khoản của tôi</a></li>
                    <li><a href="" class="text-gray-400 hover:text-white transition">Theo dõi đơn hàng</a></li>
                    <li><a href="" class="text-gray-400 hover:text-white transition">Danh sách yêu thích</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Liên hệ</h3>
                <ul class="space-y-3">
                    <li class="flex">
                        <div class="w-5 h-5 flex items-center justify-center text-primary mr-3">
                            <i class="ri-map-pin-line"></i>
                        </div>
                        <span class="text-gray-400">470 Trần Đại Nghĩa, Quận Ngũ Hành Sơn, TP.Đà Nẵng</span>
                    </li>
                    <li class="flex">
                        <div class="w-5 h-5 flex items-center justify-center text-primary mr-3">
                            <i class="ri-phone-line"></i>
                        </div>
                        <span class="text-gray-400">0123 456 789</span>
                    </li>
                    <li class="flex">
                        <div class="w-5 h-5 flex items-center justify-center text-primary mr-3">
                            <i class="ri-mail-line"></i>
                        </div>
                        <span class="text-gray-400">info@giuongdep.vn</span>
                    </li>
                    <li class="flex">
                        <div class="w-5 h-5 flex items-center justify-center text-primary mr-3">
                            <i class="ri-time-line"></i>
                        </div>
                        <span class="text-gray-400">Thứ 2 - Chủ nhật: 8:00 - 21:00</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm mb-4 md:mb-0">© 2025 Giường Đẹp. Tất cả quyền được bảo lưu.</p>
            <div class="flex items-center space-x-4">
                <span class="text-gray-400 text-sm">Thanh toán qua:</span>
                <div class="flex space-x-3">
                    <i class="ri-visa-fill ri-lg"></i>
                    <i class="ri-mastercard-fill ri-lg"></i>
                    <i class="ri-paypal-fill ri-lg"></i>
                    <i class="ri-bank-card-fill ri-lg"></i>
                </div>
            </div>
        </div>
    </div>
</footer>