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
    
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function openProductModal(product) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
        modal.id = 'productModal';
        
        const modalContent = `
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center p-6 border-b">
                    <h2 class="text-2xl font-bold text-gray-800">${escapeHtml(product.name)}</h2>
                    <button onclick="document.getElementById('productModal').remove()" class="text-gray-500 hover:text-gray-700">
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>
                
                <div class="p-6 space-y-4">
                    ${product.thumbnail ? `
                        <div class="flex justify-center">
                            <img src="${escapeHtml(product.thumbnail)}" alt="${escapeHtml(product.name)}" class="max-w-full h-64 object-cover rounded-lg">
                        </div>
                    ` : ''}
                    
                    <div class="text-3xl font-bold text-primary">
                        ${product.price ? new Intl.NumberFormat('vi-VN').format(product.price) + '₫' : 'Liên hệ'}
                    </div>
                    
                    ${product.reason ? `
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <p class="text-sm text-gray-700"><strong>Lý do gợi ý:</strong> ${escapeHtml(product.reason)}</p>
                        </div>
                    ` : ''}
                    
                    <div class="flex gap-3 pt-4">
                        <a href="/user/products/${escapeHtml(product.slug)}" class="flex-1 bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition-colors text-center">
                            Xem chi tiết
                        </a>
                        <button onclick="document.getElementById('productModal').remove()" class="flex-1 bg-gray-200 text-gray-800 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        modal.innerHTML = modalContent;
        document.body.appendChild(modal);
        
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.remove();
            }
        });
    }

    function renderProductSuggestions(products) {
        if (!products || products.length === 0) {
            return '';
        }
        
        let html = '<div class="mt-2 space-y-2">';
        products.forEach(product => {
            const name = escapeHtml(product.name);
            const price = product.price ? new Intl.NumberFormat('vi-VN').format(product.price) + '₫' : 'Liên hệ';
            const reason = product.reason ? escapeHtml(product.reason) : 'Sản phẩm phù hợp';
            const thumbnail = product.thumbnail ? escapeHtml(product.thumbnail) : '/images/placeholder.png';
            const productUrl = `/user/products/${escapeHtml(product.slug)}`;
            
            html += `
                <a href="${productUrl}" class="block border border-gray-200 rounded-lg p-2 hover:shadow-md transition-shadow hover:border-primary">
                    <div class="flex gap-2">
                        <img src="${thumbnail}" alt="${name}" class="w-16 h-16 object-cover rounded">
                        <div class="flex-1 text-sm">
                            <p class="font-semibold text-gray-800">${name}</p>
                            <p class="text-primary font-bold">${price}</p>
                            <p class="text-gray-600 text-xs mt-1">${reason}</p>
                        </div>
                    </div>
                </a>
            `;
        });
        html += '</div>';
        return html;
    }

    function appendUserMessageDOM(content, time) {
        const userMessage = document.createElement('div');
        userMessage.className = 'flex mb-4 justify-end';
        userMessage.innerHTML = `
            <div class="bg-primary bg-opacity-10 p-3 rounded-lg shadow-sm max-w-[80%]">
                <p class="text-gray-700 text-sm">${escapeHtml(content)}</p>
                <span class="text-xs text-gray-500 mt-1 block">${time}</span>
            </div>
        `;
        chatMessages.appendChild(userMessage);
    }

    function appendBotMessageDOM(reply, products, time) {
        const botMessage = document.createElement('div');
        botMessage.className = 'flex mb-4';
        
        let botContent = `
            <div class="w-8 h-8 flex items-center justify-center bg-primary rounded-full text-white mr-2 flex-shrink-0">
                <i class="ri-customer-service-2-line"></i>
            </div>
            <div class="bg-white p-3 rounded-lg shadow-sm max-w-[80%]">
                <p class="text-gray-700 text-sm">${escapeHtml(reply || 'Xin lỗi, tôi không thể xử lý yêu cầu này.')}</p>
                ${renderProductSuggestions(products || [])}
                <span class="text-xs text-gray-500 mt-2 block">${time}</span>
            </div>
        `;
        
        botMessage.innerHTML = botContent;
        chatMessages.appendChild(botMessage);
    }

    function sendChatMessage() {
        const message = chatInput.value.trim();
        if (!message) return;

        const now = new Date();
        const time = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();
        
        // Display user message
        appendUserMessageDOM(message, time);
        
        chatInput.value = '';
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Call API
        fetch('/chat/query', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            appendBotMessageDOM(data.reply, data.products, time);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(error => {
            console.error('Chat API error:', error);
            const errorReply = 'Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau.';
            appendBotMessageDOM(errorReply, [], time);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    }

    sendMessage.addEventListener('click', sendChatMessage);
    
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendChatMessage();
        }
    });
});
