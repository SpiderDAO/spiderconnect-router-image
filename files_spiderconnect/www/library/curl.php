<?php

class curl
{

    private $curl;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function execute($url, $method, $fields)
    {
		global $access_token;
		
        $fields_string = '';
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
		
		$fp = fopen('/tmp/router_curl.log', 'w');
		
        rtrim($fields_string, '&');
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $fields_string,
			CURLOPT_VERBOSE => true,
			CURLOPT_STDERR => $fp,
			CURLOPT_TIMEOUT => 5,
            CURLOPT_HTTPHEADER => array(
                "User-Agent: Router",
                "Authorization: Bearer ".$access_token
            ),
        ));

        $response = curl_exec($this->curl);
		$retry = 0;
		while(curl_errno($this->curl) == 28 && $retry != 2){
			$response = curl_exec($this->curl);
			$retry++;
		}
        $err = curl_error($this->curl);

        curl_close($this->curl);
        if ($err) {
            return $err;
        } else {
            return $response;
        }


    }
}