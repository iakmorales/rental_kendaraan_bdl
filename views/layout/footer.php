<!DOCTYPE html>
<html lang="en">    
    <body>
        <style>
            footer {
                background: linear-gradient(135deg, #202020 0%, #333533 100%);
                color: white;
                padding: 1.5rem 2rem;
                margin-left: 250px;
                width: calc(100% - 250px);
                position: relative;
                z-index: 1;
            }

            .footer-content {
                max-width: 100%;
                margin: 0 auto;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .footer-info p {
                margin: 0;
                color: #e0e0e0;
            }

            .footer-links {
                display: flex;
                gap: 2rem;
            }

            .footer-links a {
                color: #FFEE32;
                text-decoration: none;
                transition: color 0.3s;
                font-weight: 500;
            }

            .footer-links a:hover {
                color: #FFD100;
            }

            @media (max-width: 768px) {
                footer {
                    margin-left: 0;
                    width: 100%;
                }

                .footer-content {
                    flex-direction: column;
                    gap: 1rem;
                    text-align: center;
                }

                .footer-links {
                    flex-direction: column;
                    gap: 0.5rem;
                }
            }
        </style>

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