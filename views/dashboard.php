<?php
/**
 * FILE: views/dashboard.php
 * FUNGSI: Menampilkan halaman Dashboard Admin
 */
include 'views/layout/header.php';
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    }

    .main-container {
        display: flex;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        flex: 1;
    }

    .content-area {
        flex: 1;
        padding: 2rem;
        background-color: #f9f9f9;
    }

    .content-header h1 {
        font-size: 2rem;
        color: #202020;
        margin-bottom: 0.5rem;
    }

    .content-header p {
        color: #666;
        margin-bottom: 1.5rem;
    }

    .content-body {
        background: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        min-height: 350px;
    }
</style>

<div class="main-container">

    <!-- Sidebar yang sudah disendirikan -->
    <?php include 'views/layout/sidebar.php'; ?>

    <!-- Area konten -->
    <main class="content-area">
        <div class="content-header">
            <h1>Dashboard Admin</h1>
            <p>Selamat datang di halaman dashboard admin.</p>
        </div>

        <div class="content-body">
            <p style="color: #666;">Area konten utama - silakan sesuaikan konten dashboard Anda.</p>
        </div>
    </main>

</div>

<?php include 'views/layout/footer.php'; ?>
