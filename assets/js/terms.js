// JavaScript Document
angular.module('myApp', ['ui.bootstrap'], function ($httpProvider){
  delete $httpProvider.defaults.headers.common['X-Requested-With'];
});

function MainCtrl($scope, $http, $document, $modal, orderByFilter) {
	
	$scope.terms = []	//This is the loaded website on the page
	$scope.term = {};
	
	//Getting Database Stats
	$scope.getTerms = function(){
		
		var payload = {"action":"getTerms"};
		console.log("Getting Terms",payload);		
		
		//Getting the active runs from the server
		$http({method: 'POST', url: 'assets/scripts/terms.php', data:payload})
		.success(function(data, status, headers, config) {
			console.log("Got Terms",data);
			$scope.terms = data;
			
		})
		.error(function(data, status, headers, config){});
	}
	
	$scope.deleteTerm = function(term){
		
		var payload = {"action":"deleteTerm","term":term};
		console.log("Deleting Term",payload);		
		
		//Getting the active runs from the server
		$http({method: 'POST', url: 'assets/scripts/terms.php', data:payload})
		.success(function(data, status, headers, config) {
			console.log("Deleted Term",data);
			$scope.getTerms();
			
		})
		.error(function(data, status, headers, config){});
	}

	$scope.addTerm = function(){
		
		if( $scope.term.term == "" ){ alert("The term cannot be left blank"); }
		
		var payload = {"action":"addTerm","term":$scope.term};
		console.log("Adding Term",payload);		
		
		//Getting the active runs from the server
		$http({method: 'POST', url: 'assets/scripts/terms.php', data:payload})
		.success(function(data, status, headers, config) {
			console.log("Added Term",data);
			$scope.terms.push(data);
			$scope.term.term = "";
		})
		.error(function(data, status, headers, config){});
	}
 }
 
// - - - - - - Modal Dialog Controls - - - - - - //
 
var ModalDemoCtrl = function ($scope, $modal, $log) {
	//Opening the Modal Dialog
	$scope.open = function (template) {
		modalInstance = $modal.open({
			templateUrl: 'assets/templates/' + template,
			controller: ModalInstanceCtrl
    	});
	};
};

var ModalInstanceCtrl = function ($scope, $modalInstance) {
	$scope.close = function () {
		$modalInstance.close();
	};
};