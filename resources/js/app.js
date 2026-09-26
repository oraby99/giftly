document.addEventListener('alpine:init', () => {
    Alpine.store('cart', {
        items: [],

        init() {
            this.load();
        },

        load() {
            try {
                this.items = JSON.parse(localStorage.getItem('giftly_cart') || '[]');
            } catch {
                this.items = [];
            }
        },

        save() {
            localStorage.setItem('giftly_cart', JSON.stringify(this.items));
        },

        get count() {
            return this.items.reduce((sum, item) => sum + (item.quantity || 1), 0);
        },

        addProduct(product, quantity = 1) {
            const existing = this.items.find(i => i.type === 'product' && i.product_id === product.id);
            if (existing) {
                existing.quantity = (existing.quantity || 1) + quantity;
            } else {
                this.items.push({
                    type: 'product',
                    product_id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    quantity,
                });
            }
            this.save();
            this.showToast('تمت إضافة المنتج إلى السلة ✓');
        },

        addGiftBox(giftBox, quantity = 1) {
            const existing = this.items.find(i => i.type === 'gift_box' && i.gift_box_id === giftBox.id);
            if (existing) {
                existing.quantity = (existing.quantity || 1) + quantity;
            } else {
                this.items.push({
                    type: 'gift_box',
                    gift_box_id: giftBox.id,
                    name: giftBox.name,
                    price: giftBox.price,
                    image: giftBox.image,
                    quantity,
                });
            }
            this.save();
            this.showToast('تمت إضافة الصندوق إلى السلة ✓');
        },

        addCustomBox(customBox) {
            this.items.push({
                type: 'custom_gift_box',
                name: 'صندوق هدايا مخصص',
                ...customBox,
                quantity: 1,
            });
            this.save();
            this.showToast('تمت إضافة الصندوق المخصص إلى السلة ✓');
        },

        updateQuantity(index, quantity) {
            if (quantity <= 0) {
                this.remove(index);
            } else {
                this.items[index].quantity = quantity;
                this.save();
            }
        },

        remove(index) {
            this.items.splice(index, 1);
            this.save();
        },

        clear() {
            this.items = [];
            this.save();
        },

        get subtotal() {
            return this.items.reduce((sum, item) => {
                const price = parseFloat(item.price || item.unit_price || 0);
                const qty = item.quantity || 1;
                return sum + (price * qty);
            }, 0);
        },

        showToast(message) {
            const toast = document.createElement('div');
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 9999;
                background: oklch(0.58 0.165 345); color: white;
                padding: 0.875rem 1.5rem; border-radius: 0.75rem;
                font-family: inherit; font-size: 0.9375rem; font-weight: 600;
                box-shadow: 0 8px 24px -4px oklch(0.58 0.165 345 / 0.5);
                animation: slideIn 0.3s ease;
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2500);
        },
    });

    Alpine.store('favorites', {
        items: [],

        init() {
            this.load();
        },

        load() {
            try {
                this.items = JSON.parse(localStorage.getItem('giftly_favorites') || '[]');
            } catch {
                this.items = [];
            }
        },

        save() {
            localStorage.setItem('giftly_favorites', JSON.stringify(this.items));
        },

        get count() {
            return this.items.length;
        },

        toggle(item) {
            const key = `${item.type}_${item.id}`;
            const index = this.items.findIndex(i => `${i.type}_${i.id}` === key);
            if (index >= 0) {
                this.items.splice(index, 1);
            } else {
                this.items.push(item);
            }
            this.save();
        },

        isFavorite(type, id) {
            return this.items.some(i => i.type === type && i.id === id);
        },
    });

    Alpine.data('giftlyApp', giftlyApp);
});

function giftlyApp() {
    return {
        mobileMenuOpen: false,

        get cartCount() {
            try {
                return Alpine.store('cart') ? Alpine.store('cart').count : 0;
            } catch {
                return 0;
            }
        },

        get favoritesCount() {
            try {
                return Alpine.store('favorites') ? Alpine.store('favorites').count : 0;
            } catch {
                return 0;
            }
        },
    };
}

window.giftlyApp = giftlyApp;

const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateY(1rem); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
`;
document.head.appendChild(style);
