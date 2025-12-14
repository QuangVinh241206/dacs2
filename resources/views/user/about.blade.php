@extends('layouts.user.master')
@section('content')
    <!-- Hero Section -->
    <section class="hero-section w-full h-[400px] flex items-center">
        <div class="container mx-auto px-4">
            <div class="max-w-lg">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Về Chúng Tôi</h1>
                <p class="text-lg text-gray-700">Hơn 15 năm kinh nghiệm trong lĩnh vực nội thất phòng ngủ cao cấp</p>
            </div>
        </div>
    </section>
    <!-- Story Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Câu chuyện của chúng tôi</h2>
                    <p class="text-gray-600 mb-6">Được thành lập vào năm 2010, Giường Đẹp bắt đầu từ một cửa hàng nhỏ tại
                        Quận 1, TP. Hồ Chí Minh. Với tâm huyết mang đến những sản phẩm nội thất phòng ngủ chất lượng cao cho
                        người Việt Nam, chúng tôi đã không ngừng phát triển và mở rộng quy mô hoạt động.</p>
                    <p class="text-gray-600 mb-6">Ngày nay, Giường Đẹp tự hào là một trong những thương hiệu nội thất phòng
                        ngủ hàng đầu tại Việt Nam, với hệ thống showroom trải dài khắp các tỉnh thành lớn và đội ngũ nhân
                        viên chuyên nghiệp luôn sẵn sàng phục vụ khách hàng.</p>
                    <div class="grid grid-cols-3 gap-6 mb-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary mb-2">15+</div>
                            <p class="text-gray-600">Năm kinh nghiệm</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary mb-2">50k+</div>
                            <p class="text-gray-600">Khách hàng</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary mb-2">20+</div>
                            <p class="text-gray-600">Showroom</p>
                        </div>
                    </div>
                </div>
                <div>
                    <img src="https://readdy.ai/api/search-image?query=modern%2520furniture%2520workshop%2520with%2520craftsmen%2520working%2520on%2520wooden%2520bed%2520frames%2C%2520professional%2520woodworking%2520environment%2C%2520quality%2520control%2C%2520skilled%2520artisans%2C%2520natural%2520materials%2C%2520clean%2520workspace%2C%2520on%2520plain%2520white%2520background&width=600&height=400&seq=about2&orientation=landscape"
                        alt="Về chúng tôi" class="rounded-lg shadow-lg w-full">
                </div>
            </div>
        </div>
    </section>
    <!-- Values Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Giá trị cốt lõi</h2>
                <p class="text-gray-600">Những giá trị định hình nên thương hiệu và cam kết của chúng tôi với khách hàng</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-sm text-center">
                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ri-heart-line text-primary ri-2x"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Chất lượng</h3>
                    <p class="text-gray-600">Cam kết sử dụng nguyên liệu cao cấp và quy trình sản xuất nghiêm ngặt để tạo ra
                        những sản phẩm bền đẹp, an toàn cho sức khỏe.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm text-center">
                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ri-shield-star-line text-primary ri-2x"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Uy tín</h3>
                    <p class="text-gray-600">Xây dựng niềm tin với khách hàng thông qua sự minh bạch trong kinh doanh và
                        dịch vụ hậu mãi chu đáo.</p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm text-center">
                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ri-customer-service-2-line text-primary ri-2x"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Dịch vụ</h3>
                    <p class="text-gray-600">Đặt khách hàng làm trung tâm, cung cấp dịch vụ tư vấn chuyên nghiệp và hỗ trợ
                        tận tâm.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Đội ngũ lãnh đạo</h2>
                <p class="text-gray-600">Những người đồng hành và dẫn dắt Giường Đẹp phát triển</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-48 h-48 rounded-full overflow-hidden mx-auto mb-4">
                        <img src="https://readdy.ai/api/search-image?query=professional%2520asian%2520businessman%2520portrait%2C%2520confident%2520pose%2C%2520formal%2520attire%2C%2520warm%2520smile%2C%2520leadership%2520presence%2C%2520executive%2520headshot%2C%2520clean%2520background%2C%2520high-quality%2520corporate%2520photography&width=200&height=200&seq=ceo&orientation=squarish"
                            alt="CEO" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Nguyễn Minh Quân</h3>
                    <p class="text-gray-600 mb-2">Giám đốc điều hành</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <i class="ri-linkedin-fill"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <i class="ri-facebook-fill"></i>
                        </a>
                    </div>
                </div>
                <div class="text-center">
                    <div class="w-48 h-48 rounded-full overflow-hidden mx-auto mb-4">
                        <img src="https://readdy.ai/api/search-image?query=professional%2520asian%2520businesswoman%2520portrait%2C%2520confident%2520pose%2C%2520formal%2520attire%2C%2520warm%2520smile%2C%2520leadership%2520presence%2C%2520executive%2520headshot%2C%2520clean%2520background%2C%2520high-quality%2520corporate%2520photography&width=200&height=200&seq=coo&orientation=squarish"
                            alt="COO" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Trần Thu Hà</h3>
                    <p class="text-gray-600 mb-2">Giám đốc vận hành</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <i class="ri-linkedin-fill"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <i class="ri-facebook-fill"></i>
                        </a>
                    </div>
                </div>
                <div class="text-center">
                    <div class="w-48 h-48 rounded-full overflow-hidden mx-auto mb-4">
                        <img src="https://readdy.ai/api/search-image?query=professional%2520asian%2520businessman%2520portrait%2C%2520creative%2520director%2C%2520casual%2520smart%2520attire%2C%2520friendly%2520smile%2C%2520artistic%2520presence%2C%2520design%2520leader%2520headshot%2C%2520clean%2520background%2C%2520high-quality%2520corporate%2520photography&width=200&height=200&seq=design&orientation=squarish"
                            alt="Design Director" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Lê Thanh Tùng</h3>
                    <p class="text-gray-600 mb-2">Giám đốc thiết kế</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <i class="ri-linkedin-fill"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <i class="ri-facebook-fill"></i>
                        </a>
                    </div>
                </div>
                <div class="text-center">
                    <div class="w-48 h-48 rounded-full overflow-hidden mx-auto mb-4">
                        <img src="https://readdy.ai/api/search-image?query=professional%2520asian%2520businessman%2520portrait%2C%2520sales%2520director%2C%2520business%2520attire%2C%2520confident%2520smile%2C%2520commercial%2520presence%2C%2520sales%2520leader%2520headshot%2C%2520clean%2520background%2C%2520high-quality%2520corporate%2520photography&width=200&height=200&seq=sales&orientation=squarish"
                            alt="Sales Director" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-1">Phạm Văn Đức</h3>
                    <p class="text-gray-600 mb-2">Giám đốc kinh doanh</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <i class="ri-linkedin-fill"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary">
                            <i class="ri-facebook-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Showroom Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Hệ thống showroom</h2>
                <p class="text-gray-600">Ghé thăm showroom gần nhất để trải nghiệm sản phẩm</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Showroom Quận 1 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="w-full h-48">
                        <iframe
                            src="https://www.google.com/maps?q={{ urlencode('123 Đường Lê Lợi, Phường Bến Nghé, Quận 1, TP. HCM') }}&output=embed"
                            class="w-full h-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            aria-label="Showroom Quận 1"></iframe>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Showroom Quận 1</h3>
                        <p class="text-gray-600 mb-4">123 Đường Lê Lợi, Phường Bến Nghé, Quận 1, TP. HCM</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-600">
                                <i class="ri-time-line mr-2"></i>
                                <span>08:00 - 21:00</span>
                            </div>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode('123 Đường Lê Lợi, Phường Bến Nghé, Quận 1, TP. HCM') }}"
                               target="_blank" class="text-primary hover:underline">Mở trên Google Maps</a>
                        </div>
                    </div>
                </div>

                <!-- Showroom Quận 7 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="w-full h-48">
                        <iframe
                            src="https://www.google.com/maps?q={{ urlencode('456 Nguyễn Thị Thập, Phường Tân Phú, Quận 7, TP. HCM') }}&output=embed"
                            class="w-full h-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            aria-label="Showroom Quận 7"></iframe>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Showroom Quận 7</h3>
                        <p class="text-gray-600 mb-4">456 Nguyễn Thị Thập, Phường Tân Phú, Quận 7, TP. HCM</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-600">
                                <i class="ri-time-line mr-2"></i>
                                <span>08:00 - 21:00</span>
                            </div>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode('456 Nguyễn Thị Thập, Phường Tân Phú, Quận 7, TP. HCM') }}"
                               target="_blank" class="text-primary hover:underline">Mở trên Google Maps</a>
                        </div>
                    </div>
                </div>

                <!-- Showroom Hà Nội -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="w-full h-48">
                        <iframe
                            src="https://www.google.com/maps?q={{ urlencode('789 Đường Láng, Quận Đống Đa, Hà Nội') }}&output=embed"
                            class="w-full h-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            aria-label="Showroom Hà Nội"></iframe>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Showroom Hà Nội</h3>
                        <p class="text-gray-600 mb-4">789 Đường Láng, Quận Đống Đa, Hà Nội</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-600">
                                <i class="ri-time-line mr-2"></i>
                                <span>08:00 - 21:00</span>
                            </div>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode('789 Đường Láng, Quận Đống Đa, Hà Nội') }}"
                               target="_blank" class="text-primary hover:underline">Mở trên Google Maps</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection