<?php
require_once __DIR__ . '/env.php';
load_env();

function env_get($key, $default = '') {
    $val = getenv($key);
    if ($val === false || $val === null) return $default;
    return $val;
}

class SupabaseClientLightweight {
    private $url;
    private $anonKey;
    private $serviceRoleKey;

    public function __construct() {
        $this->url = rtrim(env_get('SUPABASE_URL'), '/');
        $this->anonKey = env_get('SUPABASE_ANON_KEY');
        $this->serviceRoleKey = env_get('SUPABASE_SERVICE_ROLE_KEY');
    }

    private function buildQueryString($params) {
        if (empty($params)) return '';
        $pairs = [];
        foreach ($params as $key => $value) {
            $pairs[] = rawurlencode($key) . '=' . rawurlencode($value);
        }
        return '?' . implode('&', $pairs);
    }

    private function request($method, $endpoint, $headers = [], $body = null, $useServiceKey = true) {
        if (empty($this->url)) {
            return [ 'ok' => false, 'status' => 0, 'error' => 'SUPABASE_URL not configured' ];
        }
        $ch = curl_init();
        $url = $this->url . $endpoint;
        $defaultHeaders = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        $authKey = $useServiceKey ? $this->serviceRoleKey : $this->anonKey;
        if (!empty($authKey)) {
            $defaultHeaders[] = 'apikey: ' . $authKey;
            $defaultHeaders[] = 'Authorization: Bearer ' . $authKey;
        }
        $allHeaders = array_merge($defaultHeaders, $headers);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $allHeaders);

        if ($body !== null) {
            if (is_array($body)) {
                $body = json_encode($body);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return [ 'ok' => false, 'status' => 0, 'error' => $err ];
        }
        $decoded = json_decode($response, true);
        $ok = $status >= 200 && $status < 300;
        return [ 'ok' => $ok, 'status' => $status, 'data' => $decoded, 'raw' => $response ];
    }

    // REST: insert row into table
    public function insert($table, $data, $returnRepresentation = true) {
        $headers = [ 'Prefer: resolution=merge-duplicates' ];
        if ($returnRepresentation) {
            $headers[] = 'Prefer: return=representation';
        }
        return $this->request('POST', '/rest/v1/' . urlencode($table), $headers, [$data], true);
    }

    // REST: select rows from table
    public function select($table, $select = '*', $filters = [], $orderBy = null, $ascending = false, $limit = 100) {
        $params = [ 'select' => $select ];
        foreach ($filters as $col => $val) {
            // eq operator
            $params[$col] = 'eq.' . $val;
        }
        if (!empty($orderBy)) {
            $params['order'] = $orderBy . ($ascending ? '.asc' : '.desc');
        }
        if (!empty($limit)) {
            $params['limit'] = (string)intval($limit);
        }
        $qs = $this->buildQueryString($params);
        return $this->request('GET', '/rest/v1/' . urlencode($table) . $qs, [], null, true);
    }

    // Storage: upload object
    public function storageUpload($bucket, $objectPath, $localFilePath, $contentType = 'application/octet-stream') {
        if (!file_exists($localFilePath)) {
            return [ 'ok' => false, 'status' => 0, 'error' => 'File not found: ' . $localFilePath ];
        }
        $contents = file_get_contents($localFilePath);
        $headers = [
            'Content-Type: ' . $contentType,
            'x-upsert: true'
        ];
        return $this->request('POST', '/storage/v1/object/' . rawurlencode($bucket) . '/' . $objectPath, $headers, $contents, true);
    }

    // Storage: list objects
    public function storageList($bucket, $prefix = '', $limit = 100, $offset = 0) {
        $body = [
            'prefix' => $prefix,
            'limit' => $limit,
            'offset' => $offset,
            'sortBy' => [ 'column' => 'name', 'order' => 'asc' ]
        ];
        return $this->request('POST', '/storage/v1/object/list/' . rawurlencode($bucket), [], $body, false);
    }
}

function supabase_client() {
    static $client = null;
    if ($client === null) {
        $client = new SupabaseClientLightweight();
    }
    return $client;
}
?>


