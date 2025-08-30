<?php
require_once __DIR__ . '/supabase.php';

header('Content-Type: application/json');
header('Cache-Control: no-store');

$bucket = isset($_GET['bucket']) ? $_GET['bucket'] : (getenv('SUPABASE_STORAGE_BUCKET') ?: 'public');
$prefix = isset($_GET['prefix']) ? $_GET['prefix'] : '';
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 200;

try {
    $sb = supabase_client();
    $res = $sb->storageList($bucket, $prefix, $limit, 0);
    if (!$res['ok']) {
        http_response_code($res['status'] ?: 500);
        echo json_encode([ 'error' => true, 'message' => 'Failed to list storage', 'details' => $res ]);
        exit;
    }

    $url = getenv('SUPABASE_URL') ?: '';
    $base = rtrim($url, '/');
    $publicBase = $base . '/storage/v1/object/public/' . rawurlencode($bucket) . '/';

    $items = isset($res['data']) && is_array($res['data']) ? $res['data'] : [];
    $files = [];
    foreach ($items as $item) {
        if (!isset($item['name'])) continue;
        $name = $item['name'];
        if (isset($item['metadata']['mimetype'])) {
            $mime = $item['metadata']['mimetype'];
        } else {
            $mime = '';
        }
        $files[] = [
            'name' => $name,
            'mime' => $mime,
            'publicUrl' => $publicBase . str_replace('%2F', '/', rawurlencode($name))
        ];
    }

    echo json_encode([ 'error' => false, 'files' => $files ]);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([ 'error' => true, 'message' => 'Unexpected error', 'details' => $e->getMessage() ]);
}
?>


