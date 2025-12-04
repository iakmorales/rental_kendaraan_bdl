
<?php
/**
 * FILE: views/pengembalian/pengembalian_list.php
 * FUNGSI: Menampilkan daftar semua pengembalian kendaraan
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
        box-shadow: 0 4px 8px rgba(40,167,69,0.3);
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

    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
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
    }

    /* Responsiveness */
    @media (max-width: 1024px) {
        .main-container {
            margin-left: 0;
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
        
        .table-container {
            overflow-x: auto;
        }
        
        .data-table {
            min-width: 700px;
        }
        
        .data-table th,
        .data-table td {
            padding: 0.8rem 0.5rem;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 0.3rem;
        }
        
        .btn-delete {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .main-container {
            padding: 0.8rem;
        }
        
        .btn-primary {
            width: 100%;
            text-align: center;
        }
        
        .stats-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
</style>

<div class="page-wrapper">
    <?php include 'views/layout/sidebar.php'; ?>

    <div class="main-container">
        <div class="content-header">
            <h2>
                <i class="fa-solid fa-file"></i> Daftar Pengembalian Kendaraan
            </h2>
            <a href="index.php?action=pengembalian_create" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Proses Pengembalian Baru
            </a>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert">
                <?php
                $messages = [
                    'created' => '✅ Pengembalian berhasil diproses!',
                    'deleted' => '✅ Data pengembalian berhasil dihapus!'
                ];
                echo $messages[$_GET['message']] ?? '✅ Operasi berhasil!';
                ?>
            </div>
        <?php endif; ?>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID Pengembalian</th>
                        <th>ID Rental</th>
                        <th>Tanggal Kembali Aktual</th>
                        <th>Denda</th>
                        <th>Kondisi Akhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($pengembalian->rowCount() > 0): ?>
                        <?php while ($row = $pengembalian->fetch(PDO::FETCH_ASSOC)): ?>
                            <?php
                            $denda_badge = $row['denda'] > 0 ? 'badge-danger' : 'badge-success';
                            $denda_text = $row['denda'] > 0 ? 'Rp ' . number_format($row['denda'], 0, ',', '.') : 'Tidak ada';
                            ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($row['pengembalian_id']); ?></strong></td>
                                <td><strong><?php echo htmlspecialchars($row['rental_id']); ?></strong></td>
                                <td><?php echo date('d-m-Y H:i', strtotime($row['tanggal_kembali_aktual'])); ?></td>
                                <td>
                                    <span class="badge <?php echo $denda_badge; ?>">
                                        <?php echo $denda_text; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    $kondisi = htmlspecialchars($row['kondisi_akhir'] ?? '-');
                                    echo strlen($kondisi) > 50 ? substr($kondisi, 0, 50) . '...' : $kondisi;
                                    ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="index.php?action=pengembalian_delete&id=<?php echo $row['pengembalian_id']; ?>" 
                                        class="btn btn-delete" 
                                        onclick="return confirm('Yakin ingin menghapus data pengembalian ini?')">
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <p>Belum ada data pengembalian.</p>
                                    <a href="index.php?action=pengembalian_create" class="btn btn-primary">Proses Pengembalian Pertama</a>
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
            <span><?php echo $pengembalian->rowCount(); ?> pengembalian tercatat</span>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>