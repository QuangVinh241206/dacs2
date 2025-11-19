@extends('layouts.user.master')
@section('content')
    <main class="flex-1 flex items-center justify-center py-12 bg-gradient-to-br from-blue-50 via-white to-blue-100">
        <div
            class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full border border-blue-100 transition-all duration-300 hover:shadow-blue-200">
            <div class="flex flex-col items-center mb-8">
                <div class="bg-primary bg-opacity-20 rounded-full p-4 mb-3 shadow-md">
                    <i class="ri-mail-send-line text-primary text-4xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2 tracking-tight">Liên hệ với chúng tôi</h2>
                <p class="text-gray-500 text-base">Bạn cần hỗ trợ? Hãy gửi thông tin, chúng tôi sẽ phản hồi nhanh nhất!</p>
            </div>
            <form class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="relative group">
                        <input id="fullname" type="text" required
                            class="peer w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-base bg-gray-50 transition"
                            placeholder=" " />
                        <label for="fullname"
                            class="absolute left-10 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none transition-all peer-focus:-top-3 peer-focus:left-3 peer-focus:text-xs peer-focus:text-primary peer-placeholder-shown:top-1/2 peer-placeholder-shown:left-10 peer-placeholder-shown:text-base">Họ
                            và tên</label>
                        <i class="ri-user-line absolute left-3 top-1/2 -translate-y-1/2 text-primary"></i>
                    </div>
                    <div class="relative group">
                        <input id="email" type="email" required
                            class="peer w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-base bg-gray-50 transition"
                            placeholder=" " />
                        <label for="email"
                            class="absolute left-10 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none transition-all peer-focus:-top-3 peer-focus:left-3 peer-focus:text-xs peer-focus:text-primary peer-placeholder-shown:top-1/2 peer-placeholder-shown:left-10 peer-placeholder-shown:text-base">Email</label>
                        <i class="ri-mail-line absolute left-3 top-1/2 -translate-y-1/2 text-primary"></i>
                    </div>
                </div>
                <div class="relative group">
                    <input id="phone" type="tel"
                        class="peer w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-base bg-gray-50 transition"
                        placeholder=" " />
                    <label for="phone"
                        class="absolute left-10 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none transition-all peer-focus:-top-3 peer-focus:left-3 peer-focus:text-xs peer-focus:text-primary peer-placeholder-shown:top-1/2 peer-placeholder-shown:left-10 peer-placeholder-shown:text-base">Số
                        điện thoại</label>
                    <i class="ri-phone-line absolute left-3 top-1/2 -translate-y-1/2 text-primary"></i>
                </div>
                <div class="relative group">
                    <input id="subject" type="text"
                        class="peer w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-base bg-gray-50 transition"
                        placeholder=" " />
                    <label for="subject"
                        class="absolute left-10 top-1/2 -translate-y-1/2 text-gray-400 text-base pointer-events-none transition-all peer-focus:-top-3 peer-focus:left-3 peer-focus:text-xs peer-focus:text-primary peer-placeholder-shown:top-1/2 peer-placeholder-shown:left-10 peer-placeholder-shown:text-base">Chủ
                        đề</label>
                    <i class="ri-bookmark-line absolute left-3 top-1/2 -translate-y-1/2 text-primary"></i>
                </div>
                <div class="relative group">
                    <textarea id="message" rows="4" required
                        class="peer w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary text-base bg-gray-50 transition resize-none"
                        placeholder=" "></textarea>
                    <label for="message"
                        class="absolute left-10 top-6 text-gray-400 text-base pointer-events-none transition-all peer-focus:-top-3 peer-focus:left-3 peer-focus:text-xs peer-focus:text-primary peer-placeholder-shown:top-6 peer-placeholder-shown:left-10 peer-placeholder-shown:text-base">Nội
                        dung liên hệ</label>
                    <i class="ri-chat-3-line absolute left-3 top-6 text-primary"></i>
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-primary to-blue-400 text-white py-3 rounded-xl font-semibold text-lg shadow-md hover:scale-105 hover:shadow-lg transition-all duration-200">Gửi
                    liên hệ</button>
            </form>
            <div class="mt-10">
                <h3 class="text-lg font-semibold mb-2 text-primary">Thông tin liên hệ</h3>
                <ul class="space-y-2 text-gray-600 text-base">
                    <li class="flex items-center"><i class="ri-map-pin-line text-primary mr-2"></i> 123 Đường Lê Lợi, Quận
                        1, TP.Đà Nẵng</li>
                    <li class="flex items-center"><i class="ri-phone-line text-primary mr-2"></i> 0123 456 789</li>
                    <li class="flex items-center"><i class="ri-mail-line text-primary mr-2"></i> info@giuongdep.vn</li>
                    <li class="flex items-center"><i class="ri-time-line text-primary mr-2"></i> Thứ 2 - Chủ nhật: 8:00 -
                        21:00</li>
                </ul>
            </div>
        </div>
    </main>
@endsection