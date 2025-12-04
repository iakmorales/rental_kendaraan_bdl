<?php
/**
 * FILE: views/rental_pengembalian/laporan_rental_pengembalian.php
 * FUNGSI: Menampilkan daftar rental dengan data pengembalian (query langsung)
 */
$limit = 10; 
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

// QUERY 1: Ambil data dengan filter dan pagination
$query = "SELECT * FROM vw_rental_pengembalian WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query .= " AND (
        \"Nama Pelanggan\" ILIKE ? OR 
        \"Merek Mobil\" ILIKE ?
    )";
    $searchParam = '%' . $search . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
}

if (!empty($filter_status)) {
    $query .= " AND \"Status_Rental\" = ?";
    $params[] = $filter_status;
}

$query .= " ORDER BY \"Tanggal Mulai\" DESC LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;

$stmt = $db->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key + 1, $value);
}
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// QUERY 2: Hitung total records untuk pagination
$countQuery = "SELECT COUNT(*) as total FROM vw_rental_pengembalian WHERE 1=1";
$countParams = [];

if (!empty($search)) {
    $countQuery .= " AND (
        \"Nama Pelanggan\" ILIKE ? OR 
        \"Merek Mobil\" ILIKE ?
    )";
    $searchParam = '%' . $search . '%';
    $countParams[] = $searchParam;
    $countParams[] = $searchParam;
}

if (!empty($filter_status)) {
    $countQuery .= " AND \"Status_Rental\" = ?";
    $countParams[] = $filter_status;
}

$stmt = $db->prepare($countQuery);
foreach ($countParams as $key => $value) {
    $stmt->bindValue($key + 1, $value);
}
$stmt->execute();
$countResult = $stmt->fetch(PDO::FETCH_ASSOC);
$totalRecords = $countResult['total'] ?? 0;
$totalPages = ceil($totalRecords / $limit);

include 'views/layout/header.php';
?>

<style>
    /* SALIN STYLE DARI laporan_rental_sopir.php */
    .page-wrapper {
        display: flex;
        min-height: 100vh;
        padding-top: 70px;
    }

    .main-container {
        margin-left: 250px;
        flex: 1;
        padding: 1rem;
        background: #f4f6f9;
        min-height: calc(100vh - 70px);
    }

    .content-header {
        margin-bottom: 1rem;
    }

    .content-header h2 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 700;
        color: #202020;
    }

    .search-form-container {
        background: white;
        border-radius: 6px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
        align-items: center;
    }

    .search-group {
        flex: 1;
        display: flex;
        gap: 0.5rem;
        min-width: 300px;
    }

    .search-input {
        flex: 1;
        padding: 0.6rem 0.8rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 0.9rem;
    }

    .btn-search {
        padding: 0.6rem 1rem;
        background: #ffc107;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        transition: background 0.2s;
    }

    .btn-search:hover {
        background: #27c100ff;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-select {
        padding: 0.6rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 0.9rem;
        min-width: 160px;
        background: white;
    }

    .btn-reset {
        padding: 0.6rem 0.8rem;
        background: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        transition: background 0.2s;
    }

    .btn-reset:hover {
        background: #5a6268;
    }

    .table-container {
        background: white;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }

    .data-table th {
        background: #202020;
        color: white;
        padding: 0.7rem 0.5rem;
        text-align: left;
        font-weight: 600;
        white-space: nowrap;
    }

    .data-table td {
        padding: 0.6rem 0.5rem;
        border-bottom: 1px solid #e9ecef;
        color: #495057;
        vertical-align: top;
        white-space: nowrap;
    }

    .data-table tbody tr:hover {
        background: #f8f9fa;
    }

    .status-badge {
        display: inline-block;
        padding: 0.2rem 0.5rem;
        border-radius: 3px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-selesai {
        background: #cce5ff;
        color: #004085;
    }

    .status-belum_selesai {
        background: #fff3cd;
        color: #856404;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.3rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .pagination a, 
    .pagination span {
        display: inline-block;
        padding: 0.3rem 0.6rem;
        border-radius: 3px;
        text-decoration: none;
        background: white;
        color: #0e0900ff;
        border: 1px solid #f7dd18ff;
        font-size: 0.8rem;
    }

    .pagination a:hover {
        background: #ffc107;
        color: white;
        border-color: #ffc107;
    }

    .pagination .active {
        background: #ffc107;
        color: white;
        border-color: #ffc107;
    }

    .pagination .disabled {
        color: #6c757d;
        pointer-events: none;
        opacity: 0.6;
    }

    .stats-footer {
        margin-top: 1rem;
        padding: 0.8rem 1rem;
        background: white;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        font-size: 0.85rem;
    }

    .stats-footer strong {
        color: #202020;
    }

    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
    }

    .empty-state p {
        color: #6c757d;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .main-container {
            margin-left: 0;
            padding: 0.8rem;
        }

        .search-form {
            flex-direction: column;
            align-items: stretch;
        }

        .search-group {
            min-width: 100%;
        }

        .filter-group {
            width: 100%;
            justify-content: space-between;
        }

        .filter-select {
            flex: 1;
        }

        .data-table {
            display: block;
            overflow-x: auto;
            font-size: 0.8rem;
        }

        .pagination {
            justify-content: flex-start;
        }
    }
