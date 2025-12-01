// app.js
// Fungsi untuk menampilkan SweetAlert Toast
function showToast(icon, title, text = '') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: icon,
        title: title,
        text: text
    });
}

// Inisialisasi Lucide Icons (dipindahkan dari layout)
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
});

// Listener untuk membuka modal skrining dari Navbar
document.addEventListener('alpine:init', () => {
    Alpine.effect(() => {
        if (Alpine.store('global').screeningOpen) {
            // Logika untuk memastikan modal dibuka
            // (akan dihandle oleh x-show di dashboard.php)
            // Ini hanya untuk memastikan state berubah
        }
    });

    // Membuat store global untuk state modal
    Alpine.store('global', {
        screeningOpen: false,
    });

    // Event listener untuk membuka modal
    document.addEventListener('open-screening-modal', () => {
        // Cek apakah user sudah login
        if (<?= auth()->loggedIn() ? 'true' : 'false' ?>) {
            Alpine.store('global').screeningOpen = true;
        } else {
            window.location.href = '/login';
        }
    });
});

