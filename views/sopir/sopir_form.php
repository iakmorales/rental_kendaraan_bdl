<?php
/**
 * FILE: views/sopir/sopir_form.php
 * FUNGSI: Form untuk tambah/edit sopir
 */
include 'views/layout/header.php';

$isEdit = isset($sopir) && $sopir;
$pageTitle = $isEdit ? 'Edit Sopir' : 'Tambah Sopir Baru';

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
                    <label for="sopir_id">ID Sopir <span class="required">*</span></label>
                    <input type="text" 
                           id="sopir_id" 
                           name="sopir_id" 
                           placeholder="Contoh: SP01" 
                           required>
                </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="nama_sopir">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" 
                           id="nama_sopir" 
                           name="nama_sopir" 
                           value="<?php echo $isEdit ? htmlspecialchars($sopir['nama_sopir']) : ''; ?>"
                           placeholder="Masukkan nama lengkap sopir" 
                           required>
                </div>

                <div class="form-group">
                    <label for="no_telepon">No Telepon <span class="required">*</span></label>
                    <input type="text" 
                           id="no_telepon" 
                           name="no_telepon" 
                           value="<?php echo $isEdit ? htmlspecialchars($sopir['no_telepon']) : ''; ?>"
                           placeholder="Contoh: 081234567890" 
                           required>
                </div>

                <div class="form-group">
                    <label for="tarif_sopir_per_hari">Tarif Per Hari (Rp) <span class="required">*</span></label>
                    <input type="number" 
                           id="tarif_sopir_per_hari" 
                           name="tarif_sopir_per_hari" 
                           value="<?php echo $isEdit ? $sopir['tarif_sopir_per_hari'] : ''; ?>"
                           placeholder="Contoh: 150000" 
                           required>
                </div>

                <div class="form-group">
                    <label for="status">Status <span class="required">*</span></label>
                    <select id="status" name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="tersedia" <?php echo ($isEdit && $sopir['status'] == 'tersedia') ? 'selected' : ''; ?>>
                            Tersedia
                        </option>
                        <option value="tidak tersedia" <?php echo ($isEdit && $sopir['status'] == 'tidak tersedia') ? 'selected' : ''; ?>>
                            Tidak Tersedia
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="catatan">Catatan</label>
                    <textarea id="catatan" 
                              name="catatan" 
                              placeholder="Catatan tambahan (opsional)"><?php echo $isEdit ? htmlspecialchars($sopir['catatan'] ?? '') : ''; ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <?php if ($isEdit): ?>
                            <i class="fa-solid fa-floppy-disk"></i> Update Data 
                        <?php else: ?>
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                        <?php endif; ?>
                    </button>
                    <a href="index.php?action=sopir" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>

