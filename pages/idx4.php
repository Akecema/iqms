<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FG Inspection | Quick Login</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="login-minimal.css">
</head>

<body>

<style>

    :root{
  --primary: #085209;
  --primaryHover: #0a6a2b;
  --bg: #f4f8f5;
}

*{
  box-sizing: border-box;
  font-family: 'Inter', sans-serif;
}

body{
  margin: 0;
  background: var(--bg);
}

.login-wrapper{
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-card{
  width: min(360px, 92vw);
  background: #fff;
  padding: 28px 24px;
  border-radius: 12px;
  box-shadow: 0 10px 40px rgba(0,0,0,0.08);
  text-align: center;
}

.logo{
  width: 70px;
  margin-bottom: 10px;
}

h1{
  font-size: 22px;
  color: var(--primary);
  margin-bottom: 4px;
}

.dept{
  color: #4b6b57;
  margin-bottom: 22px;
  font-weight: 500;
}

input[type="text"],
input[type="password"]{
  width: 100%;
  padding: 14px;
  margin-bottom: 14px;
  border-radius: 8px;
  border: 1px solid #d6e5dc;
  font-size: 15px;
}

input:focus{
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(8,82,9,0.15);
}

.shift{
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-bottom: 18px;
  font-size: 14px;
}

.shift input{
  accent-color: var(--primary);
}

button{
  width: 100%;
  padding: 14px;
  background: var(--primary);
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
}

button:hover{
  background: var(--primaryHover);
}

.footer{
  margin-top: 18px;
  font-size: 12px;
  color: #6b7280;
}


</style>

<div class="login-wrapper">

  <div class="login-card">

    <img src="logo.png" class="logo" alt="Company Logo">

    <h1>FG Inspection System</h1>
    <p class="dept">Quality Department</p>

    <form method="post" action="login-process.php">

      <input type="text" name="staff_id" placeholder="Staff ID" autofocus required>

      <input type="password" name="password" placeholder="Password" required>

      <div class="shift">
        <label>
          <input type="radio" name="shift" value="D" required>
          Day
        </label>
        <label>
          <input type="radio" name="shift" value="N">
          Night
        </label>
      </div>

      <button type="submit">LOGIN</button>

    </form>

    <div class="footer">
      For Quality Department use only
    </div>

  </div>

</div>

</body>
</html>
