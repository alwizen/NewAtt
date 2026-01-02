<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tap Kartu RFID</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: #ffffff;
            padding: 50px 40px;
            width: 100%;
            max-width: 480px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            text-align: center;
            position: relative;
        }

        .icon-wrapper {
            width: 80px;
            height: 80px;
            background: #e8f4fd;
            border-radius: 50%;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-wrapper svg {
            width: 40px;
            height: 40px;
            fill: #2196F3;
        }

        h1 {
            font-size: 28px;
            color: #1a202c;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .subtitle {
            color: #718096;
            margin-bottom: 35px;
            font-size: 16px;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 18px 20px;
            font-size: 18px;
            text-align: center;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        input:focus {
            border-color: #2196F3;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(33, 150, 243, 0.1);
        }

        .instruction {
            color: #a0aec0;
            font-size: 14px;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background: #48bb78;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.1);
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal.show {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 20px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.3s ease;
            position: relative;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-icon.success {
            background: #d4edda;
        }

        .modal-icon.error {
            background: #f8d7da;
        }

        .modal-icon svg {
            width: 35px;
            height: 35px;
        }

        .modal-icon.success svg {
            fill: #28a745;
        }

        .modal-icon.error svg {
            fill: #dc3545;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1a202c;
        }

        .modal-message {
            font-size: 16px;
            color: #718096;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .modal-close {
            background: #2196F3;
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: #1976D2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
        }

        .modal-close:active {
            transform: translateY(0);
        }

        /* Loading animation */
        .loading {
            display: none;
            margin-top: 20px;
        }

        .loading.show {
            display: block;
        }

        .spinner {
            width: 40px;
            height: 40px;
            margin: 0 auto;
            border: 4px solid #e2e8f0;
            border-top: 4px solid #2196F3;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 40px 25px;
            }

            h1 {
                font-size: 24px;
            }

            .modal-content {
                padding: 30px 25px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                    d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z" />
            </svg>
        </div>

        <h1>Absensi Karyawan</h1>
        <p class="subtitle">Tempelkan kartu RFID Anda pada reader</p>

        <form id="tapForm">
            <div class="input-wrapper">
                <input type="text" id="rfid_number" name="rfid_number" placeholder="Menunggu kartu..." autofocus
                    autocomplete="off">
            </div>
        </form>

        <div class="instruction">
            <span class="pulse-dot"></span>
            <span>Sistem siap menerima kartu</span>
        </div>

        <div class="loading" id="loading">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-icon" id="modalIcon">
                <svg id="successIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display: none;">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                </svg>
                <svg id="errorIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display: none;">
                    <path
                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                </svg>
            </div>
            <h2 class="modal-title" id="modalTitle"></h2>
            <p class="modal-message" id="modalMessage"></p>
            <button class="modal-close" id="modalClose">Tutup</button>
        </div>
    </div>

    <script>
        const form = document.getElementById('tapForm');
        const input = document.getElementById('rfid_number');
        const modal = document.getElementById('modal');
        const modalIcon = document.getElementById('modalIcon');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const modalClose = document.getElementById('modalClose');
        const successIcon = document.getElementById('successIcon');
        const errorIcon = document.getElementById('errorIcon');
        const loading = document.getElementById('loading');

        // 1. Definisikan variabel timer di luar fungsi
        let autoCloseTimer;

        function showModal(success, title, message) {
            // 2. Bersihkan timer lama jika ada agar tidak bentrok
            clearTimeout(autoCloseTimer);

            modalIcon.className = 'modal-icon ' + (success ? 'success' : 'error');

            if (success) {
                successIcon.style.display = 'block';
                errorIcon.style.display = 'none';
            } else {
                successIcon.style.display = 'none';
                errorIcon.style.display = 'block';
            }

            modalTitle.textContent = title;
            modalMessage.textContent = message;
            modal.classList.add('show');

            // 3. Atur timer untuk menutup modal otomatis (3 detik)
            autoCloseTimer = setTimeout(() => {
                hideModal();
            }, 1500);
        }

        function hideModal() {
            // 4. Pastikan timer dihentikan jika user klik "Tutup" manual sebelum 3 detik
            clearTimeout(autoCloseTimer);
            modal.classList.remove('show');
            input.value = '';
            input.focus();
        }

        modalClose.addEventListener('click', hideModal);

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideModal();
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const rfid = input.value.trim();
            if (!rfid) return;

            loading.classList.add('show');
            input.disabled = true;

            fetch('/api/attendance/tap', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        rfid_number: rfid
                    })
                })
                .then(res => res.json())
                .then(data => {
                    loading.classList.remove('show');
                    input.disabled = false;

                    if (data.success) {
                        showModal(true, 'Berhasil!', data.message);
                    } else {
                        showModal(false, 'Gagal', data.message ?? 'Gagal memproses tap kartu');
                    }
                })
                .catch(() => {
                    loading.classList.remove('show');
                    input.disabled = false;
                    showModal(false, 'Error', 'Koneksi ke server gagal. Silakan coba lagi.');
                });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('show')) {
                hideModal();
            }
        });
    </script>

</body>

</html>
