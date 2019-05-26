<?php
if(!isset($_SESSION['Neft-Gaming_connecter']) OR !$_SESSION['Neft-Gaming_connecter']) die();

if(isset($_GET['goToRPG']))
{
	header("Location: ".$CONFIG['vote']);
	die();
}

if(isset($_GET['close']))
{
	echo '<script>self.close();</script>';
	die();
}

if(isset($_GET['go']))
{
	$_SESSION['vote_go'] = time() + 600;
	$_SESSION['out_de_rpg'] = 0;
	
	
	$cache = $CONFIG['cache_folder'].'out_rpg_Neft-Gaming.cache';
	$expire = time() - 3800 + rand(10, 600); // 6h + 10min max
	//$expire = time() - 5;
										 
	if(!file_exists($cache) || filemtime($cache) <= $expire)
	{						
		$fileNotExist = FALSE;
		$out_cached = 999999999999999999;
		
		$RPG = new RpgApi($CONFIG['id_rpg']);
		$OUT = intval($RPG->getOut());
		
		if(file_exists($cache)) $out_cached = file_get_contents($cache);
		else $fileNotExist = true;
		
		if($OUT > $out_cached OR $fileNotExist)
		{
			ob_start();
			echo $OUT;
			$page = ob_get_contents();
			ob_end_clean();
			file_put_contents($cache, $page);
		}
		else
		{
			if($OUT > 0)
			{
				ob_start();
				echo $OUT;
				$page = ob_get_contents();
				ob_end_clean();
				file_put_contents($cache, $page);
			}
		}
	}
	
	if(file_exists($cache) AND date("m", time()) != date("m", filemtime($cache)))
	{
		ob_start();
		echo $OUT;
		$page = ob_get_contents();
		ob_end_clean();
		file_put_contents($cache, $page);
	}
	
	$_SESSION['out_de_rpg'] = file_get_contents($cache);
	
	//sleep(2000);
	
	if($_SESSION['out_de_rpg'] == 0) echo 'RPG_DOWN';
	else echo 'OK'; // $CONFIG['vote']
	die();
}
if(isset($_GET['out']))
{
	
	if(isset($_SESSION['vote_go']) AND $_SESSION['vote_go'] > time() AND isset($_SESSION['out_de_rpg']))
	{
		//if(isset($_GET['out'])) echo $_GET['out'];
		//if(isset($_SESSION['out_de_rpg'])) echo $_SESSION['out_de_rpg'];
		if(!empty(intval($_GET['out'])) AND intval($_GET['out']) == $_GET['out'] AND $_GET['out'] >= 0)
		{
			//if(($_GET['out'] >= ($_SESSION['out_de_rpg'] - 500) AND $_GET['out'] <= ($_SESSION['out_de_rpg'] + 500)) OR $_SESSION['out_de_rpg'] == 0)
			if(true)
			{
				if(empty($COMPTE->LastClientKey)) die();
				$realIP = get_real_ip();
				
				$query = $Sql->prepare('SELECT COUNT(*) FROM accounts WHERE LastVote > ? and (last_ip_web = ? OR LastConnectedIp = ? OR LastClientKey = ?)');
				$query->execute(array(date("Y-m-d H:i:s", (time() - (60*60*3))), $realIP, $realIP, $COMPTE->LastClientKey));
				$row = $query->fetch();
				$nbvoteIP = $row['COUNT(*)'];
				$query->closeCursor();
				
				$query = $Sql->prepare('SELECT LastVote, Votes FROM accounts WHERE Login = ? LIMIT 0,1');
				$query->execute(array($_SESSION['Neft-Gaming_login']));
				$row = $query->fetch();
				$ultimoVotof = $row['LastVote'];
				$nbdevoteTotaldeja = $row['Votes'];
				$query->closeCursor();
						
				$ecartminute = (time() - strtotime($ultimoVotof))/60; // TODO
				

					if ($ecartminute > 180)
					{
						if($nbvoteIP == 0)
						{
							$nbvotefinal = (empty($nbdevoteTotaldeja) OR $nbdevoteTotaldeja == NULL OR $nbdevoteTotaldeja == 0) ? 1 : $nbdevoteTotaldeja + 1;
							$query = $Sql->prepare('UPDATE accounts set LastVote = ?, Votes = ? , Tokens = Tokens + ? , last_ip_web = ?  WHERE Login = ?');
							$query->execute(array(date("Y-m-d H:i:s", (time())), $nbvotefinal, $CONFIG['nbr_vote'], $realIP, $_SESSION['Neft-Gaming_login']));
							$query->closeCursor();
							if(isset($_SESSION['vote_go'])) unset($_SESSION['vote_go']);
							if(isset($_SESSION['out_de_rpg'])) unset($_SESSION['out_de_rpg']);
							echo 'VOTE_OK';
						}
					}
			}
			else
				echo 'ERROR_OUT';
		}
		else
			echo 'ERROR_OUT';
	}
	else
	{
		echo 'TO_LATE';
	}
}
?>