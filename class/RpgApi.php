<?php
class RpgApi{
    private $id;
    private $page_code='';
    private $position=0;
    private $out=-1;
    private $votes=-1;
    public function __construct($rpg_id){
        $this->id=$rpg_id;
    }
	
    public function getCaptcha(){
        $page_data = file_get_contents('http://www.rpg-paradize.com/?page=vote&vote='.$this->id);

        if(!$page_data){
            trigger_error('RpgApi->getCaptcha() : une erreur est survenue lors de la récupération de la page. FALSE retourné !', E_USER_NOTICE);
            return false;
        }

        $matches = array();

        $start_tag = '<script src=\'http://api.adscaptcha.com/Get.aspx';
        $end_tag = '\' type=\'text/javascript\'></script>';

        if(!preg_match('#'.$start_tag.'(\?.+)'.$end_tag.'#', $page_data, $matches)){
            trigger_error('RpgApi->getCaptcha() : La page a été récupéré avec succès, mais son contenue est invalide. L\'id RPG est peut-être invalide... FALSE retourné.', E_USER_NOTICE);
            return false;
        }

        return $start_tag.$matches[1].$end_tag;
    }

    public function submitVote($get = false){

        if(empty($_POST['adscaptcha_response_field']) || empty($_POST['adscaptcha_challenge_field']))
            return false;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'http://www.rpg-paradize.com/?page=vote2');
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'adscaptcha_response_field'=>$_POST['adscaptcha_response_field'],
            'adscaptcha_challenge_field'=>$_POST['adscaptcha_challenge_field'],
            'submitvote'=>$this->id
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $data = curl_exec($curl);
        curl_close($curl);

        if($data===false){
            trigger_error('RpgApi->submitVote() : Une erreur est survenue lors du test du captcha...', E_USER_NOTICE);
            return false;
        }

        if(strpos($data, '<span style="font-size:20px;color:red;">Captcha incorrect</span>')!==false)
                return false;

        return true;
    }

    private function loadPage(){
        if($this->page_code!=='')
            return $this->page_code;
		
		  $curl = curl_init();

		  $header[0] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,";
		  $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
		  $header[] = "Cache-Control: max-age=0";
		  $header[] = "Connection: keep-alive";
		  $header[] = "Keep-Alive: 5";
		  $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		  $header[] = "Accept-Language: fr,fr-fr;q=0.8,en-us;q=0.5,en;q=0.3";

			curl_setopt($curl, CURLOPT_URL, 'http://www.rpg-paradize.com/site--'.$this->id);
			//curl_setopt($curl, CURLOPT_URL, 'http://localhost/abyssia%20ankalike/sleep.php');
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0");
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl, CURLOPT_REFERER, 'http://www.rpg-paradize.com');
			curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate");
			curl_setopt($curl, CURLOPT_AUTOREFERER, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_TIMEOUT, 5);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
			curl_setopt($curl, CURLOPT_VERBOSE, false);
			curl_setopt($curl,CURLOPT_COOKIEFILE,'cookiessdfdsfds.txt');
			curl_setopt($curl,CURLOPT_COOKIEJAR,'cookiessdfdsfds.txt');

		  $html = curl_exec($curl);
		  //$info = curl_getinfo($curl);
		  //print_r($info);
		  
		  $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		  $this->page_code = $html;
		  
		if (($httpcode < 200 && $httpcode >=300))
			return false;

        if(!$this->page_code){
            //trigger_error('RpgApi->loadPage() : impossible de charger la page...', E_USER_NOTICE);
            return false;
        }

        return $this->page_code;
    }

    public function getPosition(){
        if($this->position!==0)
            return $this->position;

        $matches = array();
        if(!$code = $this->loadPage()){
            trigger_error('RpgApi->getPosition() : récupération impossible de la position.', E_USER_NOTICE);
            return 0;
        }

        if(!preg_match('#<b>Position ([0-9]+)</b>#', $code, $matches)){
            trigger_error('RpgApi->getPosition() : La page à été chargée avec succès, mais il est impossible de trouver la position. L\'id est peut-être incorrect.', E_USER_NOTICE);
            return 0;
        }

        return $this->position = $matches[1];
    }

    public function getVotes(){
        if($this->votes!==-1)
            return $this->votes;

        $matches = array();
        if(!$code = $this->loadPage()){
            trigger_error('RpgApi->getVotes() : récupération impossible du nombre de votes...', E_USER_NOTICE);
            return 0;
        }
        
        if(!preg_match('#>Vote : ([0-9]+)</a>#', $code, $matches)){
            trigger_error('RpgApi->getVotes() : La page à été chargée avec succès, mais il est impossible de trouver le nombre de votes. L\'id est peut-être incorrect.', E_USER_NOTICE);
            return 0;
        }

        return $this->votes = $matches[1];
    }

    public function getOut(){
        if($this->out!==-1)
            return $this->out;

        $matches = array();
        if(!$code = $this->loadPage()){
            //trigger_error('RpgApi->getOut() : récupération impossible du nombre de redirection vers le site...', E_USER_NOTICE);
            return 0;
        }

        if(!preg_match('#Clic Sortant : ([0-9]+)#', $code, $matches)){
            //trigger_error('RpgApi->getOut() : La page à été chargée avec succès, mais il est impossible de trouver le nombre de redirection vers le site. L\'id est peut-être incorrect.', E_USER_NOTICE);
            return 0;
        }

        return $this->out = $matches[1];
    }

    public function redirectVote(){
        if(!headers_sent())
            header('location: http://www.rpg-paradize.com/?page=vote&vote='.$this->id);
        else
            echo '<meta http-equiv="refresh" content="0;url=http://www.rpg-paradize.com/?page=vote&vote='.$this->id.'"/>';
    }

    public function redirectDescription(){
        if(!headers_sent())
            header('location: http://www.rpg-paradize.com/site--'.$this->id);
        else
            echo '<meta http-equiv="refresh" content="0;url=http://www.rpg-paradize.com/site--'.$this->id.'"/>';
    }
}
?>