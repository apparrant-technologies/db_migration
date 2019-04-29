<?php


/*

**	Convert Any Text to UTF-8
**

*/

 function toUTF($text=false){
	
	if(!empty($text)){
		$utfConvert=iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);
 
		return $utfConvert;
	}
	
	return false;
	
 }
 
 
 
 function isValidIndianMobile($mobile = '')
    {
        if (preg_match('/^[3456789]\d{9}$/', $mobile)) {
            return true;
        }
        
        return false;
    }
	
	
function isValidEmail($email){
	
	if(!empty($email)){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			return true;
		} else {
			return false;
		}
	}else{
		return false;
	}
	
}








