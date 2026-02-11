@extends('layouts.HomeLayout')

@push('top')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endpush

@section('content')

<section class="hero min-h-screen bg-fixed bg-cover bg-center relative flex items-center" style="background-image: url('{{ url(asset('assets/img/team.jpg')) }}');" id="beranda">
  <div class="absolute inset-0 bg-slate-900/60"></div>
  
  <div class="container mx-auto px-6 relative z-10">
      <div class="max-w-2xl" data-aos="fade-up" data-aos-duration="800">
          <span class="text-blue-400 font-semibold tracking-[0.2em] text-xs uppercase mb-4 block">
              Pusat Terapi & Kesehatan
          </span>

          <h1 class="text-3xl md:text-5xl font-bold text-white leading-tight mb-6">
              Selamat Datang di <br>
              Omah Sehat Banyuwangi
          </h1>

          <p class="text-base md:text-lg text-gray-300 leading-relaxed mb-8 max-w-lg">
              Dapatkan keseimbangan tubuh dan pikiran melalui layanan terapi profesional kami. Pesan jadwal Anda dengan mudah secara online.
          </p>

          <div class="flex flex-wrap gap-4">
              <a href="{{ route('pesan.reservasi.terapi') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-md transition-all duration-300 text-sm uppercase tracking-wider">
                  Reservasi Online
              </a>
              <a href="#layanan-terapi" class="border border-white/50 hover:border-white text-white px-8 py-3 rounded-md transition-all duration-300 text-sm uppercase tracking-wider">
                  Pelajari Layanan
              </a>
          </div>
      </div>
  </div>
</section>

