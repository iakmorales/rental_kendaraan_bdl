<?php
/**
 * FILE: index.php
 * FUNGSI: Controller utama yang menangani semua request
 */
require_once 'config/database.php';
require_once 'models/kendaraanModel.php';
require_once 'models/tipeKendaraanModel.php';
require_once 'models/sopirModel.php';
require_once 'models/pelangganModel.php';
require_once 'models/rentalModel.php';
require_once 'models/pengembalianModel.php';

$database = new Database();
$db = $database->getConnection();
$kendaraanModel = new KendaraanModel($db);
$tipeKendaraanModel = new TipeKendaraanModel($db);
$sopirModel = new SopirModel($db);
$pelangganModel = new PelangganModel($db);
$rentalModel = new RentalModel($db);
$pengembalianModel = new PengembalianModel($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

switch ($action) {
    case 'dashboard':
        $active = 'dashboard';
        include 'views/dashboard.php';
        break;

    
}
?>