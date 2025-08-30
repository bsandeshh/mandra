<?php
require_once __DIR__ . '/supabase.php';
header('Content-Type: application/json');
header('Cache-Control: no-store');

// Simple allowlist to avoid arbitrary table reads
$allowlist = [
  'admissions' => true,
  'appointments' => true,
  'newsletter_subscriptions' => true
];

$table = isset($_GET['table']) ? strtolower(trim($_GET['table'])) : '';
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 100;
if ($limit < 1 || $limit > 1000) { $limit = 100; }

if (!$table || !isset($allowlist[$table])) {
  http_response_code(400);
  echo json_encode([ 'error' => true, 'message' => 'Invalid or non-allowed table' ]);
  exit;
}

try {
  $sb = supabase_client();
  $res = $sb->select($table, '*', [], 'submitted_at', false, $limit);
  if (!$res['ok']) {
    http_response_code($res['status'] ?: 500);
    echo json_encode([ 'error' => true, 'message' => 'Failed to fetch', 'details' => $res ]);
    exit;
  }
  echo json_encode([ 'error' => false, 'rows' => $res['data'] ]);
} catch (\Throwable $e) {
  http_response_code(500);
  echo json_encode([ 'error' => true, 'message' => 'Unexpected error', 'details' => $e->getMessage() ]);
}
?>


