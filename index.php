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
require_once 'models/adminToolsModel.php';

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
$adminToolsModel = new adminToolsModel($db);

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
    
    $stmt1 = $db->query("SELECT * FROM mv_kendaraan_terpopuler");
    $mv1 = $stmt1->fetch();
    
    $stmt2 = $db->query("SELECT * FROM mv_sewa_durasi_kendaraan");
    $mv2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
    include 'views/dashboard.php';
    break;

    case 'refresh_dashboard':
        requireLogin();
        $db->query("REFRESH MATERIALIZED VIEW mv_kendaraan_terpopuler");
        $db->query("REFRESH MATERIALIZED VIEW mv_sewa_durasi_kendaraan");
        $_SESSION['success'] = '✅ Data dashboard berhasil di-refresh!';
        header('Location: index.php?action=dashboard');
        exit();
        break;
    
    //tipe kendaraan
    case 'tipe_kendaraan':
        requireLogin();
        $tipeList = $tipeKendaraanModel->getAllTipeKendaraan();
        include 'views/tipe_kendaraan/tipe_list.php';
        break;

    // 2. CREATE
    case 'tipe_kendaraan_create':
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_tipe' => $_POST['nama_tipe'],
                'deskripsi' => $_POST['deskripsi']
            ];

            try {
                if ($tipeKendaraanModel->createTipeKendaraan($data)) {
                    $_SESSION['success'] = '✅ Tipe kendaraan berhasil ditambahkan!';
                    header("Location: index.php?action=tipe_kendaraan&message=created");
                    exit();
                } else {
                    $_SESSION['error'] = '❌ Gagal menambah tipe kendaraan.';
                    $_SESSION['old_data'] = $_POST;
                }
            } catch (PDOException $e) {
                // Tangkap error jika nama tipe duplikat (Unique Constraint)
                if (strpos($e->getMessage(), 'unique constraint') !== false) {
                    $_SESSION['error'] = '❌ Nama tipe sudah ada! Gunakan nama lain.';
                } else {
                    $_SESSION['error'] = '❌ Error Database: ' . $e->getMessage();
                }
                $_SESSION['old_data'] = $_POST;
            }
        }
        include 'views/tipe_kendaraan/tipe_form.php';
        break;

    // 3. EDIT
    case 'tipe_kendaraan_edit':
        requireLogin();
        $id = $_GET['id'];
        $tipe = $tipeKendaraanModel->getTipeKendaraanById($id)->fetch(PDO::FETCH_ASSOC);

        if (!$tipe) {
            $_SESSION['error'] = 'Data tipe kendaraan tidak ditemukan!';
            header("Location: index.php?action=tipe_kendaraan");
            exit();
        }
        include 'views/tipe_kendaraan/tipe_form.php';
        break;

    // 4. UPDATE
    case 'tipe_kendaraan_update':
        requireLogin();
        $id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_tipe' => $_POST['nama_tipe'],
                'deskripsi' => $_POST['deskripsi']
            ];

            try {
                if ($tipeKendaraanModel->updateTipeKendaraan($id, $data)) {
                    $_SESSION['success'] = '✅ Data tipe kendaraan berhasil diperbarui!';
                    header("Location: index.php?action=tipe_kendaraan&message=updated");
                    exit();
                } else {
                    $_SESSION['error'] = '❌ Gagal update tipe kendaraan.';
                }
            } catch (PDOException $e) {
                if (strpos($e->getMessage(), 'unique constraint') !== false) {
                    $_SESSION['error'] = '❌ Nama tipe sudah ada!';
                } else {
                    $_SESSION['error'] = '❌ Error: ' . $e->getMessage();
                }
            }
            $_SESSION['old_data'] = $_POST;
            header("Location: index.php?action=tipe_kendaraan_edit&id=$id");
            exit();
        }
        break;

    // 5. DELETE
    case 'tipe_kendaraan_delete':
        requireLogin();
        $id = $_GET['id'];
        try {
            if ($tipeKendaraanModel->deleteTipeKendaraan($id)) {
                $_SESSION['success'] = '✅ Tipe kendaraan berhasil dihapus!';
                header("Location: index.php?action=tipe_kendaraan&message=deleted");
            } else {
                $_SESSION['error'] = '❌ Gagal menghapus tipe kendaraan!';
                header("Location: index.php?action=tipe_kendaraan");
            }
        } catch (PDOException $e) {
            // Error Foreign Key (Masih ada mobil dengan tipe ini)
            $_SESSION['error'] = '❌ Tidak bisa menghapus tipe ini karena masih digunakan oleh data Kendaraan.';
            header("Location: index.php?action=tipe_kendaraan");
        }
        exit();
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
    
    //pelanggan
    case 'pelanggan':
        requireLogin();
        $pelangganList = $pelangganModel->getAllPelanggan();
        include 'views/pelanggan/pelanggan_list.php';
        break;

    // 2. CREATE
    case 'pelanggan_create':
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_pelanggan' => $_POST['nama_pelanggan'],
                'no_ktp' => $_POST['no_ktp'],
                'no_telepon' => $_POST['no_telepon'],
                'email' => !empty($_POST['email']) ? $_POST['email'] : NULL,
                'alamat' => $_POST['alamat'],
                'punya_sim' => isset($_POST['punya_sim']) ? $_POST['punya_sim'] : 0
            ];

            try {
                if ($pelangganModel->createPelanggan($data)) {
                    $_SESSION['success'] = '✅ Pelanggan berhasil ditambahkan!';
                    header("Location: index.php?action=pelanggan&message=created");
                    exit();
                } else {
                    $_SESSION['error'] = '❌ Gagal menambah pelanggan. Cek duplikasi KTP/Email.';
                    $_SESSION['old_data'] = $_POST;
                }
            } catch (PDOException $e) {
                $_SESSION['error'] = '❌ Error Database: ' . $e->getMessage();
                $_SESSION['old_data'] = $_POST;
            }
        }
        include 'views/pelanggan/pelanggan_form.php';
        break;

    // 3. EDIT
    case 'pelanggan_edit':
        requireLogin();
        $id = $_GET['id'];
        $pelanggan = $pelangganModel->getPelangganById($id)->fetch(PDO::FETCH_ASSOC);

        if (!$pelanggan) {
            $_SESSION['error'] = 'Data pelanggan tidak ditemukan!';
            header("Location: index.php?action=pelanggan");
            exit();
        }
        include 'views/pelanggan/pelanggan_form.php';
        break;

    // 4. UPDATE
    case 'pelanggan_update':
        requireLogin();
        $id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_pelanggan' => $_POST['nama_pelanggan'],
                'no_ktp' => $_POST['no_ktp'],
                'no_telepon' => $_POST['no_telepon'],
                'email' => !empty($_POST['email']) ? $_POST['email'] : NULL,
                'alamat' => $_POST['alamat'],
                'punya_sim' => isset($_POST['punya_sim']) ? $_POST['punya_sim'] : 0
            ];

            try {
                if ($pelangganModel->updatePelanggan($id, $data)) {
                    $_SESSION['success'] = '✅ Data pelanggan berhasil diperbarui!';
                    header("Location: index.php?action=pelanggan&message=updated");
                    exit();
                } else {
                    $_SESSION['error'] = '❌ Gagal update pelanggan.';
                }
            } catch (PDOException $e) {
                $_SESSION['error'] = '❌ Error: ' . $e->getMessage();
            }
            $_SESSION['old_data'] = $_POST;
            header("Location: index.php?action=pelanggan_edit&id=$id");
            exit();
        }
        break;

    // 5. DELETE
    case 'pelanggan_delete':
        requireLogin();
        $id = $_GET['id'];
        try {
            if ($pelangganModel->deletePelanggan($id)) {
                $_SESSION['success'] = '✅ Pelanggan berhasil dihapus!';
                header("Location: index.php?action=pelanggan&message=deleted");
            } else {
                $_SESSION['error'] = '❌ Gagal menghapus pelanggan!';
                header("Location: index.php?action=pelanggan");
            }
        } catch (PDOException $e) {
            // Biasanya error karena Foreign Key (masih ada data rental)
            $_SESSION['error'] = '❌ Tidak bisa menghapus pelanggan ini karena masih memiliki riwayat Rental.';
            header("Location: index.php?action=pelanggan");
        }
        exit();
        break;

    // rental
    case 'rental':
        requireLogin();
        // Mengambil semua data rental untuk ditampilkan di list
        $rentals = $rentalModel->getAllRental();
        include 'views/rental/rental_list.php';
        break;

    case 'rental_create':
        requireLogin();
        
        // Proses Form Submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil data dari form
            $data = [
                'pelanggan_id' => $_POST['pelanggan_id'],
                'kendaraan_id' => $_POST['kendaraan_id'],
                'sopir_id' => !empty($_POST['sopir_id']) ? $_POST['sopir_id'] : NULL, // Handle NULL jika lepas kunci
                'tanggal_mulai' => $_POST['tanggal_mulai'],
                'tanggal_selesai_rencana' => $_POST['tanggal_selesai_rencana'],
                'total_biaya_rencana' => $_POST['total_biaya_rencana'],
                'status_rental' => 'Aktif' // Default status
            ];

            try {
                // Coba simpan ke database
                if ($rentalModel->insertRental($data)) {
                    $_SESSION['success'] = '✅ Transaksi rental berhasil dibuat!';
                    header("Location: index.php?action=rental&message=created");
                    exit();
                } else {
                    // Fallback jika gagal tanpa exception
                    $_SESSION['error'] = '❌ Gagal membuat transaksi rental.';
                    $_SESSION['old_data'] = $_POST;
                }
            } catch (Exception $e) {
                // MENANGKAP ERROR DARI MODEL (Termasuk Trigger SIM)
                // Pesan error dari trigger database akan ditangkap di sini
                $_SESSION['error'] = '❌ ' . $e->getMessage();
                $_SESSION['old_data'] = $_POST; // Simpan inputan user agar tidak hilang
            }
        }
        
        // Tampilkan Form (Logic pengambilan data dropdown ada di dalam file view)
        include 'views/rental/rental_form.php';
        break;
    case 'rental_edit':
        requireLogin();
        $id = $_GET['id'];
        
        // Ambil data rental lama
        $rental = $rentalModel->getRentalById($id)->fetch(PDO::FETCH_ASSOC);
        
        if (!$rental) {
            $_SESSION['error'] = 'Data rental tidak ditemukan!';
            header("Location: index.php?action=rental");
            exit();
        }
        
        // Load view (Form yang sama, variabel $rental akan terdeteksi di sana)
        include 'views/rental/rental_form.php';
        break;

    // 4. UPDATE - Proses Simpan Perubahan
    case 'rental_update':
        requireLogin();
        $id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'pelanggan_id' => $_POST['pelanggan_id'],
                'kendaraan_id' => $_POST['kendaraan_id'],
                'sopir_id' => !empty($_POST['sopir_id']) ? $_POST['sopir_id'] : NULL,
                'tanggal_mulai' => $_POST['tanggal_mulai'],
                'tanggal_selesai_rencana' => $_POST['tanggal_selesai_rencana'],
                'total_biaya_rencana' => $_POST['total_biaya_rencana'],
                'status_rental' => $_POST['status_rental']
            ];

            try {
                if ($rentalModel->updateRental($id, $data)) {
                    $_SESSION['success'] = '✅ Data rental berhasil diperbarui!';
                    header("Location: index.php?action=rental&message=updated");
                    exit();
                } else {
                    $_SESSION['error'] = '❌ Gagal memperbarui data rental.';
                }
            } catch (Exception $e) {
                $_SESSION['error'] = '❌ ' . $e->getMessage();
            }
            
            // Jika gagal, kembali ke form edit
            $_SESSION['old_data'] = $_POST;
            header("Location: index.php?action=rental_edit&id=$id");
            exit();
        }
        break;

    case 'rental_delete':
        requireLogin();
        $id = $_GET['id'];
        
        // Cek apakah rental bisa dihapus (Opsional: misal hanya yang belum selesai)
        // Di sini kita langsung hapus saja sesuai request
        if ($rentalModel->deleteRental($id)) {
            $_SESSION['success'] = '✅ Data rental berhasil dihapus!';
            header("Location: index.php?action=rental&message=deleted");
        } else {
            $_SESSION['error'] = '❌ Gagal menghapus data rental! Mungkin data sedang digunakan di tabel pengembalian.';
            header("Location: index.php?action=rental");
        }
        exit();
        break;

    // pengembalian 
    case 'pengembalian':
        requireLogin();
        $pengembalian = $pengembalianModel->getAllPengembalian();
        include 'views/pengembalian/pengembalian_list.php';
        break;

    case 'pengembalian_create':
        requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $rental_id = $_POST['rental_id'];
            $tanggal_kembali_aktual = $_POST['tanggal_kembali_aktual'];
            $kondisi_akhir = $_POST['kondisi_akhir'];
            $denda_tambahan = $_POST['denda_tambahan'] ?? 0;
            
            // Validasi
            if (empty($rental_id) || empty($tanggal_kembali_aktual) || empty($kondisi_akhir)) {
                $_SESSION['error'] = '❌ Semua field wajib diisi!';
                $_SESSION['old_data'] = $_POST;
                header('Location: index.php?action=pengembalian_create');
                exit();
            }
            
            // Cek apakah rental sudah dikembalikan
            if ($pengembalianModel->isRentalReturned($rental_id)) {
                $_SESSION['error'] = '❌ Rental ini sudah dikembalikan sebelumnya!';
                $_SESSION['old_data'] = $_POST;
                header('Location: index.php?action=pengembalian_create');
                exit();
            }
            
            // Hitung keterlambatan dan denda
            $keterlambatan = $pengembalianModel->hitungKeterlambatan($rental_id, $tanggal_kembali_aktual);
            $denda_hitung = $pengembalianModel->hitungDenda($rental_id, $tanggal_kembali_aktual);
            
            $telat_jam = $keterlambatan['telat'] ?? 0;
            $denda_keterlambatan = $denda_hitung['denda'] ?? 0;
            $total_denda = $denda_keterlambatan + $denda_tambahan;
            
            // Simpan data ke session untuk ditampilkan di form
            $_SESSION['old_data'] = $_POST;
            $_SESSION['old_data']['calculation'] = [
                'keterlambatan_jam' => $telat_jam,
                'denda_keterlambatan' => $denda_keterlambatan,
                'denda_tambahan' => $denda_tambahan,
                'total_denda' => $total_denda
            ];
            
            // Proses penyimpanan langsung
            $pengembalian_data = [
                'rental_id' => $rental_id,
                'tanggal_kembali_aktual' => $tanggal_kembali_aktual,
                'denda' => $total_denda,
                'kondisi_akhir' => $kondisi_akhir
            ];
            
            // Mulai transaksi
            $db->beginTransaction();
            
            try {
                // 1. Simpan pengembalian
                if ($pengembalianModel->createPengembalian($pengembalian_data)) {
                    // 2. Update status rental
                    if ($pengembalianModel->updateRentalStatus($rental_id)) {
                        $db->commit();
                        
                        // Hapus session data
                        unset($_SESSION['old_data']);
                        
                        $_SESSION['success'] = '✅ Pengembalian berhasil diproses!';
                        if ($telat_jam > 0) {
                            $_SESSION['success'] .= " Terlambat: $telat_jam jam. Denda: Rp " . number_format($total_denda, 0, ',', '.');
                        }
                        
                        header("Location: index.php?action=pengembalian&message=created");
                        exit();
                    } else {
                        throw new Exception("Gagal update status rental");
                    }
                } else {
                    throw new Exception("Gagal menyimpan pengembalian");
                }
            } catch (Exception $e) {
                $db->rollBack();
                $_SESSION['error'] = '❌ Gagal memproses pengembalian: ' . $e->getMessage();
                header('Location: index.php?action=pengembalian_create');
                exit();
            }
        }
        
        include 'views/pengembalian/pengembalian_form.php';
        break;

    case 'pengembalian_delete':
        requireLogin();
        $id = $_GET['id'];
        
        if ($pengembalianModel->deletePengembalian($id)) {
            $_SESSION['success'] = '✅ Data pengembalian berhasil dihapus!';
            header("Location: index.php?action=pengembalian&message=deleted");
        } else {
            $_SESSION['error'] = '❌ Gagal menghapus data pengembalian!';
            header("Location: index.php?action=pengembalian");
        }
        exit();
        break;

    // kendaraan 
    case 'kendaraan':
        requireLogin();
        $kendaraan = $kendaraanModel->getAllKendaraan();
        include 'views/kendaraan/kendaraan_list.php';
        break;

    case 'kendaraan_create':
        requireLogin();
        if ($_POST) {
            $plat_nomor = trim($_POST['plat_nomor']);
            
            if ($kendaraanModel->isPlatExists($plat_nomor)) {
                $_SESSION['error'] = '❌ Plat nomor sudah terdaftar! Gunakan plat nomor lain.';
                $_SESSION['old_data'] = $_POST; 
            } else {
                $data = [
                    'kendaraan_id' => $_POST['kendaraan_id'],
                    'tipe_id' => $_POST['tipe_id'],
                    'plat_nomor' => $plat_nomor,
                    'merk' => $_POST['merk'],
                    'model' => $_POST['model'],
                    'tahun' => !empty($_POST['tahun']) ? $_POST['tahun'] : null,
                    'harga_sewa_per_hari' => $_POST['harga_sewa_per_hari'],
                    'status_ketersediaan' => $_POST['status_ketersediaan']
                ];

                if ($kendaraanModel->createKendaraan($data)) {
                    $_SESSION['success'] = '✅ Kendaraan berhasil ditambahkan!';
                    header("Location: index.php?action=kendaraan&message=created");
                    exit();
                } else {
                    $_SESSION['error'] = "❌ Gagal menambah kendaraan";
                    $_SESSION['old_data'] = $_POST;
                }
            }
        }
        include 'views/kendaraan/kendaraan_form.php';
        break;

    case 'kendaraan_edit':
        requireLogin();
        $id = $_GET['id'];

        if ($_POST) {
            $plat_nomor = trim($_POST['plat_nomor']);
            
            if ($kendaraanModel->isPlatExists($plat_nomor, $id)) {
                $_SESSION['error'] = '❌ Plat nomor sudah digunakan kendaraan lain!';
                $_SESSION['old_data'] = $_POST;
            } else {
                $data = [
                    'tipe_id' => $_POST['tipe_id'],
                    'plat_nomor' => $plat_nomor,
                    'merk' => $_POST['merk'],
                    'model' => $_POST['model'],
                    'tahun' => !empty($_POST['tahun']) ? $_POST['tahun'] : null,
                    'harga_sewa_per_hari' => $_POST['harga_sewa_per_hari'],
                    'status_ketersediaan' => $_POST['status_ketersediaan']
                ];

                if ($kendaraanModel->updateKendaraan($id, $data)) {
                    $_SESSION['success'] = '✅ Data kendaraan berhasil diupdate!';
                    header("Location: index.php?action=kendaraan&message=updated");
                    exit();
                } else {
                    $_SESSION['error'] = "❌ Gagal mengupdate kendaraan";
                    $_SESSION['old_data'] = $_POST;
                }
            }
        }

        $kendaraan = $kendaraanModel->getKendaraanById($id);
        include 'views/kendaraan/kendaraan_form.php';
        break;

    case 'kendaraan_delete':
        requireLogin();
        $id = $_GET['id'];
        if ($kendaraanModel->deleteKendaraan($id)) {
            $_SESSION['success'] = 'Kendaraan berhasil dihapus!';
            header("Location: index.php?action=kendaraan&message=deleted");
        } else {
            $_SESSION['error'] = 'Gagal menghapus kendaraan! Mungkin masih terkait dengan data rental.';
            header("Location: index.php?action=kendaraan&message=delete_error");
        }
        exit();
        break;
    
    case 'tools_indexing':
        requireLogin();
        $query = "SELECT * FROM Rental WHERE status_rental = 'Aktif'";
        $results = $adminToolsModel->getExplainAnalyze($query);
        include 'views/tools/indexing.php';
        break;

    case 'tools_transaction':
        requireLogin();
        $simulation = null;
        if (isset($_POST['test_type'])) {
            if ($_POST['test_type'] == 'commit') {
                $simulation = $adminToolsModel->simulasiTransaksiSukses();
            } elseif ($_POST['test_type'] == 'rollback') {
                $simulation = $adminToolsModel->simulasiTransaksiRollback();
            }
        }
        include 'views/tools/transaction.php';
        break;

    // default
    default:
        header('Location: index.php?action=login');
        exit();
        break;
}
?>