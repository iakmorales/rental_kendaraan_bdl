<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .menu-bar {
        width: 100%;
        background: #000;
        padding: 30px 0;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .nav-container {
        width: 90%;
        max-width: 1100px;   
        margin: 0 auto;      
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .logo {
        color: #fff;
        font-size: 20px;
        font-weight: bold;
        text-decoration: none;
    }

    .menu-list {
        list-style: none;
        display: flex;
        gap: 18px;
        margin: 0;
        padding: 0;
    }

    .menu-item {
        color: #fff;
        font-size: 15px;
        text-decoration: none;
        transition: .2s;
    }

    .menu-item:hover,
    .active {
        color: #ffd700;
    }
</style>

<nav class="menu-bar">
    <div class="nav-container">
        
        <a href="index.php?action=dashboard" class="logo">Max Drive</a>

        <ul class="menu-list">
            <li><a href="index.php?action=dashboard"
                class="menu-item <?= $active == 'dashboard' ? 'active' : '' ?>">Dashboard</a></li>

            <li><a href="index.php?action=kendaraan"
                class="menu-item <?= $active == 'kendaraan' ? 'active' : '' ?>">Data Kendaraan</a></li>

            <li><a href="index.php?action=rental"
                class="menu-item <?= $active == 'rental' ? 'active' : '' ?>">Rental Kendaraan</a></li>

            <li><a href="index.php?action=pengembalian"
                class="menu-item <?= $active == 'pengembalian' ? 'active' : '' ?>">Pengembalian Kendaraan</a></li>
        </ul>

    </div>
</nav>


