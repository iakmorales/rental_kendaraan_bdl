        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
        <style>
            .sidebar {
                width: 250px;
                background-color: white;
                padding: 2rem 0;
                box-shadow: 2px 0 10px rgba(0,0,0,0.05);
                position: fixed;
                top: 70px;
                left: 0;
                bottom: 0;
                overflow-y: auto;
                z-index: 100;
            }

            .sidebar-menu {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .menu-item {
                padding: 0;
            }

            .menu-item a {
                padding: 0.875rem 2rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                color: #666;
                font-weight: 500;
                text-decoration: none;
                transition: 0.3s ease;
                border-left: 3px solid transparent;
            }

            .menu-item a:hover {
                background-color: #FFF8E1;
                border-left-color: #FFD100;
                color: #202020;
            }

            .menu-item a.active {
                background-color: #FFEE32;
                border-left-color: #FFD100;
                color: #202020;
            }

            .menu-icon {
                width: 20px;
                display: flex;
                justify-content: center;
                font-size: 1.2rem;
            }
        </style>

<?php $current = isset($_GET['action']) ? $_GET['action'] : 'dashboard'; ?>

<aside class="sidebar">
    <ul class="sidebar-menu">
        <li class="menu-item">
            <a href="index.php?action=dashboard" class="<?= $current=='dashboard'?'active':'' ?>">
                <span class="menu-icon"> <i class="fa-solid fa-gauge"> </i></span>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=tipe_kendaraan" class="<?= $current=='tipe_kendaraan'?'active':'' ?>">
                <span class="menu-icon"> <i class="fa-solid fa-motorcycle"></i>
 </span>
                <span>Tipe Kendaraan</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=kendaraan" class="<?= $current=='kendaraan'?'active':'' ?>">
                <span class="menu-icon"> <i class="fa-solid fa-car"></i> </span>
                <span>Kendaraan</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=sopir" class="<?= $current=='sopir'?'active':'' ?>">
                <span class="menu-icon"> <i class="fa-solid fa-id-card"></i>
 </span>
                <span>Sopir</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=penyewa" class="<?= $current=='penyewa'?'active':'' ?>">
                <span class="menu-icon"> <i class="fa-solid fa-users"></i> </span>
                <span>Penyewa</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=rental" class="<?= $current=='rental'?'active':'' ?>">
                <span class="menu-icon"> <i class="fa-solid fa-pen-to-square"></i> </span>
                <span>Rental</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=pengembalian" class="<?= $current=='pengembalian'?'active':'' ?>">
                <span class="menu-icon"> <i class="fa-solid fa-arrow-rotate-left"></i>
 </span>
                <span>Pengembalian</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=users" class="<?= $current=='users'?'active':'' ?>">
                <span class="menu-icon"> <i class="fa-solid fa-user"> </i></span>
                <span>User</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=logout" class="<?= $current=='logout'?'active':'' ?>">
                <span class="menu-icon"> <i class="fa-solid fa-right-from-bracket"></i> </span>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>