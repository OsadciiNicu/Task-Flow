<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ro" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TaskFlow — Lista ta de sarcini</title>
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
      <li><a href="index.php" class="active">Acasă</a></li>
      <li><a href="#about">Despre</a></li>
      <li><a href="#features">Funcționalități</a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li><a href="dashboard.php">Dashboard</a></li>
      <?php endif; ?>
      <li><a href="contact.php">Contact</a></li>
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
 
<!-- HERO -->
<section class="hero">
  <div class="hero-bg">
    <div class="hero-blob blob1"></div>
    <div class="hero-blob blob2"></div>
    <div class="hero-grid"></div>
  </div>
  <div class="hero-content">
    <span class="hero-label">Organizează-ți ziua</span>
    <h1 class="hero-title">Sarcinile tale,<br>sub control.</h1>
    <p class="hero-sub">TaskFlow te ajută să îți gestionezi task-urile zilnice simplu și eficient. Adaugă, bifează, organizează — totul într-un singur loc.</p>
    <div class="hero-actions">
      <a href="<?= isset($_SESSION['user']) ? 'dashboard.php' : 'register.php' ?>" class="btn-primary">
        Începe acum →
      </a>
      <a href="#about" class="btn-ghost">Află mai mult</a>
    </div>
 
    <?php if (isset($_SESSION['user'])): ?>
    <div class="user-pill">
      <span class="user-dot"></span>
      Conectat ca: <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong>
    </div>
    <?php endif; ?>
  </div>
 
  <!-- Stats -->
  <div class="stats-bar">
    <div class="stat-item">
      <span class="stat-num" data-target="128">0</span>
      <span class="stat-label">Utilizatori</span>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
      <span class="stat-num" data-target="3420">0</span>
      <span class="stat-label">Sarcini completate</span>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
      <span class="stat-num" data-target="365">0</span>
      <span class="stat-label">Zile de productivitate</span>
    </div>
  </div>
</section>
 
<!-- FEATURES -->
<section class="features" id="features">
  <div class="section-container">
    <span class="section-label">Ce oferim</span>
    <h2 class="section-title">Funcționalități principale</h2>
    <div class="features-grid">
      <div class="feature-card" style="--delay:0s">
        <span class="feature-icon">📝</span>
        <h3>Adaugă sarcini rapid</h3>
        <p>Creează task-uri noi în câteva secunde, cu titlu și descriere.</p>
      </div>
      <div class="feature-card" style="--delay:0.1s">
        <span class="feature-icon">✅</span>
        <h3>Marchează progresul</h3>
        <p>Bifează sarcinile completate și urmărește-ți evoluția zilnică.</p>
      </div>
      <div class="feature-card" style="--delay:0.2s">
        <span class="feature-icon">🔒</span>
        <h3>Organizare personală</h3>
        <p>Fiecare utilizator are propria listă privată, accesibilă după autentificare.</p>
      </div>
      <div class="feature-card" style="--delay:0.3s">
        <span class="feature-icon">🌙</span>
        <h3>Dark & Light Mode</h3>
        <p>Alege tema preferată pentru o experiență vizuală confortabilă.</p>
      </div>
      <div class="feature-card" style="--delay:0.4s">
        <span class="feature-icon">🌐</span>
        <h3>Multilingv</h3>
        <p>Interfața disponibilă în română, engleză și rusă.</p>
      </div>
      <div class="feature-card" style="--delay:0.5s">
        <span class="feature-icon">🚀</span>
        <h3>Disponibil Oriunde</h3>
        <p>Accesează TaskFlow de pe orice dispozitiv, oricând ai nevoie.</p>
      </div>
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
      <span class="section-label">Despre TaskFlow</span>
      <h2 class="section-title">Productivitate maximă,<br>fără complicații.</h2>
      <p>TaskFlow este o aplicație web modernă creată pentru cei care vor să fie mereu organizați. Gestionează sarcinile zilnice cu ușurință, urmărește progresul și bucură-te de o interfață clară, rapidă și sigură — oriunde te-ai afla.</p>
      <a href="register.php" class="btn-primary">Începe acum →</a>
    </div>
  </div>
</section>
 
<!-- FOOTER -->
<footer class="footer">
  <div class="footer-inner">
    <span class="nav-logo"><span class="logo-icon">✦</span> TaskFlow</span>
    <p>© 2025 TaskFlow. Toate drepturile rezervate.</p>
    <div class="footer-links">
      <a href="index.php">Acasă</a>
      <a href="contact.php">Contact</a>
      <a href="login.php">Autentificare</a>
    </div>
  </div>
</footer>
 
<script src="js/script.js"></script>
</body>
</html>