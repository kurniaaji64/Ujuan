<?php

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', '1');
date_default_timezone_set("Asia/Jakarta");

Class DbOperation {

	private $database;
    
    /**
    * Constructor to allocate an instance and initialize its private variables.
    */
    public function __construct() {
    	require_once 'connection.php';

        $database = new Connection();
		$this->database = $database;
    }

    public function saveData($data = array()) {
    	print_r($data);

    	try {
		    $db = $this->database->openConnection();
		 	
		    // inserting data into create table using prepare statement to prevent from sql injections
		    $query = $db->prepare("INSERT INTO logs(product_code, customer_number, trx_type, request, response, request_date, response_date) VALUES (:product_code, :customer_number, :trx_type, :request, :response, :request_date, :response_date)");

            $query->bindValue(':product_code', $data['product_code']);
            $query->bindValue(':customer_number', $data['customer_number']);
            $query->bindValue(':trx_type', $data['trx_type']);
            $query->bindValue(':request', $data['request']);
            $query->bindValue(':response', $data['response']);
            $query->bindValue(':request_date', $data['request_date']);
            $query->bindValue(':response_date', $data['response_date']);
            $query->execute();

            $last_id = $db->lastInsertId('logs_id_seq');
            $response = "Record created successfully with id " . $last_id;

		    $this->database->closeConnection();
		} catch (PDOException $e) {
		    $response = "Oops! Something went wrong: " . $e->getMessage();
		}

        return $response;
    }

}
 
?>