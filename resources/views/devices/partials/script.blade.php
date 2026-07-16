<script>
    let deviceIdToDelete = null;
    let deviceStatusPollingTimer = null;

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, char => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[char]));
    }

    function escapeAttribute(value) {
        return escapeHtml(value).replace(/`/g, '&#096;');
    }

    function escapeJsString(value) {
        return String(value ?? '').replace(/\\/g, '\\\\').replace(/'/g, "\\'").replace(/\n/g, '\\n').replace(/\r/g, '\\r');
    }

    function cssEscape(value) {
        if (window.CSS && typeof window.CSS.escape === 'function') {
            return window.CSS.escape(value);
        }

        return String(value ?? '').replace(/["\\]/g, '\\$&');
    }

    function deviceStatusBadge(status) {
        if (status === 'connect') {
            return '<span class="px-2 py-2 text-sm font-semibold text-white bg-green-500 rounded">Connected</span>';
        }

        return '<span class="px-2 py-2 text-sm font-semibold text-white bg-red-500 rounded">Disconnect</span>';
    }

    function deviceActionButtons(device) {
        const token = escapeJsString(device.token);
        const name = escapeJsString(device.name);
        const phone = escapeJsString(device.device);

        const baseButtons = `
            <button class="px-2 py-2 text-sm font-semibold text-white bg-blue-500 rounded hover:bg-blue-600"
                onclick="copyToClipboard('${token}')">
                Copy Token
            </button>
        `;

        const statusButtons = device.status === 'connect'
            ? `
                <button class="px-2 py-2 text-sm text-white rounded bg-slate-500"
                    onclick="openSendMessageModal('${token}')">
                    Send Message
                </button>
                <button class="px-2 py-2 text-sm text-white bg-red-500 rounded disconnectButton"
                    data-device-token="${escapeAttribute(device.token)}"
                    onclick="disconnectDevice('${token}')">
                    Disconnect
                    <svg class="hidden w-4 h-4 ml-1 text-white disconnectSpinner animate-spin"
                        xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                </button>
            `
            : `
                <button onclick="activateDevice('${phone}', '${token}', this)"
                    class="px-2 py-2 text-sm text-white bg-green-500 hover:bg-green-600 rounded">
                    Connect
                </button>
            `;

        return `
            ${baseButtons}
            ${statusButtons}
            <button class="px-2 py-2 text-sm text-white bg-orange-500 hover:bg-orange-600 rounded"
                onclick="confirmDelete('${token}', '${name}')">
                Delete
            </button>
        `;
    }

    function renderDeviceRow(device, index) {
        return `
            <tr class="border-b border-gray-200" data-device-token="${escapeAttribute(device.token)}">
                <td class="p-2 text-center">${index}</td>
                <td class="p-2 text-center">${escapeHtml(device.name)}</td>
                <td class="p-2 text-center">${escapeHtml(device.device)}</td>
                <td class="p-2 text-center">${escapeHtml(device.quota ?? '-')}</td>
                <td class="p-2 text-center">${deviceStatusBadge(device.status)}</td>
                <td class="px-6 py-3 space-x-2">${deviceActionButtons(device)}</td>
            </tr>
        `;
    }

    function refreshDeviceRowNumbers() {
        document.querySelectorAll('#deviceTableBody tr').forEach((row, index) => {
            const numberCell = row.querySelector('td');
            if (numberCell) {
                numberCell.textContent = index + 1;
            }
        });
    }

    function upsertDeviceRow(device) {
        const tableBody = document.getElementById('deviceTableBody');
        if (!tableBody || !device || !device.token) return;

        const selector = `tr[data-device-token="${cssEscape(device.token)}"]`;
        const existingRow = tableBody.querySelector(selector);
        const existingQuota = existingRow?.children[3]?.textContent?.trim();
        const rowDevice = {
            ...device,
            quota: device.quota && device.quota !== '-' ? device.quota : (existingQuota || '-')
        };

        if (existingRow) {
            existingRow.outerHTML = renderDeviceRow(rowDevice, Array.from(tableBody.children).indexOf(existingRow) + 1);
        } else {
            tableBody.insertAdjacentHTML('beforeend', renderDeviceRow(rowDevice, tableBody.children.length + 1));
        }

        refreshDeviceRowNumbers();
    }

    function removeDeviceRow(device) {
        if (!device || !device.token) return;

        const row = document.querySelector(`#deviceTableBody tr[data-device-token="${cssEscape(device.token)}"]`);
        if (row) {
            row.remove();
            refreshDeviceRowNumbers();
        }
    }

    function handleDeviceRealtimeEvent(event) {
        if (event.action === 'deleted') {
            removeDeviceRow(event.device);
            return;
        }

        upsertDeviceRow(event.device);
    }

    function listenDeviceGatewayRealtime() {
        if (!window.Echo) {
            setTimeout(listenDeviceGatewayRealtime, 300);
            return;
        }

        window.Echo.join('device-gateway')
            .listen('.device-gateway-update', handleDeviceRealtimeEvent);
    }

    document.addEventListener('DOMContentLoaded', listenDeviceGatewayRealtime);

    function stopDeviceStatusPolling() {
        if (deviceStatusPollingTimer) {
            clearInterval(deviceStatusPollingTimer);
            deviceStatusPollingTimer = null;
        }
    }

    function startDeviceStatusPolling(device, token, alpine) {
        stopDeviceStatusPolling();

        let attempt = 0;
        const maxAttempts = 30;

        deviceStatusPollingTimer = setInterval(async () => {
            attempt++;

            try {
                const response = await fetch('/devices/status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        device: device,
                        token: token
                    })
                });

                const result = await response.json();

                if (result.connected === true) {
                    stopDeviceStatusPolling();
                    alpine.isOpen = false;
                    alpine.qrCode = '';
                    alert('Device berhasil terhubung!');
                    return;
                }
            } catch (error) {
                console.error('Failed to check device status:', error);
            }

            if (attempt >= maxAttempts) {
                stopDeviceStatusPolling();
            }
        }, 3000);
    }

    function activateDevice(device, token, el) {
    const alpine = Alpine.$data(el.closest('[x-data]'));

    alpine.isOpen = true;
    alpine.loading = true;
    alpine.qrCode = null;
    stopDeviceStatusPolling();


        fetch('/devices/activate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                device: device,
                token: token
            })
        })
        .then(res => res.json())
        .then(data => {

            if (data.connected === true) {
                alert('Device berhasil terhubung!');
                return;
            }

            if (data.status === true && data.qr) {
                alpine.qrCode = data.qr;
                startDeviceStatusPolling(device, token, alpine);
            } else {
                alert(data.error ?? 'QR tidak tersedia');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan');
        })
        .finally(() => {
            alpine.loading = false;
        });
    }

    function qrModal() {
        return {
            isOpen: false,
            qrCode: '',
            loading: false,
            timeLeft: 60,
            timer: null,

            startCountdown() {
                this.clearCountdown()
                this.timeLeft = 60

                this.timer = setInterval(() => {
                    if (this.timeLeft > 0) {
                        this.timeLeft--
                    } else {
                        this.refreshQr()
                    }
                }, 1000)
            },

            clearCountdown() {
                if (this.timer) {
                    clearInterval(this.timer)
                    this.timer = null
                }
            },

            refreshQr() {
                this.loading = true
                this.clearCountdown()

                // 👉 panggil endpoint generate QR kamu di sini
                // contoh simulasi:
                setTimeout(() => {
                    this.qrCode = '/generate-new-qr?' + Date.now()
                    this.loading = false
                    this.startCountdown()
                }, 1000)
            }
        }
    }

    function showModal() {
        const modal = document.getElementById('deviceModal');
        modal.classList.remove('hidden');
    }

    function disconnectDevice(deviceToken) {
        // Tampilkan loading pada tombol yang sesuai
        const disconnectButton = document.querySelector(`.disconnectButton[data-device-token="${cssEscape(deviceToken)}"]`);
        const disconnectSpinner = disconnectButton?.querySelector('.disconnectSpinner');

        if (disconnectButton) {
            disconnectButton.disabled = true; // Nonaktifkan tombol
        }
        if (disconnectSpinner) {
            disconnectSpinner.classList.remove('hidden'); // Tampilkan spinner
        }

        // Lakukan fetch untuk memproses disconnect
        fetch('{{ route("devices.disconnect") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    token: deviceToken
                })
            })
            .then(response => response.json()) // Parsing respons JSON
            .then(data => {
                if (data.message) {
                    alert('Device successfully disconnected.');
                } else if (data.error) {
                    alert('Failed to disconnect device: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while disconnecting the device.');
            })
            .finally(() => {
                // Kembalikan tombol ke keadaan semula
                if (disconnectButton) {
                    disconnectButton.disabled = false; // Aktifkan kembali tombol
                }
                if (disconnectSpinner) {
                    disconnectSpinner.classList.add('hidden'); // Sembunyikan spinner
                }
            });
    }

    function confirmDelete(deviceId, deviceName) {
        deviceIdToDelete = deviceId; // Store the device ID to delete
        document.getElementById('confirmDeleteMessage').innerText =
            `Are you sure you want to delete the device "${deviceName}"?`;
        document.getElementById('confirmDeleteModal').classList.remove('hidden'); // Show confirmation modal
    }

    function closeConfirmDeleteModal() {
        document.getElementById('confirmDeleteModal').classList.add('hidden'); // Hide confirmation modal
        deviceIdToDelete = null; // Reset the device ID
    }

    function deleteDevice() {
    if (!deviceIdToDelete) return;

    const errorContainer = document.getElementById('errorContainerOTP');
    const errorMessage = document.getElementById('errorMessageOTP');

    errorContainer.classList.add('hidden');
    errorMessage.textContent = '';

    let formData = new FormData();
    formData.append('_token', "{{ csrf_token() }}");
    formData.append('_method', 'DELETE');

    fetch('/devices/' + deviceIdToDelete, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(async response => {
        const result = await response.json();

        if (response.status === 403 && result.is_premium) {
            alert('Device premium tidak dapat dihapus.');
            throw 'PREMIUM_DEVICE';
        }

        if (!response.ok) {
            throw result.message || result.error || 'Gagal menghapus device';
        }

        return result;
    })
    .then(() => {
        deviceIdToDelete = null;
        closeConfirmDeleteModal();
    })
    .catch(error => {
        if (error === 'PREMIUM_DEVICE') return;

        errorMessage.textContent = error;
        errorContainer.classList.remove('hidden');
    });
}
    
    function openSendMessageModal(deviceToken) {
        document.getElementById('deviceToken').value = deviceToken;
        document.getElementById('sendMessageModal').classList.remove('hidden');
        clearError(); // Bersihkan error saat modal dibuka
    }

    function closeSendMessageModal() {
        document.getElementById('sendMessageModal').classList.add('hidden');
        clearError(); // Bersihkan error setelah modal ditutup
    }

    function closeOtpDeleteAuthorization() {
        document.getElementById('otpDeleteAuthorization').classList.add('hidden');
        clearError(); // Bersihkan error setelah modal ditutup
    }

    function clearError() {
        const errorContainer = document.getElementById('errorContainer');
        const errorMessage = document.getElementById('errorMessage');
        errorContainer.classList.add('hidden');
        errorMessage.textContent = '';
    }

    document.getElementById('otpAuthorizationForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        deleteDevice(formData.get('otp'))
    })

    document.getElementById('sendMessageForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const deviceToken = formData.get('device_token');
        const sendButton = document.getElementById('sendMessageButton');
        const buttonText = document.getElementById('buttonText');
        const spinner = document.getElementById('spinner');

        // Aktifkan animasi loading
        buttonText.textContent = 'Sending...';
        spinner.classList.remove('hidden');
        sendButton.disabled = true;

        try {
            const response = await fetch('/send-message', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Authorization': deviceToken, // Token dikirim di header
                },
                body: formData,
            });

            const result = await response.json();

            if (response.ok) {
                alert('Pesan berhasil dikirim!');
                closeSendMessageModal(); // Tutup modal jika berhasil
                window.location.reload();
            } else {
                // Tampilkan error di modal jika gagal
                showError(result.error || 'Gagal mengirim pesan.');
            }
        } catch (error) {
            console.error('Error:', error);
            showError('Terjadi kesalahan. Coba lagi.');
        } finally {
            // Kembalikan tombol ke keadaan semula
            buttonText.textContent = 'Send';
            spinner.classList.add('hidden');
            sendButton.disabled = false;
        }
    });

    function showSuccess(message) {
        const messageContainer = document.getElementById('messageAlert');
        messageContainer.innerHTML = `<div class="p-4 mb-4 text-green-800 bg-green-100 rounded">${message}</div>`;
    }

    function showError(message) {
        const errorContainer = document.getElementById('errorContainer');
        const errorMessage = document.getElementById('errorMessage');
        errorMessage.textContent = message;
        errorContainer.classList.remove('hidden');
    }

    function copyToClipboard(token) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(token).then(() => {
                showNotification(token);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        } else {
            // Fallback for older browsers
            const textArea = document.createElement("textarea");
            textArea.value = token;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                console.log('Fallback: Token copied successfully');
                showNotification(token);
            } catch (err) {
                console.error('Fallback: Failed to copy', err);
            }
            document.body.removeChild(textArea);
        }
    }

    function showNotification(token) {
        const notification = document.getElementById('notification');
        const notificationMessage = document.getElementById('notificationMessage');
        if (notification && notificationMessage) {
            notificationMessage.innerText = 'Token copied to clipboard: ' + token;
            notification.classList.remove('hidden'); // Show the notification

            setTimeout(() => {
                notification.classList.add('hidden');
            }, 2000);
        }
    }
</script>
