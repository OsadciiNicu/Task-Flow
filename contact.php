<?php
session_start();

$mesaj = '';
$tipMesaj = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nume    = trim($_POST['nume'] ?? '');
  $email   = trim($_POST['email'] ?? '');
  $subiect = trim($_POST['subiect'] ?? '');
  $text    = trim($_POST['mesaj'] ?? '');

  // Validare date
  if (empty($nume) || empty($email) || empty($text)) {
    $mesaj = 'Te rugăm să completezi toate câmpurile obligatorii.';
    $tipMesaj = 'error';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $mesaj = 'Adresa de email nu este validă.';
    $tipMesaj = 'error';
  } else {
    // Salvare in fisier JSON
    $feedback = [];
    $fisier = 'data/feedback.json';

    if (file_exists($fisier)) {
      $feedback = json_decode(file_get_contents($fisier), true) ?? [];
    }

    $feedback[] = [
      'id'         => uniqid('f_', true),
      'nume'       => $nume,
      'email'      => $email,
      'subiect'    => $subiect,
      'mesaj'      => $text,
      'data'       => date('Y-m-d H:i:s'),
    ];

    file_put_contents($fisier, json_encode($feedback, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    $mesaj = 'Mesajul tău a fost trimis cu succes! Îți mulțumim.';
    $tipMesaj = 'success';

    // Golim datele dupa trimitere cu succes
    $_POST = [];
  }
}
?>
<!DOCTYPE html>
<html lang="ro" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact — TaskFlow</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
  <style>
    .form-group textarea { min-height: 130px; resize: vertical; }
  </style>
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
      <?php if (isset($_SESSION['user'])): ?>
        <li><a href="dashboard.php">Dashboard</a></li>
      <?php endif; ?>
      <li><a href="contact.php" class="active">Contact</a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li><a href="logout.php" class="btn-nav logout">Deconectare</a></li>
      <?php else: ?>
        <li><a href="login.php" class="btn-nav">Autentificare</a></li>
        <li><a href="register.php" class="btn-nav primary">Înregistrare</a></li>
      <?php endif; ?>
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
  <div class="form-card" style="max-width:520px;">
    <h1>Contact</h1>
    <p class="subtitle">Ai întrebări sau sugestii? Scrie-ne!</p>

    <?php if ($mesaj): ?>
      <div class="alert alert-<?= $tipMesaj ?>">
        <?= htmlspecialchars($mesaj) ?>
      </div>
    <?php endif; ?>

    <form id="contactForm" method="POST" novalidate>
      <div class="form-group">
        <label>Nume *</label>
        <input type="text" name="nume"
               placeholder="Numele tău"
               value="<?= htmlspecialchars($_POST['nume'] ?? '') ?>">
        <span class="error-msg">Numele este obligatoriu.</span>
      </div>

      <div class="form-group">
        <label>Email *</label>
        <input type="email" name="email"
               placeholder="email@exemplu.com"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <span class="error-msg">Introdu un email valid.</span>
      </div>

      <div class="form-group">
        <label>Subiect (opțional)</label>
        <input type="text" name="subiect"
               placeholder="Subiectul mesajului"
               value="<?= htmlspecialchars($_POST['subiect'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label>Mesaj *</label>
        <textarea name="mesaj" placeholder="Scrie mesajul tău aici..."><?= htmlspecialchars($_POST['mesaj'] ?? '') ?></textarea>
        <span class="error-msg">Mesajul este obligatoriu.</span>
      </div>

      <button type="submit" class="form-submit">Trimite mesajul</button>
    </form>
  </div>
</div>

<script src="js/script.js"></script>
<script>
  validateForm('contactForm', [
    { name: 'nume',  required: true },
    { name: 'email', required: true, email: true, emailMsg: 'Introdu un email valid.' },
    { name: 'mesaj', required: true },
  ]);
</script>
</body>
</html>