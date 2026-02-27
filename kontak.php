<?php
/**
 * Daftar Kontak
 * Halaman untuk menampilkan dan mengelola kontak
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo.ico">
    <title>KKP Willybrodus</title>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f5f6fa;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            background: #fff;
            border-radius: 15px;
            padding: 20px 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .back-btn {
            background: #f0f0f0;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: #e0e0e0;
            transform: scale(1.05);
        }

        .back-btn svg {
            width: 24px;
            height: 24px;
            fill: #333;
        }

        .header h1 {
            color: #333;
            font-size: 24px;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: #f5f5f5;
            border-radius: 25px;
            padding: 8px 20px;
            gap: 10px;
            width: 280px;
        }

        .search-box svg {
            width: 20px;
            height: 20px;
            fill: #666;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            flex: 1;
            font-size: 14px;
            color: #333;
        }

        .search-box input::placeholder {
            color: #999;
        }

        .add-btn {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.5);
        }

        .add-btn svg {
            width: 18px;
            height: 18px;
            fill: #fff;
        }

        .skpd-section {
            background: #fff;
            border-radius: 15px;
            margin-bottom: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .skpd-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 25px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .skpd-header:hover {
            background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
        }

        .skpd-header h2 {
            color: #fff;
            font-size: 18px;
            font-weight: 600;
        }

        .skpd-toggle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .skpd-toggle svg {
            width: 18px;
            height: 18px;
            fill: #fff;
            transition: transform 0.3s ease;
        }

        .skpd-section.collapsed .skpd-toggle svg {
            transform: rotate(-90deg);
        }

        .skpd-section.collapsed .skpd-content {
            display: none;
        }

        .skpd-content {
            padding: 15px;
        }

        .contacts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 15px;
        }

        .contact-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .contact-name {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .contact-position {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
        }

        .contact-phone {
            font-size: 14px;
            color: #555;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .contact-phone svg {
            width: 16px;
            height: 16px;
            fill: #667eea;
        }

        .contact-actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .action-btn svg {
            width: 16px;
            height: 16px;
        }

        .edit-btn {
            background: #fff3e0;
            color: #f57c00;
            border: 1px solid #ffcc80;
        }

        .edit-btn:hover {
            background: #ffe0b2;
        }

        .edit-btn svg {
            fill: #f57c00;
        }

        .wa-btn {
            background: #e8f5e9;
            color: #4caf50;
            border: 1px solid #a5d6a7;
        }

        .wa-btn:hover {
            background: #c8e6c9;
        }

        .wa-btn svg {
            fill: #4caf50;
        }

        .delete-btn {
            background: #ffebee;
            color: #e74c3c;
            border: 1px solid #ffcdd2;
        }

        .delete-btn:hover {
            background: #ffcdd2;
        }

        .delete-btn svg {
            fill: #e74c3c;
        }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: stretch;
            }

            .header-actions {
                flex-direction: column;
            }

            .search-box {
                width: 100%;
            }

            .add-btn {
                width: 100%;
                justify-content: center;
            }

            .contacts-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <button class="back-btn" onclick="goBack()">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                    </svg>
                </button>
                <h1>Daftar Kontak</h1>
            </div>
            <div class="header-actions">
                <div class="search-box">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                    <input type="text" id="searchInput" placeholder="Cari kontak..." onkeyup="searchContacts()">
                </div>
                <button class="add-btn" onclick="window.location.href='tambah_kontak.php?id_entitas=' + getEntityId()">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Tambah Kontak
                </button>
            </div>
        </div>

        <div id="contactsContainer">
            <!-- Contacts will be loaded from database -->
        </div>

        <div id="noResults" class="no-results" style="display: none;">
            <p>Tidak ada kontak ditemukan</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        // Go back to menu with entity ID
        function goBack() {
            const urlParams = new URLSearchParams(window.location.search);
            const idEntitas = urlParams.get('id_entitas');
            if (idEntitas) {
                window.location.href = 'menu.php?id_entitas=' + idEntitas;
            } else {
                window.location.href = 'menu.php';
            }
        }

        // Get entity ID from URL
        function getEntityId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('id_entitas') || '';
        }

        // Load contacts from database via API
        let contacts = [];
        
        async function loadContacts() {
            try {
                const urlParams = new URLSearchParams(window.location.search);
                const idEntitas = urlParams.get('id_entitas');
                
                let apiUrl = 'api/proses_kontak.php';
                if (idEntitas) {
                    apiUrl += '?id_entitas=' + idEntitas;
                }
                
                console.log('Loading from API:', apiUrl);
                
                const response = await fetch(apiUrl);
                const result = await response.json();
                
                console.log('API response:', result);
                
                if (result.success) {
                    contacts = result.data || [];
                    renderContacts(contacts);
                } else {
                    console.error('API error:', result.message);
                    document.getElementById('contactsContainer').innerHTML = 
                        '<div class="no-results"><p>Error: ' + result.message + '</p></div>';
                }
            } catch (error) {
                console.error('Error loading contacts:', error);
                document.getElementById('contactsContainer').innerHTML = 
                    '<div class="no-results"><p>Error loading data. Make sure XAMPP is running.</p></div>';
            }
        }

        function renderContacts(contactsData) {
            const container = document.getElementById('contactsContainer');
            const noResults = document.getElementById('noResults');
            
            if (contactsData.length === 0) {
                container.innerHTML = '';
                noResults.style.display = 'block';
                return;
            }
            
            noResults.style.display = 'none';
            
            // Group contacts by entity
            const groupedContacts = {};
            contactsData.forEach(kontak => {
                const entityName = kontak.nama_entitas || 'Entitas Tidak Diketahui';
                if (!groupedContacts[entityName]) {
                    groupedContacts[entityName] = [];
                }
                groupedContacts[entityName].push(kontak);
            });
            
            let html = '';
            for (const [entityName, entityContacts] of Object.entries(groupedContacts)) {
                html += '<div class="skpd-section"><div class="skpd-header" onclick="toggleSkpd(this)"><h2>' + entityName + '</h2><div class="skpd-toggle"><svg viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></div></div><div class="skpd-content"><div class="contacts-grid">';
                
                entityContacts.forEach(kontak => {
                    html += '<div class="contact-card" data-name="' + kontak.nama + '" data-position="' + (kontak.posisi || '') + '" data-phone="' + (kontak.telepon || '') + '">';
                    html += '<div class="contact-name">' + kontak.nama + '</div>';
                    html += '<div class="contact-position">' + (kontak.posisi || '-') + '</div>';
                    html += '<div class="contact-phone"><svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg><span>' + (kontak.telepon || '-') + '</span></div>';
                    html += '<div class="contact-actions">';
                    html += '<button class="action-btn edit-btn" onclick="editContact(' + kontak.id_kontak + ')"><svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>Ubah</button>';
                    if (kontak.telepon) {
                        html += '<button class="action-btn wa-btn" onclick="openWhatsApp(\'' + kontak.telepon + '\')"><svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>WhatsApp</button>';
                    }
                    html += '<button class="action-btn delete-btn" onclick="deleteContact(' + kontak.id_kontak + ', \'' + kontak.nama + '\')"><svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>Hapus</button>';
                    html += '</div></div>';
                });
                
                html += '</div></div></div>';
            }
            
            container.innerHTML = html;
        }

        // Delete contact
        async function deleteContact(id, nama) {
            const result = await Swal.fire({
                title: 'Anda yakin?',
                text: 'Kontak "' + nama + '" akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                try {
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('id_kontak', id);

                    const response = await fetch('api/proses_kontak.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const res = await response.json();
                    
                    if (res.success) {
                        Swal.fire('Terhapus!', 'Kontak berhasil dihapus.', 'success')
                            .then(() => loadContacts());
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Gagal menghapus data', 'error');
                }
            }
        }

        // Toggle SKPD section collapse/expand
        function toggleSkpd(header) {
            const section = header.parentElement;
            section.classList.toggle('collapsed');
        }

        // Open WhatsApp with phone number
        function openWhatsApp(phone) {
            // Remove any non-digit characters
            const cleanPhone = phone.replace(/\D/g, '');
            // Check if number starts with 0, replace with 62 (Indonesia country code)
            const formattedPhone = cleanPhone.startsWith('0') 
                ? '62' + cleanPhone.substring(1) 
                : cleanPhone;
            // Open WhatsApp Web or WhatsApp app
            window.open('https://wa.me/' + formattedPhone, '_blank');
        }

        // Edit contact function
        function editContact(id) {
            const idEntitas = getEntityId();
            if (idEntitas) {
                window.location.href = 'ubah_kontak.php?id=' + id + '&id_entitas=' + idEntitas;
            } else {
                window.location.href = 'ubah_kontak.php?id=' + id;
            }
        }

        // Search functionality
        function searchContacts() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const container = document.getElementById('contactsContainer');
            const sections = container.getElementsByClassName('skpd-section');
            const cards = container.getElementsByClassName('contact-card');
            let hasResults = false;

            // Search in contact cards
            for (let i = 0; i < cards.length; i++) {
                const name = cards[i].getAttribute('data-name');
                const position = cards[i].getAttribute('data-position');
                const phone = cards[i].getAttribute('data-phone');

                if (name.toLowerCase().indexOf(filter) > -1 || 
                    position.toLowerCase().indexOf(filter) > -1 || 
                    phone.indexOf(filter) > -1) {
                    cards[i].style.display = "";
                    hasResults = true;
                } else {
                    cards[i].style.display = "none";
                }
            }

            // Show/hide SKPD sections based on whether they have visible contacts
            for (let i = 0; i < sections.length; i++) {
                const sectionCards = sections[i].querySelectorAll('.contact-card');
                let sectionHasVisible = false;
                
                for (let j = 0; j < sectionCards.length; j++) {
                    if (sectionCards[j].style.display !== "none") {
                        sectionHasVisible = true;
                        break;
                    }
                }

                sections[i].style.display = sectionHasVisible ? "" : "none";
            }

            // Show/hide no results message
            const noResults = document.getElementById('noResults');
            if (!hasResults) {
                noResults.style.display = "block";
                container.style.display = "none";
            } else {
                noResults.style.display = "none";
                container.style.display = "block";
            }
        }

        // Load contacts on page load
        document.addEventListener('DOMContentLoaded', loadContacts);
    </script>
</body>
</html>
