<?php
// php/save_data.php
// Utility functions for reading/writing JSON files safely

function readJson(string $filePath): array {
  if (!file_exists($filePath)) return [];
  $content = file_get_contents($filePath);
  if (!$content) return [];
  $data = json_decode($content, true);
  return is_array($data) ? $data : [];
}

function writeJson(string $filePath, array $data): bool {
  $dir = dirname($filePath);
  if (!is_dir($dir)) mkdir($dir, 0755, true);
  $result = file_put_contents(
    $filePath,
    json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
  );
  return $result !== false;
}

function appendToJson(string $filePath, array $item): bool {
  $data = readJson($filePath);
  $data[] = $item;
  return writeJson($filePath, $data);
}

function deleteFromJson(string $filePath, string $key, string $value): bool {
  $data = readJson($filePath);
  $filtered = array_filter($data, fn($item) => ($item[$key] ?? null) !== $value);
  return writeJson($filePath, array_values($filtered));
}

function updateInJson(string $filePath, string $key, string $value, array $updates): bool {
  $data = readJson($filePath);
  foreach ($data as &$item) {
    if (($item[$key] ?? null) === $value) {
      $item = array_merge($item, $updates);
      break;
    }
  }
  return writeJson($filePath, $data);
}
