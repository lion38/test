<!doctype html>
<html lang="fr" ng-app="myApp">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Amatic+SC:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link href="theme.css" rel="stylesheet">
	<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.2/angular.js"></script>
	<script src="https://code.angularjs.org/1.4.2/angular-route.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ng-table/0.8.3/ng-table.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ng-table/0.8.3/ng-table.js"></script>
	<script type="text/javascript" src="js/vendors/ui-bootstrap.js"></script>
	<script src="app.js"></script>
	<title>Neft-Gaming Logger</title>
</head>
<body ng-controller="mainWebCtrl">


    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#/connections"><strong style="color:white;">Neft-Gaming</strong> Logger</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li ng-class="{active: actualPage == '/connections'}"><a href="#/connections">Connections</a></li>
            <li ng-class="{active: actualPage == '/commandes'}"><a href="#/commandes">Commandes</a></li>
            <li ng-class="{active: actualPage == '/achatPnj'}"><a href="#/achatPnj">Achats PNJ</a></li>
            <li ng-class="{active: actualPage == '/echangeJoueurs'}"><a href="#/echangeJoueurs">Echanges Joueur</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="jumbo">
    <div class="jumbotron">
		<h3><span class="glyphicon glyphicon-chevron-right"></span> 
			<span ng-if="actualPage == '/connections'">Connections</span>
			<span ng-if="actualPage == '/commandes'">Commandes MJ</span>
			<span ng-if="actualPage == '/achatPnj'">Achats PNJ</span>
			<span ng-if="actualPage == '/echangeJoueurs'">Echanges Joueur</span>
		</h3>
    </div>
    </div>
	
    <div class="container underjumbo">
		<br />
		<span ng-view autoscroll="true"></span>
    </div>
	<!-- /container -->
</body>
</html>