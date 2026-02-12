import initProfileCropper from './features/cropper';
import initBroadcast from './features/broadcast';
import flatpickr from 'flatpickr';
import Chart from 'chart.js/auto';
import "flatpickr/dist/flatpickr.min.css";
import Alpine from 'alpinejs';
import '@fortawesome/fontawesome-free/css/all.min.css';

window.Chart = Chart;

window.Alpine = Alpine;

Alpine.start();


document.addEventListener('DOMContentLoaded',()=>{
    initProfileCropper();
    initBroadcast();
})




