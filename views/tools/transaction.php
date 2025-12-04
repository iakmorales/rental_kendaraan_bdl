<?php include 'views/layout/header.php'; ?>

<div class="page-wrapper">
    <?php include 'views/layout/sidebar.php'; ?>
    
    <div class="main-container" style="margin-left:250px; padding:2rem; background:#f4f6f9; min-height:100vh; padding-top:70px;">
        <h2 style="margin-bottom:20px;">Simulasi Transaction Management</h2>
        
        <div style="display:flex; gap:20px;">
            <!-- Box Kiri: Tombol -->
            <div style="flex:1; background:white; padding:20px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                <h3>Pilih Skenario</h3>
                <p>Klik tombol di bawah untuk menjalankan simulasi ACID Properties.</p>
                
                <form method="POST" style="margin-bottom:10px;">
                    <input type="hidden" name="test_type" value="commit">
                    <button type="submit" style="width:100%; padding:15px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer; font-size:16px;">
                        Test Skenario Sukses (COMMIT)
                    </button>
                </form>

                <form method="POST">
                    <input type="hidden" name="test_type" value="rollback">
                    <button type="submit" style="width:100%; padding:15px; background:#dc3545; color:white; border:none; border-radius:5px; cursor:pointer; font-size:16px;">
                        Test Skenario Gagal (ROLLBACK)
                    </button>
                </form>
            </div>

            <!-- Box Kanan: Log Hasil -->
            <div style="flex:2; background:white; padding:20px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                <h3>Log Eksekusi</h3>
                
                <?php if ($simulation): ?>
                    <div style="background:#f8f9fa; border:1px solid #ddd; padding:15px; border-radius:5px;">
                        <?php foreach ($simulation['log'] as $log): ?>
                            <div style="padding:5px 0; border-bottom:1px dashed #eee;">
                                <?php 
                                    // Highlight kata kunci
                                    $log = str_replace('BEGIN', '<strong style="color:blue">BEGIN</strong>', $log);
                                    $log = str_replace('COMMIT', '<strong style="color:green">COMMIT</strong>', $log);
                                    $log = str_replace('ROLLBACK', '<strong style="color:red">ROLLBACK</strong>', $log);
                                    $log = str_replace('ERROR', '<strong style="color:red">ERROR</strong>', $log);
                                    echo $log;
                                ?>
                            </div>
                        <?php endforeach; ?>
                        
                        <div style="margin-top:15px; font-weight:bold; font-size:1.1em;">
                            Hasil Akhir: 
                            <?php if ($simulation['status'] == 'success'): ?>
                                <span style="color:green">DATA TERSIMPAN (KONSISTEN)</span>
                            <?php else: ?>
                                <span style="color:red">DATA DIBATALKAN / TIDAK ADA YANG MASUK (KONSISTEN)</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <p style="color:#888; font-style:italic;">Belum ada simulasi yang dijalankan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>