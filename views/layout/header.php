<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Go Drive Admin</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
            integrity="sha512-pbFz1cAQYz4sVxqV5D8Zyx/+D5z+wec3s+sqXwVxLqS2Cj0Yw5Dfdd1q+o5hVH6UgM0G3jqm+DQ2nRrGnx1pRw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }

                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: #f4f6f9;
                    min-height: 100vh;
                    display: flex;
                    flex-direction: column;
                }

                /* Header */
                header {
                    background: linear-gradient(135deg, #202020 0%, #333533 100%);
                    color: white;
                    padding: 1rem 2rem;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    z-index: 1000;
                    height: 70px;
                }

                .header-content {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    max-width: 100%;
                    margin: 0 auto;
                    height: 100%;
                }

                .logo-section {
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                }

                .logo {
                    width: 50px;
                    height: 50px;
                    background-color: #FFD100;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                    font-size: 1.5rem;
                    color: #202020;
                }

                .logo-section h2 {
                    margin: 0;
                    font-size: 1.5rem;
                }

                .user-section {
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                }

                .user-avatar {
                    width: 40px;
                    height: 40px;
                    background: linear-gradient(135deg, #FFEE32, #FFD100);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                    color: #202020;
                }
            </style>
    </head>
    <body>
        <header>
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo">🦊</div>
                    <h2>Go Drive</h2>
                </div>
                <div class="user-section">
                    <span>Admin</span>
                    <div class="user-avatar">Ad</div>
                </div>
            </div>
        </header>
    </body>
</html>


