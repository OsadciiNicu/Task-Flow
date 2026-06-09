<?php
session_start();
require_once 'php/auth.php';

// Redirect if already logged in
if (isset($_SESSION['user'])) {
  header('Location: dashboard.php');
  exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';
  $result = loginUser($username, $password);

  if ($result['success']) {
    $_SESSION['user'] = $result['user'];
    header('Location: dashboard.php');
    exit;
  } else {
    $error = $result['message'];
  }
}

$tema = $_COOKIE['theme'] ?? 'light';
?>
<!DOCTYPE html>
<html lang="ro" data-theme="<?= $tema ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Autentificare — TaskFlow</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php include 'php/navbar_partial.php'; ?>

<div class="form-page">
  <div class="form-card">
    <h1>Autentificare</h1>
    <p class="subtitle">Bine ai revenit! Intră în contul tău.</p>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['registered'])): ?>
      <div class="alert alert-success">Cont creat cu succes! Te poți autentifica.</div>
    <?php endif; ?>

    <form id="loginForm" method="POST" novalidate>
      <div class="form-group">
        <label for="username">Nume utilizator</label>
        <input type="text" id="username" name="username" placeholder="ex: ion_popescu"
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" autocomplete="username">
        <span class="error-msg">Câmpul este obligatoriu.</span>
      </div>
      <div class="form-group">
        <label for="password">Parolă</label>
        <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password">
        <span class="error-msg">Câmpul este obligatoriu.</span>
      </div>
      <button type="submit" class="form-submit">Intră în cont</button>
    </form>

    <p class="form-link">Nu ai cont? <a href="register.php">Înregistrează-te</a></p>
  </div>
</div>

<script src="js/script.js"></script>
<script>
  if (typeof validateForm === 'function') {
    validateForm('loginForm', [
      { name: 'username', required: true },
      { name: 'password', required: true },
    ]);
  }
</script>
</body>
</html>