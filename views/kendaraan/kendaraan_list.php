<?php
/**
 * FILE: views/kendaraan/kendaraan_list.php
 * FUNGSI: Menampilkan daftar semua kendaraan dalam bentuk tabel
 */
include 'views/layout/header.php';
?>
<style>
    .page-wrapper {
        display: flex;
        min-height: 100vh;
        padding-top: 70px;
    }

    .main-container {
        margin-left: 250px;
        flex: 1;
        padding: 2rem;
        background: #f4f6f9;
        min-height: calc(100vh - 70px);
    }

    .content-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .content-header h2 {
        margin: 0;
        font-weight: 700;
        color: #202020;
    }

    .btn {
        display: inline-block;
        padding: 0.6rem 1.2rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0069d9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,123,255,0.3);
    }

    .btn-edit {
        background: #ffc107;
        color: #000;
        padding: 0.4rem 0.9rem;
        font-size: 0.9rem;
    }

    .btn-edit:hover {
        background: #e0a800;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
        padding: 0.4rem 0.9rem;
        font-size: 0.9rem;
    }

    .btn-delete:hover {
        background: #c82333;
    }

    .status-badge {
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .status-tersedia {
        background: #d4edda;
        color: #155724;
    }

    .status-disewa {
        background: #fff3cd;
        color: #856404;
    }

    .status-maintenance {
        background: #f8d7da;
        color: #721c24;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .table-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background: linear-gradient(135deg, #202020 0%, #333533 100%);
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
        color: #495057;
    }

    .data-table tbody tr {
        transition: background 0.2s;
    }

    .data-table tbody tr:hover {
        background: #f8f9fa;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .stats-footer {
        margin-top: 1.5rem;
        padding: 1rem 1.5rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .stats-footer strong {
        color: #202020;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-state p {
        color: #6c757d;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .main-container {
            margin-left: 0;
            padding: 1rem;
        }

        .content-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .data-table {
            font-size: 0.85rem;
        }

        .data-table th,
        .data-table td {
            padding: 0.7rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }

    /* Responsiveness */
    @media (max-width: 1024px) {
        .main-container {
            margin-left: 0;
        }
        
        .page-wrapper {
            flex-direction: column;
        }
    }

    @media (max-width: 768px) {
    .main-container {
        margin-left: 0;
        padding: 1rem;
        }
    }
    
    @media (max-width: 768px) {
        .main-container {
            padding: 1rem;
        }
        
        .content-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .data-table {
            font-size: 0.85rem;
        }
        
        .data-table th,
        .data-table td {
            padding: 0.7rem 0.5rem;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 0.3rem;
        }
        
        .btn-edit, .btn-delete {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .main-container {
            padding: 0.8rem;
        }
        
        .stats-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        .data-table {
            min-width: 600px;
        }
    }
</style>

<div class="page-wrapper">
    <?php include 'views/layout/sidebar.php'; ?>

    <div class="main-container">
        <div class="content-header">
            <h2>
                <i class="fa-solid fa-car"></i> Daftar Kendaraan
            </h2>
            <a href="index.php?action=kendaraan_create" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Kendaraan Baru
            </a>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert">
                <?php
                $messages = [
                    'created' => '✅ Kendaraan berhasil ditambahkan!',
                    'updated' => '✅ Data kendaraan berhasil diupdate!',
                    'deleted' => '✅ Kendaraan berhasil dihapus!'
                ];
                echo $messages[$_GET['message']] ?? '✅ Operasi berhasil!';
                ?>
            </div>
        <?php endif; ?>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Plat Nomor</th>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>Tahun</th>
                        <th>Tipe</th>
                        <th>Harga Sewa/Hari</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($kendaraan->rowCount() > 0): ?>
                        <?php while ($row = $kendaraan->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($row['kendaraan_id']); ?></strong></td>
                                <td><?php echo htmlspecialchars($row['plat_nomor']); ?></td>
                                <td><?php echo htmlspecialchars($row['merk']); ?></td>
                                <td><?php echo htmlspecialchars($row['model']); ?></td>
                                <td><?php echo $row['tahun'] ?: '-'; ?></td>
                                <td><?php echo htmlspecialchars($row['nama_tipe'] ?? '-'); ?></td>
                                <td>Rp <?php echo number_format($row['harga_sewa_per_hari'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php 
                                    $statusClass = '';
                                    switch($row['status_ketersediaan']) {
                                        case 'Tersedia':
                                            $statusClass = 'status-tersedia';
                                            break;
                                        case 'Disewa':
                                            $statusClass = 'status-disewa';
                                            break;
                                        case 'Maintenance':
                                            $statusClass = 'status-maintenance';
                                            break;
                                    }
                                    ?>
                                    <span class="status-badge <?php echo $statusClass; ?>">
                                        <?php echo htmlspecialchars($row['status_ketersediaan']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="index.php?action=kendaraan_edit&id=<?php echo $row['kendaraan_id']; ?>" 
                                        class="btn btn-edit">Edit</a>
                                        <a href="index.php?action=kendaraan_delete&id=<?php echo $row['kendaraan_id']; ?>" 
                                        class="btn btn-delete" 
                                        onclick="return confirm('Yakin ingin menghapus kendaraan ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <p>Belum ada data kendaraan.</p>
                                    <a href="index.php?action=kendaraan_create" class="btn btn-primary">Tambah Kendaraan Pertama</a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="stats-footer">
            <strong> 
                <i class="fa-solid fa-chart-column"></i> Total Data:
            </strong>
            <span><?php echo $kendaraan->rowCount(); ?> kendaraan terdaftar</span>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>