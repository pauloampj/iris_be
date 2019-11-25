<?php
/********************************************************************************
** @Company     : Damaplan                                                     **
** @System      : Iris - Gestor de Normativos		                           **
** @Module		: Hash - Classe estática para codificar/decodificar as 		   **
**				  strings.													   **
** @Namespace	: Damaplan\Iris\Core\Utils								   **
** @Copyright	: Damaplan Consultoria LTDA (http://www.damaplan.com.br)       **
** @Link		: http://norman.damaplan.com.br/documentation                  **
** @Email		: sistemas@damaplan.com.br					                   **
** @Observation : Esta ferramenta e seu inteiro teor é de propriedade da	   **
**				  Damaplan Consultoria e Estratégia LTDA. Não é permitida sua  **
**				  edição, distribuição ou divulgação sem prévia autorização.   **
** --------------------------------------------------------------------------- **
** @Developer	:                                                              **
** @Date	 	:                                                     	       **
** @Version	 	:                                                     	       **
** @Comment	 	:                                                              **
** --------------------------------------------------------------------------- **
** @Developer	: @pauloampj                                                   **
** @Date	 	: 29/06/2018                                           	       **
** @Version	 	: 1.0                                                 	       **
** @Comment	 	: Primeira versão.                                             **
********************************************************************************/

namespace Damaplan\Iris\Core\Utils;

Use Damaplan\Iris\Core\Utils\DMPLParams;

class DMPLHash {
	
	public static function toMd5($aString = ''){
		return hash('md5', $aString);
	}
	
	public static function toSha1($aString = ''){
		return hash('sha1', $aString);
	}
	
	public static function encryptPassword($aPassword = ''){
		switch (strtoupper(DMPLParams::read ('SECURITY.PASSWORD_HASH_METHOD'))){
			case 'MD5': 	return static::toMd5($aPassword);
			case 'SHA1':	return static::toSha1($aPassword);
			default:		return static::toMd5($aPassword);
		}
	}
	
	public static function encrypt(string $message, string $key): string {
		if (mb_strlen($key, '8bit') !== SODIUM_CRYPTO_SECRETBOX_KEYBYTES) {
			die('Key is not the correct size (must be 32 bytes).');
		}
		$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
		
		$cipher = base64_encode(
				$nonce.
				sodium_crypto_secretbox(
						$message,
						$nonce,
						$key
						)
				);
		sodium_memzero($message);
		sodium_memzero($key);
		return $cipher;
	}
	

	public static function decrypt(string $encrypted, string $key): string {
		$decoded = base64_decode($encrypted);
		$nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
		$ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
		
		$plain = sodium_crypto_secretbox_open(
				$ciphertext,
				$nonce,
				$key
				);
		if (!is_string($plain)) {
			die('Invalid MAC');
		}
		sodium_memzero($ciphertext);
		sodium_memzero($key);
		return $plain;
	}
	
}