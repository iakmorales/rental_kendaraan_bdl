<?php
session_start();

require_once 'config/database.php';
require_once 'models/kendaraanModel.php';
require_once 'models/tipeKendaraanModel.php';
require_once 'models/sopirModel.php';
require_once 'models/pelangganModel.php';
require_once 'models/rentalModel.php';
require_once 'models/pengembalianModel.php';
require_once 'models/loginModel.php';
require_once 'models/usersModel.php';

$database = new Database();
$db = $database->getConnection();
$kendaraanModel = new KendaraanModel($db);
$tipeKendaraanModel = new TipeKendaraanModel($db);
$sopirModel = new SopirModel($db);
$pelangganModel = new PelangganModel($db);
$rentalModel = new RentalModel($db);
$pengembalianModel = new PengembalianModel($db);
$loginModel = new LoginModel($db);
$usersModel = new UsersModel($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    function requireLogin() {
        if (!isLoggedIn()) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu!';
            header('Location: index.php?action=login_register/login');
            exit();
        }
    }

switch ($action) {
    // login_register
    case 'login':
        if (isLoggedIn()) {
            header('Location: index.php?action=dashboard');
            exit();
        }
        
        if (isset($_POST['login'])) {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Username dan password harus diisi!';
            } else {
                $user = $loginModel->authenticate($username, $password);
                
                if ($user) {
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
        
        include 'views/login_register/login.php';
        break;
    
    case 'logout':
        session_destroy();
        header('Location: index.php?action=login_register/login');
        exit();
        break;
    
    case 'register':
        if (isLoggedIn()) {
            header('Location: index.php?action=dashboard');
            exit();
        }
        
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
        
        include 'views/login_register/register.php';
        break;
    
    // dashboard
    case 'dashboard':
        requireLogin();
        $active = 'dashboard';
        include 'views/dashboard.php';
        break;
    
   
    // sopir 
    case 'sopir':
        requireLogin();
        $sopir = $sopirModel->getAllSopir();
        include 'views/sopir/sopir_list.php';
        break;


    case 'sopir_create':
        requireLogin();
        if ($_POST) {
            $no_telepon = trim($_POST['no_telepon']);
            
            if ($sopirModel->isPhoneExists($no_telepon)) {
                $_SESSION['error'] = '❌ Nomor telepon sudah terdaftar! Gunakan nomor lain.';
                $_SESSION['old_data'] = $_POST; 
            } else {
                $data = [
                    'sopir_id' => $_POST['sopir_id'],
                    'nama_sopir' => $_POST['nama_sopir'],
                    'no_telepon' => $no_telepon,
                    'tarif_sopir_per_hari' => $_POST['tarif_sopir_per_hari'],
                    'status' => $_POST['status'],
                    'catatan' => $_POST['catatan'] ?? null
                ];

                if ($sopirModel->createSopir($data)) {
                    $_SESSION['success'] = '✅ Sopir berhasil ditambahkan!';
                    header("Location: index.php?action=sopir&message=created");
                    exit();
                } else {
                    $_SESSION['error'] = "❌ Gagal menambah sopir";
                    $_SESSION['old_data'] = $_POST;
                }
            }
        }
        include 'views/sopir/sopir_form.php';
        break;

    case 'sopir_edit':
        requireLogin();
        $id = $_GET['id'];

        if ($_POST) {
            $no_telepon = trim($_POST['no_telepon']);
            
            if ($sopirModel->isPhoneExists($no_telepon, $id)) {
                $_SESSION['error'] = '❌ Nomor telepon sudah digunakan sopir lain!';
                $_SESSION['old_data'] = $_POST;
            } else {
                $data = [
                    'nama_sopir' => $_POST['nama_sopir'],
                    'no_telepon' => $no_telepon,
                    'tarif_sopir_per_hari' => $_POST['tarif_sopir_per_hari'],
                    'status' => $_POST['status'],
                    'catatan' => $_POST['catatan'] ?? null
                ];

                if ($sopirModel->updateSopir($id, $data)) {
                    $_SESSION['success'] = '✅ Data sopir berhasil diupdate!';
                    header("Location: index.php?action=sopir&message=updated");
                    exit();
                } else {
                    $_SESSION['error'] = "❌ Gagal mengupdate sopir";
                    $_SESSION['old_data'] = $_POST;
                }
            }
        }

        $sopir = $sopirModel->getSopirById($id);
        include 'views/sopir/sopir_form.php';
        break;

    case 'sopir_delete':
        requireLogin();
        $id = $_GET['id'];
        if ($sopirModel->deleteSopir($id)) {
            $_SESSION['success'] = 'Sopir berhasil dihapus!';
            header("Location: index.php?action=sopir&message=deleted");
        } else {
            $_SESSION['error'] = 'Gagal menghapus sopir!';
            header("Location: index.php?action=sopir&message=delete_error");
        }
        exit();
        break;
        

    // users 
    case 'users':
        requireLogin(); 
        $users = $usersModel->getAllUsers();
        include 'views/users/users_list.php';
        break;
    
    case 'users_create':
        requireLogin();
        if ($_POST) {
            $data = [
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'role' => $_POST['role']
            ];

            if ($usersModel->createUsers($data)) {
                $_SESSION['success'] = '✅ User berhasil ditambahkan!';
                header("Location: index.php?action=users&message=created");
                exit();
            } else {
                $_SESSION['error'] = "❌ Gagal menambah user";
                $_SESSION['old_data'] = $_POST;
            }
        }
        include 'views/users/users_form.php';
        break;

    case 'users_edit':
        requireLogin();
        $id = $_GET['id'];
        if ($_POST) {
            $data = [
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'role' => $_POST['role']
            ];

            if ($usersModel->updateUsers($id, $data)) {
                $_SESSION['success'] = '✅ Data user berhasil diupdate!';
                header("Location: index.php?action=users&message=updated");
                exit();
            } else {
                $_SESSION['error'] = "❌ Gagal mengupdate user";
                $_SESSION['old_data'] = $_POST;
            }
        }
        $users = $usersModel->getUsersById($id);
        include 'views/users/users_form.php';
        break;

    case 'users_delete':
        requireLogin();
        $id = $_GET['id'];
        if ($usersModel->deleteUsers($id)) {
            $_SESSION['success'] = 'User berhasil dihapus!';
            header("Location: index.php?action=users&message=deleted");
        } else {
            $_SESSION['error'] = 'Gagal menghapus user!';
            header("Location: index.php?action=users&message=delete_error");
        }
        exit();
        break;


    // default
    default:
        header('Location: index.php?action=login');
        exit();
        break;
}
?>