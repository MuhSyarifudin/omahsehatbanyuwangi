addEventListener("DOMContentLoaded", () => { 

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


    function LoadReservasiCount() {
        fetch('/api/get-reservasi-count', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            }
        })
        .then(res => {
            if (res.status === 401) throw new Error('Unauthenticated');
            return res.json();
        })
        .then(data => {
            const jumlahReservasi = document.getElementById('jumlah-reservasi');
            jumlahReservasi.innerText = data.count_reservasi > 0 ? data.count_reservasi : 0;
        })
        .catch(err => console.error(err));
    }

    LoadReservasiCount();

        function loadUserCount(){
            fetch('api/get-users-count',{
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            }
        })
        .then(res => res.json())
        .then(data => {
        let jumlahUsers = document.getElementById('jumlah-user');
        
        jumlahUsers.innerText = data.count_users;
        })
        .catch(err => console.error(err));
    }

    loadUserCount();

        Echo.join('notification-bell')
        .listen('.notification-update', () => {
            loadNotifikasi();
            loadNotifikasiList();
            LoadReservasiCount();
        });

        Echo.join('registered-event')
        .listen('.registration-event-update',()=>{
            loadUserCount();
        });

})