<?php
/**
 * FILE: views/kendaraan/kendaraan_form.php
 * FUNGSI: Form untuk tambah/edit kendaraan
 */
include 'views/layout/header.php';

$isEdit = isset($kendaraan) && $kendaraan;
$pageTitle = $isEdit ? 'Edit Kendaraan' : 'Tambah Kendaraan Baru';

// Ambil data lama jika ada error
$oldData = isset($_SESSION['old_data']) ? $_SESSION['old_data'] : [];
if (!empty($oldData)) {
    unset($_SESSION['old_data']);
}

// Ambil data tipe kendaraan untuk dropdown
$tipeKendaraanModel = new TipeKendaraanModel($db);
$tipeKendaraan = $tipeKendaraanModel->getAllTipeKendaraan();
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
    }

    .content-header h2 {
        margin: 0;
        font-weight: 700;
        color: #202020;
    }

    .form-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 2rem;
        max-width: 800px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #202020;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        cursor: pointer;
        border: none;
        font-size: 1rem;
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

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .required {
        color: #dc3545;
    }

    @media (max-width: 768px) {
        .main-container {
            margin-left: 0;
            padding: 1rem;
        }

        .form-container {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
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
        
        .form-container {
            padding: 1.5rem;
            max-width: 100%;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }
    }

    @media (max-width: 480px) {
        .main-container {
            padding: 0.8rem;
        }
        
        .form-container {
            padding: 1rem;
        }
        
        h2 {
            font-size: 1.3rem;
        }
    }
</style>

<div class="page-wrapper">
    <?php include 'views/layout/sidebar.php'; ?>

    <div class="main-container">
        <div class="content-header">
            <h2><?php echo $pageTitle; ?></h2>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" action="">
                <?php if (!$isEdit): ?>
                <div class="form-group">
                    <label for="kendaraan_id">ID Kendaraan <span class="required">*</span></label>
                    <input type="text" 
                           id="kendaraan_id" 
                           name="kendaraan_id" 
                           value="<?php echo !empty($oldData['kendaraan_id']) ? htmlspecialchars($oldData['kendaraan_id']) : ''; ?>"
                           placeholder="Contoh: K001" 
                           required>
                </div>
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tipe_id">Tipe Kendaraan <span class="required">*</span></label>
                        <select id="tipe_id" name="tipe_id" required>
                            <option value="">-- Pilih Tipe --</option>
                            <?php while ($tipe = $tipeKendaraan->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?php echo $tipe['tipe_id']; ?>"
                                    <?php 
                                    if ($isEdit && $kendaraan['tipe_id'] == $tipe['tipe_id']) echo 'selected';
                                    elseif (!empty($oldData['tipe_id']) && $oldData['tipe_id'] == $tipe['tipe_id']) echo 'selected';
                                    ?>>
                                    <?php echo htmlspecialchars($tipe['nama_tipe']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="plat_nomor">Plat Nomor <span class="required">*</span></label>
                        <input type="text" 
                               id="plat_nomor" 
                               name="plat_nomor" 
                               value="<?php 
                                   echo $isEdit ? htmlspecialchars($kendaraan['plat_nomor']) : 
                                   (!empty($oldData['plat_nomor']) ? htmlspecialchars($oldData['plat_nomor']) : '');
                               ?>"
                               placeholder="Contoh: B 1234 ABC" 
                               required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="merk">Merk <span class="required">*</span></label>
                        <input type="text" 
                               id="merk" 
                               name="merk" 
                               value="<?php 
                                   echo $isEdit ? htmlspecialchars($kendaraan['merk']) : 
                                   (!empty($oldData['merk']) ? htmlspecialchars($oldData['merk']) : '');
                               ?>"
                               placeholder="Contoh: Toyota, Honda, etc" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="model">Model <span class="required">*</span></label>
                        <input type="text" 
                               id="model" 
                               name="model" 
                               value="<?php 
                                   echo $isEdit ? htmlspecialchars($kendaraan['model']) : 
                                   (!empty($oldData['model']) ? htmlspecialchars($oldData['model']) : '');
                               ?>"
                               placeholder="Contoh: Avanza, Civic, etc" 
                               required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="number" 
                               id="tahun" 
                               name="tahun" 
                               value="<?php 
                                   echo $isEdit ? $kendaraan['tahun'] : 
                                   (!empty($oldData['tahun']) ? $oldData['tahun'] : '');
                               ?>"
                               placeholder="Contoh: 2023"
                               min="1900" 
                               max="<?php echo date('Y') + 1; ?>">
                    </div>

                    <div class="form-group">
                        <label for="harga_sewa_per_hari">Harga Sewa per Hari (Rp) <span class="required">*</span></label>
                        <input type="number" 
                               id="harga_sewa_per_hari" 
                               name="harga_sewa_per_hari" 
                               value="<?php 
                                   echo $isEdit ? $kendaraan['harga_sewa_per_hari'] : 
                                   (!empty($oldData['harga_sewa_per_hari']) ? $oldData['harga_sewa_per_hari'] : '');
                               ?>"
                               placeholder="Contoh: 300000" 
                               required
                               min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label for="status_ketersediaan">Status Ketersediaan <span class="required">*</span></label>
                    <select id="status_ketersediaan" name="status_ketersediaan" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Tersedia" 
                            <?php 
                            if ($isEdit && $kendaraan['status_ketersediaan'] == 'Tersedia') echo 'selected';
                            elseif (!empty($oldData['status_ketersediaan']) && $oldData['status_ketersediaan'] == 'Tersedia') echo 'selected';
                            ?>>Tersedia</option>
                        <option value="Disewa" 
                            <?php 
                            if ($isEdit && $kendaraan['status_ketersediaan'] == 'Disewa') echo 'selected';
                            elseif (!empty($oldData['status_ketersediaan']) && $oldData['status_ketersediaan'] == 'Disewa') echo 'selected';
                            ?>>Disewa</option>
                        <option value="Maintenance" 
                            <?php 
                            if ($isEdit && $kendaraan['status_ketersediaan'] == 'Maintenance') echo 'selected';
                            elseif (!empty($oldData['status_ketersediaan']) && $oldData['status_ketersediaan'] == 'Maintenance') echo 'selected';
                            ?>>Maintenance</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <?php if ($isEdit): ?>
                            <i class="fa-solid fa-floppy-disk"></i> Update Data 
                        <?php else: ?>
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                        <?php endif; ?>
                    </button>
                    <a href="index.php?action=kendaraan" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>