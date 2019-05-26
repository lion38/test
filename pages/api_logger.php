<?php
	if(!isset($_SESSION['Neft-Gaming_connecter']) OR !$_SESSION['Neft-Gaming_connecter']) die();
	if(!isset($COMPTE->Login)) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
	else
	{
		if(!in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT'])) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
	}

	function checkIsAValidDate($myDateString){
	    return (bool)strtotime($myDateString);
	}

	$logArrayConfigured = array('connections' => 'characters_connections', 'commandes' => 'Commands', 'achatpnj' => 'NpcShopBuy', 'echangejoueurs' => 'PlayerTrade');
	if(!isset($_GET['logtype']) OR empty($_GET['logtype']) OR !array_key_exists(strtolower($_GET['logtype']), $logArrayConfigured)) die();
	//$_GET['logtype']

	$datasObject = array();
	$page = (isset($_POST['page']) AND is_numeric($_POST['page']) AND $_POST['page'] > 0) ? $_POST['page'] : 1;
	$count = (isset($_POST['count']) AND is_numeric($_POST['count']) AND $_POST['count'] > 0) ? $_POST['count'] : 1;
	$filter = (isset($_POST['filter']) AND !empty($_POST['filter'])) ? $_POST['filter'] : array();
	$sorting = (isset($_POST['sorting']) AND !empty($_POST['sorting'])) ? $_POST['sorting'] : null;
	$filter_save = $filter;
	$start = ($count * $page) - $count;

	if (isset($filter['DateShow']) AND checkIsAValidDate($filter['DateShow']))
	{
		$filter['Date'] = new MongoRegex('/^'.$filter['DateShow'].'/');
		unset($filter['DateShow']);
	}

	if (isset($filter['Username'])) {
		$resultado = $Sql->prepare('SELECT Id FROM accounts WHERE Login=:login') or die ($error);
		$resultado->bindvalue(':login', $filter['Username'], PDO::PARAM_STR);
		$resultado->execute();
		$resultado->setFetchMode(PDO::FETCH_OBJ);
		$filter['AcctId'] = (int) $resultado->fetch()->Id;
		$resultado->closeCursor();
		unset($filter['Username']);
	}

	if (isset($filter['Character'])) {
		$resultado = $Sql->prepare('SELECT Id FROM '. $CONFIG['db_world'] .'.characters WHERE Name=:name') or die ($error);
		$resultado->bindvalue(':name', $filter['Character'], PDO::PARAM_STR);
		$resultado->execute();
		$resultado->setFetchMode(PDO::FETCH_OBJ);
		$filter['CharacterId'] = (int) $resultado->fetch()->Id;
		$resultado->closeCursor();
		unset($filter['Character']);
	}

	if (isset($filter['FirstTrader'])) {
		$resultado = $Sql->prepare('SELECT Id FROM '. $CONFIG['db_world'] .'.characters WHERE Name=:name') or die ($error);
		$resultado->bindvalue(':name', $filter['FirstTrader'], PDO::PARAM_STR);
		$resultado->execute();
		$resultado->setFetchMode(PDO::FETCH_OBJ);
		$filter['FirstTraderId'] = (int) $resultado->fetch()->Id;
		$resultado->closeCursor();
		unset($filter['FirstTrader']);
	}

	if (isset($filter['SecondTrader'])) {
		$resultado = $Sql->prepare('SELECT Id FROM '. $CONFIG['db_world'] .'.characters WHERE Name=:name') or die ($error);
		$resultado->bindvalue(':name', $filter['SecondTrader'], PDO::PARAM_STR);
		$resultado->execute();
		$resultado->setFetchMode(PDO::FETCH_OBJ);
		$filter['SecondTraderId'] = (int) $resultado->fetch()->Id;
		$resultado->closeCursor();
		unset($filter['SecondTrader']);
	}

	if (isset($filter['IsToken']))
	{
		if(strtolower($filter['IsToken']) == 'true') $filter['IsToken'] = true;
		elseif(strtolower($filter['IsToken']) == 'false') $filter['IsToken'] = false;
		else unset($filter['IsToken']);
	}

	foreach ($filter as $key => $value)
	{
		if (is_numeric($value))
			$filter[$key] = (int)$value;
	}

	foreach ($sorting as $key => $value)
	{
		$ordered = ($value == 'desc') ? -1 : 1;
		if($key == 'Username') $sorting = array('label' => 'AcctId','order' => $ordered);
		elseif($key == 'Character') $sorting = array('label' => 'CharacterId','order' => $ordered);
		elseif($key == 'FirstTrader') $sorting = array('label' => 'FirstTraderId','order' => $ordered);
		elseif($key == 'SecondTrader') $sorting = array('label' => 'SecondTraderId','order' => $ordered);
		elseif($key != 'DateShow') $sorting = array('label' => $key,'order' => $ordered);
		// DateShow inclus
		else $sorting = array('label' => '_id','order' => $ordered);

		break;
	}

	$options = array("connectTimeoutMS" => 5000);
	$m = new MongoClient( 'mongodb://Neft-Gaming:0RV7bC73I3n5ebQ@10.10.1.6:27017/Neft-Gaming',$options);

	$database   = $m->Neft-Gaming;
	$dbtouse = $logArrayConfigured[$_GET['logtype']];
	$collection = $database->$dbtouse;


	$cursor = $collection->find($filter);
	if($sorting != null) $cursor = $cursor->sort(array($sorting['label'] => $sorting['order']));
	$cursor = $cursor->skip($start)->limit($count);


	$datasCount = $collection->find($filter)->count();

	foreach ($cursor as $onedoc)
	{
		$data = (object)array();
		$data->DateShow = $onedoc['Date'];

		if(isset($onedoc['AcctId']))
		{
			$data->AcctId = $onedoc['AcctId'];
			$resultado = $Sql->prepare('SELECT Login FROM accounts WHERE Id=:id') or die ($error);
			$resultado->bindvalue(':id', $onedoc['AcctId'], PDO::PARAM_INT);
			$resultado->execute();
			$resultado->setFetchMode(PDO::FETCH_OBJ);
			$data->Username = $resultado->fetch()->Login;
			$resultado->closeCursor();
		}

		if(isset($onedoc['CharacterId']))
		{
			$data->CharacterId = $onedoc['CharacterId'];
			$resultado = $Sql->prepare('SELECT Name FROM '. $CONFIG['db_world'] .'.characters WHERE Id=:id') or die ($error);
			$resultado->bindvalue(':id', $onedoc['CharacterId'], PDO::PARAM_INT);
			$resultado->execute();
			$resultado->setFetchMode(PDO::FETCH_OBJ);
			$data->Character = $resultado->fetch()->Name;
			$resultado->closeCursor();
		}

		if(isset($onedoc['FirstTraderId']))
		{
			$data->FirstTraderId = $onedoc['FirstTraderId'];
			$resultado = $Sql->prepare('SELECT Name FROM '. $CONFIG['db_world'] .'.characters WHERE Id=:id') or die ($error);
			$resultado->bindvalue(':id', $onedoc['FirstTraderId'], PDO::PARAM_INT);
			$resultado->execute();
			$resultado->setFetchMode(PDO::FETCH_OBJ);
			$data->FirstTrader = $resultado->fetch()->Name;
			$resultado->closeCursor();
		}

		if(isset($onedoc['SecondTraderId']))
		{
			$data->SecondTraderId = $onedoc['SecondTraderId'];
			$resultado = $Sql->prepare('SELECT Name FROM '. $CONFIG['db_world'] .'.characters WHERE Id=:id') or die ($error);
			$resultado->bindvalue(':id', $onedoc['SecondTraderId'], PDO::PARAM_INT);
			$resultado->execute();
			$resultado->setFetchMode(PDO::FETCH_OBJ);
			$data->SecondTrader = $resultado->fetch()->Name;
			$resultado->closeCursor();
		}

		if($_GET['logtype'] == 'connections')
		{
			$data->IPAddress = $onedoc['IPAddress'];
			$data->Action = $onedoc['Action'];
		}
		elseif($_GET['logtype'] == 'commandes')
		{
			$data->Command = $onedoc['Command'];
			$data->Parameters = $onedoc['Parameters'];
		}
		elseif($_GET['logtype'] == 'achatpnj')
		{
			$data->ItemId = $onedoc['ItemId'];
			$data->Amount = $onedoc['Amount'];
			$data->FinalPrice = $onedoc['FinalPrice'];
			$data->IsToken = $onedoc['IsToken'];
		}
		elseif($_GET['logtype'] == 'echangejoueurs')
		{
			$data->FirstTraderKamas = $onedoc['FirstTraderKamas'];
			$data->SecondTraderKamas = $onedoc['SecondTraderKamas'];
			$data->FirstTraderItems = $onedoc['FirstTraderItems'];
			$data->SecondTraderItems = $onedoc['SecondTraderItems'];
		}

		array_push($datasObject, $data);
	}

	if (isset($filter['Date'])) { unset($filter['Date']); }
	if (isset($filter['AcctId'])) { $filter['Username'] = $filter_save['Username']; unset($filter['AcctId']); }
	if (isset($filter['CharacterId'])) { $filter['Character'] = $filter_save['Character']; unset($filter['CharacterId']); }

	$dataToReturn = array(
		'total' => $datasCount,
		'filter' => $filter,
		'list' => $datasObject
	);

	echo json_encode($dataToReturn);
?>