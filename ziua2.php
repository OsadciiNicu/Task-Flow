<?php
// =============================================
// ziua2.php — Script de antrenament PHP
// Ziua 2: Mesaje în consolă și în browser
// =============================================

// ─── Mesaj în consolă (terminal) ─────────────
// Acest mesaj apare în CMD/terminal unde rulezi php
fwrite(STDERR, "[CONSOLA] Buna ziua! Acesta este primul meu script PHP - Osadcii Nicolae\n");

// ─── Mesaj în browser (web) ──────────────────
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ziua 2 — Script PHP</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
    }
    .card {
      background: white;
      border-radius: 12px;
      padding: 40px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 500px;
    }
    h1 { color: #2d6a4f; margin-bottom: 10px; }
    p  { color: #555; font-size: 1.1rem; }
    .badge {
      display: inline-block;
      background: #d8f3dc;
      color: #2d6a4f;
      padding: 6px 16px;
      border-radius: 999px;
      font-size: 0.85rem;
      margin-bottom: 20px;
    }
    .info { margin-top: 30px; text-align: left; border-top: 1px solid #eee; padding-top: 20px; }
    .info p { font-size: 0.9rem; color: #777; margin: 6px 0; }
    .info span { color: #2d6a4f; font-weight: bold; }
  </style>
</head>
<body>
<div class="card">
  <div class="badge">Ziua 2 — Antrenament PHP</div>
  <h1>✦ TaskFlow</h1>
  <p>Bună ziua! Acesta este primul meu script PHP.</p>
  <p><strong>Osadcii Nicolae — DAW-241</strong></p>

  <div class="info">
    <?php
      // Afișăm informații utile despre server și PHP
      echo "<p>📅 Data: <span>" . date('d.m.Y') . "</span></p>";
      echo "<p>⏰ Ora: <span>" . date('H:i:s') . "</span></p>";
      echo "<p>🐘 Versiune PHP: <span>" . phpversion() . "</span></p>";
      echo "<p>🌐 Server: <span>" . ($_SERVER['SERVER_SOFTWARE'] ?? 'PHP Built-in Server') . "</span></p>";
      echo "<p>📁 Fișier: <span>" . basename(__FILE__) . "</span></p>";
    ?>
  </div>
</div>
</body>
</html>
