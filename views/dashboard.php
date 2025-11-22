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
        margin-top: 70px; 
        margin-left: 250px; 
        padding: 2rem;
        display: flex;
        justify-content: center; 
        margin-bottom: 150px;
    }

    .content-area {
        width: 100%;
        max-width: 900px; 
        padding: 1rem 0;
    }

    .content-header h1 {
        font-size: 1.8rem;
        color: #202020;
        margin-bottom: 0.25rem;
    }

    .content-header p {
        color: #666;
        margin-bottom: 1.5rem;
    }

    .content-body {
        background: #fff;
        padding: 1.8rem;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        min-height: 250px; 
        width: 100%;
    }

</style>

<div class="main-container">

    <?php include 'views/layout/sidebar.php'; ?>

    <main class="content-area">
        <div class="content-header">
            <h1>Dashboard Admin</h1>
        </div>

        <div class="content-body">
            <p style="color: #666;">Selamat datang di halaman dashboard admin.</p>
        </div>
    </main>

</div>

<?php include 'views/layout/footer.php'; ?>