<?php
session_start();
require_once 'php/functions.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name    = trim($_POST['name'] ?? '');
  $email   = trim($_POST['email'] ?? '');
  $subject = trim($_POST['subject'] ?? '');
  $msg     = trim($_POST['message'] ?? '');

  if ($name && $email && $msg) {
    saveFeedback($name, $email, $subject, $msg);
    $message = 'Mesajul tău a fost trimis! Îți mulțumim pentru feedback.';
    $messageType = 'success';
  } else {
    $message = 'Te rugăm să completezi toate câmpurile obligatorii.';
    $messageType = 'error';
  }
}

// Tema (din cookie, implicit light)
$tema = $_COOKIE['theme'] ?? 'light';
?>
<!DOCTYPE html>
<html lang="ro" data-theme="<?= $tema ?>">
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
<?php include 'php/navbar_partial.php'; ?>

<div class="form-page">
  <div class="form-card" style="max-width:520px;">
    <h1>Contact</h1>
    <p class="subtitle">Ai întrebări sau sugestii? Scrie-ne!</p>

    <?php if ($message): ?>
      <div class="alert alert-<?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form id="contactForm" method="POST" novalidate>
      <div class="form-group">
        <label>Nume *</label>
        <input type="text" name="name" placeholder="Numele tău" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        <span class="error-msg">Numele este obligatoriu.</span>
      </div>
      <div class="form-group">
        <label>Email *</label>
        <input type="email" name="email" placeholder="email@exemplu.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <span class="error-msg">Introdu un email valid.</span>
      </div>
      <div class="form-group">
        <label>Subiect (opțional)</label>
        <input type="text" name="subject" placeholder="Subiectul mesajului" value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">
      </div>
      <div class="form-group">
        <label>Mesaj *</label>
        <textarea name="message" placeholder="Scrie mesajul tău aici..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        <span class="error-msg">Mesajul este obligatoriu.</span>
      </div>
      <button type="submit" class="form-submit">Trimite mesajul</button>
    </form>
  </div>
</div>

<script src="js/script.js"></script>
<script>
  if (typeof validateForm === 'function') {
    validateForm('contactForm', [
      { name: 'name', required: true },
      { name: 'email', required: true, email: true },
      { name: 'message', required: true },
    ]);
  }

  // Toggle tema (dacă butonul există în navbar)
  const themeToggle = document.getElementById('themeToggle');
  if (themeToggle) {
    themeToggle.addEventListener('click', () => {
      const html = document.documentElement;
      const currentTheme = html.getAttribute('data-theme');
      const newTheme = currentTheme === 'light' ? 'dark' : 'light';
      html.setAttribute('data-theme', newTheme);
      document.cookie = `theme=${newTheme}; path=/; max-age=31536000`;
    });
  }

  // Mobile menu toggle
  const navToggle = document.getElementById('navToggle');
  const navLinks = document.getElementById('navLinks');
  if (navToggle && navLinks) {
    navToggle.addEventListener('click', () => {
      navLinks.classList.toggle('open');
    });
  }
</script>
</body>
</html>