import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import flatpickr from 'flatpickr';
import Chart from 'chart.js/auto';
import "flatpickr/dist/flatpickr.min.css";
import Alpine from 'alpinejs';

window.Chart = Chart;

window.Alpine = Alpine;

Alpine.start();

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});


