<?php
session_start();

$errors = [
  'login' => $_SESSION['login_error'] ?? '',
  'register' => $_SESSION['register_error'] ?? ''
];

$activeForm = $_SESSION['active_form'] ?? 'login';

unset($_SESSION['login_error']);
unset($_SESSION['register_error']);
unset($_SESSION['active_form']);

function showError($error) {
  return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
  return $formName === $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Auth Page</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background-color: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 420px;
    }

    .tabs {
      display: flex;
      justify-content: space-around;
      margin-bottom: 1.5rem;
    }

    .tabs button {
      flex: 1;
      padding: 0.75rem;
      border: none;
      background-color: #eee;
      cursor: pointer;
      font-weight: bold;
    }

    .tabs button.active {
      background-color: #000;
      color: #fff;
    }

    form {
      display: none;
    }

    form.active {
      display: block;
    }

    h2 {
      text-align: center;
      font-weight: 500;
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-size: 0.95rem;
      color: #555;
    }

    input[type="email"],
    input[type="password"],
    input[type="text"] {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      background-color: #e6f0ff;
      font-size: 1rem;
    }

    .options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      font-size: 0.9rem;
    }

    .remember input {
      margin-right: 5px;
    }

    .forgot {
      text-decoration: none;
      color: #0078d4;
    }

    button[type="submit"] {
      width: 100%;
      padding: 0.75rem;
      background-color: #000;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #333;
    }

    .error-message {
      color: red;
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="tabs">
      <button class="<?= isActiveForm('login', $activeForm) ?>" onclick="switchForm('login')">Sign In</button>
      <button class="<?= isActiveForm('register', $activeForm) ?>" onclick="switchForm('register')">Register</button>
    </div>

    <form id="login" class="<?= isActiveForm('login', $activeForm) ?>" action="login_register.php" method="post">

      <h2>Sign In</h2>
      <?= showError($errors['login']); ?>
      <label for="login-email">Email</label>
      <input type="email" id="login-email" name="email" placeholder="Enter your email" required />

      <label for="login-password">Password</label>
      <input type="password" id="login-password" name="password" placeholder="Enter your password" required />

      <div class="options">
        <label class="remember">
          <input type="checkbox" />
          Remember me
        </label>
        <a href="#" class="forgot">Forgot your password?</a>
      </div>

      <button type="submit" name="login">Sign in</button>
    </form>

    <form id="register" class="<?= isActiveForm('register', $activeForm) ?>" action="login_register.php" method="post">

      <?= showError($errors['register']); ?>
      <label for="name">Name</label>
      <input type="text" id="name" name="name" placeholder="Your name" required />

      <label for="register-email">Email</label>
      <input type="email" id="register-email" name="email" placeholder="your@email.com" required />

      <label for="register-password">Password</label>
      <input type="password" id="register-password" name="password" placeholder="*****" required />

      <label for="confirm-password">Confirm Password</label>
      <input type="password" id="confirm-password" name="new-password" placeholder="*****" required />

      <button type="submit" name="register">Create</button>
    </form>
  </div>

  <script>
    function switchForm(form) {
      document.getElementById('login').classList.remove('active');
      document.getElementById('register').classList.remove('active');
      document.querySelectorAll('.tabs button').forEach(btn => btn.classList.remove('active'));

      document.getElementById(form).classList.add('active');
      event.target.classList.add('active');
    }
  </script>
</body>
</html>