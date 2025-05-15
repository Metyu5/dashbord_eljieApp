<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Admin - EljieHotelApp</title>
  <link rel="icon" href="./assets/images/logo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --primary: #4f46e5;
      --primary-hover: #4338ca;
      --text: #1f2937;
      --text-light: #6b7280;
      --bg: #f9fafb;
      --card-bg: #ffffff;
      --border: #e5e7eb;
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 1rem;
      color: var(--text);
    }

    .login-container {
      width: 100%;
      max-width: 28rem;
      background: var(--card-bg);
      border-radius: 1rem;
      box-shadow: var(--shadow);
      padding: 2.5rem;
      text-align: center;
      border: 1px solid var(--border);
      height: auto;
      max-height: 95vh;
      overflow-y: auto;
    }

    .login-icon {
      width: 5rem;
      height: 5rem;
      margin: 0 auto 1.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
      border-radius: 50%;
      color: var(--primary);
      font-size: 1.75rem;
      box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1), 0 2px 4px -1px rgba(79, 70, 229, 0.06);
    }

    .login-title {
      font-size: clamp(1.5rem, 2.5vw, 1.75rem);
      font-weight: 700;
      margin-bottom: 0.25rem;
      color: var(--text);
    }

    .login-subtitle {
      font-size: clamp(0.75rem, 2vw, 0.875rem);
      color: var(--text-light);
      margin-bottom: 2rem;
    }

    .login-form {
      display: flex;
      flex-direction: column;
      gap: 1.25rem;
    }

    .form-group {
      text-align: left;
    }

    .form-group label {
      display: block;
      font-size: 0.875rem;
      font-weight: 500;
      margin-bottom: 0.5rem;
      color: var(--text);
    }

    .input-group {
      position: relative;
    }

    .input-group i {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-light);
      font-size: 1rem;
    }

    .input-group input {
      width: 100%;
      padding: 0.75rem 1rem 0.75rem 2.75rem;
      border: 1px solid var(--border);
      border-radius: 0.5rem;
      font-size: 0.9375rem;
      font-family: 'Poppins', sans-serif;
      transition: all 0.2s;
    }

    .input-group input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .toggle-password {
      position: absolute;
      right: 3rem;
      top: 50%;
      transform: translateY(-90%);
      background: none;
      border: none;
      color: var(--text-light);
      cursor: pointer;
      font-size: 1rem;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin-top: -0.5rem;
    }

    .remember-me input {
      width: 1rem;
      height: 1rem;
      accent-color: var(--primary);
    }

    .remember-me label {
      font-size: 0.875rem;
      color: var(--text-light);
      font-weight: 400;
    }

    .btn-submit {
      background-color: var(--primary);
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 0.5rem;
      font-size: 0.9375rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 0.5rem;
    }

    .btn-submit:hover {
      background-color: var(--primary-hover);
    }

    .footer-text {
      margin-top: 2rem;
      font-size: 0.75rem;
      color: var(--text-light);
    }

    /* Responsiveness */
    @media (max-width: 1024px) {
      .login-container {
        padding: 2rem;
        max-width: 90%;
      }
    }

    @media (max-width: 768px) {
      .login-container {
        padding: 1.5rem;
      }

      .btn-submit {
        font-size: 0.875rem;
        padding: 0.65rem 1rem;
      }
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 1.25rem;
      }

      .form-group label {
        font-size: 0.75rem;
      }

      .input-group input {
        font-size: 0.875rem;
        padding-left: 2.5rem;
      }

      .toggle-password {
        right: 2.5rem;
        font-size: 0.875rem;
      }

      .footer-text {
        font-size: 0.7rem;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-icon">
      <i class="fas fa-lock"></i>
    </div>

    <h1 class="login-title">Administrator</h1>
    <p class="login-subtitle">EljieHotelApp</p>

    <form action="login.php" method="POST" class="login-form">
      <div class="form-group">
        <label for="username">Username</label>
        <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" id="username" name="username" placeholder="Enter your username" required />
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-group">
          <i class="fas fa-key"></i>
          <input type="password" id="password" name="password" placeholder="Enter your password" required />
          <button type="button" class="toggle-password" id="togglePassword">
            <i class="fas fa-eye" id="eyeIcon"></i>
          </button>
        </div>
      </div>

      <div class="remember-me">
        <input type="checkbox" id="remember-me" name="remember-me" />
        <label for="remember-me">Remember me</label>
      </div>

      <button type="submit" class="btn-submit">
        Sign In <i class="fas fa-arrow-right"></i>
      </button>
    </form>

    <div class="footer-text">
      © 2025 EljieHotelApp Admin Portal. All rights reserved.
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const togglePassword = document.getElementById("togglePassword");
      const passwordInput = document.getElementById("password");
      const eyeIcon = document.getElementById("eyeIcon");

      togglePassword.addEventListener("click", function () {
        const isPassword = passwordInput.type === "password";
        passwordInput.type = isPassword ? "text" : "password";

        eyeIcon.classList.toggle("fa-eye-slash");
        eyeIcon.classList.toggle("fa-eye");
      });
    });
  </script>
</body>

</html>
