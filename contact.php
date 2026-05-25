<?php
session_start();
require_once 'php/functions.php';

$lang = $_SESSION['lang'] ?? 'ro';
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

$labels = [
  'ro' => ['title'=>'Contact','subtitle'=>'Ai întrebări sau sugestii? Scrie-ne!','name'=>'Nume','email'=>'Email','subject'=>'Subiect (opțional)','message'=>'Mesaj','btn'=>'Trimite mesajul'],
  'en' => ['title'=>'Contact','subtitle'=>'Have questions or suggestions? Write to us!','name'=>'Name','email'=>'Email','subject'=>'Subject (optional)','message'=>'Message','btn'=>'Send message'],
  'ru' => ['title'=>'Контакт','subtitle'=>'Есть вопросы или предложения? Напишите нам!','name'=>'Имя','email'=>'Email','subject'=>'Тема (необязательно)','message'=>'Сообщение','btn'=>'Отправить сообщение'],
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
  <style>
    .form-group textarea { min-height: 130px; resize: vertical; }
  </style>
</head>
<body>
<?php include 'php/navbar_partial.php'; ?>

<div class="form-page">
  <div class="form-card" style="max-width:520px;">
    <h1><?= $l['title'] ?></h1>
    <p class="subtitle"><?= $l['subtitle'] ?></p>

    <?php if ($message): ?>
      <div class="alert alert-<?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form id="contactForm" method="POST" novalidate>
      <div class="form-group">
        <label><?= $l['name'] ?> *</label>
        <input type="text" name="name" placeholder="Numele tău" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        <span class="error-msg">Numele este obligatoriu.</span>
      </div>
      <div class="form-group">
        <label><?= $l['email'] ?> *</label>
        <input type="email" name="email" placeholder="email@exemplu.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <span class="error-msg">Introdu un email valid.</span>
      </div>
      <div class="form-group">
        <label><?= $l['subject'] ?></label>
        <input type="text" name="subject" placeholder="Subiectul mesajului" value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">
      </div>
      <div class="form-group">
        <label><?= $l['message'] ?> *</label>
        <textarea name="message" placeholder="Scrie mesajul tău aici..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        <span class="error-msg">Mesajul este obligatoriu.</span>
      </div>
      <button type="submit" class="form-submit"><?= $l['btn'] ?></button>
    </form>
  </div>
</div>

<script src="js/script.js"></script>
<script>
  validateForm('contactForm', [
    { name: 'name', required: true },
    { name: 'email', required: true, email: true },
    { name: 'message', required: true },
  ]);
</script>
</body>
</html>
