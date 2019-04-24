<?php

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', '1');
date_default_timezone_set("Asia/Jakarta");

Class ApiInterface {
	
	private $pel_user;
	private $pel_pass;
	private $pel_key;
	private $pel_url;

	public function __construct() {
		$this->pel_user = "plg12110004";
		$this->pel_pass = "aldwin.3";
		$this->pel_key = "1234";
		$this->pel_url = "http://202.152.60.61:8118/Transactions/trx.json";
	}

	/*public function generateTrxId($length) {
		return substr(str_shuffle("0123456789"), 0, $length);
	}*/

	public function hitApi($params = array()) {
		$trx_date = $params['trx_date'];
		$trx_id = $params['trx_id'];
		$trx_type = $params['trx_type'];
		$cust_msisdn = $params['cust_msisdn'];
		$cust_account_no = $params['cust_account_no'];
		$product_id = $params['product_id'];
		$product_nomination = $params['product_nomination'];
		$periode_payment = $params['periode_payment'];
		$unsold = $params['unsold'];

		$signature = md5($this->pel_user . $this->pel_pass . $product_id . $trx_date . $this->pel_key);

		$post_data = array(
			'trx_date' => $trx_date,
			'trx_type' => $trx_type,
			'trx_id' => $trx_id,
			'cust_msisdn' => $cust_msisdn,
			'cust_account_no' => $cust_account_no,
			'product_id' => $product_id,
			'product_nomination' => $product_nomination,
			'periode_payment' => $periode_payment,
			// 'unsold' => '1'
		);

		$post_data = http_build_query($post_data, '', '&');
		$curl = curl_init($this->pel_url);

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_VERBOSE, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_URL, $this->pel_url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		    'Authorization: PELANGIREST username='.$this->pel_user.'&password='.$this->pel_pass.'&signature='.$signature
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

		$response = curl_exec($curl);
		$info = curl_getinfo($curl);

		curl_close($curl);

		// $output = json_decode($response, true);
		return $response;
	}

}

?>