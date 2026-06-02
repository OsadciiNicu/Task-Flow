<?php
session_start();

if (isset($_SESSION['user'])) {
  header('Location: dashboard.php');
  exit;
}

$eroare = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $parola   = $_POST['parola'] ?? '';

  // Validare campuri goale
  if (empty($username) || empty($parola)) {
    $eroare = 'Completează toate câmpurile.';
  } else {
    // Citire utilizatori din JSON
    $fisier = 'data/users.json';
    $utilizatori = [];

    if (file_exists($fisier)) {
      $utilizatori = json_decode(file_get_contents($fisier), true) ?? [];
    }

    // Cautare utilizator
    $gasit = false;
    foreach ($utilizatori as $u) {
      if (strtolower($u['username']) === strtolower($username)) {
        if (password_verify($parola, $u['password'])) {
          // Autentificare reusita
          $sesiune = $u;
          unset($sesiune['password']);
          $_SESSION['user'] = $sesiune;
          header('Location: dashboard.php');
          exit;
        } else {
          $eroare = 'Parolă incorectă.';
          $gasit = true;
          break;
        }
      }
    }

    if (!$gasit && empty($eroare)) {
      $eroare = 'Utilizatorul nu a fost găsit.';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ro" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Autentificare — TaskFlow</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
  <div class="nav-container">
    <a href="index.php" class="nav-logo">
      <span class="logo-icon">✦</span> TaskFlow
    </a>
    <button class="nav-toggle" id="navToggle" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
    <ul class="nav-links" id="navLinks">
      <li><a href="index.php">Acasă</a></li>
      <li><a href="index.php#about">Despre</a></li>
      <li><a href="index.php#features">Funcționalități</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="login.php" class="btn-nav active">Autentificare</a></li>
      <li><a href="register.php" class="btn-nav primary">Înregistrare</a></li>
    </ul>
    <div class="nav-controls">
      <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
        <span class="icon-sun">☀</span>
        <span class="icon-moon">☾</span>
      </button>
    </div>
  </div>
</nav>

<div class="form-page">
  <div class="form-card">
    <h1>Autentificare</h1>
    <p class="subtitle">Bine ai revenit! Intră în contul tău.</p>

    <?php if ($eroare): ?>
      <div class="alert alert-error"><?= htmlspecialchars($eroare) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['inregistrat'])): ?>
      <div class="alert alert-success">Cont creat cu succes! Te poți autentifica.</div>
    <?php endif; ?>

    <form id="loginForm" method="POST" novalidate>
      <div class="form-group">
        <label for="username">Nume utilizator</label>
        <input type="text" id="username" name="username"
               placeholder="ex: ion_popescu"
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
               autocomplete="username">
        <span class="error-msg">Câmpul este obligatoriu.</span>
      </div>

      <div class="form-group">
        <label for="parola">Parolă</label>
        <input type="password" id="parola" name="parola"
               placeholder="••••••••"
               autocomplete="current-password">
        <span class="error-msg">Câmpul este obligatoriu.</span>
      </div>

      <button type="submit" class="form-submit">Intră în cont</button>
    </form>

    <p class="form-link">Nu ai cont? <a href="register.php">Înregistrează-te</a></p>
  </div>
</div>

<script src="js/script.js"></script>
<script>
  validateForm('loginForm', [
    { name: 'username', required: true },
    { name: 'parola',   required: true },
  ]);
</script>
</body>
</html>