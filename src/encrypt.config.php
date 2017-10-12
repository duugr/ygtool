<?php

// base64_encode(openssl_random_pseudo_bytes(32));

//固定初始向量数值，128位为16字节字符，256位为32位字符
//$iv = mcrypt_create_iv(mcrypt_get_iv_size(self::CIPHER,self::MODE),MCRYPT_RAND);

define('ENCRYPT_KEY', '39f845dcc8b2aa5ac16a9b1710d387a9');
define('ENCRYPT_IV', 'xxnn32x60z668523');
define('ENCRYPT_METHOD', 'AES-128-CBC'); //密码学方式。openssl_get_cipher_methods() 可获取有效密码方式列表。
