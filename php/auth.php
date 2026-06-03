<?php
// php/auth.php — Register & Login logic

define('USERS_FILE', __DIR__ . '/../data/users.json');

function getUsers(): array {
  if (!file_exists(USERS_FILE)) return [];
  $json = file_get_contents(USERS_FILE);
  return json_decode($json, true) ?? [];
}

function saveUsers(array $users): void {
  file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function registerUser(string $username, string $email, string $password): array {
  if (strlen($username) < 3) {
    return ['success' => false, 'message' => 'Numele de utilizator trebuie să aibă cel puțin 3 caractere.'];
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return ['success' => false, 'message' => 'Adresa de email nu este validă.'];
  }
  if (strlen($password) < 6) {
    return ['success' => false, 'message' => 'Parola trebuie să aibă cel puțin 6 caractere.'];
  }

  $users = getUsers();

  // Check if username or email already exists
  foreach ($users as $u) {
    if (strtolower($u['username']) === strtolower($username)) {
      return ['success' => false, 'message' => 'Numele de utilizator este deja folosit.'];
    }
    if (strtolower($u['email']) === strtolower($email)) {
      return ['success' => false, 'message' => 'Adresa de email este deja înregistrată.'];
    }
  }

  $newUser = [
    'id'         => uniqid('u_', true),
    'username'   => $username,
    'email'      => $email,
    'password'   => password_hash($password, PASSWORD_DEFAULT),
    'created_at' => date('Y-m-d H:i:s'),
  ];

  $users[] = $newUser;
  saveUsers($users);

  return ['success' => true];
}

function loginUser(string $username, string $password): array {
  if (!$username || !$password) {
    return ['success' => false, 'message' => 'Completează toate câmpurile.'];
  }

  $users = getUsers();

  foreach ($users as $u) {
    if (strtolower($u['username']) === strtolower($username)) {
      if (password_verify($password, $u['password'])) {
        // Don't store password hash in session
        $sessionUser = $u;
        unset($sessionUser['password']);
        return ['success' => true, 'user' => $sessionUser];
      } else {
        return ['success' => false, 'message' => 'Parolă incorectă.'];
      }
    }
  }

  return ['success' => false, 'message' => 'Utilizatorul nu a fost găsit.'];
}
