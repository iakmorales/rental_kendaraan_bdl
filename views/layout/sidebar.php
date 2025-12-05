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
        z-index: 1000;
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
    
    .menu-header {
        padding: 1.5rem 2rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #aaa;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    /* Mobile Menu Header */
    .mobile-menu-header {
        display: none;
        padding: 1rem 1.5rem;
        background: #202020;
        color: white;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #333;
    }
    
    .mobile-menu-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .mobile-close-btn {
        background: none;
        border: none;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0.3rem;
        border-radius: 4px;
        transition: background 0.3s;
    }
    
    .mobile-close-btn:hover {
        background: rgba(255, 255, 255, 0.1);
    }
    
    /* Overlay for mobile */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 70px;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        backdrop-filter: blur(2px);
    }
    
    .sidebar-overlay.active {
        display: block;
    }

    /* Responsiveness */
    @media (max-width: 1024px) {
        .sidebar {
            width: 220px;
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 280px;
            position: fixed;
            top: 70px;
            left: -280px;
            bottom: 0;
            transition: left 0.3s ease;
            box-shadow: 2px 0 15px rgba(0,0,0,0.2);
        }
        
        .sidebar.active {
            left: 0;
        }
        
        .mobile-menu-header {
            display: flex;
        }
        
        .menu-item a {
            padding: 0.875rem 1.5rem;
        }
        
        .menu-header {
            padding: 1.5rem 1.5rem 0.5rem;
        }
    }

    @media (max-width: 480px) {
        .sidebar {
            width: 85%;
            max-width: 300px;
            left: -100%;
        }
        
        .sidebar.active {
            left: 0;
        }
        
        .menu-item a {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
        }
        
        .menu-icon {
            font-size: 1rem;
        }
        
        .mobile-menu-header {
            padding: 1rem;
        }
        
        .mobile-menu-header h3 {
            font-size: 1rem;
        }
    }
</style>

<?php $current = isset($_GET['action']) ? $_GET['action'] : 'dashboard'; ?>

<!-- Overlay for mobile -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="mobile-menu-header">
        <h3>Menu Navigasi</h3>
        <button class="mobile-close-btn" onclick="closeSidebar()">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
    
    <ul class="sidebar-menu">
        <li class="menu-item">
            <a href="index.php?action=dashboard" class="<?= $current=='dashboard'?'active':'' ?>" onclick="closeSidebarOnMobile()">
                <span class="menu-icon"> <i class="fa-solid fa-gauge"> </i></span>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=tipe_kendaraan" class="<?= $current=='tipe_kendaraan'?'active':'' ?>" onclick="closeSidebarOnMobile()">
                <span class="menu-icon"> <i class="fa-solid fa-motorcycle"></i></span>
                <span>Tipe Kendaraan</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=kendaraan" class="<?= $current=='kendaraan'?'active':'' ?>" onclick="closeSidebarOnMobile()">
                <span class="menu-icon"> <i class="fa-solid fa-car"></i> </span>
                <span>Kendaraan</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=sopir" class="<?= $current=='sopir'?'active':'' ?>" onclick="closeSidebarOnMobile()">
                <span class="menu-icon"> <i class="fa-solid fa-id-card"></i></span>
                <span>Sopir</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=pelanggan" class="<?= $current=='pelanggan'?'active':'' ?>" onclick="closeSidebarOnMobile()">
                <span class="menu-icon"> <i class="fa-solid fa-users"></i> </span>
                <span>Penyewa</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=laporan_rental_pengembalian" class="<?= $current=='laporan_rental_pengembalian'?'active':'' ?>" onclick="closeSidebarOnMobile()">
                <span class="menu-icon"> <i class="fa-solid fa-car-side"></i> </span>
                <span>Laporan Rental & Pengembalian</span>
            </a>
        </li>

        <li class="menu-header">Transaksi</li>
        <li class="menu-item">
            <a href="index.php?action=rental" class="<?= $current=='rental'?'active':'' ?>" onclick="closeSidebarOnMobile()">
                <span class="menu-icon"> <i class="fa-solid fa-pen-to-square"></i> </span>
                <span>Rental</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=pengembalian" class="<?= $current=='pengembalian'?'active':'' ?>" onclick="closeSidebarOnMobile()">
                <span class="menu-icon"> <i class="fa-solid fa-arrow-rotate-left"></i></span>
                <span>Pengembalian</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=tools_functions" class="<?= $current=='tools_functions'?'active':'' ?>">
                <span class="menu-icon"><i class="fa-solid fa-bolt"></i></span>
                <span>Laporan Rental & Booking Express</span>
            </a>
        </li>

        <li class="menu-header">Admin Tools</li>
        <li class="menu-item">
            <a href="index.php?action=tools_indexing" class="<?= $current=='tools_indexing'?'active':'' ?>" onclick="closeSidebarOnMobile()">
                <span class="menu-icon"><i class="fa-solid fa-gauge-high"></i></span>
                <span>Indexing Check</span>
            </a>
        </li>
        
        <li class="menu-header">System</li>
        <li class="menu-item">
            <a href="index.php?action=users" class="<?= $current=='users'?'active':'' ?>" onclick="closeSidebarOnMobile()">
                <span class="menu-icon"> <i class="fa-solid fa-user"> </i></span>
                <span>User</span>
            </a>
        </li>

        <li class="menu-item">
            <a href="index.php?action=logout" class="<?= $current=='logout'?'active':'' ?>" onclick="closeSidebarOnMobile()">
                <span class="menu-icon"> <i class="fa-solid fa-right-from-bracket"></i> </span>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>

<script>
// Function to toggle sidebar
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
}

// Function to close sidebar
function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
}

// Function to close sidebar when clicking menu items on mobile
function closeSidebarOnMobile() {
    if (window.innerWidth <= 768) {
        closeSidebar();
    }
}

// Close sidebar with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeSidebar();
    }
});

// Auto-close sidebar when clicking outside on mobile
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.querySelector('.mobile-menu-toggle');
    
    if (window.innerWidth <= 768 && 
        sidebar.classList.contains('active') && 
        !sidebar.contains(e.target) && 
        !toggleBtn.contains(e.target)) {
        closeSidebar();
    }
});
</script>