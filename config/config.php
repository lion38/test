<?php
// Config générale
$CONFIG['URL_SITE'] = "http://www.neft-gaming.com/"; // avec slash
$CONFIG['title'] = "Neft-Gaming - L'exclusivité servie sur un plateau";
$CONFIG['forum'] = "http://forum.neft-gaming.com";
$CONFIG['archive_install_uplauncher'] = ""; // Lien du dl de l'installateur contenant l'uplauncher
$CONFIG['presentation_link'] = "http://www.rpg-paradize.com/site-BETA+Neft+Gaming++Serveur+2.40+-103125";
$CONFIG['nbr_vote'] = 20; // Nombre de points par vote
// $CONFIG['nbr_vote_VIP'] = 30; // Nombre de points par vote en plus (pour VIP)(ex : 5 donneras : nbr_vote + 5 au total pour un vip)
$CONFIG['nb_ladder_par_page'] = 50; // Nombre de ladder par page
$CONFIG['nb_news_par_page'] = 4; // Nombre de news par page
$CONFIG['id_rpg'] = 103125;
$CONFIG['nb_de_ligne_par_classement'] = 25; // Nombre de ligne affiché dans chaque ladder
$CONFIG['ladder_show_Roles_less_than'] = 2; // Utilise pour hide les staff dans le classement (2 car ça prend < 2 donc 1 au max :) )

// Config Dedipass/points
$CONFIG['nbr_buy_points'] = 125; // Nombre de point en boutique
$CONFIG['dedipass_key'] = '7eadfeea8dca77b93af3d4d86842ebdd'; // Nombre de point en boutique
$CONFIG['boutique_offre_ogrine_double'] = false; // Valeur : True ou False, a activé pendant offre double points pour l'affichage
$CONFIG['paypal_array_ammont_allowed'] = array(5, 10, 15, 20, 30, 50, 60, 75, 100, 150);


$CONFIG['vote'] = "http://www.rpg-paradize.com/?page=vote&vote=".$CONFIG['id_rpg']; // lien vote principal // ABYSSIA
$CONFIG['vote2'] = "http://www.rpg-paradize.com/?page=vote&vote=103125"; // lien vote principal // SQUAREMC

// Nom des databases
$CONFIG['db_auth'] = "neftgamb_auth";
$CONFIG['db_world'] = "neftgamb_world";

// Marché des personnages
$CONFIG['marcheperso_classement_nbdeligne_partableau'] = "25"; // Le nombre de ligne affiché dans les tableau maximum (ensuite ça utilise la pagination)
$CONFIG['marcheperso_prixvente_mini'] = "700"; // Montant minimum en ogrines pour mettre un perso en vente
$CONFIG['marcheperso_idaccount_stackpersotosell'] = "1337991337"; //Id de du compte qui se connecteras jamais mais qui sert à stack les perso en vente
$CONFIG['marcheperso_array_etat'] = array(
	'annule' => -1,
	'wait_confirmation' => 0,
	'en_vente' => 1,
	'vendu' => 2
); 

// Administration 
// Ici les nom de compte des staff autorisé avec accés limité - STAFF DE BASE
$CONFIG['administration_login_allowed'] = array(); // SI personne , mettre array() et non array('') ou array("") !!

///!\NE PAS CHANGER/!\
// Ici les nom de compte des staffs avec un accés CUSTOM /!\ NE CHANGER QUE POUR GERER LES CHEF STAFF /!\
$CONFIG['administration_CHEF_STAFF'] = array('lion', 'ramadylan22'); //
///!\NE PAS CHANGER/!\

///!\NE PAS CHANGER/!\
// Ici les nom de compte des fondateurs accés ILLIMITE - FONDATEUR /!\NE PAS CHANGER/!\
$CONFIG['admin_a_pas_changer_FULL_DROIT'] = array('lion', 'ramadylan22');
///!\NE PAS CHANGER/!\

//Update les array admins
$CONFIG['administration_login_allowed'] = array_merge($CONFIG['administration_login_allowed'], $CONFIG['administration_CHEF_STAFF']);

#CACHE
$CONFIG['cache_folder'] = 'pages/cache_data/';
$CONFIG['cache_classement_seconde'] = 600; // Delais en seconde du cache de chaque page classement
$CONFIG['cache_news_seconde'] = 600; // Delais en seconde du cache pour recharger les news

$classe=array(
    1 => 'Feca',
    2 => 'Osamodas',
    3 => 'Enutrof',
	4 => 'Sram',
	5 => 'Xelor',
	6 => 'Ecaflip',
	7 => 'Eniripsa',
	8 => 'Iop',
	9 => 'Cra',
	10 => 'Sadida',
	11 => 'Sacrieur',
	12 => 'Pandawa',
	13 => 'Roublard',
	14 => 'Zobal',
	15 => 'Steamer',
	16 => 'Eliotrope',
	17 => 'Huppermage',
	18 => 'Ouginak');
	
$moisarray=array(
    '01' => 'janvier',
    '02' => 'fevrier',
    '03' => 'mars',
	'04' => 'avril',
	'05' => 'mai',
	'06' => 'juin',
	'07' => 'juillet',
	'08' => 'août',
	'09' => 'septembre',
	'10' => 'octobre',
	'11' => 'novembre',
	'12' => 'decembre');
	
$moisarray_short=array(
    '01' => 'JANV',
    '02' => 'FEV',
    '03' => 'MARS',
	'04' => 'AVRIL',
	'05' => 'MAI',
	'06' => 'JUIN',
	'07' => 'JUIL',
	'08' => 'AOUT',
	'09' => 'SEPT',
	'10' => 'OCT',
	'11' => 'NOV',
	'12' => 'DEC');
	
$joursarray=array(
    'Monday' => 'lundi',
    'Tuesday' => 'mardi',
    'Wednesday' => 'mercredi',
	'Thursday' => 'jeudi',
	'Friday' => 'vendredi',
	'Saturday' => 'samedi',
	'Sunday' => 'dimanche');
	
function get_real_ip()
{
    if( isset( $_SERVER ) )
    {
		if (isset($_SERVER["HTTP_X_REAL_IP"]))
		{
			$realip = $_SERVER["HTTP_X_REAL_IP"];
		}
        else if( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) )
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
		if( getenv( 'HTTP_X_REAL_IP' ) )
        {
            $realip = getenv( 'HTTP_X_REAL_IP' );
        }
        else if( getenv( 'HTTP_X_FORWARDED_FOR' ) )
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
?>