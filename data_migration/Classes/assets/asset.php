<?php 

require 'createUser.php';
	
// Made by saurabh chhabra

	function _moveFile($tmpPath,$assetPath,$log){
	
			
		//print_R($tmpPath);print_r($_FILES);die;
		$target_url = ASSET_GUEST_REQUEST_URL;
		//$file_path = $this->_file['tmp_name'] . '/' . $this->_file['name'];
		//$file_path = $this->_file['tmp_name'];
		$cfile = new \CURLFile($tmpPath);//print_r($cfile);
		//$file_path_split = explode('/', $tmpPath);print_R($file_path_split);die;
		$post = array(
		 "file" => $cfile,
		 'fileName' => "ONB",
		 'title' => 'ONB',
		 'description' => 'ONB',
		 'path' => $assetPath,
		);
		
		
		$writelog= date('H:i:s') ."  File cURL object".PHP_EOL.PHP_EOL.json_encode($cfile,JSON_PRETTY_PRINT).PHP_EOL;
		echo $writelog;
		$log->lwrite($writelog);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $target_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:multipart/form-data'));
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:multipart/form-data', 'loginId:knojiyaTest3', 'sessionToken: 6Ysk0XvlvYUt2nFxiVhBrgYbm'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$result = curl_exec($ch);
		//print_r($result); die;
		$resp = json_decode($result, TRUE);
		//return $resp;
		
		if ($result === FALSE) {
			throw new \Exception('Curl error: ' . curl_error($ch));
			$writelog= date('H:i:s') ." Exception Occured ".PHP_EOL.PHP_EOL.curl_error($ch).PHP_EOL;
			echo $writelog;
			$log->lwrite($writelog);
		}
		curl_close($ch);
		if (empty($resp) || !$resp['status']) {
			throw new \Exception('Some error occured in file upload.');
			$writelog= date('H:i:s') ." Some error occured in file upload. ".PHP_EOL;
			echo $writelog;
			$log->lwrite($writelog);
		}
		return $resp;
 
    }
	
	
	function insertUploadDetails($resp,$log,$type,$emailid,$school_code,$ayid){
		
		if($resp['status']==1){
			
			echo PHP_EOL,$resp['relativePath'],PHP_EOL;
			
			$target_url = URL_API_BL.'/schoolonboarding/uploadDetails';
			
			//$tmpPath= realpath("./499982148602_.xlsx");
			//$tmpPath= realpath($resp['relativePath']);
			//$tmpname= $_FILES['file']['name'];
			//move_uploaded_file($tmpPath, __DIR__."/logs/$tmpname");
			//$path='saurabh/';
			//$file_path = $this->_file['tmp_name'] . '/' . $this->_file['name'];
			//$file_path = $this->_file['tmp_name'];
			//$cfile = new \CURLFile($tmpPath);print_r($cfile);
			//$output = system('curl -i -F file=@'.$tmpPath.' -F path='.$path.' '.$target_url);print_r($output);exit;
			//$file_path_split = explode('/', $tmpPath);print_R($file_path_split);die;
			
			$post = array(
			
			 "details" => array( 
			 'filePath' => $resp['relativePath'],
			 'type' => $type,
			 'uuid' => '123456',
			 'emailId' => $emailid,
			 'schoolCode'=>$school_code,
             'ayid'=>$ayid,

			 )
			);
			$post=json_encode($post,JSON_PRETTY_PRINT);
			//print_r($post);
			
			$writelog= date('H:i:s') ."  File post object".PHP_EOL.PHP_EOL.$post.PHP_EOL;
			echo $writelog;
			$log->lwrite($writelog);
			
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $target_url);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:multipart/form-data'));
			 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','schoolCode:16273117','profileCode:4846904962', 'loginId:SaurabhChhabra', 'sessionToken: Cc9RTDXBhyDyr3qkMyCIZD0FD '));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			$result = curl_exec($ch);
			//print_r($result); die;
			$insertResp = json_decode($result, TRUE);
			return($insertResp);
				
		}
	}
	

?>