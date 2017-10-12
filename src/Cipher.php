<?php
namespace YGTool;

class Cipher
{
	const CIPHER = MCRYPT_RIJNDAEL_128;
	const MODE   = MCRYPT_MODE_CBC;

	private static $_instance;
	private static $_device;
	private static $_data;

	private function _initInputData()
	{
		$d           = self::decryptData(postval('data'));
		self::$_data = json_decode($d, true);
	}

	public function __clone()
	{
		trigger_error('CLONE IS NOT ALLOWED', E_USER_ERROR);
	}

	/**
	 *	获取对象单例
	 */
	public static function getInstance()
	{
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	private function getiv()
	{
		//固定初始向量数值，128位为16字节字符，256位为32位字符
		//$iv = mcrypt_create_iv(mcrypt_get_iv_size(self::CIPHER,self::MODE),MCRYPT_RAND);
		return ENCRYPT_IV;
	}

	public function createNonceStr($length = 16)
	{
		$chars      = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str        = "";
		$charposmax = strlen($chars) - 1;
		for ($i = 0; $i < $length; $i++) {
			$str .= $chars[mt_rand(0, $charposmax)];
		}
		return $str;
	}

	public function aesEncode($key, $str)
	{
		$iv = $this->getiv();

		return mcrypt_encrypt(self::CIPHER, $key, $str, self::MODE, $iv);
	}

	public function aesDecode($key, $str)
	{
		$iv = $this->getiv();

		$str = mcrypt_decrypt(self::CIPHER, $key, $str, self::MODE, $iv);
		$str = rtrim($str); //解密后不是key的倍数的数据，会自动添加空格，故需做一次trim
		return $str;
	}

	/**
	 *	获取当前设备的加解密密码
	 */
	public function getAESKey()
	{
		return ENCRYPT_KEY;
	}

	/**
	 *	用AESKEY解密
	 */
	public function decryptData($data)
	{
		$key = $this->getAESKey();
		if (empty($key)) {
			return null;
		}
		//加密后的data应是先被base64编码的，所以需要先解码
		$bin = base64_decode($data);
		if (strlen($bin)) {
			return $this->aesDecode($key, $bin);
		} else {
			return null;
		}
	}

	/**
	 *	用AESKEY加密
	 */
	public function encryptData($data)
	{
		$key = $this->getAESKey();
		if (empty($key)) {
			return null;
		}
		$raw = $this->aesEncode($key, $data);
		//因为raw为二进制，网络传输不便，故改为base64编码数据
		$val = base64_encode($raw);
		return $val;
	}

	public function dataSign($string, $nonce)
	{
		return sha1($nonce . md5($this->getAESKey()) . $string . sha1($this->getiv()) . $nonce);
	}
	/**
	 *	根据KEY获取加密数据
	 */
	public function getValue($key)
	{
		if (null === self::$_data) {
			$this->_initInputData();
		}
		$d = self::$_data;
		if (isset($d[$key])) {
			return $d[$key];
		} else {
			return null;
		}
	}

}
