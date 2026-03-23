import './bootstrap';

// Initialize AOS (Animate On Scroll) once DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 700,
            once: true,
            offset: 60,
        });
    }
});
