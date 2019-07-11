<?php
	function inacbg_config() {
		$menu = '';
		$CI =& get_instance();    
		$CI->load->model('ina-cbg/M_irj','',TRUE);
		$CI->load->model('ina-cbg/M_pasien','',TRUE);	
		$result = $CI->M_inacbg->config_inacbg()->row();
		return $result;	
	}

	function web_service($data_klaim) {
		$CI =& get_instance();    
		$CI->load->model('ina-cbg/M_irj','',TRUE);
		$CI->load->model('ina-cbg/M_pasien','',TRUE);
		
		$config = $CI->M_inacbg->config_inacbg()->row();
		$key = '02646768dd07a907171871b93d4449ede64dd1d02360754d347b69ca35ba3634';		
		$payload = inacbg_encrypt($data_klaim,$config->key);
		$header = array($config->header_post);
		$url = $config->service_url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		$response = curl_exec($ch);
		curl_close($ch);	 			
		$first = strpos($response, "\n")+1;
		$last = strrpos($response, "\n")-1;
		$response = substr($response,$first,strlen($response) - $first - $last);     
 		$response = inacbg_decrypt($response,$config->key);     
	    $msg = json_decode($response,true);
	    return $response;
	}

	function inacbg_encrypt($data, $key) {      
      	$key = hex2bin($key);      
		if (mb_strlen($key, "8bit") !== 32) {
			throw new Exception("Needs a 256-bit key!");
		}	      
      	$iv_size = openssl_cipher_iv_length("aes-256-cbc");
      	$iv = openssl_random_pseudo_bytes($iv_size);      
      	$encrypted = openssl_encrypt($data, "aes-256-cbc",$key,OPENSSL_RAW_DATA,$iv );   
   		$signature = mb_substr(
   			hash_hmac("sha256",$encrypted,$key,true),0,10,"8bit"
   		);   
		$encoded = chunk_split(base64_encode($signature.$iv.$encrypted));
		return $encoded;
	}

	function inacbg_decrypt($str, $strkey){
   		$key = hex2bin($strkey);   
		if (mb_strlen($key, "8bit") !== 32) {
			throw new Exception("Needs a 256-bit key!");
		}   
   		$iv_size = openssl_cipher_iv_length("aes-256-cbc");
		$decoded = base64_decode($str);
		$signature = mb_substr($decoded,0,10,"8bit");
		$iv = mb_substr($decoded,10,$iv_size,"8bit");
		$encrypted = mb_substr($decoded,$iv_size+10,NULL,"8bit");   
   		$calc_signature = mb_substr(
   			hash_hmac("sha256",$encrypted,$key,true),0,10,"8bit"
   		);
   		if(!inacbg_compare($signature,$calc_signature)) {
      		return "SIGNATURE_NOT_MATCH";
		}
   		$decrypted = openssl_decrypt($encrypted,"aes-256-cbc",$key,OPENSSL_RAW_DATA,$iv);
   		return $decrypted;
	}

	function inacbg_compare($a, $b) {
      if (strlen($a) !== strlen($b)) return false;      
      $result = 0;
      for($i = 0; $i < strlen($a); $i ++) {
         $result |= ord($a[$i]) ^ ord($b[$i]);
      }
      return $result == 0;
	} 

?>