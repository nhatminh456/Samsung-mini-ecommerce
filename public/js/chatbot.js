// Sales Chatbot Logic - Phiên bản gọi thẳng API Backend (Chỉ lo phần Giao diện)
const chatbot = {
    init() {
        this.setupEventListeners();
        this.addBotMessage(
            'Xin chào! Mình là trợ lý ảo của SAMSUNG Center.\n' +
            'Bạn đang tìm kiếm sản phẩm nào, hay cần tư vấn mức giá bao nhiêu ạ?'
        );
    },

    setupEventListeners() {
        const chatbotBtn = document.getElementById('chatbot-btn');
        const chatbotWindow = document.getElementById('chatbot-window');
        const chatbotClose = document.getElementById('chatbot-close');
        const chatbotSend = document.getElementById('chatbot-send');
        const chatbotInput = document.getElementById('chatbot-input');

        chatbotBtn?.addEventListener('click', () => {
            chatbotWindow?.classList.toggle('active');
            if (chatbotWindow?.classList.contains('active')) {
                chatbotInput?.focus();
            }
        });

        chatbotClose?.addEventListener('click', () => {
            chatbotWindow?.classList.remove('active');
        });

        chatbotSend?.addEventListener('click', () => this.sendMessage());

        chatbotInput?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.sendMessage();
            }
        });
    },

    async sendMessage() {
        const input = document.getElementById('chatbot-input');
        const message = (input?.value || '').trim();
        if (!message) return;

        // 1. In tin nhắn của khách lên màn hình
        this.addUserMessage(message);
        input.value = '';

        // 2. Hiện hiệu ứng gõ phím
        this.showTyping();

        try {
            // 3. Gửi câu hỏi lên Laravel xử lý (Bộ não thật sự nằm ở đây)
            const response = await fetch('/api/chatbot/reply', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();
            
            // 4. Nhận kết quả từ Backend và in ra
            this.hideTyping();
            this.addBotMessage(data.reply);

        } catch (error) {
            console.error('Lỗi khi gọi API:', error);
            this.hideTyping();
            this.addBotMessage('Xin lỗi, hệ thống của SAMSUNG đang bận chút xíu. Bạn vui lòng thử lại sau nhé!');
        }
    },

    escapeHtml(text) {
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' };
        return String(text).replace(/[&<>"']/g, (m) => map[m]);
    },

    addUserMessage(text) {
        const messagesDiv = document.getElementById('chatbot-messages');
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message user';
        messageDiv.innerHTML = `<div class="message-content">${this.escapeHtml(text)}</div>`;
        messagesDiv.appendChild(messageDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    },

    addBotMessage(text) {
        const messagesDiv = document.getElementById('chatbot-messages');
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message bot';
        messageDiv.innerHTML = `<div class="message-content">${this.escapeHtml(text).replace(/\n/g, '<br>')}</div>`;
        messagesDiv.appendChild(messageDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    },

    showTyping() {
        const messagesDiv = document.getElementById('chatbot-messages');
        const typingDiv = document.createElement('div');
        typingDiv.className = 'message bot';
        typingDiv.id = 'typing-indicator';
        typingDiv.innerHTML = `
            <div class="typing-indicator">
                <span></span><span></span><span></span>
            </div>
        `;
        messagesDiv.appendChild(typingDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    },

    hideTyping() {
        const typingDiv = document.getElementById('typing-indicator');
        if (typingDiv) typingDiv.remove();
    }
};

document.addEventListener('DOMContentLoaded', () => {
    chatbot.init();
});