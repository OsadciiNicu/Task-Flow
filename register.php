<?php
session_start();
require_once 'php/auth.php';

if (isset($_SESSION['user'])) {
  header('Location: dashboard.php');
  exit;
}

$lang = $_SESSION['lang'] ?? 'ro';
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

$labels = [
  'ro' => ['title'=>'Cont nou','subtitle'=>'Creează-ți contul TaskFlow gratuit.','user'=>'Nume utilizator','email'=>'Email','pass'=>'Parolă','confirm'=>'Confirmă parola','btn'=>'Creează cont','have_acc'=>'Ai deja cont?','login'=>'Autentifică-te'],
  'en' => ['title'=>'Create Account','subtitle'=>'Sign up for TaskFlow for free.','user'=>'Username','email'=>'Email','pass'=>'Password','confirm'=>'Confirm password','btn'=>'Create account','have_acc'=>'Already have an account?','login'=>'Sign in'],
  'ru' => ['title'=>'Новый аккаунт','subtitle'=>'Зарегистрируйтесь в TaskFlow бесплатно.','user'=>'Имя пользователя','email'=>'Email','pass'=>'Пароль','confirm'=>'Подтвердите пароль','btn'=>'Создать аккаунт','have_acc'=>'Уже есть аккаунт?','login'=>'Войти'],
];
$l = $labels[$lang];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $l['title'] ?> — TaskFlow</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php include 'php/navbar_partial.php'; ?>

<div class="form-page">
  <div class="form-card">
    <h1><?= $l['title'] ?></h1>
    <p class="subtitle"><?= $l['subtitle'] ?></p>

    <?php if ($error): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form id="registerForm" method="POST" novalidate>
      <div class="form-group">
        <label for="username"><?= $l['user'] ?></label>
        <input type="text" id="username" name="username" placeholder="ex: ion_popescu"
               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        <span class="error-msg"></span>
      </div>
      <div class="form-group">
        <label for="email"><?= $l['email'] ?></label>
        <input type="email" id="email" name="email" placeholder="ex: ion@email.com"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <span class="error-msg"></span>
      </div>
      <div class="form-group">
        <label for="password"><?= $l['pass'] ?></label>
        <input type="password" id="password" name="password" placeholder="Minim 6 caractere">
        <span class="error-msg"></span>
      </div>
      <div class="form-group">
        <label for="confirm"><?= $l['confirm'] ?></label>
        <input type="password" id="confirm" name="confirm" placeholder="Repetă parola">
        <span class="error-msg"></span>
      </div>
      <button type="submit" class="form-submit"><?= $l['btn'] ?></button>
    </form>

    <p class="form-link"><?= $l['have_acc'] ?> <a href="login.php"><?= $l['login'] ?></a></p>
  </div>
</div>

<script src="js/script.js"></script>
<script>
  validateForm('registerForm', [
    { name: 'username', required: true, minLength: 3, shortMsg: 'Minim 3 caractere.' },
    { name: 'email', required: true, email: true, emailMsg: 'Introdu un email valid.' },
    { name: 'password', required: true, minLength: 6, shortMsg: 'Parola trebuie să aibă cel puțin 6 caractere.' },
    { name: 'confirm', required: true, match: 'password', matchMsg: 'Parolele nu coincid.' },
  ]);
</script>
</body>
</html>
