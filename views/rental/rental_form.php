
<?php
/**
 * FILE: views/rental/rental_form.php
 * FUNGSI: Form untuk proses rental kendaraan
 */
include 'views/layout/header.php';


$isEdit = isset($rental); // Jika variabel $rental ada (dikirim dari index), berarti mode EDIT
$formData = $isEdit ? $rental : (isset($_SESSION['old_data']) ? $_SESSION['old_data'] : []);

// Judul & Action URL
$pageTitle = $isEdit ? 'Edit Data Rental' : 'Buat Transaksi Rental Baru';
$formAction = $isEdit ? 'index.php?action=rental_update&id=' . $rental['rental_id'] : 'index.php?action=rental_create';
$submitLabel = $isEdit ? 'Simpan Perubahan' : 'Buat Pesanan';

// --- AMBIL DATA DROPDOWN ---

// 1. Pelanggan
$stmtP = $db->query("SELECT * FROM Pelanggan ORDER BY nama_pelanggan ASC");
$listPelanggan = $stmtP->fetchAll(PDO::FETCH_ASSOC);

// 2. Kendaraan
// LOGIKA KHUSUS EDIT: Tampilkan mobil yang 'Tersedia' ATAU mobil yang sedang dipakai di rental ini
if ($isEdit) {
    $sqlK = "SELECT * FROM Kendaraan WHERE status_ketersediaan = 'Tersedia' OR kendaraan_id = :current_k_id ORDER BY merk ASC";
    $stmtK = $db->prepare($sqlK);
    $stmtK->execute([':current_k_id' => $rental['kendaraan_id']]);
} else {
    // Mode Create: Hanya yang tersedia
    $sqlK = "SELECT * FROM Kendaraan WHERE status_ketersediaan = 'Tersedia' ORDER BY merk ASC";
    $stmtK = $db->query($sqlK);
}
$listKendaraan = $stmtK->fetchAll(PDO::FETCH_ASSOC);

// 3. Sopir
// LOGIKA KHUSUS EDIT: Tampilkan sopir 'Tersedia' ATAU sopir yang sedang dipakai di rental ini
if ($isEdit && !empty($rental['sopir_id'])) {
    $sqlS = "SELECT * FROM Sopir WHERE status = 'Tersedia' OR sopir_id = :current_s_id ORDER BY nama_sopir ASC";
    $stmtS = $db->prepare($sqlS);
    $stmtS->execute([':current_s_id' => $rental['sopir_id']]);
} else {
    $stmtS = $db->query("SELECT * FROM Sopir WHERE status = 'Tersedia' ORDER BY nama_sopir ASC");
}
$listSopir = $stmtS->fetchAll(PDO::FETCH_ASSOC);

