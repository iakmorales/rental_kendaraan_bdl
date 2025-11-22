<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Rental Kendaraan</title>

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            body {
                background: linear-gradient(135deg, #202020 100%);
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .wrapper {
                width: 90%;
                max-width: 1000px;
                background: #fff;
                border-radius: 20px;
                display: flex;
                overflow: hidden;
                box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            }

            .left-side {
                width: 50%;
                background: #ffd100;
                padding: 40px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                text-align: center;
            }

            .left-side img {
                width: 85%;
                margin: 0 auto 20px auto;
            }

            .left-side h2 {
                font-size: 24px;
                font-weight: 700;
                color: #202020;
                margin-top: 10px;
            }

            .right-side {
                width: 50%;
                background: #d6d6d6;
                padding: 50px;
            }

            .right-side h1 {
                text-align: center;
                margin-bottom: 30px;
                color: #333533;
                font-size: 28px;
            }

            .alert {
                padding: 12px 16px;
                border-radius: 8px;
                margin-bottom: 20px;
                font-weight: 500;
                animation: slideDown 0.3s ease;
            }

            .alert-success {
                background: #d4edda;
                border: 1px solid #c3e6cb;
                color: #155724;
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
                margin-bottom: 20px;
            }

            .form-group label {
                font-weight: 600;
                color: #202020;
                margin-bottom: 6px;
                display: block;
            }

            .form-group input {
                width: 100%;
                padding: 12px;
                border-radius: 8px;
                border: 2px solid #333533;
                font-size: 15px;
                transition: .2s;
            }

            .form-group input:focus {
                border-color: #FFD100;
                outline: none;
                box-shadow: 0 0 5px rgba(255, 209, 0, 0.5);
            }

            .form-group input.error {
                border-color: #f5c6cb;
            }

            .btn-login {
                width: 100%;
                padding: 12px;
                background: #FFD100;
                color: #202020;
                border: none;
                border-radius: 10px;
                font-size: 17px;
                font-weight: 700;
                cursor: pointer;
                transition: .2s;
            }

            .btn-login:hover {
                background: #FFEE32;
                transform: translateY(-2px);
            }

            .register-link {
                text-align: center;
                margin-top: 25px;
                color: #333;
            }

            .register-link a {
                color: #202020;
                font-weight: 700;
                text-decoration: none;
            }

            .register-link a:hover {
                text-decoration: underline;
            }

            @media(max-width: 860px) {
                .wrapper {
                    flex-direction: column;
                }
                .left-side, .right-side {
                    width: 100%;
                }
                .left-side img {
                    width: 70%;
                }
            }
        </style>
    </head>

    <body>
        <div class="wrapper">
            <div class="left-side">
                <img src="image/login_mobil.png" alt="Mobil Image">
                <h2>Go Drive</h2>
                <p>Rental Kendaraan Terpercaya</p>
            </div>

            <div class="right-side">
                <h1>Welcome Back</h1>
                <?php if (isset($_SESSION['success'])): ?>
                    <script>
                        alert('✅ <?php echo addslashes($_SESSION['success']); ?>');
                    </script>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        ❌ <?php echo htmlspecialchars($_SESSION['error']); ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form action="index.php?action=login" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" 
                            id="username" 
                            name="username" 
                            required 
                            maxlength="50" 
                            placeholder="Masukkan username"
                            autocomplete="username"
                            class="<?php echo isset($_SESSION['login_error']) ? 'error' : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" 
                            id="password" 
                            name="password" 
                            required 
                            maxlength="50" 
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            class="<?php echo isset($_SESSION['login_error']) ? 'error' : ''; ?>">
                    </div>

                    <button type="submit" name="login" class="btn-login">LOGIN</button>
                </form>

                <div class="register-link">
                    Belum punya akun? <a href="index.php?action=register">Daftar di sini</a>
                </div>
            </div>
        </div>
    </body>
</html>
