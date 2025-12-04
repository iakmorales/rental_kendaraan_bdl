<?php include 'views/layout/header.php'; ?>

<div class="page-wrapper">
    <?php include 'views/layout/sidebar.php'; ?>
    
    <div class="main-container" style="margin-left:250px; padding:2rem; background:#f4f6f9; min-height:100vh; padding-top:70px;">
        <h2 style="margin-bottom:20px;">Test Performa & Indexing</h2>
        
        <div style="background:white; padding:20px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
            <form method="POST" action="">
                <div style="margin-bottom:15px;">
                    <label><strong>SQL Query untuk Dianalisa:</strong></label>
                    <textarea name="query" rows="3" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:5px; font-family:monospace;"><?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : "SELECT * FROM Rental WHERE status_rental = 'Aktif'"; ?></textarea>
                    <small>Default query ini menggunakan <strong>Partial Index</strong> pada kolom status_rental.</small>
                </div>
                <button type="submit" class="btn btn-primary" style="background:#007bff; color:white; padding:10px 20px; border:none; border-radius:5px; cursor:pointer;">
                    Jalankan Explain Analyze
                </button>
            </form>

            <hr style="margin:20px 0;">

            <?php if (isset($results)): ?>
                <h3>Hasil Analisa Database:</h3>
                <div style="background:#2d2d2d; color:#00ff00; padding:15px; border-radius:5px; font-family:'Courier New', monospace; overflow-x:auto;">
                    <?php foreach ($results as $line): ?>
                        <div><?php echo htmlspecialchars($line); ?></div>
                    <?php endforeach; ?>
                </div>
                
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
include 'views/layout/footer.php'; ?>