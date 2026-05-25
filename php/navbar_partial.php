<?php
// php/navbar_partial.php — Shared navbar for all pages
// Requires session_start() and $lang to be set before including

$lang = $lang ?? $_SESSION['lang'] ?? 'ro';

// Handle language switch
if (isset($_GET['lang']) && in_array($_GET['lang'], ['ro','en','ru'])) {
  $_SESSION['lang'] = $_GET['lang'];
  // Redirect to same page without ?lang param
  $url = strtok($_SERVER['REQUEST_URI'], '?');
  header('Location: ' . $url);
  exit;
}

$nav = [
  'ro' => ['home'=>'Acasă','about'=>'Despre','features'=>'Funcționalități','dashboard'=>'Dashboard','contact'=>'Contact','login'=>'Autentificare','register'=>'Înregistrare','logout'=>'Deconectare'],
  'en' => ['home'=>'Home','about'=>'About','features'=>'Features','dashboard'=>'Dashboard','contact'=>'Contact','login'=>'Login','register'=>'Register','logout'=>'Logout'],
  'ru' => ['home'=>'Главная','about'=>'О проекте','features'=>'Функции','dashboard'=>'Панель','contact'=>'Контакт','login'=>'Войти','register'=>'Регистрация','logout'=>'Выйти'],
];
$n = $nav[$lang];

// Determine current page for active link
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar" id="navbar">
  <div class="nav-container">
    <a href="index.php" class="nav-logo">
      <span class="logo-icon">✦</span> TaskFlow
    </a>

    <button class="nav-toggle" id="navToggle" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>

    <ul class="nav-links" id="navLinks">
      <li><a href="index.php" <?= $currentPage==='index.php'?'class="active"':'' ?>><?= $n['home'] ?></a></li>
      <li><a href="index.php#about"><?= $n['about'] ?></a></li>
      <li><a href="index.php#features"><?= $n['features'] ?></a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li><a href="dashboard.php" <?= $currentPage==='dashboard.php'?'class="active"':'' ?>><?= $n['dashboard'] ?></a></li>
      <?php endif; ?>
      <li><a href="contact.php" <?= $currentPage==='contact.php'?'class="active"':'' ?>><?= $n['contact'] ?></a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li><a href="logout.php" class="btn-nav logout"><?= $n['logout'] ?></a></li>
      <?php else: ?>
        <li><a href="login.php" class="btn-nav <?= $currentPage==='login.php'?'active':'' ?>"><?= $n['login'] ?></a></li>
        <li><a href="register.php" class="btn-nav primary"><?= $n['register'] ?></a></li>
      <?php endif; ?>
    </ul>

    <div class="nav-controls">
      <div class="lang-switcher">
        <a href="?lang=ro" class="<?= $lang==='ro'?'active':'' ?>">RO</a>
        <a href="?lang=en" class="<?= $lang==='en'?'active':'' ?>">EN</a>
        <a href="?lang=ru" class="<?= $lang==='ru'?'active':'' ?>">RU</a>
      </div>
      <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
        <span class="icon-sun">☀</span>
        <span class="icon-moon">☾</span>
      </button>
    </div>
  </div>
</nav>
