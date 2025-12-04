<?php
/**
 * FILE: views/pelanggan/pelanggan_form.php
 * FUNGSI: Form untuk tambah/edit pelanggan
 */
include 'views/layout/header.php';

$isEdit = isset($pelanggan);
$formData = $isEdit ? $pelanggan : (isset($_SESSION['old_data']) ? $_SESSION['old_data'] : []);

$title = $isEdit ? 'Edit Data Pelanggan' : 'Tambah Pelanggan Baru';
$actionUrl = $isEdit ? 'index.php?action=pelanggan_update&id=' . $pelanggan['pelanggan_id'] : 'index.php?action=pelanggan_create';

// Bersihkan old_data
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
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
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
        <h2 style="margin-bottom: 1.5rem;"><?php echo $title; ?></h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" action="<?php echo $actionUrl; ?>">
                
                <div class="form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="nama_pelanggan" required 
                           value="<?php echo isset($formData['nama_pelanggan']) ? htmlspecialchars($formData['nama_pelanggan']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Nomor KTP (NIK) <span class="required">*</span></label>
                    <input type="text" name="no_ktp" required maxlength="20"
                           value="<?php echo isset($formData['no_ktp']) ? htmlspecialchars($formData['no_ktp']) : ''; ?>">
                </div>

                <div class="row" style="display:flex; gap:20px;">
                    <div class="form-group" style="flex:1;">
                        <label>No Telepon <span class="required">*</span></label>
                        <input type="text" name="no_telepon" required 
                               value="<?php echo isset($formData['no_telepon']) ? htmlspecialchars($formData['no_telepon']) : ''; ?>">
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label>Email</label>
                        <input type="email" name="email" 
                               value="<?php echo isset($formData['email']) ? htmlspecialchars($formData['email']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" rows="3"><?php echo isset($formData['alamat']) ? htmlspecialchars($formData['alamat']) : ''; ?></textarea>
                </div>

                <div class="form-group" style="background: #f8f9fa; padding: 1rem; border-radius: 6px; border: 1px solid #e9ecef;">
                    <label style="margin-bottom: 0.5rem; display: block;">Status Kepemilikan SIM A <span class="required">*</span></label>
                    
                    <?php 
                        // Logic deteksi value SIM
                        $simValue = isset($formData['punya_sim']) ? $formData['punya_sim'] : 0;
                        // PostgreSQL boolean bisa return 't'/'f' atau 1/0
                        $isPunya = ($simValue == 't' || $simValue == 1);
                    ?>

                    <div style="display:flex; gap: 20px;">
                        <label style="font-weight: normal; cursor: pointer;">
                            <input type="radio" name="punya_sim" value="1" <?php echo $isPunya ? 'checked' : ''; ?>> 
                            <span font-weight: bold;>Punya SIM</span>
                        </label>
                        <label style="font-weight: normal; cursor: pointer;">
                            <input type="radio" name="punya_sim" value="0" <?php echo !$isPunya ? 'checked' : ''; ?>> 
                            Tidak Punya
                        </label>
                    </div>
                    <small style="color: #6c757d; display:block; margin-top:5px;">
                        * Pelanggan tanpa SIM tidak bisa menyewa secara Lepas Kunci.
                    </small>
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Simpan Data
                    </button>
                    <a href="index.php?action=pelanggan" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>

