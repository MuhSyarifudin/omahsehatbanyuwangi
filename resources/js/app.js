import Echo from 'laravel-echo';
import Pusher from 'pusher-js';


window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});


// window.Echo.channel('notification-count')
//     .listen('.notification-count-update', function(data) {
//         console.log('Data diterima:', data);
//         const badge = document.getElementById('notif-badge-luar');
//                 if (badge) {
//                     badge.innerText = data.count;
//                     badge.classList.remove('hidden');
//                 }
//     });