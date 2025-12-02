<?php
/**
 * FILE: views/dashboard.php
 * FUNGSI: Menampilkan halaman Dashboard Admin
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

    .content-header h1 {
        margin: 0;
        font-weight: 700;
        color: #202020;
        font-size: 1.8rem;
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

    .btn-warning {
        background: #ffc107;
        color: #000;
    }

    .btn-warning:hover {
        background: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255,193,7,0.3);
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        border-left: 4px solid;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left-color: #28a745;
    }

    .alert-info {
        background: #d1ecf1;
        color: #0c5460;
        border-left-color: #17a2b8;
    }

    .cards-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 1.5rem;
        transition: transform 0.3s, box-shadow 0.3s;
        border-top: 4px solid;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .stat-card-primary {
        border-top-color: #ffc107;
    }

    .stat-card-success {
        border-top-color: #ffc107;
    }

    .stat-card-info {
        border-top-color: #ffc107;
    }

    .card-icon {
        font-size: 1.8rem;
        margin-bottom: 1rem;
        display: inline-block;
        width: 50px;
        height: 50px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .icon-primary {
        background: rgba(0, 123, 255, 0.1);
        color: #007bff;
    }

    .icon-success {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .icon-info {
        background: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }

    .card-content {
        flex: 1;
    }

    .card-title {
        font-size: 0.9rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 0.5rem 0;
        font-weight: 600;
    }

    .card-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #202020;
        margin: 0 0 0.5rem 0;
        line-height: 1.2;
    }

    .card-value small {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 400;
        display: block;
        margin-top: 0.3rem;
    }

    .card-subtext {
        font-size: 0.85rem;
        color: #6c757d;
        margin: 0;
    }

    .table-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 2rem;
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

    .badge {
        padding: 0.5rem 0.8rem;
        border-radius: 4px;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .badge-primary {
        background: #d4edda;
        color: #155724;
    }

    .badge-info {
        background: #69ebffff; 
        color: #0f6977ff;
    }

    .badge-success {
        background: #fff3cd;
        color: #856404;
    }

    .stats-footer {
        margin-top: 1.5rem;
        padding: 1rem 1.5rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .section-title {
        font-size: 30px;
        font-weight: 600;
        color: #202020;
        margin-bottom: 1.2rem;
    }

    .welcome-card {
        background: linear-gradient(135deg, #202020 0%, #333533 100%);
        color: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(106, 17, 203, 0.2);
    }

    .welcome-card h3 {
        margin: 0 0 0.3rem 0;
        font-size: 1.6rem;
        font-weight: 700;
    }

    .welcome-card p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.95rem;
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

        .cards-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .data-table {
            font-size: 0.85rem;
        }

        .data-table th,
        .data-table td {
            padding: 0.7rem;
        }

        .card-value {
            font-size: 1.5rem;
        }
    }
</style>

<div class="page-wrapper">
    <?php include 'views/layout/sidebar.php'; ?>

    <div class="main-container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="welcome-card">
            <h3> Hello, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>!</h3>
            <p>Selamat datang di sistem rental kendaraan</p>
        </div>

        <div class="cards-row">
            <div class="stat-card stat-card-primary">
                <div class="card-icon icon-primary">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Kendaraan Terpopuler</h4>
                    <div class="card-value">
                        <?php 
                        $kendaraan = $mv1['kendaraan_terpopuler'] ?? 'Belum ada';
                        $model = $mv1['model_terpopuler'] ?? '';
                        if ($kendaraan !== 'Belum ada' && $model) {
                            echo $kendaraan;
                            if ($model) {
                                echo "<small>($model)</small>";
                            }
                        } else {
                            echo $kendaraan;
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="stat-card stat-card-success">
                <div class="card-icon icon-success">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Total Pendapatan</h4>
                    <div class="card-value">
                        Rp <?php echo number_format($mv1['total_pendapatan'] ?? 0, 0, ',', '.'); ?>
                    </div>
                    <p class="card-subtext">Dari semua rental</p>
                </div>
            </div>
            
            <div class="stat-card stat-card-info">
                <div class="card-icon icon-info">
                    <i class="fa-solid fa-chart-bar"></i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Rental Aktif</h4>
                    <div class="card-value">
                        <?php echo $mv1['rental_aktif'] ?? 0; ?>
                    </div>
                    <p class="card-subtext">Sedang berjalan</p>
                </div>
            </div>
        </div>

        <h4 class="section-title"> <i class="fa-solid fa-hourglass-half"></i> Statistik Durasi Sewa Kendaraan </h4>
        <div class="table-container">
            <?php if (!empty($mv2)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kendaraan</th>
                            <th>Jumlah Sewa</th>
                            <th>Total Durasi (Hari)</th>
                            <th>Rata-rata Durasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($mv2 as $row): ?>
                            <?php 
                            $avg_duration = $row['jumlah_sewa'] > 0 
                                ? round($row['total_durasi_hari'] / $row['jumlah_sewa'], 1)
                                : 0;
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><strong><?php echo htmlspecialchars($row['nama_kendaraan']); ?></strong></td>
                                <td>
                                    <span class="badge badge-primary">
                                        <?php echo $row['jumlah_sewa']; ?> kali
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        <?php echo $row['total_durasi_hari']; ?> hari
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        <?php echo $avg_duration; ?> hari/rental
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p><i class="fas fa-info-circle"></i> Belum ada data durasi sewa.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="stats-footer">
            <a href="index.php?action=refresh_dashboard" class="btn btn-warning">
                <i class="fa-solid fa-rotate-right"></i> Refresh Data Dashboard
            </a>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>