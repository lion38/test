﻿<?php
session_start();
require 'class/sql.class.php'; 
date_default_timezone_set('Europe/Paris');
$Sql = new Sql();
$Sql->query("SET NAMES utf8");

        $status_codes = array (
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended'
        );
		
	function header_status($status_codes, $statusCode = null) {


		if ($status_codes[$statusCode] !== null) {
			$status_string = $statusCode . ' ' . $status_codes[$statusCode];
			header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
		}
	}

	$random_status = array_rand($status_codes, 1);
	// header_status($status_codes, $random_status);
	// sleep(65);

	$content = 0;
	$QUERYBOT = $Sql->prepare("SELECT CharsCount FROM worlds");
	$QUERYBOT->execute();
	$row = $QUERYBOT->fetch();
	$QUERYBOT->closeCursor();
	if($row) $content =  $row['CharsCount'];
	
	// $content = $content + rand(-25, 800);
	// $content = $content + rand(-50, 50);
$Sql = null;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>STATS | <?php echo $content; ?></title>
<meta http-equiv="refresh" content="5">
</head>
<body>
<?php echo '<h1>Nombre de joueurs en ligne : <strong style="font-size:150%;font-family:Verdana;">'.$content.'</strong></h1>';; ?>
</body>
</html>