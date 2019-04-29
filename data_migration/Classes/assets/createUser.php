<?php

	function adultUser($log,$first_name,$middle_name,$last_name,$mobile_number,$email_id,$login_id,$date_of_birth,$gender){
		
		if(empty($login_id) || empty($mobile_number)){
			$writelog='Empty Data Recieved';
			echo $writelog;
			$log->lwrite($writelog);
			//exit;
		}
		
		//print_R($tmpPath);print_r($_FILES);die;
		$target_url = URL_API_UMS_ADULT_USER;
		//$file_path = $this->_file['tmp_name'] . '/' . $this->_file['name'];
		//$file_path = $this->_file['tmp_name'];
		//$cfile = new \CURLFile($tmpPath);//print_r($cfile);
		//$file_path_split = explode('/', $tmpPath);print_R($file_path_split);die;
		$postJSON = array("user" => array
			(	
				"loginId" =>$login_id,
				"firstName" =>$first_name,
				"middleName" =>$middle_name,
				"lastName" =>$last_name,
				"gender" =>$gender,
				"mobileNumber" => $mobile_number,
				"emailId" =>$email_id,
				"dateOfBirth" =>$date_of_birth,
				"nickname" =>"",
				"updatedBy" =>1,
				"shouldInvite" =>1,
				"addressLine1" =>"",
				"addressLine2" =>"",
				"cityId" =>"",
				"stateId" =>"",
				"zipCode" =>""
			),
			"password" => "123456"
		);

    
		
		//$post=json_encode($postJSON);print_r($post);die;
		$post=json_encode($postJSON);
		$writelog= date('H:i:s') ."  File cURL object".PHP_EOL.PHP_EOL.json_encode($post,JSON_PRETTY_PRINT).PHP_EOL;
		echo $writelog;
		$log->lwrite($writelog);
		/*
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $target_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:multipart/form-data', 'loginId:knojiyaTest3', 'sessionToken: 6Ysk0XvlvYUt2nFxiVhBrgYbm'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$result = curl_exec($ch);
		//print_r($result); //die;
		$resp = json_decode($result, TRUE);
		
		*/
		
		$shell="curl --request POST --url ".$target_url." --header 'content-type: application/json' --data '".$post."'";//print_r($shell);
		$umsUser = system($shell);
		
		$resp=json_decode($umsUser);
		print_r($resp);
  
  
		echo PHP_EOL,'---------------------',PHP_EOL;
		print_r(json_encode($resp));
		return $resp;


	}


?>