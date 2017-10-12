<?php

require 'config.php';
require '../src/Crypt.php';
require '../src/Cipher.php';

use YGTool\Crypt;
use YGTool\Cipher;

$data = 'phpbest';
echo $data;
echo "\n";
$encrypt = Crypt::encrypt($data);
echo $encrypt;
$decrypt = Crypt::decrypt($encrypt);
echo "\n";
echo $decrypt;
echo "\n";



$Cipher = Cipher::getInstance();
echo $encrypt = $Cipher->encryptData($data);
echo "\n";
echo $Cipher->decryptData($encrypt);
echo "\n";