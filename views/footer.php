<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Design</title>
    <style>
        footer {
            background-color: #000;
            color: white;
            padding: 40px 0;
            font-family: Arial, sans-serif;
        }

        .footer-container {
            display: flex;
            justify-content: center;   
            gap: 60px;                 
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 20px;
        }

        .footer-section {
            flex: 1;
            max-width: 300px;         
            text-align: center;         
        }

        .footer-section h3 {
            font-size: 1.2rem;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .footer-section p, 
        .footer-section ul {
            font-size: 0.9rem;
            line-height: 1.5;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        ul li a:hover {
            color: #00bcd4;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #444;
        }

        .footer-bottom p {
            font-size: 0.8rem;
        }

        .footer-bottom a {
            color: #00bcd4;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                align-items: center;
                gap: 30px;
            }

            .footer-section {
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>Max Drive</h3>
                <p>At Max Drive, we prioritize reliable cars and customer satisfaction. Our dedicated team is committed to making every journey effortless.</p>
            </div>

            <div class="footer-section">
                <h3>Quick links</h3>
                <ul>
                    <li><a href="index.php?action=dashboard">Dashboard</a></li>
                    <li><a href="index.php?action=">Data Kendaraan</a></li>
                    <li><a href="index.php?action=">Rental Kendaran</a></li>
                    <li><a href="index.php?action=">Pengembalian</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contact</h3>
                <p>Email: <a href="mailto:support@maxdrive.com">support@maxdrive.com</a></p>
                <p>Phone: +62 812 3217 0196</p>
                <p>Address: Kota Malang</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 Kelompok 6 Basis Data Lanjut | <a>Privacy & Policy</a></p>
        </div>
    </footer>
</body>
</html>
