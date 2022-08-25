<?php
class newCurl {

    /**
	 * [CURL description]
	 * @param  [string]     $method     [POST,GET,PUT,DELETE]
     * @param  [string]     $url        [url del servicio]
     * @param  [array]      $header      [ejm: array('token: asdasdasdasdasdasd','server: asdas')]
     * @param  [array]      $body        [ejm:("server"=> $server,"token"=> $token)]
	 * @return [text]          [json con respuesta si solicitud fue correcta]
	 */
    function curlPost($url,$header,$body){
        $curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($body),
            CURLOPT_HTTPHEADER => $header,
        ));
        $response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response,true);
        //return json_decode($response,true);
	}
	
	function curlPut ($url,$header, $body){
	    try{
    		$curl = curl_init();
    		curl_setopt_array($curl, array(
    			CURLOPT_URL => $url,
    			CURLOPT_RETURNTRANSFER => true,
    			CURLOPT_ENCODING => '',
    			CURLOPT_MAXREDIRS => 10,
    			CURLOPT_TIMEOUT => 0,
    			CURLOPT_FOLLOWLOCATION => true,
    			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    			CURLOPT_CUSTOMREQUEST => 'PUT',
    			CURLOPT_POSTFIELDS => http_build_query($body),
    			CURLOPT_HTTPHEADER => $header
    		));
    		$response = curl_exec($curl);
            if ($response === false){
				throw new Exception(curl_error($curl), curl_errno($curl));
			}else{
				//$response = curl_exec($curl);
				//return $response;
				return json_decode($response,true);
			}
    		//return json_decode($response,true);
	    }catch(Exception $e) {
			return array('success' => false,"error-codes"=> array("Error curl"));
		} finally {
			if (is_resource($curl)) {
				curl_close($curl);
			}
		}
	    
	    
		/*$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'PUT',
			CURLOPT_POSTFIELDS => http_build_query($body),
			CURLOPT_HTTPHEADER => $header,//array('token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.','server: localhost','Content-Type: application/x-www-form-urlencoded)'
		));
		$response = curl_exec($curl);

		curl_close($curl);
		return json_decode($response,true);*/
	}

	function curlGet($url,$header){
        $curl = curl_init();
        $config = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => $header
            
        );
        if($header==false){
            unset($config[CURLOPT_HTTPHEADER]);
        }
		curl_setopt_array($curl, $config);
        
        $response = curl_exec($curl);
		curl_close($curl);
        return json_decode($response,true);
	}
	
	function get(){
	    $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.aqupe.com/v1/admin/getAfiliados/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2NDExODg3MTMsImF1ZCI6IjNhZDYyNjA0YTVmZTVlZmM2NjIyZGVkMDM5NWUxZTg5OWFkOTcyYWYiLCJkYXRhIjp7ImlkVXN1YXJpbyI6IjUxIiwidXN1YXJpbyI6InpudGNreG1wY3pAdGVtcG1haWwuZGV2Iiwic2VydmVyIjoibG9jYWxob3N0In19.A2vLl40lUT8vTjs7v_gTwxWpvPgS_oQSsQpTu6dSYE8',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
	}
}


?>