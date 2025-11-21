<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
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
require_once 'models/loginModel.php';

$database = new Database();
$db = $database->getConnection();
$kendaraanModel = new KendaraanModel($db);
$tipeKendaraanModel = new TipeKendaraanModel($db);
$sopirModel = new SopirModel($db);
$pelangganModel = new PelangganModel($db);
$rentalModel = new RentalModel($db);
$pengembalianModel = new PengembalianModel($db);
$loginModel = new LoginModel($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fungsi helper untuk redirect ke login
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = 'Silakan login terlebih dahulu!';
        header('Location: index.php?action=login');
        exit();
    }
}

switch ($action) {
    // ===== AUTENTIKASI =====
    case 'login':
        // Jika sudah login, redirect ke dashboard
        if (isLoggedIn()) {
            header('Location: index.php?action=dashboard');
            exit();
        }
        
        // Proses login
        if (isset($_POST['login'])) {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Username dan password harus diisi!';
            } else {
                $user = $loginModel->authenticate($username, $password);
                
                if ($user) {
                    // Set session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'] ?? 'admin';
                    
                    $_SESSION['success'] = 'Login berhasil! Selamat datang, ' . $user['username'];
                    header('Location: index.php?action=dashboard');
                    exit();
                } else {
                    $_SESSION['error'] = 'Username atau password salah!';
                }
            }
        }
        
        include 'views/login.php';
        break;
    
    case 'logout':
        session_destroy();
        header('Location: index.php?action=login');
        exit();
        break;
    
    case 'register':
    // Jika sudah login, redirect ke dashboard
    if (isLoggedIn()) {
        header('Location: index.php?action=dashboard');
        exit();
    }
    
    // Proses registrasi
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $role = $_POST['role'] ?? 'admin';
        
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Username dan password harus diisi!';
        } elseif ($password !== $confirm_password) {
            $_SESSION['error'] = 'Password tidak cocok!';
        } elseif (strlen($password) < 6) {
            $_SESSION['error'] = 'Password minimal 6 karakter!';
        } else {
            // Cek apakah username sudah ada
            if ($loginModel->usernameExists($username)) {
                $_SESSION['error'] = 'Username sudah digunakan!';
            } else {
                $data = [
                    'username' => $username,
                    'password' => $password,
                    'role' => $role
                ];
                
                if ($loginModel->createUser($data)) {
                    $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
                    header('Location: index.php?action=login');
                    exit();
                } else {
                    $_SESSION['error'] = 'Registrasi gagal. Silakan coba lagi.';
                }
            }
        }
    }
    
    include 'views/register.php';
    break;

    
    // ===== DASHBOARD =====
    case 'dashboard':
        requireLogin();
        $active = 'dashboard';
        include 'views/dashboard.php';
        break;
    
    // ===== FORM PENGEMBALIAN =====
    case 'form_pengembalian':
        requireLogin();
        $active = 'pengembalian';
        include 'views/form_pengembalian.php';
        break;
    
    // ===== DEFAULT =====
    default:
        header('Location: index.php?action=login');
        exit();
        break;
}
?>
