<?php
function encryptData($data, $key = 'your-secret-key') {
    $iv = substr(hash('sha256', $key), 0, 16);
    return base64_encode(openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv));
}

function decryptData($data, $key = 'your-secret-key') {
    $iv = substr(hash('sha256', $key), 0, 16);
    return openssl_decrypt(base64_decode($data), 'AES-256-CBC', $key, 0, $iv);
}

?>