</style>

<div class="page-wrapper">
    <?php include 'views/layout/sidebar.php'; ?>

    <div class="main-container">
        <div class="content-header">
            <h2>
                <i class="fa-solid fa-car"></i> Laporan Rental & Pengembalian
            </h2>
        </div>

        <!-- Search and Filter Form -->
        <div class="search-form-container">
            <form method="GET" action="" class="search-form" id="searchForm">
                <input type="hidden" name="action" value="laporan_rental_pengembalian">
                
                <!-- Group Search Input + Button -->
                <div class="search-group">
                    <input type="text" 
                           name="search" 
                           value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Cari nama pelanggan atau merek mobil..."
                           class="search-input">
                    
                    <button type="submit" class="btn-search">
                        <i class="fa-solid fa-search"></i> Cari
                    </button>
                </div>
                
                <!-- Group Filter + Reset -->
                <div class="filter-group">
                    <select name="status" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="selesai" <?php echo $filter_status == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                        <option value="belum_selesai" <?php echo $filter_status == 'belum_selesai' ? 'selected' : ''; ?>>Belum Selesai</option>
                    </select>
                    
                    <?php if (!empty($search) || !empty($filter_status)): ?>
                        <a href="index.php?action=laporan_rental_pengembalian" class="btn-reset">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Results Table -->
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID Rental</th>
                        <th>Pelanggan</th>
                        <th>Mobil</th>
                        <th>Mulai</th>
                        <th>Selesai Rencana</th>
                        <th>Kembali Aktual</th>
                        <th>Denda</th>
                        <th>Kondisi Akhir</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($data) > 0): ?>
                        <?php foreach ($data as $row): 
                            $status = $row['Status_Rental'];
                            $status_class = str_replace(' ', '_', strtolower($status));
                        ?>
                            <tr>
                                <td><strong>#<?php echo htmlspecialchars($row['ID Rental']); ?></strong></td>
                                <td><?php echo htmlspecialchars($row['Nama Pelanggan']); ?></td>
                                <td><?php echo htmlspecialchars($row['Merek Mobil']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['Tanggal Mulai'])); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['Tanggal Selesai Rencana'])); ?></td>
                                <td>
                                    <?php if (!empty($row['Tanggal Kembali Aktual'])): ?>
                                        <?php echo date('d/m/Y', strtotime($row['Tanggal Kembali Aktual'])); ?>
                                    <?php else: ?>
                                        <span style="color: #6c757d;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>Rp <?php echo number_format($row['Denda'], 0, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars($row['Kondisi Akhir Kendaraan']); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $status_class; ?>">
                                        <?php echo $status == 'selesai' ? 'Selesai' : 'Belum Selesai'; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <p>Tidak ada data ditemukan.</p>
                                    <?php if (!empty($search) || !empty($filter_status)): ?>
                                        <a href="index.php?action=laporan_rental_pengembalian" class="btn-search">
                                            Tampilkan Semua Data
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="index.php?action=laporan_rental_pengembalian&page=<?php echo $page-1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($filter_status); ?>">
                    &laquo;
                </a>
            <?php else: ?>
                <span class="disabled">&laquo;</span>
            <?php endif; ?>

            <?php 
            // Tampilkan maksimal 5 halaman
            $startPage = max(1, $page - 2);
            $endPage = min($totalPages, $startPage + 4);
            $startPage = max(1, $endPage - 4);
            
            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="active"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="index.php?action=laporan_rental_pengembalian&page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($filter_status); ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="index.php?action=laporan_rental_pengembalian&page=<?php echo $page+1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($filter_status); ?>">
                    &raquo;
                </a>
            <?php else: ?>
                <span class="disabled">&raquo;</span>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Stats Footer -->
        <div class="stats-footer">
            <strong><i class="fa-solid fa-chart-column"></i> Total:</strong>
            <span><?php echo $totalRecords; ?> transaksi</span>
            
            <?php if (!empty($search)): ?>
                <span style="color: #6c757d;">
                    <i class="fa-solid fa-search"></i> "<?php echo htmlspecialchars($search); ?>"
                </span>
            <?php endif; ?>
            
            <?php if (!empty($filter_status)): ?>
                <span style="color: #6c757d;">
                    <i class="fa-solid fa-filter"></i> <?php echo $filter_status == 'selesai' ? 'Selesai' : 'Belum Selesai'; ?>
                </span>
            <?php endif; ?>
            
            <?php if ($totalPages > 1): ?>
                <span style="color: #6c757d;">
                    <i class="fa-solid fa-file-lines"></i> Halaman <?php echo $page; ?>/<?php echo $totalPages; ?>
                </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Auto submit on enter in search input
    document.querySelector('.search-input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('searchForm').submit();
        }
    });
    
    // Auto submit when filter changes
    document.querySelector('.filter-select')?.addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });
</script>

<?php include 'views/layout/footer.php'; ?>