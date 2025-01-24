@extends('layouts.app')

@section('content')
<section class="hero min-h-screen sm:h-auto bg-fixed bg-cover bg-center relative" style="background-image: url('{{ url(asset('assets/img/team.jpg')) }}');" id="beranda">
  <!-- Gradient Overlay -->
  <div class="absolute inset-0 bg-gradient-black from-black/60 via-transparent to-black/60 h-full"></div>
  <!-- Color Overlay -->
  <div class="absolute inset-0 bg-black opacity-40"></div>
  
  <div class="hero-content flex-col lg:flex-row-reverse text-white relative z-10">
      <div data-aos="fade-up" data-aos-delay="300">
          <h1 class="text-5xl font-bold">Selamat datang di Website resmi </h1>
          <h1 class="text-5xl font-bold">Omah Sehat Banyuwangi </h1>
          <p class="py-6">Segera lakukan reservasi layanan terapi kami secara online untuk mendapatkan tubuh yang sehat dengan klik tombol reservasi</p>
          <a href="{{ route('pesan.reservasi.terapi') }}" class="btn btn-primary">reservasi</a>
      </div>
  </div>
</section>


<section class="py-12 bg-base-100" id="layanan-terapi">
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center mb-8">Layanan kami</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <!-- Layanan 1 -->
        <div class="card bg-base-200 shadow-lg rounded-lg p-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
            <img src="{{ url(asset('assets/img/terapi-kesehatan.jpg')) }}" alt="Layanan 1" class="w-24 h-24 mx-auto mb-4 object-cover">
            <h3 class="text-xl font-semibold mb-2 text-center">Terapi Bekam</h3>
            <p class="text-gray-600 text-left">
                <ul>
                    <li>Detox</li>
                    <li>Punggung</li>
                    <li>Kepala</li>
                    <li>Estetika</li>
                </ul>
            </p>
        </div>
        <!-- Layanan 2 -->
        <div class="card bg-base-200 shadow-lg rounded-lg p-4 " data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
            <img src="{{ url(asset('assets/img/terapi-kecantikan.jpg')) }}" alt="Layanan 2" class="w-24 h-24 mx-auto mb-4 object-cover">
            <h3 class="text-xl font-semibold mb-2 text-center">Terapi Kecantikan</h3>
            <p class="text-gray-600 text-left">
                <ul>
                    <li>Totok Wajah</li>
                    <li>Facial Detox</li>
                    <li>Facial Electric</li>
                    <li><b>Lulur SPA</b>
                        <ul>
                            <li class="ml-4">- Kendedes (Javanese)</li>
                            <li class="ml-4">- Jasmine (Balinese)</li>
                        </ul>
                    </li>
                    <li>Spa Telinga</li>
                    <li>Sauna Rempah</li>
                    <li>Terapi mata</li>
                </ul>
            </p>
        </div>
        <!-- Layanan 3 -->
        <div class="card bg-base-200 shadow-lg rounded-lg p-4" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
            <img src="{{ url(asset('assets/img/terapi-akupuntur.jpg')) }}" alt="Layanan 3" class="w-24 h-24 mx-auto mb-4 object-cover">
            <h3 class="text-xl font-semibold mb-2 text-center">Terapi Akupuntur</h3>
            <p class="text-gray-600 text-left">
                <ul>
                    <li>Keluhan</li>
                    <li>Estetika Glowing</li>
                    <li>Estetika Pelangsing</li>
                    <li>Anti Double Chin</li>
                    <li>Tuina Chuzhen</li>
                    <li>Aura</li>
                    <li>Kebutuhan Khusus</li>
                </ul>
            </p>
        </div>
        <!-- Layanan 4 -->
        <div class="card bg-base-200 shadow-lg rounded-lg p-4" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
            <img src="{{ url(asset('assets/img/rawat-luka.jpg')) }}" alt="Layanan 4" class="w-24 h-24 mx-auto mb-4 object-cover">
            <h3 class="text-xl font-semibold mb-2 text-center">Perawatan Luka</h3>
            <p class="text-gray-600 text-left">
                <ul>
                    <li>Diabetes</li>
                    <li>Vitamin Booster</li>
                </ul>
            </p>
        </div>
        <div class="card bg-base-200 shadow-lg rounded-lg p-4" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
            <img src="{{ url(asset('assets/img/cek-kesehatan.jpeg')) }}" alt="Layanan 4" class="w-24 h-24 mx-auto mb-4 object-cover">
            <h3 class="text-xl font-semibold mb-2  text-center">Cek Kesehatan</h3>
            <p class="text-gray-600 text-left">
                <ul>
                    <li>Asam Urat</li>
                    <li>Kolesterol</li>
                    <li>Kadar Gula</li>
                </ul>
            </p>
        </div>
        <div class="card bg-base-200 shadow-lg rounded-lg p-4" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">
            <img src="{{ url(asset('assets/img/terapi-lainnya.jpg')) }}" alt="Layanan 4" class="w-24 h-24 mx-auto mb-4 object-cover">
            <h3 class="text-xl font-semibold mb-2  text-center">Add-on</h3>
            <p class="text-gray-600 text-left">
                <ul>
                    <li>Collon Cleansing</li>
                    <li>Rawat Sendi & Tulang</li>
                    <li>Terapi Rotan</li>
                    <li><b>Terapi Gurah</b>
                        <ul>
                            <li class="ml-4">-THT</li>
                            <li class="ml-4">-Mata</li>
                        </ul>
                    </li>
                    <li>Terapi Lintah</li>
                </ul>
            </p>
        </div>
    </div>
