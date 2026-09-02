<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FG Inspection System | Login</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="login-glass.css">
</head>

<body>

<style>

    :root{
  --primary: #085209;
  --primaryHover: #0a6a2b;
  --textDark: #0f172a;
  --textMute: rgba(255,255,255,0.78);
  --cardBg: rgba(255, 255, 255, 0.18);
  --cardBorder: rgba(255, 255, 255, 0.25);
}

* { box-sizing: border-box; font-family: "Inter", sans-serif; }
body { margin: 0; }

.bg-wrap{
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;

  /* Put your chosen background here */
  background: url("inspection-bg.jpg") center/cover no-repeat;
  position: relative;
}

.overlay{
  position: absolute;
  inset: 0;
  background: linear-gradient(
    120deg,
    rgba(8,82,9,0.75),
    rgba(0,0,0,0.40)
  );
}

/* Glass card */
.login-card{
  position: relative;
  z-index: 2;
  width: min(420px, 92vw);
  padding: 26px 24px;

  background: var(--cardBg);
  border: 1px solid var(--cardBorder);
  border-radius: 16px;

  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);

  box-shadow: 0 20px 70px rgba(0,0,0,0.35);
  color: white;
}

.brand{
  display: flex;
  gap: 12px;
  align-items: center;
  margin-bottom: 18px;
}

.brand-badge{
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: rgba(255,255,255,0.16);
  border: 1px solid rgba(255,255,255,0.25);
  position: relative;
}
.brand-badge:after{
  content:"";
  position:absolute;
  inset: 10px;
  border-radius: 10px;
  background: var(--primary);
}

.brand h1{
  margin: 0;
  font-size: 22px;
  line-height: 1.2;
}
.brand p{
  margin: 4px 0 0;
  color: var(--textMute);
  font-weight: 500;
}

.form-group{ margin-top: 14px; }
label{
  display:block;
  font-size: 13px;
  margin-bottom: 7px;
  color: rgba(255,255,255,0.85);
}

input{
  width: 100%;
  padding: 12px 12px;
  border-radius: 10px;
  border: 1px solid rgba(255,255,255,0.20);
  background: rgba(255,255,255,0.14);
  color: white;
  outline: none;
}
input::placeholder{ color: rgba(255,255,255,0.65); }
input:focus{
  border-color: rgba(255,255,255,0.45);
  box-shadow: 0 0 0 3px rgba(8,82,9,0.35);
}

.password-wrap{
  position: relative;
}
.btn-eye{
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  border: 0;
  background: rgba(255,255,255,0.10);
  color: white;
  width: 36px;
  height: 34px;
  border-radius: 10px;
  cursor: pointer;
}

.btn-login{
  width: 100%;
  margin-top: 18px;
  padding: 12px;
  border: 0;
  border-radius: 12px;
  background: var(--primary);
  color: white;
  font-weight: 700;
  cursor: pointer;
  font-size: 15px;
}
.btn-login:hover{
  background: var(--primaryHover);
}

.meta{
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  margin-top: 14px;
}
.pill{
  font-size: 12px;
  padding: 6px 10px;
  border-radius: 999px;
  background: rgba(255,255,255,0.12);
  border: 1px solid rgba(255,255,255,0.18);
}

.footer-note{
  margin-top: 16px;
  font-size: 12px;
  color: rgba(255,255,255,0.7);
}


</style>

  <div class="bg-wrap">
    <div class="overlay"></div>

    <div class="login-card">
      <div class="brand">
        <div class="brand-badge"></div>
        <div>
          <h1>FG Inspection System</h1>
          <p>Quality Department</p>
        </div>
      </div>

      <form method="post" action="login-process.php" class="form">
        <div class="form-group">
          <label>Staff ID / Email</label>
          <input type="text" name="username" placeholder="Enter staff ID" required>
        </div>

        <div class="form-group">
          <label>Password</label>
          <div class="password-wrap">
            <input id="pwd" type="password" name="password" placeholder="••••••••" required>
            <button type="button" class="btn-eye" onclick="togglePwd()">👁</button>
          </div>
        </div>

        <button type="submit" class="btn-login">Login</button>

        <div class="meta">
          <span class="pill">Secure Access</span>
          <span class="pill">Finished Goods</span>
          <span class="pill">Inspection</span>
        </div>

        <div class="footer-note">
          For Quality Department use only • v1.0
        </div>
      </form>
    </div>
  </div>

  <script>
    function togglePwd() {
      const el = document.getElementById('pwd');
      el.type = el.type === 'password' ? 'text' : 'password';
    }
  </script>

</body>
</html>
