import flatpickr from "https://cdn.jsdelivr.net/npm/flatpickr/+esm";

// Ambil elemen select jenis layanan dan alamat section
const jenisLayananSelect = document.getElementById('jenisLayanan');
const alamatSection = document.getElementById('alamatSection');
const hariInput = document.getElementById('hari');

// Fungsi untuk menampilkan atau menyembunyikan alamat berdasarkan pilihan jenis layanan
function toggleAlamatSection() {
    if (jenisLayananSelect.value === 'Homecare') {
        alamatSection.style.display = 'block'; // Tampilkan input alamat
    } else {
        alamatSection.style.display = 'none';  // Sembunyikan input alamat
    }
}

// Event listener untuk perubahan pada select jenis layanan
jenisLayananSelect.addEventListener('change', toggleAlamatSection);

// Panggil fungsi saat halaman pertama kali dimuat
document.addEventListener('DOMContentLoaded', toggleAlamatSection);

 
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


  // const hariSelect = document.getElementById('hari');
    const jamSelect = document.getElementById('jam');

    // Fungsi untuk mengatur jam berdasarkan hari
    function aturJam(hari) {
        jamSelect.innerHTML = '<option value="" disabled selected>Pilih Jam</option>'; // Reset opsi jam
        
        // Aktifkan kembali dropdown jam untuk setiap perubahan
        jamSelect.disabled = false; 

        let jamAwal = 8; // Jam mulai (08:00)
        let jamAkhir = 20; // Jam default berakhir (17:00)

        if (hari === 'Jumat' || hari === 'Sabtu') {
            jamAkhir = 14; // Jumat dan Sabtu hanya sampai jam 14:00
        } else if (hari === 'Minggu') {
            jamSelect.innerHTML = '<option value="" disabled selected>Libur</option>';
            jamSelect.disabled = true; // Disable dropdown untuk hari Minggu
            return;
        }

        // Generate opsi jam sesuai kondisi
        for (let i = jamAwal; i <= jamAkhir; i++) {
            const jam = i.toString().padStart(2, '0') + ':00';
            const option = document.createElement('option');
            option.value = jam;
            option.textContent = jam;
            jamSelect.appendChild(option);
        }
    }


    document.addEventListener('DOMContentLoaded', function () {
      flatpickr("#tanggalPicker", {
        dateFormat: "Y-m-d",  // Format tanggal yang diinginkan
        onChange: function (selectedDates, dateStr, instance) {
          if (selectedDates.length > 0) {
              let selectedDate = selectedDates[0]; // Dapatkan tanggal yang dipilih
              let dayName = selectedDate.toLocaleDateString('id-ID', { weekday: 'long' }); // Ambil nama hari dalam Bahasa Indonesia

              aturJam(dayName);
              hariInput.value = dayName;
              console.log(dayName);
            }
      },
        minDate: "today",     // Tidak bisa memilih tanggal sebelumnya
        maxDate: new Date().fp_incr(3), // Membatasi hingga 3 hari ke depan
        disable: [
          function(date) {
            // Disable hari Minggu
            return date.getDay() === 0;  // 0 adalah hari Minggu
          }
        ],
        locale: {
          firstDayOfWeek: 1   // Mulai minggu dari hari Senin
        }
      });
    });