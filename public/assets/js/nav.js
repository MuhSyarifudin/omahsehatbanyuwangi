// Ambil elemen header
const header = document.getElementById('header');

// Tambahkan event listener untuk scroll
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) { // Jika scroll lebih dari 50px
        header.classList.add('fixed');
    } else {
        header.classList.remove('fixed');
    }
});

 // Optional: Close dropdown when clicking outside
 document.addEventListener('click', function(event) {
    const dropdowns = document.querySelectorAll('.dropdown-content');
    dropdowns.forEach(dropdown => {
        if (!dropdown.parentElement.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });
});

// Ambil elemen-elemen
const menuToggle = document.getElementById('menu-toggle');
const mobileMenu = document.getElementById('mobile-menu');

// Event listener untuk tombol menu
menuToggle.addEventListener('click', function() {
    // Toggle kelas 'hidden' untuk menampilkan atau menyembunyikan menu
    mobileMenu.classList.toggle('hidden');
});