
<?php
/**
 * FILE: views/pengembalian/pengembalian_form.php
 * FUNGSI: Form untuk proses pengembalian kendaraan
 */
include 'views/layout/header.php';

// Get active rentals for dropdown
$stmt = $pengembalianModel->getActiveRentals();
$activeRentals = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $activeRentals[] = $row;
}

// Ambil data lama jika ada error
$oldData = isset($_SESSION['old_data']) ? $_SESSION['old_data'] : [];
if (!empty($oldData)) {
    unset($_SESSION['old_data']);
}
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

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
    }

    .form-section h3 {
        color: #495057;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        
    }

    .form-group {
        margin-bottom: 20px;
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
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(40,167,69,0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .calculation-box {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .calculation-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .calculation-row:last-child {
        border-bottom: none;
        font-weight: 600;
        color: #202020;
    }

    .calculation-row.total {
        font-size: 1.1rem;
        color: #dc3545;
        font-weight: 700;
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
        background: #007bff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40,167,69,0.3);
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

    .alert-info {
        background: #d1ecf1;
        color: #0c5460;
        border-left: 4px solid #17a2b8;
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
            margin-bottom: 0.5rem;
        }
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
</style>

<div class="page-wrapper">
    <?php include 'views/layout/sidebar.php'; ?>

    <div class="main-container">
        <div class="content-header">
            <h2>Proses Pengembalian Kendaraan</h2>
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
                
                <!-- Section 1: Pilih Rental -->
                <div class="form-section">            
                    <div class="form-group">
                        <label for="rental_id">Rental Aktif <span class="required">*</span></label>
                        <select id="rental_id" name="rental_id" required>
                            <option value="">-- Pilih Rental --</option>
                            <?php foreach ($activeRentals as $rental): ?>
                                <option value="<?php echo $rental['rental_id']; ?>"
                                    <?php echo (isset($oldData['rental_id']) && $oldData['rental_id'] == $rental['rental_id']) ? 'selected' : ''; ?>>
                                    Rental ID: <?php echo $rental['rental_id']; ?> 
                                    (Selesai: <?php echo date('d-m-Y H:i', strtotime($rental['tanggal_selesai_rencana'])); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_kembali_aktual">Tanggal & Waktu Kembali Aktual <span class="required">*</span></label>
                        <input type="datetime-local" 
                               id="tanggal_kembali_aktual" 
                               name="tanggal_kembali_aktual" 
                               value="<?php echo isset($oldData['tanggal_kembali_aktual']) ? $oldData['tanggal_kembali_aktual'] : date('Y-m-d\TH:i'); ?>"
                               required>
                    </div>
            
                    <div class="form-group">
                        <label for="kondisi_akhir">Kondisi Akhir Kendaraan <span class="required">*</span></label>
                        <textarea id="kondisi_akhir" 
                                  name="kondisi_akhir" 
                                  placeholder="Deskripsi kondisi kendaraan saat dikembalikan..." 
                                  required><?php echo isset($oldData['kondisi_akhir']) ? htmlspecialchars($oldData['kondisi_akhir']) : ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="denda_tambahan">Denda Tambahan (Jika Ada)</label>
                        <input type="number" 
                               id="denda_tambahan" 
                               name="denda_tambahan" 
                               value="<?php echo isset($oldData['denda_tambahan']) ? $oldData['denda_tambahan'] : '0'; ?>"
                               placeholder="0"
                               min="0"
                               step="25000">
                    </div>
                </div>

                <?php if (isset($oldData['calculation'])): ?>
                <div class="alert alert-info">
                    <h4>Hasil Perhitungan</h4>
                    <p><strong>Keterlambatan:</strong> <?php echo $oldData['calculation']['keterlambatan_jam']; ?> jam</p>
                    <p><strong>Denda Keterlambatan:</strong> Rp <?php echo number_format($oldData['calculation']['denda_keterlambatan'], 0, ',', '.'); ?></p>
                    <p><strong>Denda Tambahan:</strong> Rp <?php echo number_format($oldData['calculation']['denda_tambahan'], 0, ',', '.'); ?></p>
                    <p><strong>Total Denda:</strong> <span style="color: #dc3545; font-weight: bold;">Rp <?php echo number_format($oldData['calculation']['total_denda'], 0, ',', '.'); ?></span></p>
                </div>
                <?php endif; ?>

                <div class="form-actions">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Pengembalian
                    </button>
                    <a href="index.php?action=pengembalian" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Kembali 
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>