<?php
namespace YGTool;
/**
 * Created by PhpStorm.
 * User: Russell
 * Date: 2017/6/5
 * Time: 11:15
 */

class Crypt
{
	public static function encrypt($data)
	{
		$encrypted = openssl_encrypt(
			$data,
			ENCRYPT_METHOD,
			ENCRYPT_KEY,
			OPENSSL_RAW_DATA,
			ENCRYPT_IV
		);
		// return $encrypted;
		return base64_encode($encrypted);
	}
	public static function decrypt($data)
	{
		$encrypted = base64_decode($data);
		$decrypted = openssl_decrypt(
			$encrypted,
			ENCRYPT_METHOD,
			ENCRYPT_KEY,
			OPENSSL_RAW_DATA,
			ENCRYPT_IV
		);
		return $decrypted;
	}
}
