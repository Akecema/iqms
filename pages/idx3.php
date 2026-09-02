<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quality Dept | Car Accessories Inspection</title>
    <style>
        :root {
            --brand-green: #085209; /* Your specific color */
            --soft-bg: #f3f4f6;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--soft-bg);
        }

        .split-container {
            display: flex;
            height: 100vh;
        }

        /* Form Area */
        .login-panel {
            flex: 1;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .login-content {
            width: 100%;
            max-width: 380px;
        }

        .brand-header {
            color: var(--brand-green);
            font-weight: 800;
            letter-spacing: -1px;
            font-size: 24px;
            margin-bottom: 30px;
        }

        h1 { font-size: 26px; margin-bottom: 10px; color: #111827; }
        .description { color: #6b7280; margin-bottom: 30px; font-size: 15px; }

        .input-group { margin-bottom: 20px; }
        label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        
        input {
            width: 100%;
            padding: 12px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--brand-green);
            box-shadow: 0 0 0 4px rgba(8, 82, 9, 0.15);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: var(--brand-green);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.1s ease;
        }

        .btn-submit:active { transform: scale(0.98); }

        /* Visual Area - Car Accessory Inspection Theme */
        .visual-panel {
            flex: 1.5;
            /* High-quality automotive inspection placeholder */
            background: linear-gradient(rgba(8, 82, 9, 0.3), rgba(8, 82, 9, 0.6)), 
                        url('https://images.unsplash.com/photo-1517524008436-bb401acb0c58?q=80&w=2000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
            padding: 80px;
        }

        .glass-info {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 20px;
            color: white;
            max-width: 500px;
        }

        @media (max-width: 1024px) {
            .visual-panel { display: none; }
        }
    </style>
</head>
<body>

<div class="split-container">
    <div class="login-panel">
        <div class="login-content">
            <div class="brand-header">AUTO_QC</div>
            <h1>Quality Portal</h1>
            <p class="description">Inspection management for car accessories and finished materials.</p>

            <form action="login_process.php" method="POST">
                <div class="input-group">
                    <label>Inspector ID</label>
                    <input type="text" name="username" placeholder="Enter your ID" required>
                </div>
                <div class="input-group">
                    <label>Access Code</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" name="login" class="btn-submit">Sign In to Inspection</button>
            </form>
        </div>
    </div>

    <div class="visual-panel">
        <div class="glass-info">
            <h2 style="margin: 0 0 10px 0;">Material Excellence</h2>
            <p style="margin: 0; line-height: 1.6; opacity: 0.9;">
                Standardized quality checks for interior and exterior car components. 
                Precision is the hallmark of our finished goods.
            </p>
        </div>
    </div>
</div>

</body>
</html>