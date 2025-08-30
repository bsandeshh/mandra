<?php
require_once __DIR__ . '/env.php';
load_env();

header('Content-Type: application/javascript');
header('Cache-Control: no-store');

$url = getenv('SUPABASE_URL') ?: '';
$anon = getenv('SUPABASE_ANON_KEY') ?: '';

// Only expose non-sensitive public config
$safeUrl = $url;
$safeAnon = $anon;

echo "window.__SUPABASE_PUBLIC__ = { url: '" . addslashes($safeUrl) . "', anonKey: '" . addslashes($safeAnon) . "' };\n";
?>


