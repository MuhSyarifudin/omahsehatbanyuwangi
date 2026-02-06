document.addEventListener("DOMContentLoaded", () => {

    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');

    const btnTandaiBacaSemua = document.getElementById('tandai-baca-semua');

    if (btnTandaiBacaSemua) {
        btnTandaiBacaSemua.addEventListener('click', () => {
            markAsReadAll();
        });
    }

    /* =========================
       MARK AS READ (ALL)
    ========================== */
    function markAsReadAll() {
        fetch('/api/notifikasi/read-all', {
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
            loadNotifikasi();
            loadNotifikasiList();
        })
        .catch(console.error);
    }

    /* =========================
       MARK AS READ (SINGLE)
    ========================== */
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
            loadNotifikasi();
            loadNotifikasiList();
        })
        .catch(console.error);
    }

    /* =========================
       LOAD BADGE COUNT
    ========================== */
    function loadNotifikasi() {
        fetch('/api/get-count', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            }
        })
        .then(res => res.json())
        .then(data => {
            const badge1 = document.getElementById('notif-badge-luar-1');
            const badge2 = document.getElementById('notif-badge-luar-2');

            if (data.count_notifikasi > 0) {
                badge1.textContent = data.count_notifikasi;
                badge2.textContent = data.count_notifikasi + ' new';
                badge1.classList.remove('hidden');
                badge2.classList.remove('hidden');
            } else {
                badge1.classList.add('hidden');
                badge2.classList.add('hidden');
            }
        })
        .catch(console.error);
    }

    /* =========================
       LOAD NOTIFICATION LIST
    ========================== */
    function loadNotifikasiList() {
        fetch('/api/get-notifikasi', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            }
        })
        .then(res => res.json())
        .then(data => {

            const list  = document.getElementById('notif-list');
            const empty = document.getElementById('no-notif-message');

            list.innerHTML = '';

            if (!data.notifikasi || data.notifikasi.length === 0) {
                empty.classList.remove('hidden');
                return;
            }

            empty.classList.add('hidden');

            data.notifikasi.forEach(notif => {

                const isUnread = notif.read_at === null;

                /* =========================
                   ITEM WRAPPER
                ========================== */
                const a = document.createElement('a');
                a.href = '#';
                a.className =
                    'flex items-center justify-between py-4 px-3 transition cursor-pointer ' +
                    (isUnread
                        ? 'bg-blue-50 hover:bg-blue-100'
                        : 'bg-white hover:bg-gray-100 opacity-70');

                /* =========================
                   LEFT SIDE
                ========================== */
                const left = document.createElement('div');
                left.className = 'flex items-center';

                /* ===== SVG BELL ICON ===== */
                const icon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                icon.setAttribute(
                    'class',
                    'w-8 h-8 p-1.5 rounded-full relative ' +
                    (isUnread
                        ? 'bg-blue-100 text-blue-600'
                        : 'bg-gray-200 text-gray-400')
                );
                icon.setAttribute('fill', 'none');
                icon.setAttribute('stroke', 'currentColor');
                icon.setAttribute('viewBox', '0 0 24 24');

                const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                path.setAttribute('stroke-linecap', 'round');
                path.setAttribute('stroke-linejoin', 'round');
                path.setAttribute('stroke-width', '2');
                path.setAttribute(
                    'd',
                    'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0h6z'
                );

                icon.appendChild(path);

                // dot unread
                if (isUnread) {
                    const dot = document.createElement('span');
                    dot.className =
                        'absolute top-1 right-1 w-2 h-2 bg-blue-600 rounded-full';
                    icon.appendChild(dot);
                }

                /* ===== TEXT ===== */
                const textWrap = document.createElement('div');
                textWrap.className = 'text-sm ml-3';

                const title = document.createElement('p');
                title.className =
                    'capitalize ' +
                    (isUnread ? 'font-bold text-gray-800' : 'text-gray-500');
                title.textContent = notif.data?.status ?? '-';

                const message = document.createElement('p');
                message.className = 'text-xs text-gray-500';
                message.textContent = notif.data?.message ?? '-';

                textWrap.appendChild(title);
                textWrap.appendChild(message);

                left.appendChild(icon);
                left.appendChild(textWrap);

                /* =========================
                   RIGHT SIDE
                ========================== */
                const right = document.createElement('div');
                right.className = 'flex flex-col items-end gap-1';

                const time = document.createElement('span');
                time.className = 'text-xs font-bold text-gray-500';
                time.textContent = notif.created_at ?? '';

                right.appendChild(time);

                if (isUnread) {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className =
                        'text-xs text-blue-600 hover:underline cursor-pointer';
                    btn.textContent = 'Tandai dibaca';

                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        markAsRead(notif.id);
                    });

                    right.appendChild(btn);
                }

                a.addEventListener('click', () => {
                    if (isUnread) markAsRead(notif.id);
                });

                a.appendChild(left);
                a.appendChild(right);
                list.appendChild(a);
            });
        })
        .catch(console.error);
    }

    /* =========================
       INIT
    ========================== */
    loadNotifikasi();
    loadNotifikasiList();

    window.loadNotifikasi = loadNotifikasi;
    window.loadNotifikasiList = loadNotifikasiList;

    Echo.join('notification-bell')
        .listen('.notification-update', () => {
            loadNotifikasi();
            loadNotifikasiList();
            if (typeof LoadReservasiCount === 'function') {
                LoadReservasiCount();
            }
        });


});