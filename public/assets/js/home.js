        AOS.init();

        // Get the button
        const scrollToTopButton = document.getElementById("scrollToTop");

        // Show the button when scrolling down
        window.onscroll = function() {
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                scrollToTopButton.style.display = "block";
            } else {
                scrollToTopButton.style.display = "none";
            }
        };

        // Scroll to top function
        scrollToTopButton.onclick = function() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        };

// Function to open lightbox
function openLightbox(imgElement) {
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    lightboxImg.src = imgElement.src; // Set the source of the lightbox image
    lightbox.classList.remove('hidden'); // Show the lightbox
}

// Function to close lightbox
function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.add('hidden'); // Hide the lightbox
}

    document.addEventListener('DOMContentLoaded', function () {
        const slides = document.querySelectorAll('.carousel-item');
        let currentSlide = 0;
        const slideInterval = 4000; // Interval waktu (ms)

        // Menampilkan slide berdasarkan index
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.display = i === index ? 'block' : 'none';
            });
        }

        // Menampilkan slide berikutnya
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        // Menampilkan slide sebelumnya
        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        // Tampilkan slide pertama saat halaman dimuat
        showSlide(currentSlide);

        // Menjadwalkan auto slide setiap interval
        setInterval(nextSlide, slideInterval);

        // Menambahkan event listener untuk tombol navigasi
        document.getElementById('nextBtn').addEventListener('click', nextSlide);
        document.getElementById('prevBtn').addEventListener('click', prevSlide);
    });

    document.addEventListener('DOMContentLoaded', function () {
    // Pilih semua anchor link dengan atribut href yang diawali dengan #
    const links = document.querySelectorAll('a[href^="#"]');
    
    // Loop untuk menambahkan event listener pada setiap link
    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault(); // Mencegah aksi default (scroll langsung)
            
            const targetId = this.getAttribute('href'); // Ambil target id dari href
            const targetElement = document.querySelector(targetId); // Pilih elemen berdasarkan id
            
            // Lakukan smooth scroll ke target dengan scrollIntoView
            targetElement.scrollIntoView({
                behavior: 'smooth', // Membuat smooth scroll
                block: 'start' // Scroll mulai dari bagian atas elemen
            });
        });
    });
});

