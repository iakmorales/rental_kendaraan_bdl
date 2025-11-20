<?php
/**
* FILE: views/dashboard.php
* FUNGSI: Menampilkan dashboard dengan data statistik
*/
include 'views/header.php';
?>

<style>
    .hero {
        width: 100%;
        height: 100vh;
        background: url('image/hero_mobil.jpg');
        background-size: cover;
        background-position: center;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.55);
        z-index: 1;
    }

    .hero-container {
        width: 90%;
        max-width: 1100px;  
        margin: 0 auto;
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
    }

    .hero-container h1 {
        font-size: 50px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .hero-container p {
        font-size: 18px;
        margin-bottom: 25px;
        opacity: 0.9;
    }

    /* Tombol */
    .btn {
        display: inline-block;
        padding: 12px 25px;
        margin: 8px;
        border-radius: 8px;
        font-size: 15px;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-yellow {
        background: #f1cd26;
        color: black;
    }

    .btn-green {
        background: #0b8f5a;
        color: white;
    }
</style>

<div class="hero">
    <div class="hero-container">
        <h1>Explore the Road Ahead<br>with Max Drive Rentals</h1>

        <p>
            Whether it's a weekend trip or a business journey, our reliable and stylish fleet is 
            ready to take you where you need to go — on time, every time.
        </p>

        <a class="btn btn-yellow" href="#">Reserve Your Car</a>
    </div>
</div>
<?php include 'views/footer.php'; ?>