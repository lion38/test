<?php
function get_real_ip()
{
    if( isset( $_SERVER ) )
    {
        if( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) )
        {
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif( isset( $_SERVER["HTTP_CLIENT_IP"] ) )
        {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        }
        else
        {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } 
    else 
    {
        if( getenv( 'HTTP_X_FORWARDED_FOR' ) )
        {
            $realip = getenv( 'HTTP_X_FORWARDED_FOR' );
        }
        elseif( getenv( 'HTTP_CLIENT_IP' ) )
        {
            $realip = getenv( 'HTTP_CLIENT_IP' );
        }
        else
        {
            $realip = getenv( 'REMOTE_ADDR' );
        }
    }
    return $realip;
}

if(isset($_POST['ipet']) AND !empty($_POST['ipet']))
{
	include("assets/geoip/geoip.inc");
	$gi = geoip_open("assets/geoip/GeoIP.dat",GEOIP_STANDARD);
	$date = date("d-m-Y");
	$heure = date("H:i");
	$ip_PHP = get_real_ip();
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$real_ip_JS = $_POST['ipet'];
	
	$country_code_php = strtolower(geoip_country_code_by_addr($gi, $ip_PHP));
	$country_name_php = geoip_country_name_by_addr($gi, $ip_PHP);
	$country_code_js = strtolower(geoip_country_code_by_addr($gi, $real_ip_JS));
	$country_name_js = geoip_country_name_by_addr($gi, $real_ip_JS);
	
	geoip_close($gi);
	
	$monfichier = fopen('pages/cache_data/iplogger.txt', 'a+');
	fputs($monfichier, "--------------------------------------------------------------------------------------------\r\n");
	fputs($monfichier, "-----------------------------------| $date - $heure |-----------------------------------\r\n");
	fputs($monfichier, "--------------------------------------------------------------------------------------------\r\n");
	fputs($monfichier, "IP PHP : " . $ip_PHP . " [".$country_code_php." - ".$country_name_php."]\r\n");
	fputs($monfichier, "USER AGENT : " . $user_agent . "\r\n");
	fputs($monfichier, "IP REAL BY JS : " . $real_ip_JS . " [".$country_code_js." - ".$country_name_js."]\r\n");
	fclose($monfichier);
}

?>