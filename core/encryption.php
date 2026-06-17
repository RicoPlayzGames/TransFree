<?php
// Functie om een random token van 16 bits te genereren 
function generateToken() {
  return bin2hex(random_bytes(16));
};

// Functie om de token te encrypten
function encryptToken($token, $key){
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($ivLength);
    $ciphertext = openssl_encrypt($token, 'aes-256-cbc', $key, 0, $iv);
    // Combine IV and ciphertext for storage
    return base64_encode($iv . $ciphertext);
};

// Laat encrypted token zien
// echo "Encrypted Data: " . $encryptedToken;

// Decryption function
// function decryptData($encryptedToken, $key) {
//     $data = base64_decode($encryptedToken);
//     $ivLength = openssl_cipher_iv_length('aes-256-cbc');
//     $iv = substr($data, 0, $ivLength);
//     $ciphertext = substr($data, $ivLength);
//     return openssl_decrypt($ciphertext, 'aes-256-cbc', $key, 0, $iv);
// }

// Decryped de token
// $decryptedData = decryptData($encryptedToken, $key);
// Laat decrypted token zien
// echo "Decrypted Data: " . $decryptedData;

?>