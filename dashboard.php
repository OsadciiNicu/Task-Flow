<?php
session_start();
require_once 'php/auth.php';
require_once 'php/functions.php';

// Pagina protejata - redirect daca nu e logat
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$user = $_SESSION['user'];
$message = '';
$messageType = '';

// Procesare actiuni
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'add') {
    $title = trim($_POST['title'] ?? '');
    $desc  = trim($_POST['desc'] ?? '');
    if ($title) {
      addTask($user['id'], $title, $desc);
      $message = 'Sarcina a fost adăugată!';
      $messageType = 'success';
    } else {
      $message = 'Titlul sarcinii este obligatoriu.';
      $messageType = 'error';
    }
  } elseif ($action === 'toggle') {
    $taskId = $_POST['task_id'] ?? '';
    toggleTask($user['id'], $taskId);
    header('Location: dashboard.php');
    exit;
  } elseif ($action === 'delete') {
    $taskId = $_POST['task_id'] ?? '';
    deleteTask($user['id'], $taskId);
    $message = 'Sarcina a fost ștearsă.';
    $messageType = 'success';
  } elseif ($action === 'edit') {
    $taskId = $_POST['task_id'] ?? '';
    $title  = trim($_POST['title'] ?? '');
    $desc   = trim($_POST['desc'] ?? '');
    if ($title) {
      editTask($user['id'], $taskId, $title, $desc);
      $message = 'Sarcina a fost actualizată!';
      $messageType = 'success';
    }
  }
}

$tasks = getUserTasks($user['id']);
$done  = array_filter($tasks, fn($t) => $t['done']);
$total = count($tasks);
$doneCount = count($done);
$percent = $total > 0 ? round(($doneCount / $total) * 100) : 0;

// Tema (din cookie, implicit light)
$tema = $_COOKIE['theme'] ?? 'light';
?>
<!DOCTYPE html>
<html lang="ro" data-theme="<?= $tema ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard — TaskFlow</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
  <style>
    .task-list { display: flex; flex-direction: column; gap: 12px; margin-top: 24px; }
    .task-item {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 18px 20px;
      display: flex;
      align-items: flex-start;
      gap: 16px;
      transition: all 0.2s;
      animation: fadeUp 0.3s ease both;
    }
    .task-item.is-done { opacity: 0.6; }
    .task-item.is-done .task-title { text-decoration: line-through; color: var(--text-muted); }
    .task-check {
      width: 22px; height: 22px;
      border: 2px solid var(--border);
      border-radius: 6px;
      flex-shrink: 0;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      background: var(--bg);
      transition: all 0.2s;
      margin-top: 2px;
    }
    .task-item.is-done .task-check {
      background: var(--accent);
      border-color: var(--accent);
      color: #fff;
    }
    .task-body { flex: 1; min-width: 0; }
    .task-title { font-weight: 500; font-size: 0.95rem; margin-bottom: 4px; }
    .task-desc  { font-size: 0.83rem; color: var(--text-muted); }
    .task-meta  { font-size: 0.75rem; color: var(--text-muted); margin-top: 6px; }
    .task-actions { display: flex; gap: 8px; flex-shrink: 0; }
    .task-btn {
      padding: 6px 12px; border-radius: 6px; border: 1px solid var(--border);
      background: var(--bg); color: var(--text-muted);
      font-size: 0.78rem; cursor: pointer; transition: all 0.2s;
    }
    .task-btn:hover { background: var(--surface2); color: var(--text); }
    .task-btn.danger { border-color: var(--accent2); color: var(--accent2); }
    .task-btn.danger:hover { background: var(--accent2-light); }

    .add-form {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 24px;
      margin-bottom: 32px;
    }
    .add-form h3 { font-family: var(--font-head); font-size: 1rem; margin-bottom: 16px; }
    .add-row { display: flex; gap: 12px; flex-wrap: wrap; }
    .add-row input { flex: 1; min-width: 180px; }
    .add-row .form-group { flex: 1; margin: 0; }

    .stats-row {
      display: grid; grid-template-columns: repeat(3,1fr);
      gap: 16px; margin-bottom: 32px;
    }
    .stat-box {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 20px;
      text-align: center;
    }
    .stat-box .num {
      font-family: var(--font-head);
      font-size: 2rem; font-weight: 800;
      color: var(--accent);
    }
    .stat-box .lbl { font-size: 0.8rem; color: var(--text-muted); margin-top: 4px; }

    .progress-section {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 20px 24px;
      margin-bottom: 32px;
    }
    .progress-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .progress-top span { font-size: 0.88rem; color: var(--text-muted); }
    .progress-top strong { font-family: var(--font-head); font-size: 1.1rem; }
    .progress-bar-lg { height: 10px; background: var(--bg-alt); border-radius: 999px; overflow: hidden; }
    .progress-fill-lg { height: 100%; background: var(--accent); border-radius: 999px; transition: width 1s ease; }

    .edit-modal {
      display: none;
      position: fixed; inset: 0;
      background: rgba(0,0,0,0.5);
      z-index: 2000;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }
    .edit-modal.open { display: flex; }
    .edit-modal-card {
      background: var(--surface);
      border-radius: var(--radius-lg);
      padding: 36px;
      width: 100%; max-width: 440px;
      animation: fadeUp 0.3s ease both;
    }
    .edit-modal-card h2 { font-family: var(--font-head); margin-bottom: 20px; }
    .modal-actions { display: flex; gap: 12px; margin-top: 20px; }

    @media (max-width: 600px) {
      .stats-row { grid-template-columns: 1fr 1fr; }
    }
  </style>
