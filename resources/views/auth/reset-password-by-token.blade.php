<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: #f9f9f9;
    }

    .reset-password-container {
      background: #fff;
      padding: 30px;
      width: 350px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .logo {
      font-size: 20px;
      font-weight: bold;
      color: #f59b57;
    }

    .sub-logo {
      font-size: 14px;
      color: #f59b57;
      display: block;
      margin-top: 5px;
    }

    h2 {
      margin-top: 20px;
      font-size: 18px;
      color: #333;
    }

    p {
      font-size: 14px;
      color: #666;
      margin: 10px 0 20px;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    input[type="password"] {
      width: 100%;
      padding: 10px 40px 10px 15px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 5px;
      outline: none;
      transition: border 0.3s;
    }

    input[type="password"]:focus {
      border-color: #007bff;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 18px;
      color: #666;
    }

    button {
      background: #1a3d59;
      color: #fff;
      border: none;
      padding: 10px 20px;
      font-size: 14px;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background: #144051;
    }

    .footer-text {
      font-size: 12px;
      color: #aaa;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="reset-password-container">
    <div class="logo">Yortago<br><span class="sub-logo">SOCIAL LOGO</span></div>
    <h2>Reset Your Password</h2>
    <p>Enter your new password.</p>
    <form action="{{route('reset.password.by.token')}}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
      <div class="input-group">
        <input type="password" name='password' placeholder="Password" required>
        <span class="toggle-password">&#128065;</span>
      </div>
      <div class="input-group">
        <input type="password" name='password_confirmation' placeholder="Confirm Password" required>
        <span class="toggle-password">&#128065;</span>
      </div>
      <button type="submit">Reset your password</button>
    </form>
    <p class="footer-text">Powered by Yortago</p>
  </div>
</body>
</html>