</div>
</section>

<section class="py-12 gradient-blue from-blue-500 via-teal-400 to-indigo-600" id="visi-misi">
<div class="container mx-auto px-6 lg:px-16 text-center">
    <h2 class="text-4xl font-bold mb-8 text-white">Visi & Misi</h2>
    <p class="text-gray-200 mb-12 max-w-2xl mx-auto" data-aos="fade-up" data-aos-duration="1000">
        Kami berkomitmen untuk memberikan pelayanan terbaik dalam mencapai kesejahteraan fisik dan mental bagi setiap pelanggan kami.
    </p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Visi Section -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow" data-aos="zoom-in-up" data-aos-duration="1000">
            <h3 class="text-2xl font-semibold mb-4 text-gray-800"><i class="fa-brands fa-dart-lang"></i> Visi</h3>
            <p class="text-gray-600 text-custom-dark">
                Menjadi pusat terapi kesehatan terpercaya yang mengutamakan kualitas layanan dan kepuasan pelanggan.
            </p>
        </div>
        <!-- Misi Section -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow" data-aos="zoom-in-up" data-aos-duration="1000">
            <h3 class="text-2xl font-semibold mb-4 text-gray-800"><i class="fa-solid fa-rocket"></i> Misi</h3>
            <ul class="list-disc text-gray-600 pl-4 text-left text-custom-dark">
                <li>Menyediakan layanan terapi berkualitas dengan pendekatan holistik.</li>
                <li>Mengutamakan profesionalisme dan etika dalam setiap layanan.</li>
                <li>Meningkatkan kesadaran masyarakat tentang pentingnya kesehatan.</li>
                <li>Menyediakan fasilitas yang nyaman dan modern untuk pelanggan.</li>
            </ul>
        </div>
    </div>
</div>
</section>


<!-- Team Section -->
<section class="py-20" id="team">
    <h2 class="text-4xl font-bold text-center mb-10">Meet Our Team</h2>
    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-10">
      <!-- Team Member 1 -->
      <div class="card bg-base-200 shadow-xl w-64 mx-auto" data-aos="flip-right" data-aos-duration="2000">
        <figure class="h-64 overflow-hidden">
          <img src="{{ url(asset('assets/img/alin.jpg')) }}" alt="Team Member 1" class="w-full h-full object-cover object-top rounded-t-lg" onclick="openLightbox(this)" />
        </figure>
        <div class="card-body">
          <h3 class="text-xl font-semibold">Alin</h3>
          <p class="text-gray-500">Therapist</p>
          <p>
            <i>"Halo, saya Alin, terapis kesehatan dan kecantikan alternatif. Dengan pendekatan holistik, saya berkomitmen untuk membantu Anda meraih keseimbangan tubuh dan pikiran serta meningkatkan kepercayaan diri melalui perawatan alami dan menyeluruh."</i>
          </p>
        </div>
      </div>
      <!-- Team Member 2 -->
      <div class="card bg-base-200 shadow-xl w-64 mx-auto" data-aos="flip-right" data-aos-duration="2000">
        <figure class="h-64 overflow-hidden">
          <img src="{{ url(asset('assets/img/asnawi.jpg')) }}" alt="Team Member 2" class="w-full h-full object-cover object-top rounded-t-lg" onclick="openLightbox(this)" />
        </figure>
        <div class="card-body">
          <h3 class="text-xl font-semibold">Asnawi</h3>
          <p class="text-gray-500">Therapist</p>
          <p>
            <i>"Halo, saya Asnawi, terapis alternatif profesional. Saya siap memberikan solusi kesehatan dan kebugaran yang holistik untuk membantu Anda mencapai keseimbangan tubuh dan pikiran."</i>
          </p>
        </div>
      </div>
      <!-- Team Member 3 -->
      <div class="card bg-base-200 shadow-xl w-64 mx-auto" data-aos="flip-right" data-aos-duration="2000">
        <figure class="h-64 overflow-hidden">
          <img src="{{ url(asset('assets/img/asty.jpg')) }}" alt="Team Member 3" class="w-full h-full object-cover object-top rounded-t-lg" onclick="openLightbox(this)" />
        </figure>
        <div class="card-body">
          <h3 class="text-xl font-semibold">Asty</h3>
          <p class="text-gray-500">Therapist</p>
          <p>
            <i>"Halo, saya Asty, terapis kesehatan dan kecantikan alternatif. Dengan sentuhan holistik, saya siap membantu Anda meraih kesehatan optimal dan kecantikan alami dari dalam."</i>
          </p>
        </div>
      </div>
      <!-- Team Member 4 -->
      <div class="card bg-base-200 shadow-xl w-64 mx-auto" data-aos="flip-right" data-aos-duration="2000">
        <figure class="h-64 overflow-hidden">
          <img src="{{ url(asset('assets/img/niken.jpg')) }}" alt="Team Member 4" class="w-full h-full object-cover object-top rounded-t-lg" onclick="openLightbox(this)" />
        </figure>
        <div class="card-body">
          <h3 class="text-xl font-semibold">Niken</h3>
          <p class="text-gray-500">Therapist</p>
          <p>
            <i>"Perkenalkan, saya Niken Kurnia, terapis kesehatan dan kecantikan yang menggabungkan keahlian Akupuntur Cina dan Thibunabawi."</i>
          </p>
        </div>
      </div>
      <!-- Team Member 5 -->
      <div class="card bg-base-200 shadow-xl w-64 mx-auto" data-aos="flip-right" data-aos-duration="2000">
        <figure class="h-64 overflow-hidden">
          <img src="{{ url(asset('assets/img/putriyani.jpg')) }}" alt="Team Member 5" class="w-full h-full object-cover object-top rounded-t-lg" onclick="openLightbox(this)" />
        </figure>
        <div class="card-body">
          <h3 class="text-xl font-semibold">Putriyani</h3>
          <p class="text-gray-500">Therapist</p>
          <p>
            <i>"Salam sehat! Saya Putriyani, terapis kesehatan alternatif dengan keahlian dalam bekam, reposisi tulang sendi, serta totok wajah."</i>
          </p>
        </div>
      </div>
    </div>
  </section>
  

