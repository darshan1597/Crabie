<?php

    function isAdminLogin(){
        if(isset($_SESSION['admin-id'])){
		    return true;
	    }
        else{
	        return false;
        }
    }

    function convertData($string, $action = 'encrypt'){
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'ZFH56OIS6RM12IHROPZY87UNQO28';
		$secret_iv = '4td6aftHuS5';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ($action == 'encrypt'){
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} 
		else if ($action == 'decrypt'){
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}

	function isUser(){
        if(isset($_SESSION['id'])){
		    return true;
	    }
        else{
	        return false;
        }
    }

?>