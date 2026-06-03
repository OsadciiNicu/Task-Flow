<?php
// php/functions.php — Task & Feedback management

define('ITEMS_FILE',    __DIR__ . '/../data/items.json');
define('FEEDBACK_FILE', __DIR__ . '/../data/feedback.json');

// ─── Tasks ───────────────────────────────────

function getAllTasks(): array {
  if (!file_exists(ITEMS_FILE)) return [];
  return json_decode(file_get_contents(ITEMS_FILE), true) ?? [];
}

function saveTasks(array $tasks): void {
  file_put_contents(ITEMS_FILE, json_encode(array_values($tasks), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getUserTasks(string $userId): array {
  $all = getAllTasks();
  $userTasks = array_filter($all, fn($t) => $t['user_id'] === $userId);
  // Sort: undone first, then by created_at desc
  usort($userTasks, function($a, $b) {
    if ($a['done'] === $b['done']) {
      return strtotime($b['created_at']) - strtotime($a['created_at']);
    }
    return $a['done'] <=> $b['done'];
  });
  return array_values($userTasks);
}

function addTask(string $userId, string $title, string $desc = ''): void {
  $tasks = getAllTasks();
  $tasks[] = [
    'id'         => uniqid('t_', true),
    'user_id'    => $userId,
    'title'      => $title,
    'desc'       => $desc,
    'done'       => false,
    'created_at' => date('d.m.Y H:i'),
  ];
  saveTasks($tasks);
}

function toggleTask(string $userId, string $taskId): void {
  $tasks = getAllTasks();
  foreach ($tasks as &$task) {
    if ($task['id'] === $taskId && $task['user_id'] === $userId) {
      $task['done'] = !$task['done'];
      break;
    }
  }
  saveTasks($tasks);
}

function deleteTask(string $userId, string $taskId): void {
  $tasks = getAllTasks();
  $tasks = array_filter($tasks, fn($t) => !($t['id'] === $taskId && $t['user_id'] === $userId));
  saveTasks($tasks);
}

function editTask(string $userId, string $taskId, string $title, string $desc = ''): void {
  $tasks = getAllTasks();
  foreach ($tasks as &$task) {
    if ($task['id'] === $taskId && $task['user_id'] === $userId) {
      $task['title'] = $title;
      $task['desc']  = $desc;
      break;
    }
  }
  saveTasks($tasks);
}

// ─── Feedback / Contact ───────────────────────

function saveFeedback(string $name, string $email, string $subject, string $msg): void {
  $data = [];
  if (file_exists(FEEDBACK_FILE)) {
    $data = json_decode(file_get_contents(FEEDBACK_FILE), true) ?? [];
  }
  $data[] = [
    'id'         => uniqid('f_', true),
    'name'       => $name,
    'email'      => $email,
    'subject'    => $subject,
    'message'    => $msg,
    'created_at' => date('Y-m-d H:i:s'),
  ];
  file_put_contents(FEEDBACK_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
