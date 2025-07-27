// public/js/icon-animations.js

document.addEventListener('DOMContentLoaded', function() {

    // Fungsi untuk menyalin teks ke clipboard
    async function performCopyUrl(text) {
        if (navigator.clipboard && window.isSecureContext) {
            // Gunakan Clipboard API modern jika tersedia (HTTPS/localhost)
            try {
                await navigator.clipboard.writeText(text);
                alert('Link berhasil disalin!');
                console.log('Teks berhasil disalin via Clipboard API:', text);
            } catch (err) {
                console.error('Gagal menyalin teks via Clipboard API:', err);
                alert('Gagal menyalin link.');
            }
        } else {
            // Fallback untuk lingkungan non-secure (HTTP)
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed'; // Mencegah scroll
            textArea.style.left = '-9999px'; // Pindahkan ke luar layar
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                alert('Link berhasil disalin!');
                console.log('Teks berhasil disalin via execCommand:', text);
            } catch (err) {
                console.error('Gagal menyalin teks via execCommand:', err);
                alert('Gagal menyalin link.');
            }
            document.body.removeChild(textArea);
        }
    }

    function openInNewTab(url) {
    window.open(url, '_blank');
    }

    // Fungsi untuk inisialisasi tombol dengan animasi
    function setupAnimatedButton(buttonId, iconContainerClass, onClickCallback = null) {
        const button = document.getElementById(buttonId);

        if (button) {
            button.addEventListener('click', (event) => {
                event.preventDefault(); // Mencegah aksi default

                const iconContainer = button.querySelector(`.${iconContainerClass}`);
                if (iconContainer) {
                    iconContainer.classList.toggle('transformed');
                    createParticles(button);
                }

                // Jalankan callback jika ada
                if (typeof onClickCallback === 'function') {
                    onClickCallback(button);
                }
            });
        }
    }

    // Inisialisasi Tombol "Copy Link"
    setupAnimatedButton('copyLinkBtn', 'icon-container', (button) => {
        const copyUrl = button.dataset.copyUrl;
        if (copyUrl) {
            performCopyUrl(copyUrl);
        } else {
            console.warn("Atribut 'data-copy-url' tidak ditemukan pada tombol.");
        }
    });

    // Inisialisasi Tombol "Export PDF"
    setupAnimatedButton('exportPdfBtn', 'icon-container', (button) => {
        // Ambil URL dari atribut href tombol
        const exportUrl = button.href;
        if (exportUrl) {
            // Arahkan browser ke URL tersebut di tab baru
            window.open(exportUrl, '_blank');
            
        } else {
            console.warn("Atribut 'href' tidak ditemukan pada tombol Export PDF.");
        }
    });


    // Fungsi untuk membuat partikel (tidak perlu diubah)
    function createParticles(element) {
        const numParticles = 15;
        const elementRect = element.getBoundingClientRect();
        const centerX = elementRect.left + elementRect.width / 2;
        const centerY = elementRect.top + elementRect.height / 2;

        for (let i = 0; i < numParticles; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            document.body.appendChild(particle);

            const size = Math.random() * 5 + 2;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.left = `${centerX - size / 2}px`;
            particle.style.top = `${centerY - size / 2}px`;

            const angle = Math.random() * Math.PI * 2;
            const radius = Math.random() * 50 + 20;
            const targetX = radius * Math.cos(angle);
            const targetY = radius * Math.sin(angle);

            particle.style.setProperty('--x', `${targetX}px`);
            particle.style.setProperty('--y', `${targetY}px`);

            particle.addEventListener('animationend', () => {
                particle.remove();
            });
        }
    }
});
