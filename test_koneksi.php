<?php
/**
 * FILE: test_koneksi.php
 * FUNGSI: Untuk menguji koneksi ke database
 */
include "config/database.php";

$db = new Database();
$conn = $db->getConnection();

if ($conn) {
    echo "<h3 style='color: green;'>Koneksi ke database BERHASIL ✓</h3>";
} else {
    echo "<h3 style='color: red;'>Koneksi ke database GAGAL ✗</h3>";
}
?>
