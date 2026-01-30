// Add to cart functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.game-card__button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const gameName = this.closest('.game-card').querySelector('.game-card__name').textContent;
            const gamePrice = this.closest('.game-card').querySelector('.game-card__price > span:not(.game-card__discount-badge):not(.game-card__original-price)').textContent;
            
            // Show notification
            showNotification(`¡${gameName} añadido al carrito por ${gamePrice}!`);
            
            // Add animation effect
            const originalText = this.textContent;
            this.textContent = '✓ Añadido';
            this.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            
            setTimeout(() => {
                this.textContent = originalText;
                this.style.background = '';
            }, 2000);
        });
    });
});

// Notification system
function showNotification(message) {
    // Remove existing notification if any
    const existing = document.querySelector('.notification');
    if (existing) existing.remove();
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 30px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
        z-index: 10000;
        font-weight: 600;
        animation: slideIn 0.3s ease-out;
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add animations for notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Smooth scroll for navigation
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.header__nav-link').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const headerOffset = 100;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});
