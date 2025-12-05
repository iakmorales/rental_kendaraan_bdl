<?php include 'views/layout/header.php'; ?>

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
        background: #f8f9fa;
    }

    .section-header {
        background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
        color: #ffffffff;
        padding: 1.5rem;
        border-radius: 10px 10px 0 0;
        border-bottom: 4px solid #ffc107;
    }

    .section-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-header p {
        margin: 8px 0 0 0;
        color: #e0e0e0;
        font-size: 0.9rem;
    }

    .card-function {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .card-function:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .card-header-custom {
        padding: 1.2rem;
        font-weight: 700;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 3px solid;
    }

    .card-header-yellow {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        color: #1a1a1a;
        border-bottom-color: #1a1a1a;
    }

    .card-header-black {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        color: #ffc107;
        border-bottom-color: #ffc107;
    }

    .card-header-accent {
        background: linear-gradient(135deg, #333 0%, #555 100%);
        color: #fff;
        border-bottom-color: #ffc107;
    }

    .card-body-custom {
        padding: 1.5rem;
    }

    .form-label-custom {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.95rem;
    }

    /* CUSTOM SELECT DROPDOWN - Style Normal (klik baru muncul) */
    .select-custom {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background-color: white;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.5rem;
    }

    .select-custom:focus {
        outline: none;
        border-color: #ffc107;
        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
    }

    .select-custom option {
        padding: 10px;
    }

    .input-custom {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .input-custom:focus {
        outline: none;
        border-color: #ffc107;
        box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
    }

    .btn-yellow {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        color: #1a1a1a;
        font-weight: 700;
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-yellow:hover {
        background: linear-gradient(135deg, #ffb300 0%, #ffa000 100%);
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
    }

    .btn-black {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        color: #ffc107;
        font-weight: 700;
        padding: 0.8rem 1.5rem;
        border: 2px solid #ffc107;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-black:hover {
        background: linear-gradient(135deg, #2d2d2d 0%, #404040 100%);
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }

    .btn-accent {
        background: linear-gradient(135deg, #333 0%, #555 100%);
        color: white;
        font-weight: 700;
        padding: 0.8rem 1.5rem;
        border: 2px solid #ffc107;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-accent:hover {
        background: linear-gradient(135deg, #555 0%, #666 100%);
        transform: scale(1.02);
    }

    .result-box {
        background: linear-gradient(135deg, #fff9e6 0%, #fffbf0 100%);
        border-left: 4px solid #ffc107;
        padding: 1.2rem;
        border-radius: 8px;
        margin-top: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .result-box-black {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        border-left: 4px solid #ffc107;
        padding: 1.2rem;
        border-radius: 8px;
        margin-top: 1rem;
        color: white;
    }

    .result-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1a1a1a;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .result-value {
        font-size: 2rem;
        font-weight: 800;
        color: #ffc107;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .table-custom thead {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        color: #fff;
    }

    .table-custom thead th {
        padding: 1rem;
        text-align: left;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-custom tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s ease;
    }

    .table-custom tbody tr:hover {
        background: #fff9e6;
    }

    .table-custom tbody td {
        padding: 1rem;
        color: #333;
        font-size: 0.95rem;
    }

    .alert-custom {
        padding: 1rem 1.2rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .info-text {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .code-badge {
        background: #1a1a1a;
        color: #ffc107;
        padding: 0.2rem 0.6rem;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .mb-3 { margin-bottom: 1rem; }
    .mt-3 { margin-top: 1rem; }
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
        <div class="section-header">
            <h2>
                <i class="fa-solid fa-gear"></i>
                Laporan Rental dengan Booking Express
            </h2>
        </div>

        <!-- Alert Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert-custom alert-success">
                <i class="fa-solid fa-circle-check" style="font-size: 1.5rem;"></i>
                <span><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert-custom alert-danger">
                <i class="fa-solid fa-circle-exclamation" style="font-size: 1.5rem;"></i>
                <span><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
            
            <!-- 1. SCALAR FUNCTION: Total Pendapatan Kendaraan -->
            <div class="card-function">
                <div class="card-header-custom card-header-yellow">
                    <i class="fa-solid fa-sack-dollar" style="font-size: 1.3rem;"></i>
                    <span>Total Pendapatan</span>
                </div>
                <div class="card-body-custom">

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label-custom">
                                <i class="fa-solid fa-car"></i> Pilih Kendaraan
                            </label>
                            <select name="kendaraan_id" class="select-custom" required>
                                <option value="">-- Pilih Kendaraan --</option>
                                <?php foreach($listKendaraan as $k): ?>
                                    <option value="<?= $k['kendaraan_id'] ?>" 
                                            <?= (isset($_POST['kendaraan_id']) && $_POST['kendaraan_id'] == $k['kendaraan_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($k['merk']) ?> <?= htmlspecialchars($k['model']) ?> - <?= htmlspecialchars($k['plat_nomor']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" name="cek_pendapatan" class="btn-yellow">
                            <i class="fa-solid fa-calculator"></i>
                            Hitung Total Pendapatan
                        </button>
                    </form>

                    <?php if ($hasil_pendapatan !== null): ?>
                        <div class="result-box">
                            <div class="result-title">
                                <i class="fa-solid fa-chart-line"></i>
                                Total Pendapatan Kendaraan
                            </div>
                            <div class="result-value">
                                Rp <?= number_format($hasil_pendapatan['total'] ?? 0, 0, ',', '.') ?>
                            </div>
                            <p style="margin-top: 0.5rem; color: #666; font-size: 0.85rem;">
                                <i class="fa-solid fa-info-circle"></i> Akumulasi dari semua transaksi rental
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 2. TABLE FUNCTION: Riwayat Rental Kendaraan -->
            <div class="card-function">
                <div class="card-header-custom card-header-black">
                    <i class="fa-solid fa-clock-rotate-left" style="font-size: 1.3rem;"></i>
                    <span>Riwayat Rental</span>
                </div>
                <div class="card-body-custom">

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label-custom">
                                <i class="fa-solid fa-car"></i> Pilih Kendaraan
                            </label>
                            <select name="kendaraan_id2" class="select-custom" required>
                                <option value="">-- Pilih Kendaraan --</option>
                                <?php if (!empty($listKendaraan2)): ?>
                                    <?php foreach($listKendaraan2 as $k): ?>
                                        <?php 
                                        // LOGIKA AGAR DROPDOWN TIDAK RESET
                                        $selected = (isset($_POST['kendaraan_id2']) && $_POST['kendaraan_id2'] == $k['kendaraan_id']) ? 'selected' : ''; 
                                        ?>
                                        <option value="<?= htmlspecialchars($k['kendaraan_id']) ?>" <?= $selected ?>>
                                            [<?= htmlspecialchars($k['kendaraan_id']) ?>] 
                                            <?= htmlspecialchars($k['merk']) ?> <?= htmlspecialchars($k['model']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option disabled>Tidak ada data kendaraan</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <button type="submit" name="cek_riwayat" class="btn-black">
                            <i class="fa-solid fa-search"></i> Tampilkan Riwayat
                        </button>
                    </form>

                    <?php if ($hasil_riwayat !== null): ?>
                        <?php 
                        $riwayat_data = $hasil_riwayat->fetchAll(PDO::FETCH_ASSOC);
                        $count = count($riwayat_data);
                        ?>
                        <div class="result-box-black" style="margin-top: 20px;">
                            <div class="result-title" style="color: white; margin-bottom: 10px;">
                                <i class="fa-solid fa-list"></i>
                                Ditemukan <?= $count ?> Transaksi Rental
                            </div>
                            
                            <?php if($count > 0): ?>
                                <div style="max-height: 300px; overflow-y: auto;">
                                    <table class="table-custom" style="width: 100%; border-collapse: collapse; color: white;">
                                        <thead>
                                            <tr style="border-bottom: 1px solid #555;">
                                                <th style="padding: 8px;">ID Rental</th>
                                                <th style="padding: 8px;">Pelanggan</th>
                                                <th style="padding: 8px;">Tgl Rental</th>
                                                <th style="padding: 8px;">Durasi</th>
                                                <th style="padding: 8px;">Total Bayar</th>
                                                <th style="padding: 8px;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($riwayat_data as $r): ?>
                                            <tr style="border-bottom: 1px solid #333;">
                                                
                                                <td style="padding: 8px;"><strong>#<?= htmlspecialchars($r['rental_id']) ?></strong></td>
                                                <td style="padding: 8px;"><?= htmlspecialchars($r['nama_peminjam']) ?></td>
                                                <td style="padding: 8px;"><?= date('d/m/Y', strtotime($r['tgl_sewa'])) ?></td>
                                                <td style="padding: 8px;"><?= htmlspecialchars($r['durasi_hari']) ?> Hari</td>
                                                <td style="padding: 8px;"><strong style="color: #ffc107;">Rp <?= number_format($r['biaya'], 0, ',', '.') ?></strong></td>
                                                <td style="padding: 8px;">
                                                    <span class="badge" style="background: #e5f600ff; padding: 3px 8px; border-radius: 4px;">
                                                        <?= htmlspecialchars($r['status_sewa']) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p style="color: #ccc; margin-top: 1rem;">
                                    <i class="fa-solid fa-inbox"></i> Belum ada riwayat rental untuk kendaraan ini
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


            <!-- 3. STORED PROCEDURE: Booking Express -->
            <div class="card-function" style="grid-column: 1 / -1;">
                <div class="card-header-custom card-header-accent">
                    <i class="fa-solid fa-bolt" style="font-size: 1.3rem;"></i>
                    <span>Booking Express (Quick Rent)</span>
                </div>
                <div class="card-body-custom"> 
                    <form method="POST" onsubmit="return confirm('⚡ Yakin melakukan Booking Express? Transaksi akan langsung diproses!');">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                            <div>
                                <label class="form-label-custom">
                                    <i class="fa-solid fa-user"></i> Pilih Pelanggan
                                </label>
                                <select name="pelanggan_id" class="select-custom" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    <?php foreach($listPelanggan as $p): ?>
                                        <option value="<?= $p['pelanggan_id'] ?>">
                                            <?= htmlspecialchars($p['nama_pelanggan']) ?> - <?= htmlspecialchars($p['no_ktp']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label class="form-label-custom">
                                    <i class="fa-solid fa-car"></i> Pilih Kendaraan
                                </label>
                                <select name="kendaraan_id" class="select-custom" required>
                                    <option value="">-- Pilih Kendaraan --</option>
                                    <?php if (!empty($listKendaraan2)): ?>
                                        <?php foreach($listKendaraan2 as $k): ?>
                                            <option value="<?= htmlspecialchars($k['kendaraan_id']) ?>">
                                                [<?= htmlspecialchars($k['kendaraan_id']) ?>] 
                                                <?= htmlspecialchars($k['merk']) ?> ...
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option disabled>Tidak ada data kendaraan</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div>
                                <label class="form-label-custom">
                                    <i class="fa-solid fa-calendar-days"></i> Lama Sewa (Hari)
                                </label>
                                <input type="number" name="lama_hari" class="input-custom" 
                                       placeholder="Contoh: 3" min="1" max="30" required>
                                <small style="color: #666; font-size: 0.8rem;">
                                    <i class="fa-solid fa-info-circle"></i> Maksimal 30 hari
                                </small>
                            </div>
                        </div>

                        <div style="margin-top: 1.5rem;">
                            <button type="submit" name="booking_express" class="btn-accent">
                                <i class="fa-solid fa-rocket"></i>
                                Booking Express Go Drive
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>