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
            templateUrl: 'view/connections.html',
            controller: 'loggerCtrl'
        })
        .when('/commandes', {
            templateUrl: 'view/commandes.html',
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
var myAppControllers = angular.module('myAppControllers', ['ui.bootstrap', 'ngTable']);

myAppControllers.controller('mainWebCtrl', ['$scope', '$rootScope', '$location',
	function($scope, $rootScope, $location){
		$rootScope.actualPage = $location.path();
	}
]);

myAppControllers.controller('loggerCtrl', ['$scope', '$rootScope', '$http', '$filter', 'ngTableParams', '$location',
	function($scope, $rootScope, $http, $filter, ngTableParams, $location){
		$rootScope.actualPage = $location.path();
		$scope.applyTableFiltreCount = function($defer, data, params, total) {
			var filteredData = params.filter() ? $filter('filter')(data, params.filter()) : data;				
			var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
			params.total(total); // set total for recalc pagination	
			$defer.resolve(orderedData);
		}

		$scope.connectionsTableParams = new ngTableParams({
			page: 1,
			count: 25,
			sorting: { Date: 'desc' }
		},
		{
			total: 0,
			getData: function($defer, params) {
				$http({
					method  : 'POST',
					url     : 'api.php',
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
