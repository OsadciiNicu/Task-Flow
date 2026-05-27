<?php
// =============================================
// Ziua 3 — Flow control: if + for
// Verificare numere pare și impare
// =============================================

$numere = [4, 7, 12, 3, 8, 15, 22, 9, 6, 11];

$pare   = 0;
$impare = 0;

for ($i = 0; $i < count($numere); $i++) {
    if ($numere[$i] % 2 == 0) {
        $pare++;
    } else {
        $impare++;
    }
}
?>

<!-- Ziua 3 — afișare în browser -->
<div class="card" style="margin-top: 30px;">
  <div class="badge" style="background:#fde8e1; color:#e76f51;">Ziua 3 — Flow Control PHP</div>
  <h1 style="color:#e76f51;">Numere pare și impare</h1>

  <div class="info">
    <?php
      echo "<p>📋 Șirul de numere: <span>" . implode(", ", $numere) . "</span></p>";
      echo "<p>✅ Numere pare: <span>" . $pare . "</span></p>";
      echo "<p>❌ Numere impare: <span>" . $impare . "</span></p>";

      // Afișăm fiecare număr cu tipul lui
      echo "<p style='margin-top:12px;'><strong>Detalii:</strong></p>";
      for ($i = 0; $i < count($numere); $i++) {
          $tip = ($numere[$i] % 2 == 0) ? "par" : "impar";
          echo "<p>{$numere[$i]} → <span>{$tip}</span></p>";
      }
    ?>
  </div>
</div>
