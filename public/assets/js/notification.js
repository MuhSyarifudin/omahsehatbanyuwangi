addEventListener("DOMContentLoaded", () => { 

// const token = document.querySelector('meta[name="api-token"]').getAttribute('content');

const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// const token = window.APP?.apiToken;


function markAsRead(id) {
    fetch(`/api/notifikasi/${id}/read`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token
        }
    })
    .then(res => {
        if (!res.ok) throw res.status;
        return res.json();
    })
    .then(() => {
        loadNotifikasiList();
        loadNotifikasi();
    })
    .catch(console.error);
}

function loadNotifikasi() {

    fetch('/api/get-count', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token
        }
    })
    .then(res => {
        if (res.status === 401) throw 'Unauthenticated';
        return res.json();
    })
    .then(data => {
        const badge1 = document.getElementById('notif-badge-luar-1');
        const badge2 = document.getElementById('notif-badge-luar-2');

        if (data.count_notifikasi > 0) {
            badge1.textContent = data.count_notifikasi;
            badge1.classList.remove('hidden');
            badge2.textContent = data.count_notifikasi;
            badge2.classList.remove('hidden');

        } else {
            badge1.classList.add('hidden');
            badge2.classList.add('hidden');
        }
    })
    .catch(err => console.error(err));
}

loadNotifikasi()


function loadNotifikasiList() {
    fetch('/api/get-notifikasi', {
        method: 'GET',
        headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': token
        }
    })
    .then(res => {
        if (!res.ok) throw new Error('Unauthenticated');
        return res.json();
    })
    .then(data => {

        const list  = document.getElementById('notif-list');
        const empty = document.getElementById('no-notif-message');

        // Bersihkan list
        list.innerHTML = '';

        // Tidak ada notifikasi
        if (!data.notifikasi || data.notifikasi.length === 0) {
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');

        data.notifikasi.forEach(notif => {

            // ===== Anchor =====
            const a = document.createElement('a');
            a.href = '#';
            a.className =
                'flex items-center justify-between py-4 px-3 ' +
                'hover:bg-gray-100 bg-opacity-20';

            // ===== Kiri =====
            const left = document.createElement('div');
            left.className = 'flex items-center';

            const icon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            icon.setAttribute('class', 'w-8 h-8 bg-primary bg-opacity-20 text-primary px-1.5 py-0.5 rounded-full');
            icon.setAttribute('fill', 'none');
            icon.setAttribute('stroke', 'currentColor');
            icon.setAttribute('viewBox', '0 0 24 24');

            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('stroke-linecap', 'round');
            path.setAttribute('stroke-linejoin', 'round');
            path.setAttribute('stroke-width', '2');
            path.setAttribute(
                'd',
                'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'
            );

            icon.appendChild(path);

            const textWrap = document.createElement('div');
            textWrap.className = 'text-sm ml-3';

            const title = document.createElement('p');
            title.className = 'text-gray-600 font-bold capitalize';
            title.textContent = notif.data?.status ?? '-';

            const message = document.createElement('p');
            message.className = 'text-xs';
            message.textContent = notif.data?.message ?? '-';

            textWrap.appendChild(title);
            textWrap.appendChild(message);

            left.appendChild(icon);
            left.appendChild(textWrap);

            // ===== Kanan =====
            const right = document.createElement('div');
            right.className = 'flex flex-col items-end gap-1';

            const time = document.createElement('span');
            time.className = 'text-xs font-bold';
            time.textContent = notif.created_at ?? '';

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'text-xs text-primary hover:underline cursor-pointer';
            btn.textContent = 'Tandai dibaca';

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                markAsRead(notif.id);
            });

            right.appendChild(time);
            right.appendChild(btn);

            // ===== Gabung =====
            a.appendChild(left);
            a.appendChild(right);
            list.appendChild(a);
        });
    })
    .catch(err => {
        console.error(err);
    });
}


loadNotifikasiList()

Echo.join('notification-bell')
.listen('.notification-update', () => {
    loadNotifikasi();
    loadNotifikasiList();
    LoadReservasiCount();
});

});