<section class="py-16 bg-gray-50" id="layanan-terapi">
  <div class="container mx-auto px-4">
      <div class="text-center mb-12">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Layanan Kami</h2>
          <p class="text-gray-500 max-w-2xl mx-auto">Klik atau jelajahi berbagai metode terapi kesehatan dan kecantikan holistik yang kami sediakan untuk Anda.</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
          
          <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden" data-aos="fade-up">
              <div class="relative h-48 overflow-hidden">
                  <img src="{{ url(asset('assets/img/terapi-kesehatan.jpg')) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
              </div>
              <div class="p-6">
                  <h3 class="text-xl font-bold mb-4 text-gray-800">Terapi Bekam</h3>
                  <div class="flex flex-wrap gap-2">
                      <span class="bg-teal-50 text-teal-700 px-3 py-1 rounded-full text-xs font-medium border border-teal-100">Detox</span>
                      <span class="bg-teal-50 text-teal-700 px-3 py-1 rounded-full text-xs font-medium border border-teal-100">Punggung</span>
                      <span class="bg-teal-50 text-teal-700 px-3 py-1 rounded-full text-xs font-medium border border-teal-100">Kepala</span>
                      <span class="bg-teal-50 text-teal-700 px-3 py-1 rounded-full text-xs font-medium border border-teal-100">Estetika</span>
                  </div>
              </div>
          </div>

          <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
              <div class="relative h-48 overflow-hidden">
                  <img src="{{ url(asset('assets/img/terapi-kecantikan.jpg')) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
              </div>
              <div class="p-6">
                  <h3 class="text-xl font-bold mb-4 text-gray-800">Terapi Kecantikan</h3>
                  <div class="flex flex-wrap gap-2">
                      <span class="bg-pink-50 text-pink-700 px-3 py-1 rounded-full text-xs font-medium border border-pink-100">Totok Wajah</span>
                      <span class="bg-pink-50 text-pink-700 px-3 py-1 rounded-full text-xs font-medium border border-pink-100">Facial Detox</span>
                      <span class="bg-pink-50 text-pink-700 px-3 py-1 rounded-full text-xs font-medium border border-pink-100">Lulur Spa</span>
                      <span class="bg-pink-50 text-pink-700 px-3 py-1 rounded-full text-xs font-medium border border-pink-100">Sauna Rempah</span>
                      <span class="bg-pink-50 text-pink-700 px-3 py-1 rounded-full text-xs font-medium border border-pink-100">Ear Spa</span>
                      <span class="bg-pink-50 text-pink-700 px-3 py-1 rounded-full text-xs font-medium border border-pink-100">Terapi Mata</span>
                  </div>
              </div>
          </div>

          <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
              <div class="relative h-48 overflow-hidden">
                  <img src="{{ url(asset('assets/img/terapi-akupuntur.jpg')) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
              </div>
              <div class="p-6">
                  <h3 class="text-xl font-bold mb-4 text-gray-800">Terapi Akupuntur</h3>
                  <div class="flex flex-wrap gap-2">
                      <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-medium border border-blue-100">Glowing</span>
                      <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-medium border border-blue-100">Pelangsing</span>
                      <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-medium border border-blue-100">Double Chin</span>
                      <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-medium border border-blue-100">Aura</span>
                      <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-medium border border-blue-100">Tuina Chuzhen</span>
                  </div>
              </div>
          </div>

          <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="300">
              <div class="relative h-48 overflow-hidden">
                  <img src="{{ url(asset('assets/img/rawat-luka.jpg')) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
              </div>
              <div class="p-6">
                  <h3 class="text-xl font-bold mb-4 text-gray-800">Perawatan Luka</h3>
                  <div class="flex flex-wrap gap-2">
                      <span class="bg-red-50 text-red-700 px-3 py-1 rounded-full text-xs font-medium border border-red-100">Diabetes</span>
                      <span class="bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium border border-yellow-100">Vitamin Booster</span>
                  </div>
              </div>
          </div>

          <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="400">
              <div class="relative h-48 overflow-hidden">
                  <img src="{{ url(asset('assets/img/cek-kesehatan.jpeg')) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
              </div>
              <div class="p-6">
                  <h3 class="text-xl font-bold mb-4 text-gray-800">Cek Kesehatan</h3>
                  <div class="flex flex-wrap gap-2">
                      <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-medium border border-indigo-100">Asam Urat</span>
                      <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-medium border border-indigo-100">Kolesterol</span>
                      <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-medium border border-indigo-100">Gula Darah</span>
                  </div>
              </div>
          </div>

          <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="500">
              <div class="relative h-48 overflow-hidden">
                  <img src="{{ url(asset('assets/img/terapi-lainnya.jpg')) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
              </div>
              <div class="p-6">
                  <h3 class="text-xl font-bold mb-4 text-gray-800">Terapi Tambahan</h3>
                  <div class="flex flex-wrap gap-2">
                      <span class="bg-orange-50 text-orange-700 px-3 py-1 rounded-full text-xs font-medium border border-orange-100">Gurah THT</span>
                      <span class="bg-orange-50 text-orange-700 px-3 py-1 rounded-full text-xs font-medium border border-orange-100">Gurah Mata</span>
                      <span class="bg-orange-50 text-orange-700 px-3 py-1 rounded-full text-xs font-medium border border-orange-100">Terapi Lintah</span>
                      <span class="bg-orange-50 text-orange-700 px-3 py-1 rounded-full text-xs font-medium border border-orange-100">Collon Cleansing</span>
                      <span class="bg-orange-50 text-orange-700 px-3 py-1 rounded-full text-xs font-medium border border-orange-100">Terapi Rotan</span>
                  </div>
              </div>
          </div>

      </div>
  </div>
</section>

<section class="py-20 bg-blue-500" id="visi-misi"> <div class="container mx-auto px-6 lg:px-16">
  <div class="text-center mb-16">
      <h2 class="text-4xl font-extrabold text-white mb-4 tracking-tight">Visi & Misi</h2>
      <div class="w-20 h-1.5 bg-yellow-400 mx-auto rounded-full mb-6"></div>
      <p class="text-blue-100 max-w-2xl mx-auto text-lg" data-aos="fade-up">
          Komitmen kami dalam menghadirkan harmoni antara kesehatan fisik dan ketenangan mental bagi Anda.
      </p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
      <div class="group h-full" data-aos="fade-right" data-aos-duration="1000">
          <div class="bg-white p-8 rounded-2xl shadow-2xl border-b-8 border-yellow-400 flex flex-col h-full transform transition-transform duration-300 group-hover:-translate-y-2">
              <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 text-blue-700">
                  <i class="fa-solid fa-eye text-3xl"></i>
              </div>
              <h3 class="text-2xl font-bold mb-4 text-slate-800">Visi Kami</h3>
              <p class="text-slate-600 leading-relaxed text-lg italic">
                  "Menjadi pusat terapi kesehatan holistik terpercaya yang mengutamakan kualitas layanan dan kepuasan pelanggan secara menyeluruh."
              </p>
          </div>
      </div>

      <div class="group h-full" data-aos="fade-left" data-aos-duration="1000">
          <div class="bg-white p-8 rounded-2xl shadow-2xl border-b-8 border-blue-500 flex flex-col h-full transform transition-transform duration-300 group-hover:-translate-y-2">
              <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 text-green-600">
                  <i class="fa-solid fa-hand-holding-heart text-3xl"></i> </div>
              <h3 class="text-2xl font-bold mb-4 text-slate-800">Misi Kami</h3>
              <div class="flex flex-wrap gap-3">
                  <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-xl text-sm font-bold border border-blue-100 flex items-center gap-2">
                      <i class="fa-solid fa-circle-check"></i> Layanan Holistik
                  </span>
                  <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-xl text-sm font-bold border border-blue-100 flex items-center gap-2">
                      <i class="fa-solid fa-circle-check"></i> Etika & Profesional
                  </span>
                  <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-xl text-sm font-bold border border-blue-100 flex items-center gap-2">
                      <i class="fa-solid fa-circle-check"></i> Edukasi Kesehatan
                  </span>
                  <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-xl text-sm font-bold border border-blue-100 flex items-center gap-2">
                      <i class="fa-solid fa-circle-check"></i> Fasilitas Modern
                  </span>
                  <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-xl text-sm font-bold border border-blue-100 flex items-center gap-2">
                      <i class="fa-solid fa-circle-check"></i> Kenyamanan Pasien
                  </span>
              </div>
          </div>
      </div>
  </div>
