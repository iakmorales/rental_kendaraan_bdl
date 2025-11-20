<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Admin</title>
    <style>
        footer {
            background: linear-gradient(135deg, #202020 0%, #333533 100%);
            color: white;
            padding: 2rem;
            margin-top: auto;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-links {
            display: flex;
            gap: 2rem;
        }

        .footer-links a {
            color: #FFEE32;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #FFD100;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
     <footer>
        <div class="footer-content">
            <div class="footer-info">
                <p>&copy; 2025 Go Drive. All rights reserved.</p>
            </div>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Contact</a>
            </div>
        </div>
    </footer>
</body>
</html>