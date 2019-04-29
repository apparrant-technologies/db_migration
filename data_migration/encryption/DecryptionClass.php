<?php




class Loop {

public $keyD;


	public function __construct($ciphertext_base64){
		
		try{
			
			$key = pack('H*', KEY);
			
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			# --- DECRYPTION ---
			
			$ciphertext_dec = base64_decode($ciphertext_base64);
			
			# retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
			$iv_dec = substr($ciphertext_dec, 0, $iv_size);
			
			# retrieves the cipher text (everything except the $iv_size in the front)
			$ciphertext_dec = substr($ciphertext_dec, $iv_size);

			# may remove 00h valued characters from end of plain text
			@$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$key,
											$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
			
			$this->keyD= $plaintext_dec;
			
			}catch(Exception $e){
			
			
			
		}
		
		
		
	}


}

$encrypt=new Loop($toDecrypt);