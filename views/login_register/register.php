<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrasi User</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #202020 0%, #333533 100%);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }

            .container {
                background: #D6D6D6;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
                overflow: hidden;
                max-width: 900px;
                width: 100%;
                display: flex;
                flex-direction: row;
            }

            .welcome-section {
                background: linear-gradient(135deg, #FFD100 100%);
                padding: 60px 40px;
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                color: #202020;
            }

            .welcome-section h1 {
                font-size: 2.5em;
                margin-bottom: 20px;
                font-weight: 700;
            }

            .welcome-section p {
                font-size: 1.1em;
                line-height: 1.6;
                opacity: 0.9;
            }

            .form-section {
                padding: 60px 40px;
                flex: 1;
                background: #D6D6D6;
            }

            .form-section h2 {
                color: #202020;
                margin-bottom: 10px;
                font-size: 2em;
            }

            .form-section p {
                color: #333533;
                margin-bottom: 30px;
            }

            .alert {
                padding: 12px 16px;
                border-radius: 8px;
                margin-bottom: 20px;
                font-weight: 500;
                animation: slideDown 0.3s ease;
            }

            .alert-error {
                background: #f8d7da;
                border: 1px solid #f5c6cb;
                color: #721c24;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .form-group {
                margin-bottom: 25px;
            }

            .form-group label {
                display: block;
                margin-bottom: 8px;
                color: #202020;
                font-weight: 600;
                font-size: 0.95em;
            }

            .form-group input,
            .form-group select {
                width: 100%;
                padding: 14px 16px;
                border: 2px solid #333533;
                border-radius: 10px;
                font-size: 1em;
                transition: all 0.3s ease;
                background: white;
                color: #202020;
            }

            .form-group input:focus,
            .form-group select:focus {
                outline: none;
                border-color: #FFD100;
                box-shadow: 0 0 0 3px rgba(255, 209, 0, 0.1);
            }

            .btn-submit {
                width: 100%;
                padding: 16px;
                background: linear-gradient(135deg, #FFD100 0%, #FFEE32 100%);
                color: #202020;
                border: none;
                border-radius: 10px;
                font-size: 1.1em;
                font-weight: 700;
                cursor: pointer;
                transition: all 0.3s ease;
                margin-top: 10px;
            }

            .btn-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(255, 209, 0, 0.3);
            }

            .btn-submit:active {
                transform: translateY(0);
            }

            .login-link {
                text-align: center;
                margin-top: 20px;
                color: #333533;
            }

            .login-link a {
                color: #202020;
                font-weight: 700;
                text-decoration: none;
            }

            .login-link a:hover {
                text-decoration: underline;
            }

            @media (max-width: 768px) {
                .container {
                    flex-direction: column;
                }

                .welcome-section {
                    padding: 40px 30px;
                }

                .form-section {
                    padding: 40px 30px;
                }

                .welcome-section h1 {
                    font-size: 2em;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="welcome-section">
                <h1>Selamat Datang!</h1>
                <p>Daftarkan akun Anda untuk mengakses sistem admin kami. Silakan isi formulir dengan lengkap dan benar.</p>
            </div>

            <div class="form-section">
                <h2>Registrasi Akun</h2>
                <p>Buat akun baru untuk memulai</p>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        ❌ <?php echo htmlspecialchars($_SESSION['error']); ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form method="POST" action="index.php?action=register" id="registerForm">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" 
                            id="username" 
                            name="username" 
                            required 
                            minlength="4"
                            maxlength="50" 
                            pattern="[a-zA-Z0-9_]+"
                            title="Username hanya boleh berisi huruf, angka, dan underscore"
                            placeholder="Masukkan username (min. 4 karakter)">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" 
                            id="password" 
                            name="password" 
                            required 
                            minlength="6"
                            placeholder="Masukkan password (min. 6 karakter)">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password</label>
                        <input type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            required 
                            placeholder="Ulangi password">
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role">
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit">Daftar Sekarang</button>
                </form>

                <div class="login-link">
                    Sudah punya akun? <a href="index.php?action=login">Login di sini</a>
                </div>
            </div>
        </div>

        <script>
            // validasi password
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirm_password').value;
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('❌ Password tidak cocok! Silakan cek kembali.');
                    return false;
                }
            });
        </script>
    </body>
</html>