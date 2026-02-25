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
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .add-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.5);
            transition: all 0.3s ease;
            z-index: 100;
        }

        .add-btn:hover {
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .add-btn svg {
            width: 24px;
            height: 24px;
            fill: #fff;
        }

        .entity-selector {
            position: fixed;
            top: 20px;
            left: 20px;
            background: #fff;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            z-index: 100;
        }

        .entity-selector:hover {
            transform: scale(1.1);
        }

        .entity-selector svg {
            width: 24px;
            height: 24px;
            fill: #333;
        }

        /* Entity Cards Grid */
        #entitiesContainer {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1200px;
            padding: 80px 20px 100px;
        }

        .entity-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .entity-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
        }

        .entity-card .logo {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            overflow: hidden;
        }

        .entity-card .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .entity-card .logo svg {
            width: 70px;
            height: 70px;
            fill: #fff;
        }

        .entity-card .entity-name {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .entity-card .entity-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 25px;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .card-actions .action-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .card-actions .action-btn svg {
            width: 16px;
            height: 16px;
        }

        .card-actions .edit-btn {
            background: #fff3e0;
            color: #f57c00;
            border: 1px solid #ffcc80;
        }

        .card-actions .edit-btn:hover {
            background: #ffe0b2;
        }

        .card-actions .edit-btn svg {
            fill: #f57c00;
        }

        .card-actions .delete-btn {
            background: #ffebee;
            color: #e74c3c;
            border: 1px solid #ffcdd2;
        }

        .card-actions .delete-btn:hover {
            background: #ffcdd2;
        }

        .card-actions .delete-btn svg {
            fill: #e74c3c;
        }

        .index-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 60px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            max-width: 450px;
            width: 100%;
            margin: 80px auto;
        }

        .index-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
        }

        .logo {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .logo svg {
            width: 70px;
            height: 70px;
            fill: #fff;
        }

        .entity-name {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .entity-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 25px;
        }

        @media (max-width: 500px) {
            #entitiesContainer {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Entity Selector Button -->
    <button class="entity-selector" onclick="showEntitySelector()" title="Pilih Entitas">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
        </svg>
    </button>

    <div id="entitiesContainer">
        <!-- Entities will be loaded from database -->
    </div>

    <div class="index-container" id="noEntitiesMessage" style="display: none;">
        <div class="logo">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/>
            </svg>
        </div>
        <div class="entity-name">Belum Ada Entitas</div>
        <div class="entity-subtitle">Klik tombol + untuk menambah entitas</div>
    </div>

    <button class="add-btn" onclick="window.location.href='tambah_entitas.php'" title="Tambah Entitas">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
        </svg>
    </button>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        // Entity data - loaded from database
        let entities = [];
        let currentEntityId = null;

        // Load entities from database on page load
        async function loadEntities() {
            try {
                const response = await fetch('api/proses_entitas.php');
                const result = await response.json();
                
                if (result.success) {
                    entities = result.data || [];
                    
                    const container = document.getElementById('entitiesContainer');
                    const noEntitiesMsg = document.getElementById('noEntitiesMessage');
                    
                    if (entities.length === 0) {
                        container.innerHTML = '';
                        noEntitiesMsg.style.display = 'block';
                    } else {
                        noEntitiesMsg.style.display = 'none';
                        container.innerHTML = '';
                        
                        entities.forEach(entitas => {
                            const card = document.createElement('div');
                            card.className = 'entity-card';
                            card.onclick = (e) => {
                                // Don't navigate if clicking buttons
                                if (e.target.closest('.edit-btn') || e.target.closest('.delete-btn')) {
                                    return;
                                }
                                window.location.href = 'menu.php?id_entitas=' + entitas.id_entitas;
                            };
                            card.innerHTML = `
                                <div class="logo">
                                    ${entitas.logo ? 
                                        '<img src="' + entitas.logo + '" alt="Logo">' : 
                                        '<svg viewBox="0 0 24 24"><path d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-4.86 8.86l-3 3.87L9 13.14 6 17h12l-3.86-5.14z"/></svg>'
                                    }
                                </div>
                                <div class="entity-name">${entitas.nama_entitas}</div>
                                <div class="entity-subtitle">${entitas.level} ${entitas.daerah || ''}</div>
                                <div class="card-actions">
                                    <button class="action-btn edit-btn" onclick="editEntitas(event, ${entitas.id_entitas})">
                                        <svg viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z 7.04M20.71c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        Ubah
                                    </button>
                                    <button class="action-btn delete-btn" onclick="deleteEntitas(event, ${entitas.id_entitas}, '${entitas.nama_entitas}')">
                                        <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                        Hapus
                                    </button>
                                </div>
                            `;
                            container.appendChild(card);
                        });
                    }
                }
            } catch (error) {
                console.error('Error loading entities:', error);
            }
        }

        // Edit entity
        function editEntitas(event, id) {
            event.stopPropagation();
            window.location.href = 'ubah_entitas.php?id=' + id;
        }

        // Delete entity
        async function deleteEntitas(event, id, nama) {
            event.stopPropagation();
            
            const result = await Swal.fire({
                title: 'Anda yakin?',
                text: 'Entitas "' + nama + '" akan dihapus!',
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
                    formData.append('id_entitas', id);

                    const response = await fetch('api/proses_entitas.php', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const res = await response.json();
                    
                    if (res.success) {
                        Swal.fire('Terhapus!', 'Entitas berhasil dihapus.', 'success')
                            .then(() => loadEntities());
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Gagal menghapus data', 'error');
                }
            }
        }

        // Show entity selector
        function showEntitySelector() {
            if (entities.length === 0) {
                Swal.fire('Info', 'Belum ada entitas. Tambahkan entitas terlebih dahulu.', 'info');
                return;
            }
            
            const entityOptions = entities.map(entity => 
                '<option value="' + entity.id_entitas + '">' + entity.nama_entitas + '</option>'
            ).join('');

            Swal.fire({
                title: 'Pilih Entitas',
                html: '<select id="entitySelect" class="swal2-select" style="width: 100%; padding: 12px; border: 2px solid #e1e1e1; border-radius: 8px; font-size: 14px;">' + entityOptions + '</select>',
                showCancelButton: true,
                confirmButtonText: 'Pilih',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#ccc',
                preConfirm: () => {
                    return document.getElementById('entitySelect').value;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const entityId = parseInt(result.value);
                    const entity = entities.find(e => e.id_entitas === entityId);
                    if (entity) {
                        currentEntityId = entityId;
                        window.location.href = 'menu.php?id_entitas=' + entityId;
                    }
                }
            });
        }
        
        document.addEventListener('DOMContentLoaded', loadEntities);
    </script>
</body>
</html>