</head>
<body>
<?php include 'php/navbar_partial.php'; ?>

<div class="dashboard-page">
  <div class="dashboard-header">
    <div>
      <h1>Bună ziua, <?= htmlspecialchars($user['username']) ?> 👋</h1>
      <p style="color:var(--text-muted);font-size:0.9rem;margin-top:6px;"><?= date('l, d F Y') ?></p>
    </div>
  </div>

  <?php if ($message): ?>
    <div class="alert alert-<?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <!-- Statistici -->
  <div class="stats-row">
    <div class="stat-box">
      <div class="num"><?= $total ?></div>
      <div class="lbl">Total sarcini</div>
    </div>
    <div class="stat-box">
      <div class="num" style="color:var(--accent)"><?= $doneCount ?></div>
      <div class="lbl">Finalizate</div>
    </div>
    <div class="stat-box">
      <div class="num" style="color:var(--accent2)"><?= $total - $doneCount ?></div>
      <div class="lbl">Rămase</div>
    </div>
  </div>

  <!-- Progres -->
  <div class="progress-section">
    <div class="progress-top">
      <span>Progres</span>
      <strong><?= $percent ?>%</strong>
    </div>
    <div class="progress-bar-lg">
      <div class="progress-fill-lg" style="width:<?= $percent ?>%"></div>
    </div>
  </div>

  <!-- Formular adaugare sarcina -->
  <div class="add-form">
    <h3>Adaugă sarcină</h3>
    <form method="POST" id="addTaskForm" novalidate>
      <input type="hidden" name="action" value="add">
      <div class="add-row">
        <div class="form-group">
          <input type="text" name="title" placeholder="Titlu sarcină" autocomplete="off">
          <span class="error-msg">Titlul este obligatoriu.</span>
        </div>
        <div class="form-group">
          <input type="text" name="desc" placeholder="Descriere (opțional)" autocomplete="off">
        </div>
      </div>
      <button type="submit" class="btn-primary" style="margin-top:12px;">Adaugă +</button>
    </form>
  </div>

  <!-- Lista sarcini -->
  <h2 style="font-family:var(--font-head);font-size:1.2rem;margin-bottom:4px;">Sarcinile tale</h2>

  <?php if (empty($tasks)): ?>
    <p style="color:var(--text-muted);margin-top:20px;text-align:center;padding:40px 0;">Nu ai sarcini încă. Adaugă prima ta sarcină!</p>
  <?php else: ?>
  <div class="task-list">
    <?php foreach ($tasks as $task): ?>
    <div class="task-item <?= $task['done'] ? 'is-done' : '' ?>">
      <!-- Toggle done -->
      <form method="POST" style="margin:0;">
        <input type="hidden" name="action" value="toggle">
        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
        <button type="submit" class="task-check" title="Bifează">
          <?= $task['done'] ? '✓' : '' ?>
        </button>
      </form>
      <div class="task-body">
        <div class="task-title"><?= htmlspecialchars($task['title']) ?></div>
        <?php if ($task['desc']): ?>
          <div class="task-desc"><?= htmlspecialchars($task['desc']) ?></div>
        <?php endif; ?>
        <div class="task-meta"><?= $task['created_at'] ?></div>
      </div>
      <div class="task-actions">
        <button class="task-btn" onclick="openEdit('<?= $task['id'] ?>','<?= htmlspecialchars(addslashes($task['title'])) ?>','<?= htmlspecialchars(addslashes($task['desc'])) ?>')">
          ✎ Editează
        </button>
        <form method="POST" style="margin:0;" onsubmit="return confirm('Sigur vrei să ștergi?')">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
          <button type="submit" class="task-btn danger">✕ Șterge</button>
        </form>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>

<!-- Modal Editare -->
<div class="edit-modal" id="editModal">
  <div class="edit-modal-card">
    <h2>Editează sarcina</h2>
    <form method="POST" id="editForm">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" name="task_id" id="editTaskId">
      <div class="form-group">
        <label>Titlu</label>
        <input type="text" name="title" id="editTitle">
        <span class="error-msg">Titlul este obligatoriu.</span>
      </div>
      <div class="form-group">
        <label>Descriere</label>
        <input type="text" name="desc" id="editDesc">
      </div>
      <div class="modal-actions">
        <button type="submit" class="btn-primary">Salvează</button>
        <button type="button" class="btn-ghost" onclick="closeEdit()">Anulează</button>
      </div>
    </form>
  </div>
</div>

<script src="js/script.js"></script>
<script>
  if (typeof validateForm === 'function') {
    validateForm('addTaskForm', [
      { name: 'title', required: true, emptyMsg: 'Titlul este obligatoriu.' }
    ]);
  }

  // Toggle tema
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

  // Mobile menu
  const navToggle = document.getElementById('navToggle');
  const navLinks = document.getElementById('navLinks');
  if (navToggle && navLinks) {
    navToggle.addEventListener('click', () => {
      navLinks.classList.toggle('open');
    });
  }

  function openEdit(id, title, desc) {
    document.getElementById('editTaskId').value = id;
    document.getElementById('editTitle').value = title;
    document.getElementById('editDesc').value = desc;
    document.getElementById('editModal').classList.add('open');
  }
  function closeEdit() {
    document.getElementById('editModal').classList.remove('open');
  }
  document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEdit();
  });
</script>
</body>
</html>