// Bersihkan session old_data
if (isset($_SESSION['old_data'])) unset($_SESSION['old_data']);
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
        
        .form-section h3 {
            font-size: 1.1rem;
        }
        
        .row {
            flex-direction: column;
            gap: 10px;
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
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" action="<?php echo $formAction; ?>" id="rentalForm">
                
                <!-- Status Rental (Hidden atau bisa ditampilkan jika ingin diedit manual) -->
                <input type="hidden" name="status_rental" value="<?php echo isset($formData['status_rental']) ? $formData['status_rental'] : 'Aktif'; ?>">

                <div class="form-section">
                    <h3>Data Sewa</h3>
                    
                    <!-- Pelanggan -->
                    <div class="form-group">
                        <label for="pelanggan_id">Pilih Pelanggan <span class="required">*</span></label>
                        <select id="pelanggan_id" name="pelanggan_id" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php foreach ($listPelanggan as $p): ?>
                                <?php 
                                    $selected = (isset($formData['pelanggan_id']) && $formData['pelanggan_id'] == $p['pelanggan_id']) ? 'selected' : ''; 
                                ?>
                                <option value="<?php echo $p['pelanggan_id']; ?>" <?php echo $selected; ?>>
                                    <?php echo $p['nama_pelanggan']; ?> (NIK: <?php echo $p['no_ktp']; ?>) - <?php echo ($p['punya_sim'] == 't' || $p['punya_sim'] == 1) ? 'Punya SIM' : 'No SIM'; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Kendaraan -->
                    <div class="form-group">
                        <label for="kendaraan_id">Pilih Kendaraan <span class="required">*</span></label>
                        <select id="kendaraan_id" name="kendaraan_id" required onchange="hitungTotal()">
                            <option value="" data-harga="0">-- Pilih Kendaraan --</option>
                            <?php foreach ($listKendaraan as $k): ?>
                                <?php 
                                    $selected = (isset($formData['kendaraan_id']) && $formData['kendaraan_id'] == $k['kendaraan_id']) ? 'selected' : ''; 
                                ?>
                                <option value="<?php echo $k['kendaraan_id']; ?>" 
                                        data-harga="<?php echo $k['harga_sewa_per_hari']; ?>" 
                                        <?php echo $selected; ?>>
                                    <?php echo $k['merk'] . " " . $k['model'] . " (" . $k['plat_nomor'] . ")"; ?> 
                                    - Rp <?php echo number_format($k['harga_sewa_per_hari'], 0, ',', '.'); ?>/hari
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Sopir -->
                    <div class="form-group">
                        <label for="sopir_id">Pilih Sopir (Opsional)</label>
                        <select id="sopir_id" name="sopir_id" onchange="hitungTotal()">
                            <option value="" data-tarif="0">-- Lepas Kunci (Tanpa Sopir) --</option>
                            <?php foreach ($listSopir as $s): ?>
                                <?php 
                                    $selected = (isset($formData['sopir_id']) && $formData['sopir_id'] == $s['sopir_id']) ? 'selected' : ''; 
                                ?>
                                <option value="<?php echo $s['sopir_id']; ?>" 
                                        data-tarif="<?php echo $s['tarif_sopir_per_hari']; ?>" 
                                        <?php echo $selected; ?>>
                                    <?php echo $s['nama_sopir']; ?> 
                                    - Rp <?php echo number_format($s['tarif_sopir_per_hari'], 0, ',', '.'); ?>/hari
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small style="color: #666;">* Jika memilih "Lepas Kunci", pelanggan wajib memiliki SIM.</small>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Durasi & Biaya</h3>
                    
                    <div class="row" style="display: flex; gap: 20px;">
                        <div class="form-group" style="flex: 1;">
                            <label>Tanggal Mulai</label>
                            <?php
                                // Format tanggal untuk input datetime-local (Y-m-d\TH:i)
                                $valMulai = isset($formData['tanggal_mulai']) ? date('Y-m-d\TH:i', strtotime($formData['tanggal_mulai'])) : date('Y-m-d\TH:i');
                            ?>
                            <input type="datetime-local" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo $valMulai; ?>" required onchange="hitungTotal()">
                        </div>

                        <div class="form-group" style="flex: 1;">
                            <label>Rencana Selesai</label>
                            <?php
                                $valSelesai = isset($formData['tanggal_selesai_rencana']) ? date('Y-m-d\TH:i', strtotime($formData['tanggal_selesai_rencana'])) : '';
                            ?>
                            <input type="datetime-local" id="tanggal_selesai_rencana" name="tanggal_selesai_rencana" value="<?php echo $valSelesai; ?>" required onchange="hitungTotal()">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Estimasi Total Biaya (Rp)</label>
                        <input type="text" id="total_biaya_display" readonly style="font-weight: bold; color: #28a745; font-size: 1.2rem; background: #eee;">
                        <input type="hidden" id="total_biaya_rencana" name="total_biaya_rencana" value="<?php echo isset($formData['total_biaya_rencana']) ? $formData['total_biaya_rencana'] : ''; ?>">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> <?php echo $submitLabel; ?>
                    </button>
                    <a href="index.php?action=rental" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fungsi Hitung Total
function hitungTotal() {
    const mobilSelect = document.getElementById('kendaraan_id');
    const hargaMobil = parseFloat(mobilSelect.options[mobilSelect.selectedIndex].getAttribute('data-harga')) || 0;

    const sopirSelect = document.getElementById('sopir_id');
    const tarifSopir = parseFloat(sopirSelect.options[sopirSelect.selectedIndex].getAttribute('data-tarif')) || 0;

    const tglMulai = new Date(document.getElementById('tanggal_mulai').value);
    const tglSelesai = new Date(document.getElementById('tanggal_selesai_rencana').value);

    let totalBiaya = 0;

    if (tglMulai && tglSelesai && tglSelesai > tglMulai) {
        const diffTime = Math.abs(tglSelesai - tglMulai);
        const durasiHari = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
        totalBiaya = (hargaMobil + tarifSopir) * durasiHari;
    }

    document.getElementById('total_biaya_rencana').value = totalBiaya;
    document.getElementById('total_biaya_display').value = new Intl.NumberFormat('id-ID', { 
        style: 'currency', currency: 'IDR', minimumFractionDigits: 0
    }).format(totalBiaya);
}

// Jalankan saat load agar data edit langsung terhitung
document.addEventListener('DOMContentLoaded', function() {
    hitungTotal();
});
</script>

<?php include 'views/layout/footer.php'; ?>