//<==================CARD AND NOTIFICATIONS SECTION CODE==========================>//

addEventListener("DOMContentLoaded", () => { 

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function loadVisitorCount(){
        fetch('/api/get-visitors-count',{
            method: 'GET',
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            }
        }).then(res => {
            if (res.status === 401) throw new Error('Unauthenticated');
            return res.json();
        }).then(data => {
            const jumlahVisitor = document.getElementById('jumlah-visitor');
            jumlahVisitor.innerText = data.last_30_days ?? 0;
        }).catch(err => console.error(err));
    }

    loadVisitorCount();

    function convertToRupiah(angka)
    {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return 'Rp '+rupiah.split('',rupiah.length-1).reverse().join('');
    }

    function loadKeuntungan(){
        fetch('/api/get-keuntungan',{
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            }
        }).then(res => {
            if (res.status === 401) throw new Error('Unauthenticated');
            return res.json();
        }).then(data => {
            const jumlahKeuntungan = document.getElementById('jumlah-keuntungan');
            jumlahKeuntungan.innerText = data.keuntungan > 0 ? convertToRupiah(data.keuntungan) : 'Rp 0'
        }).catch(err => console.error(err));
    }

    loadKeuntungan();

    function loadReservasiCount() {
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

    loadReservasiCount();

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
            loadKeuntungan();
        });

        Echo.join('registered-event')
        .listen('.registration-event-update',()=>{
            loadUserCount();
        });

        Echo.join('visitor-event')
        .listen('.visitor-event-update',()=>{
            loadVisitorCount();
        });

})


//<=============================CHARTS SECTION CODE===============================>//


//PROFIT CHART

function loadChart(tahun) {
    fetch(`/dashboard/chart/tahunan?tahun=${tahun}`)
        .then(res => res.json())
        .then(data => {

            const ctx = document.getElementById('profitChart').getContext('2d');

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: `Keuntungan ${tahun}`,
                        data: data.values,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 1000
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
}

// load pertama
const tahunSelect = document.getElementById('tahunSelect');
loadChart(tahunSelect.value);

// saat dropdown berubah
tahunSelect.addEventListener('change', function () {
    loadChart(this.value);
});
    
function refreshProfitChart() {
    const tahun = document.getElementById('tahunSelect').value;
    loadChart(tahun);
}

let chartTimeout;

Echo.join('notification-bell')
    .listen('.notification-update', () => {

        loadKeuntungan();

        clearTimeout(chartTimeout);
        chartTimeout = setTimeout(() => {
            refreshProfitChart();
        }, 300);
    });