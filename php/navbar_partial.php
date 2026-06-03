<?php
// php/navbar_partial.php — Navbar partajat pentru toate paginile
// Necesita session_start() inainte de includere

// Determin pagina curenta pentru link activ
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
      <li><a href="index.php" <?= $currentPage === 'index.php' ? 'class="active"' : '' ?>>Acasă</a></li>
      <li><a href="index.php#about">Despre</a></li>
      <li><a href="index.php#features">Funcționalități</a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li><a href="dashboard.php" <?= $currentPage === 'dashboard.php' ? 'class="active"' : '' ?>>Dashboard</a></li>
      <?php endif; ?>
      <li><a href="contact.php" <?= $currentPage === 'contact.php' ? 'class="active"' : '' ?>>Contact</a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li><a href="logout.php" class="btn-nav logout">Deconectare</a></li>
      <?php else: ?>
        <li><a href="login.php" class="btn-nav <?= $currentPage === 'login.php' ? 'active' : '' ?>">Autentificare</a></li>
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