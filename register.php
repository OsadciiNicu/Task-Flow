<?php
session_start();
require_once 'php/auth.php';

if (isset($_SESSION['user'])) {
  header('Location: dashboard.php');
  exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm  = $_POST['confirm'] ?? '';

  if ($password !== $confirm) {
    $error = 'Parolele nu coincid.';
  } else {
    $result = registerUser($username, $email, $password);
    if ($result['success']) {
      header('Location: login.php?registered=1');
      exit;
    } else {
      $error = $result['message'];
    }
  }
}

$tema = $_COOKIE['theme'] ?? 'light';
?>
<!DOCTYPE html>
<html lang="ro" data-theme="<?= $tema ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Înregistrare — TaskFlow</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php include 'php/navbar_partial.php'; ?>

<div class="form-page">
  <div class="form-card">
    <h1>Cont nou</h1>
    <p class="subtitle">Creează-ți contul TaskFlow gratuit.</p>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form id="registerForm" method="POST" novalidate>
      <div class="form-group">
        <label for="username">Nume utilizator</label>
        <input type="text" id="username" name="username" placeholder="ex: ion_popescu"
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        <span class="error-msg"></span>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="ex: ion@email.com"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <span class="error-msg"></span>
      </div>
      <div class="form-group">
        <label for="password">Parolă</label>
        <input type="password" id="password" name="password" placeholder="Minim 6 caractere">
        <span class="error-msg"></span>
      </div>
      <div class="form-group">
        <label for="confirm">Confirmă parola</label>
        <input type="password" id="confirm" name="confirm" placeholder="Repetă parola">
        <span class="error-msg"></span>
      </div>
      <button type="submit" class="form-submit">Creează cont</button>
    </form>

    <p class="form-link">Ai deja cont? <a href="login.php">Autentifică-te</a></p>
  </div>
</div>

<script src="js/script.js"></script>
<script>
  if (typeof validateForm === 'function') {
    validateForm('registerForm', [
      { name: 'username', required: true, minLength: 3, shortMsg: 'Minim 3 caractere.' },
      { name: 'email', required: true, email: true, emailMsg: 'Introdu un email valid.' },
      { name: 'password', required: true, minLength: 6, shortMsg: 'Parola trebuie să aibă cel puțin 6 caractere.' },
      { name: 'confirm', required: true, match: 'password', matchMsg: 'Parolele nu coincid.' },
    ]);
  }
</script>
</body>
</html>