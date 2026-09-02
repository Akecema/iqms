<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quality Dept | Finished Goods Inspection</title>
    <style>
        :root {
            --brand-green: #085209;
            --light-bg: #f8fafc;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', -apple-system, sans-serif;
            background-color: var(--light-bg);
        }

        .container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* Left Side: Login Form */
        .login-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background: white;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
        }

        .brand-logo {
            font-weight: 700;
            font-size: 24px;
            color: var(--brand-green);
            margin-bottom: 40px;
        }

        h1 { font-size: 28px; margin-bottom: 8px; color: #1a1a1a; }
        p.subtitle { color: #64748b; margin-bottom: 32px; }

        .form-group { margin-bottom: 20px; }
        
        label { 
            display: block; 
            font-size: 14px; 
            font-weight: 500; 
            color: #475569; 
            margin-bottom: 8px; 
        }

        input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: var(--brand-green);
            box-shadow: 0 0 0 3px rgba(8, 82, 9, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background-color: var(--brand-green);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: opacity 0.2s;
        }

        .login-btn:hover { opacity: 0.9; }

        /* Right Side: Image Background */
        .image-section {
            flex: 1.2;
            background: linear-gradient(rgba(8, 82, 9, 0.2), rgba(8, 82, 9, 0.4)), 
                        url('images/image-showing-a-sophisticated-AI-driven-visual-inspection-system-in-a-manufacturing-setting.jpeg');
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: flex-end;
            padding: 60px;
        }

        .image-overlay-text {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 80%;
        }

        /* Responsive design for tablets/phones */
        @media (max-width: 900px) {
            .image-section { display: none; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="login-section">
            <div class="login-box">
                <div class="brand-logo">QC_Manager</div>
                <h1>System Login</h1>
                <p class="subtitle">Enter credentials for Finished Goods Inspection</p>

                <form action="login_process.php" method="POST">
                    <div class="form-group">
                        <label for="username">Staff ID / Username</label>
                        <input type="text" id="username" name="username" placeholder="e.g. QC-9923" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" name="login" class="login-btn">Log In to Dashboard</button>
                </form>
            </div>
        </div>

        <div class="image-section">
            <div class="image-overlay-text">
                <h2 style="margin: 0 0 10px 0;">Quality Commitment</h2>
                <p style="margin: 0; opacity: 0.9;">Ensuring every finished product meets our rigorous standards of excellence and safety.</p>
            </div>
        </div>
    </div>

</body>
</html>