</div>
</section>


<!-- Team Section -->
<section class="py-20" id="team">
  <div class="text-center mb-16">
    <h2 class="text-4xl font-bold text-slate-800 mb-4">Tenaga Terapis Profesional</h2>
    <div class="w-16 h-1 bg-blue-600 mx-auto rounded-full"></div>
    <p class="text-gray-500 mt-4 max-w-xl mx-auto">Percayakan kesehatan Anda kepada tim ahli kami yang berpengalaman di bidang terapi holistik dan kecantikan.</p>
  </div>
    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-10">
      <!-- Team Member 1 -->
      <div class="card bg-base-200 shadow-xl w-64 mx-auto" data-aos="flip-right" data-aos-duration="2000">
        <figure class="h-64 overflow-hidden">
          <img src="{{ url(asset('assets/img/alin.jpg')) }}" alt="Team Member 1" class="w-full h-full object-cover object-top rounded-t-lg" />
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
          <img src="{{ url(asset('assets/img/asnawi.jpg')) }}" alt="Team Member 2" class="w-full h-full object-cover object-top rounded-t-lg" />
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
          <img src="{{ url(asset('assets/img/asty.jpg')) }}" alt="Team Member 3" class="w-full h-full object-cover object-top rounded-t-lg" />
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
          <img src="{{ url(asset('assets/img/niken.jpg')) }}" alt="Team Member 4" class="w-full h-full object-cover object-top rounded-t-lg"/>
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
          <img src="{{ url(asset('assets/img/putriyani.jpg')) }}" alt="Team Member 5" class="w-full h-full object-cover object-top rounded-t-lg" />
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

  <section class="py-20 bg-[#1e40af]" id="daftar-jadi-terapis">
    <div class="container mx-auto px-6 lg:px-16">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-4">Bergabung Sebagai Terapis Profesional</h2>
            <div class="w-20 h-1.5 bg-yellow-400 mx-auto rounded-full mb-6"></div>
            <p class="text-blue-100 max-w-2xl mx-auto text-lg" data-aos="fade-up">
                Kami mengundang Anda, para praktisi berpengalaman, untuk berkolaborasi dalam memberikan dampak positif bagi kesehatan masyarakat.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-2xl border border-white/20 hover:bg-white hover:scale-105 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="100">
                <div class="w-12 h-12 bg-yellow-400 rounded-lg flex items-center justify-center mb-6 text-blue-900 shadow-lg">
                    <i class="fa-solid fa-graduation-cap text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-white group-hover:text-slate-800">Pengembangan Skill</h3>
                <p class="text-blue-100 group-hover:text-slate-600 leading-relaxed">Dapatkan pelatihan berkala dan pengembangan profesional untuk mengasah keterampilan klinis Anda.</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-2xl border border-white/20 hover:bg-white hover:scale-105 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="200">
                <div class="w-12 h-12 bg-yellow-400 rounded-lg flex items-center justify-center mb-6 text-blue-900 shadow-lg">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-white group-hover:text-slate-800">Lingkungan Positif</h3>
                <p class="text-blue-100 group-hover:text-slate-600 leading-relaxed">Bekerja dalam tim yang suportif dengan budaya kerja yang mengedepankan etika dan kekeluargaan.</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-2xl border border-white/20 hover:bg-white hover:scale-105 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="300">
                <div class="w-12 h-12 bg-yellow-400 rounded-lg flex items-center justify-center mb-6 text-blue-900 shadow-lg">
                    <i class="fa-solid fa-chart-line text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-white group-hover:text-slate-800">Jenjang Karier</h3>
                <p class="text-blue-100 group-hover:text-slate-600 leading-relaxed">Peluang besar untuk membangun reputasi dan karier Anda di industri kesehatan yang terus bertumbuh.</p>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('register.therapist') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-blue-900 font-bold px-10 py-4 rounded-full shadow-xl transition-all hover:shadow-2xl uppercase tracking-wider text-sm">
                Daftar Sekarang
            </a>
        </div>
    </div>
