// js/script.js
'use strict';


/**
 * Déclaration de l'application myApp
 */
var myApp = angular.module('myApp', [
    'ngRoute',
	'myAppControllers',
]);

myApp.config(['$routeProvider',
    function($routeProvider) { 
        // Systéme de routage
        $routeProvider
        .when('/connections', {
            templateUrl: 'jscript/view/connections.html',
            controller: 'loggerCtrl'
        })
        .when('/commandes', {
            templateUrl: 'jscript/view/commandes.html',
            controller: 'loggerCtrl'
        })
        .when('/achatpnj', {
            templateUrl: 'jscript/view/achatpnj.html',
            controller: 'loggerCtrl'
        })
        .when('/echangejoueurs', {
            templateUrl: 'jscript/view/echangejoueurs.html',
            controller: 'loggerCtrl'
        })
        .otherwise({
            redirectTo: '/connections'
        });
    }
	
]);


/*

myAppControllers.controller('homeCtrl', ['$scope', '$rootScope', '$timeout',
    function($scope, $rootScope, $timeout)
    {


    }
]);
*/
var myAppControllers = angular.module('myAppControllers', ['ngTable']);

myAppControllers.controller('mainWebCtrl', ['$scope', '$rootScope', '$location',
	function($scope, $rootScope, $location){
		$rootScope.actualPage = $location.path();
	}
]);

myAppControllers.controller('loggerCtrl', ['$scope', '$rootScope', '$http', '$filter', 'ngTableParams', '$location',
	function($scope, $rootScope, $http, $filter, ngTableParams, $location){
		$rootScope.actualPage = $location.path();
		$scope.selectActionsConnect = [{ id: '', title: ""}, { id: 'Login', title: "Login"}, { id: 'Loggout', title: "Loggout"}];
		$scope.selectIsTokenAchatPnj = [{ id: '', title: ""}, { id: "true", title: "true"}, { id: "false", title: "false"}];
		$scope.applyTableFiltreCount = function($defer, data, params, total) {

			var filteredData = params.filter() ? $filter('filter')(data, params.filter()) : data;	
			var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
			params.total(total); // set total for recalc pagination	
			$defer.resolve(orderedData);
		}

		$scope.connectionsTableParams = new ngTableParams({
			page: 1,
			count: 25,
			sorting: { DateShow: 'desc' }
		},
		{
			total: 0,
			getData: function($defer, params) {
				$http({
					method  : 'POST',
					url     : 'index.php?page=api_logger&logtype=connections',
					data    : $.param(params.url()),
					headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
				})
				.success(function(datarow) {
					$scope.applyTableFiltreCount($defer, datarow.list, params, datarow.total);
				});
			}
		});



		$scope.commandesTableParams = new ngTableParams({
			page: 1,
			count: 25,
			sorting: { DateShow: 'desc' }
		},
		{
			total: 0,
			getData: function($defer, params) {
				$http({
					method  : 'POST',
					url     : 'index.php?page=api_logger&logtype=commandes',
					data    : $.param(params.url()),
					headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
				})
				.success(function(datarow) {
					$scope.applyTableFiltreCount($defer, datarow.list, params, datarow.total);
				});
			}
		});

		$scope.achatpnjTableParams = new ngTableParams({
			page: 1,
			count: 25,
			sorting: { DateShow: 'desc' }
		},
		{
			total: 0,
			getData: function($defer, params) {
				$http({
					method  : 'POST',
					url     : 'index.php?page=api_logger&logtype=achatpnj',
					data    : $.param(params.url()),
					headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
				})
				.success(function(datarow) {
					$scope.applyTableFiltreCount($defer, datarow.list, params, datarow.total);
				});
			}
		});

		$scope.echangejoueursTableParams = new ngTableParams({
			page: 1,
			count: 25,
			sorting: { DateShow: 'desc' }
		},
		{
			total: 0,
			getData: function($defer, params) {
				$http({
					method  : 'POST',
					url     : 'index.php?page=api_logger&logtype=echangejoueurs',
					data    : $.param(params.url()),
					headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
				})
				.success(function(datarow) {
					$scope.applyTableFiltreCount($defer, datarow.list, params, datarow.total);
				});
			}
		});
}
]);
