<?php
/**
 * FILE: views/users/users_list.php
 * FUNGSI: Menampilkan daftar semua users dalam bentuk tabel
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
        display: flex;
        align-items: center;
        gap: 0.5rem;
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
        padding: 0.5rem 1.2rem;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .btn-edit:hover {
        background: #e0a800;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
        padding: 0.5rem 1.2rem;
        font-size: 0.9rem;
        font-weight: 600;
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
        background: linear-gradient(135deg, #2c2c2c 0%, #3a3a3a 100%);
        color: white;
        padding: 1.2rem 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 1rem;
    }

    .data-table td {
        padding: 1.5rem 1rem;
        border-bottom: 1px solid #e9ecef;
        color: #495057;
        font-size: 0.95rem;
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
        gap: 0.6rem;
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
            min-width: 500px;
        }
        
        .data-table th,
        .data-table td {
            padding: 0.8rem 0.5rem;
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
        
        .btn-primary {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="page-wrapper">
    <?php include 'views/layout/sidebar.php'; ?>

    <div class="main-container">
        <div class="content-header">
            <h2>
                <i class="fa-solid fa-file"></i> Daftar Users
            </h2>
            <a href="index.php?action=users_create" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Users
            </a>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert">
                <?php
                $messages = [
                    'created' => '✅ Users berhasil ditambahkan!',
                    'updated' => '✅ Data users berhasil diupdate!',
                    'deleted' => '✅ Users berhasil dihapus!'
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
                        <th>Username</th>
                        <th>Roles</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users->rowCount() > 0): ?>
                        <?php while ($row = $users->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($row['id']); ?></strong></td>
                                <td><strong><?php echo htmlspecialchars($row['username']); ?></strong></td>
                                <td><?= ucfirst($row['role'] ?? ''); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="index.php?action=users_edit&id=<?php echo $row['id']; ?>" 
                                           class="btn btn-edit">Edit</a>
                                        <a href="index.php?action=users_delete&id=<?php echo $row['id']; ?>" 
                                           class="btn btn-delete" 
                                           onclick="return confirm('Yakin ingin menghapus users ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <p>Belum ada data users.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="stats-footer">
            <strong><i class="fa-solid fa-chart-column"></i>  Total Data: </strong>
            <span><?php echo $users->rowCount(); ?> users terdaftar</span>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>