</section>

<section class="py-20 bg-slate-50" id="lokasi-kami">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-1/3 text-left">
                <h2 class="text-3xl font-bold text-slate-800 mb-6">Lokasi Kami</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <i class="fa-solid fa-location-dot text-blue-600 mt-1"></i>
                        <p class="text-slate-600">Jl. Cemara No.20, Kebalenan,
                          Kec. Banyuwangi, Kabupaten Banyuwangi,
                          Jawa Timur 68417</p>
                    </div>
                    <div class="flex items-start gap-4">
                        <i class="fa-solid fa-clock text-blue-600 mt-1"></i>
                        <p class="text-slate-600">Senin - Sabtu: 08.00 - 20.00 WIB</p>
                    </div>
                </div>
            </div>
            <div class="md:w-2/3 w-full">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-8 border-white">
                    <div id="map-overlay" class="absolute inset-0 bg-slate-900 z-10 transition-opacity duration-700 pointer-events-none"></div>
                    <div id="map" class="w-full h-[450px] bg-slate-200"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white" id="katalog-produk">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-bold tracking-widest uppercase text-sm">Our Shop</span>
            <h2 class="text-4xl font-bold text-slate-800 mt-2">Katalog Produk</h2>
            <div class="w-16 h-1 bg-blue-600 mx-auto mt-4 rounded-full"></div>
        </div>
        
        <div class="relative overflow-hidden">
          <div class="carousel flex w-full overflow-x-auto snap-x snap-mandatory scroll-smooth justify-center" id="carousel">
              <!-- Item 1 -->
              <div class="carousel-item snap-start w-full sm:w-1/2 md:w-1/3 lg:w-1/4 flex-shrink-0 flex justify-center">
                  <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                      <img src="{{ url(asset('assets/img/produk-1.jpg')) }}" alt="Produk 1" class="w-full h-48 object-cover">
                      <div class="p-4 text-center">
                          <h3 class="text-lg font-semibold text-black">Trace Mineral Impro</h3>
                          <p class="text-gray-600"></p>
                      </div>
                  </div>
              </div>
              
              <!-- Item 2 -->
              <div class="carousel-item snap-start w-full sm:w-1/2 md:w-1/3 lg:w-1/4 flex-shrink-0 flex justify-center">
                  <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                      <img src="{{ url(asset('assets/img/produk-2.jpeg')) }}" alt="Produk 2" class="w-full h-48 object-cover">
                      <div class="p-4 text-center">
                          <h3 class="text-lg font-semibold text-black">Minyak Waras</h3>
                          <p class="text-gray-600"></p>
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
<button id="scrollToTop" class="fixed bottom-5 right-5 p-3 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition duration-300 z-[1000]">
    <i class="fa-solid fa-arrow-up"></i>
</button>
@endsection

@push('bottom')
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script>

      var map = L.map('map').setView([ -8.2318518, 114.3465796 ], 16);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);

      L.marker([ -8.229908273576507, 114.34335350990297 ]).addTo(map)
          .bindPopup('<b>Omah Sehat Banyuwangi</b>')
          .openPopup();

      window.onload = function() {
        document.getElementById('map').classList.remove('opacity-0');
        document.getElementById('map').classList.add('opacity-100');
      };
  </script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script src="{{ url(asset('assets/js/nav.js')) }}"></script>
  <script src="{{ url(asset('assets/js/home.js')) }}"></script>

@endpush