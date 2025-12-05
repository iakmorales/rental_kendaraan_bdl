<?php include 'views/layout/header.php'; ?>

<style>
    /* --- CSS BAWAAN WEBSITE ANDA --- */
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

    .content-header h2 {
        margin: 0;
        font-weight: 700;
        color: #202020;
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

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0069d9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,123,255,0.3);
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .alert-info {
        background: #d1ecf1;
        color: #0c5460;
        border-left: 4px solid #17a2b8;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 1.5rem;
        padding: 20px;
    }

    .form-control {
        width: 100%;
        padding: 0.6rem 0.8rem;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-size: 1rem;
        transition: border 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #495057;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -0.75rem;
    }

    .col-md-4, .col-md-5, .col-md-3, .col-md-6 {
        padding: 0 0.75rem;
        box-sizing: border-box;
    }

    .col-md-4 { flex: 0 0 33.333%; max-width: 33.333%; }
    .col-md-5 { flex: 0 0 41.667%; max-width: 41.667%; }
    .col-md-3 { flex: 0 0 25%; max-width: 25%; }
    .col-md-6 { flex: 0 0 50%; max-width: 50%; }

    .g-3 { gap: 1rem; }
    .text-muted { color: #6c757d; }
    .text-dark { color: #202020; }
    .fw-bold { font-weight: 700; }
    .mb-4 { margin-bottom: 1.5rem; }
    .align-items-end { align-items: flex-end; }

    /* --- STYLE KHUSUS HASIL INDEXING --- */
    .card-result {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        height: 100%;
        overflow: hidden;
        border: 1px solid #eee;
    }
    
    .card-result-header {
        padding: 15px 20px;
        font-weight: bold;
        color: white;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.1rem;
    }
    
    .header-danger { background: #dc3545; }
    .header-success { background: #28a745; }

    .card-body-result { padding: 1.5rem; text-align: center; }

    .query-box {
        background: #2d2d2d;
        color: #00ff00;
        padding: 15px;
        border-radius: 6px;
        font-family: 'Consolas', monospace;
        font-size: 0.85rem;
        max-height: 200px;
        overflow-y: auto;
        text-align: left;
        margin-top: 1rem;
        border: 1px solid #444;
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
    
    .display-time { font-size: 3.5rem; font-weight: 800; margin: 15px 0; letter-spacing: -1px; }
    .text-danger { color: #dc3545; }
    .text-success { color: #28a745; }
    .small { font-size: 0.9rem; }
    code { background: #e9ecef; padding: 4px 8px; border-radius: 4px; font-family: monospace; color: #d63384; font-weight: bold; }
</style>

<div class="page-wrapper">
    <?php include 'views/layout/sidebar.php'; ?>
    
    <div class="main-container">
        <!-- HEADER -->
        <div class="content-header">
            <h2><i class="fa-solid fa-gauge-high"></i> Demonstrasi Indexing</h2>
        </div>

        <p class="text-muted" style="margin-top: -1.5rem; margin-bottom: 2rem;">
            Halaman ini mendemonstrasikan perbandingan performa query database <b>Sebelum</b> dan <b>Sesudah</b> penerapan Indexing.
        </p>

        <!-- CARD FORM INPUT -->
        <div class="card">
            <h5 class="fw-bold mb-4" style="border-bottom: 1px solid #eee; padding-bottom: 10px;">
                <i class="fa-solid fa-sliders"></i> Konfigurasi Test
            </h5>
            
            <form method="GET" action="index.php">
                <input type="hidden" name="action" value="tools_indexing">
                <input type="hidden" name="run_test" value="1">
                
                <div class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label">Pilih Skenario Indexing</label>
                        <select name="scenario" id="scenarioSelect" class="form-control" onchange="toggleInput()" required>
                            <option value="kendaraan" <?= (isset($_GET['scenario']) && $_GET['scenario']=='kendaraan')?'selected':'' ?>>
                                1. Indexing Kendaraan ID (B-Tree)
                            </option>
                            <option value="sim" <?= (isset($_GET['scenario']) && $_GET['scenario']=='sim')?'selected':'' ?>>
                                2. Indexing Status SIM (B-Tree)
                            </option>
                            <option value="partial" <?= (isset($_GET['scenario']) && $_GET['scenario']=='partial')?'selected':'' ?>>
                                3. Partial Index (Status = 'Aktif')
                            </option>
                        </select>
                    </div>

                    <div class="col-md-5" id="paramContainer">
                        <label class="form-label">Parameter Pencarian</label>
                        
                        <!-- Input untuk Kendaraan -->
                        <div id="inputKendaraan" style="display:block;">
                            <input list="listKendaraan" name="param" class="form-control" placeholder="Ketik ID Kendaraan..." value="<?= isset($_GET['param']) ? htmlspecialchars($_GET['param']) : 'K005' ?>">
                            <datalist id="listKendaraan">
                                <?php foreach($listKendaraanID as $id): ?>
                                    <option value="<?= htmlspecialchars($id) ?>">
                                <?php endforeach; ?>
                            </datalist>
                        </div>

                        <!-- Input untuk SIM -->
                        <div id="inputSIM" style="display:none;">
                            <select name="param_sim" class="form-control" onchange="document.getElementsByName('param')[0].value = this.value">
                                <option value="true">True (Punya SIM)</option>
                                <option value="false">False (Tidak Punya)</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fa-solid fa-play me-2"></i> Jalankan Benchmark
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- HASIL TEST -->
        <?php if ($testResult): ?>
            <?php if (isset($testResult['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> Error: <?= $testResult['error'] ?>
                </div>
            <?php else: ?>
                
                <div class="alert alert-info text-center">
                    <strong>Query yang dijalankan:</strong><br>
                    <code style="display: inline-block; margin-top: 5px;"><?= htmlspecialchars($testResult['query_used']) ?></code>
                </div>

                <div class="row">
                    <!-- KOTAK KIRI: TANPA INDEX -->
                    <div class="col-md-6">
                        <div class="card-result">
                            <div class="card-result-header header-danger">
                                <i class="fa-solid fa-circle-xmark"></i> SEBELUM (Tanpa Index)
                            </div>
                            <div class="card-body-result">
                                <p class="text-muted mb-0">Waktu Eksekusi</p>
                                <div class="display-time text-danger">
                                    <?= $testResult['time_without'] ?>
                                </div>
                                <p class="small text-muted mb-3">
                                    Metode: <b>Sequential Scan</b><br>(Membaca seluruh baris data satu per satu)
                                </p>
                                
                                <div class="query-box">
                                    <strong>EXPLAIN ANALYZE:</strong><br>
                                    <?php 
                                    if($testResult['without_index']) {
                                        foreach($testResult['without_index'] as $row) {
                                            echo htmlspecialchars($row['QUERY PLAN'] ?? $row['query plan']) . "<br>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KOTAK KANAN: DENGAN INDEX -->
                    <div class="col-md-6">
                        <div class="card-result">
                            <div class="card-result-header header-success">
                                <i class="fa-solid fa-check-circle"></i> SESUDAH (Dengan Index)
                            </div>
                            <div class="card-body-result">
                                <p class="text-muted mb-0">Waktu Eksekusi</p>
                                <div class="display-time text-success">
                                    <?= $testResult['time_with'] ?>
                                </div>
                                <p class="small text-muted mb-3">
                                    Metode: <b>Index Scan / Bitmap Heap Scan</b><br>(Langsung loncat ke data tujuan)
                                </p>
                                
                                <div class="query-box">
                                    <strong>EXPLAIN ANALYZE:</strong><br>
                                    <?php 
                                    if($testResult['with_index']) {
                                        foreach($testResult['with_index'] as $row) {
                                            echo htmlspecialchars($row['QUERY PLAN'] ?? $row['query plan']) . "<br>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    // Script untuk ubah input berdasarkan skenario
    function toggleInput() {
        const scenario = document.getElementById('scenarioSelect').value;
        const inputKendaraan = document.getElementById('inputKendaraan');
        const inputSIM = document.getElementById('inputSIM');
        const paramContainer = document.getElementById('paramContainer');
        const mainInput = document.getElementsByName('param')[0];

        if (scenario === 'kendaraan') {
            paramContainer.style.visibility = 'visible';
            inputKendaraan.style.display = 'block';
            inputSIM.style.display = 'none';
            mainInput.value = 'K005'; 
        } else if (scenario === 'sim') {
            paramContainer.style.visibility = 'visible';
            inputKendaraan.style.display = 'none';
            inputSIM.style.display = 'block';
            mainInput.value = 'true';
        } else if (scenario === 'partial') {
            paramContainer.style.visibility = 'hidden'; 
        }
    }
    
    // Jalankan saat load
    document.addEventListener("DOMContentLoaded", toggleInput);
</script>

<?php include 'views/layout/footer.php'; ?>