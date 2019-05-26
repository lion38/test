<?php

class Sql extends PDO {
	const HOST = 'cpanel2.blazingfast.io';
	const DB = 'neftgamb_auth';
	const USER = 'neftgamb_lion';
	const PASS = 'Juventus38';

	public function __construct($nombdd = '') { 
		try {
			if($nombdd != '') parent::__construct('mysql:host='.self::HOST.';dbname='.$nombdd, self::USER, self::PASS, array(PDO::ATTR_PERSISTENT => false,PDO::ERRMODE_EXCEPTION => true, PDO::ATTR_TIMEOUT => 10, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			else parent::__construct('mysql:host='.self::HOST.';dbname='.self::DB, self::USER, self::PASS, array(PDO::ATTR_PERSISTENT => false,PDO::ERRMODE_EXCEPTION => true, PDO::ATTR_TIMEOUT => 10, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch(Exception $e) {
			die('SQL error: '.$e->getMessage());
		}
	}
}


?>