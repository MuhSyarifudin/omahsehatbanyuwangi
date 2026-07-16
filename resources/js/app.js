import initProfileCropper from './features/cropper';
import initBroadcast from './features/broadcast';
import flatpickr from 'flatpickr';
import Chart from 'chart.js/auto';
import "flatpickr/dist/flatpickr.min.css";
import Alpine from 'alpinejs';
import '@fortawesome/fontawesome-free/css/all.min.css';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

window.Chart = Chart;

window.Alpine = Alpine;

Alpine.start();


window.Swiper = Swiper;

Swiper.use([Navigation, Pagination, Autoplay]);

document.addEventListener('DOMContentLoaded',()=>{
    initProfileCropper();
    initBroadcast();
})