<section class="py-12 bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 text-white" id="daftar-jadi-terapis">
    <div class="container mx-auto px-6 lg:px-16 text-center">
      <h2 class="text-4xl font-bold mb-8 text-white">Bergabung Menjadi Terapi Profesional Kami</h2>
      <p class="text-white mb-12 max-w-2xl mx-auto" data-aos="fade-up" data-aos-duration="1000">
        Kami mencari terapis berpengalaman untuk bergabung dalam tim kami dan membantu pelanggan mencapai kesejahteraan fisik dan mental.
      </p>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition-shadow" data-aos="zoom-in-up" data-aos-duration="1000">
          <h3 class="text-xl font-semibold mb-4 text-black">Keuntungan 1</h3>
          <p class="text-gray-600">Dapatkan pelatihan dan pengembangan profesional untuk meningkatkan keterampilan Anda.</p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition-shadow" data-aos="zoom-in-up" data-aos-duration="1000">
          <h3 class="text-xl font-semibold mb-4 text-black">Keuntungan 2</h3>
          <p class="text-gray-600">Bergabung dengan tim yang penuh dukungan dan lingkungan kerja yang positif.</p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition-shadow" data-aos="zoom-in-up" data-aos-duration="1000">
          <h3 class="text-xl font-semibold mb-4 text-black">Keuntungan 3</h3>
          <p class="text-gray-600">Peluang untuk membangun karier Anda di industri terapi yang berkembang.</p>
        </div>
      </div>
      <div class="mt-8">
        <a href="#apply" class="btn btn-primary text-white" data-aos="zoom-in-up" data-aos="600" data-aos-duration="1000">Daftar Sekarang</a>
      </div>
    </div>
  </section>
  
  <!-- Lightbox Modal -->
  <div id="lightbox" 
       class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center hidden z-50" 
       onclick="closeLightbox()">
    <img id="lightbox-img" src="" alt="Full Image" class="max-w-full max-h-full z-50" />
  </div>
  

<section class="py-12 bg-base-100" id="katalog-produk">
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center mb-8">Katalog Produk</h2>
    <div class="relative overflow-hidden">
        <div class="carousel flex w-full overflow-x-auto snap-x snap-mandatory scroll-smooth justify-center" id="carousel">
            <!-- Item 1 -->
            <div class="carousel-item snap-start w-full sm:w-1/2 md:w-1/3 lg:w-1/4 flex-shrink-0 flex justify-center">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ url(asset('assets/img/produk-1.jpg')) }}" alt="Produk 1" class="w-full h-48 object-cover">
                    <div class="p-4 text-center">
                        <h3 class="text-lg font-semibold text-black">Trace Mineral Impro</h3>
                        <p class="text-gray-600">Deskripsi singkat produk.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Navigasi -->
        <button id="prevBtn" class="absolute left-2 top-1/2 -translate-y-1/2 btn btn-circle btn-sm z-10 bg-gray-800 text-white">❮</button>
        <button id="nextBtn" class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-circle btn-sm z-10 bg-gray-800 text-white">❯</button>
    </div>
</div>
</section>

<!-- Scroll to Top Button -->
<button id="scrollToTop" class="fixed bottom-5 right-5 p-3 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition duration-300">
    <i class="fa-solid fa-arrow-up"></i>
</button>

@endsection

@push('bottom')

  <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script src="{{ url(asset('assets/js/nav.js')) }}"></script>
  <script src="{{ url(asset('assets/js/home.js')) }}"></script>
@endpush