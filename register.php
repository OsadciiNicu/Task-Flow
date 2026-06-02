<?php
session_start();

if (isset($_SESSION['user'])) {
  header('Location: dashboard.php');
  exit;
}

$eroare = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $parola   = $_POST['parola'] ?? '';
  $confirma = $_POST['confirma'] ?? '';

  // Validare date
  if (empty($username) || empty($email) || empty($parola) || empty($confirma)) {
    $eroare = 'Completează toate câmpurile.';
  } elseif (strlen($username) < 3) {
    $eroare = 'Numele de utilizator trebuie să aibă cel puțin 3 caractere.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $eroare = 'Adresa de email nu este validă.';
  } elseif (strlen($parola) < 6) {
    $eroare = 'Parola trebuie să aibă cel puțin 6 caractere.';
  } elseif ($parola !== $confirma) {
    $eroare = 'Parolele nu coincid.';
  } else {

    // Citire utilizatori existenti din JSON
    $fisier = 'data/users.json';
    $utilizatori = [];

    if (file_exists($fisier)) {
      $utilizatori = json_decode(file_get_contents($fisier), true) ?? [];
    }

    // Verificam daca username sau email exista deja
    foreach ($utilizatori as $u) {
      if (strtolower($u['username']) === strtolower($username)) {
        $eroare = 'Numele de utilizator este deja folosit.';
        break;
      }
      if (strtolower($u['email']) === strtolower($email)) {
        $eroare = 'Adresa de email este deja înregistrată.';
        break;
      }
    }

    // Daca nu exista eroare, adaugam utilizatorul nou
    if (empty($eroare)) {
      $utilizatorNou = [
        'id'         => uniqid('u_', true),
        'username'   => $username,
        'email'      => $email,
        'password'   => password_hash($parola, PASSWORD_DEFAULT),
        'created_at' => date('Y-m-d H:i:s'),
      ];

      $utilizatori[] = $utilizatorNou;

      // Salvare in fisierul JSON
      file_put_contents(
        $fisier,
        json_encode($utilizatori, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
      );

      // Redirectam la login cu mesaj de succes
      header('Location: login.php?inregistrat=1');
      exit;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ro" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Înregistrare — TaskFlow</title>
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
      <li><a href="login.php" class="btn-nav">Autentificare</a></li>
      <li><a href="register.php" class="btn-nav primary active">Înregistrare</a></li>
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
    <h1>Cont nou</h1>
    <p class="subtitle">Creează-ți contul TaskFlow gratuit.</p>

    <?php if ($eroare): ?>
      <div class="alert alert-error"><?= htmlspecialchars($eroare) ?></div>
    <?php endif; ?>

    <form id="registerForm" method="POST" novalidate>
      <div class="form-group">
        <label for="username">Nume utilizator</label>
        <input type="text" id="username" name="username"
               placeholder="ex: ion_popescu"
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        <span class="error-msg">Minim 3 caractere.</span>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email"
               placeholder="ex: ion@email.com"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <span class="error-msg">Introdu un email valid.</span>
      </div>

      <div class="form-group">
        <label for="parola">Parolă</label>
        <input type="password" id="parola" name="parola"
               placeholder="Minim 6 caractere">
        <span class="error-msg">Parola trebuie să aibă cel puțin 6 caractere.</span>
      </div>

      <div class="form-group">
        <label for="confirma">Confirmă parola</label>
        <input type="password" id="confirma" name="confirma"
               placeholder="Repetă parola">
        <span class="error-msg">Parolele nu coincid.</span>
      </div>

      <button type="submit" class="form-submit">Creează cont</button>
    </form>

    <p class="form-link">Ai deja cont? <a href="login.php">Autentifică-te</a></p>
  </div>
</div>

<script src="js/script.js"></script>
<script>
  validateForm('registerForm', [
    { name: 'username', required: true, minLength: 3,  shortMsg: 'Minim 3 caractere.' },
    { name: 'email',    required: true, email: true,   emailMsg: 'Introdu un email valid.' },
    { name: 'parola',   required: true, minLength: 6,  shortMsg: 'Parola trebuie să aibă cel puțin 6 caractere.' },
    { name: 'confirma', required: true, match: 'parola', matchMsg: 'Parolele nu coincid.' },
  ]);
</script>
</body>
</html>