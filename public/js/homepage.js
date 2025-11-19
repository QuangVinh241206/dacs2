// mobileMenuScript
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    mobileMenuButton.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
    });
});

// priceRangeScript
document.addEventListener('DOMContentLoaded', function() {
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');
    
    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price) + '₫';
    }
    
    priceRange.addEventListener('input', function() {
        priceValue.textContent = formatPrice(this.value);
    });
});

// backToTopScript
document.addEventListener('DOMContentLoaded', function() {
    const backToTopButton = document.getElementById('backToTop');
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.remove('opacity-0', 'invisible');
            backToTopButton.classList.add('opacity-100', 'visible');
        } else {
            backToTopButton.classList.add('opacity-0', 'invisible');
            backToTopButton.classList.remove('opacity-100', 'visible');
        }
    });
    
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});

// chatBoxScript
document.addEventListener('DOMContentLoaded', function() {
    const chatButton = document.getElementById('chatButton');
    const chatBox = document.getElementById('chatBox');
    const closeChatBox = document.getElementById('closeChatBox');
    const chatInput = document.getElementById('chatInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatMessages = document.getElementById('chatMessages');
    
    chatButton.addEventListener('click', function() {
        chatBox.classList.toggle('opacity-0');
        chatBox.classList.toggle('invisible');
        chatBox.classList.toggle('translate-y-4');
    });
    
    closeChatBox.addEventListener('click', function() {
        chatBox.classList.add('opacity-0', 'invisible', 'translate-y-4');
    });
    
    function sendChatMessage() {
        const message = chatInput.value.trim();
        if (message) {
            const now = new Date();
            const time = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();
            
            const userMessage = document.createElement('div');
            userMessage.className = 'flex mb-4 justify-end';
            userMessage.innerHTML = `
                <div class="bg-primary bg-opacity-10 p-3 rounded-lg shadow-sm max-w-[80%]">
                    <p class="text-gray-700 text-sm">${message}</p>
                    <span class="text-xs text-gray-500 mt-1 block">${time}</span>
                </div>
            `;
            chatMessages.appendChild(userMessage);
            chatInput.value = '';
            chatMessages.scrollTop = chatMessages.scrollHeight;

            setTimeout(function() {
                const botMessage = document.createElement('div');
                botMessage.className = 'flex mb-4';
                botMessage.innerHTML = `
                    <div class="w-8 h-8 flex items-center justify-center bg-primary rounded-full text-white mr-2 flex-shrink-0">
                        <i class="ri-customer-service-2-line"></i>
                    </div>
                    <div class="bg-white p-3 rounded-lg shadow-sm max-w-[80%]">
                        <p class="text-gray-700 text-sm">Cảm ơn bạn đã liên hệ. Nhân viên tư vấn sẽ phản hồi trong vòng 5 phút.</p>
                        <span class="text-xs text-gray-500 mt-1 block">${time}</span>
                    </div>
                `;
                chatMessages.appendChild(botMessage);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 1000);
        }
    }

    sendMessage.addEventListener('click', sendChatMessage);
    
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendChatMessage();
        }
    });
});
