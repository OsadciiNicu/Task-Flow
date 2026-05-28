<?php
session_start();
$lang = 'ro';

$translations = [
  'ro' => [
    'title' => 'TaskFlow — Lista ta de sarcini',
    'nav_home' => 'Acasă',
    'nav_about' => 'Despre',
    'nav_features' => 'Funcționalități',
    'nav_dashboard' => 'Dashboard',
    'nav_contact' => 'Contact',
    'nav_login' => 'Autentificare',
    'nav_register' => 'Înregistrare',
    'nav_logout' => 'Deconectare',
    'hero_label' => 'Organizează-ți ziua',
    'hero_title' => 'Sarcinile tale,<br>sub control.',
    'hero_sub' => 'TaskFlow te ajută să îți gestionezi task-urile zilnice simplu și eficient. Adaugă, bifează, organizează — totul într-un singur loc.',
    'hero_btn_start' => 'Începe acum',
    'hero_btn_about' => 'Află mai mult',
    'stat_users' => 'Utilizatori',
    'stat_tasks' => 'Sarcini completate',
    'stat_days' => 'Zile de productivitate',
    'features_label' => 'Ce oferim',
    'features_title' => 'Funcționalități principale',
    'f1_title' => 'Adaugă sarcini rapid',
    'f1_desc' => 'Creează task-uri noi în câteva secunde, cu titlu și descriere.',
    'f2_title' => 'Marchează progresul',
    'f2_desc' => 'Bifează sarcinile completate și urmărește-ți evoluția zilnică.',
    'f3_title' => 'Organizare personală',
    'f3_desc' => 'Fiecare utilizator are propria listă privată, accesibilă după autentificare.',
    'f4_title' => 'Dark & Light Mode',
    'f4_desc' => 'Alege tema preferată pentru o experiență vizuală confortabilă.',
    'f5_title' => 'Multilingv',
    'f5_desc' => 'Interfața disponibilă în română, engleză și rusă.',
    'f6_title' => 'Disponibil Oriunde',
    'f6_desc' => 'Accesează TaskFlow de pe orice dispozitiv, oricând ai nevoie.',
    'about_label' => 'Despre TaskFlow',
    'about_title' => 'Productivitate maximă,<br>fără complicații.',
    'about_text' => 'TaskFlow este o aplicație web modernă creată pentru cei care vor să fie mereu organizați. Gestionează sarcinile zilnice cu ușurință, urmărește progresul și bucură-te de o interfață clară, rapidă și sigură — oriunde te-ai afla.',
    'footer_copy' => '© 2025 TaskFlow. Toate drepturile rezervate.',
    'logged_as' => 'Conectat ca',
  ],
];

$t = $translations[$lang];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $t['title'] ?></title>
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
      <li><a href="index.php" class="active"><?= $t['nav_home'] ?></a></li>
      <li><a href="#about"><?= $t['nav_about'] ?></a></li>
      <li><a href="#features"><?= $t['nav_features'] ?></a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li><a href="dashboard.php"><?= $t['nav_dashboard'] ?></a></li>
      <?php endif; ?>
      <li><a href="contact.php"><?= $t['nav_contact'] ?></a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li><a href="logout.php" class="btn-nav logout"><?= $t['nav_logout'] ?></a></li>
      <?php else: ?>
        <li><a href="login.php" class="btn-nav"><?= $t['nav_login'] ?></a></li>
        <li><a href="register.php" class="btn-nav primary"><?= $t['nav_register'] ?></a></li>
      <?php endif; ?>
    </ul>

    <div class="nav-controls">
      <!-- Theme toggle -->
      <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
        <span class="icon-sun">☀</span>
        <span class="icon-moon">☾</span>
      </button>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg">
    <div class="hero-blob blob1"></div>
    <div class="hero-blob blob2"></div>
    <div class="hero-grid"></div>
  </div>
  <div class="hero-content">
    <span class="hero-label"><?= $t['hero_label'] ?></span>
    <h1 class="hero-title"><?= $t['hero_title'] ?></h1>
    <p class="hero-sub"><?= $t['hero_sub'] ?></p>
    <div class="hero-actions">
      <a href="<?= isset($_SESSION['user']) ? 'dashboard.php' : 'register.php' ?>" class="btn-primary">
        <?= $t['hero_btn_start'] ?> →
      </a>
      <a href="#about" class="btn-ghost"><?= $t['hero_btn_about'] ?></a>
    </div>

    <?php if (isset($_SESSION['user'])): ?>
    <div class="user-pill">
      <span class="user-dot"></span>
      <?= $t['logged_as'] ?>: <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong>
    </div>
    <?php endif; ?>
  </div>

  <!-- Stats -->
  <div class="stats-bar">
    <div class="stat-item">
      <span class="stat-num" data-target="128">0</span>
      <span class="stat-label"><?= $t['stat_users'] ?></span>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
      <span class="stat-num" data-target="3420">0</span>
      <span class="stat-label"><?= $t['stat_tasks'] ?></span>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
      <span class="stat-num" data-target="365">0</span>
      <span class="stat-label"><?= $t['stat_days'] ?></span>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="features" id="features">
  <div class="section-container">
    <span class="section-label"><?= $t['features_label'] ?></span>
    <h2 class="section-title"><?= $t['features_title'] ?></h2>
    <div class="features-grid">
      <?php
      $icons = ['📝','✅','🔒','🌙','🌐','🚀'];
      $keys = ['f1','f2','f3','f4','f5','f6'];
      foreach($keys as $i => $k): ?>
      <div class="feature-card" style="--delay: <?= $i * 0.1 ?>s">
        <span class="feature-icon"><?= $icons[$i] ?></span>
        <h3><?= $t[$k.'_title'] ?></h3>
        <p><?= $t[$k.'_desc'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="about" id="about">
  <div class="section-container about-inner">
    <div class="about-visual">
      <div class="about-card">
        <div class="card-task done">✓ Cumpărături</div>
        <div class="card-task done">✓ Tema la matematică</div>
        <div class="card-task">○ Raport lunar echipă</div>
        <div class="card-task pending">○ Prezentare finală</div>
        <div class="card-progress">
          <div class="progress-bar"><div class="progress-fill" style="width:60%"></div></div>
          <span>60% complet</span>
        </div>
      </div>
    </div>
    <div class="about-text-block">
      <span class="section-label"><?= $t['about_label'] ?></span>
      <h2 class="section-title"><?= $t['about_title'] ?></h2>
      <p><?= $t['about_text'] ?></p>
      <a href="register.php" class="btn-primary"><?= $t['hero_btn_start'] ?> →</a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-inner">
    <span class="nav-logo"><span class="logo-icon">✦</span> TaskFlow</span>
    <p><?= $t['footer_copy'] ?></p>
    <div class="footer-links">
      <a href="index.php"><?= $t['nav_home'] ?></a>
      <a href="contact.php"><?= $t['nav_contact'] ?></a>
      <a href="login.php"><?= $t['nav_login'] ?></a>
    </div>
  </div>
</footer>

<script src="js/script.js"></script>
</body>
</html>
<?php
// Handle language change via GET
if (isset($_GET['lang']) && in_array($_GET['lang'], ['ro','en','ru'])) {
  $_SESSION['lang'] = $_GET['lang'];
  header('Location: index.php');
  exit;
}
?>
