var app = angular.module("myApp", ['ngSanitize']); 
app.controller("main-controller", function($scope, $http, $timeout)
{ 
	// Local variables 
	var all_ops = ["=", "<>", ">", "<", ">=", "<="];
	var	less_ops = [all_ops[0], all_ops[1]];
	var datatype = [
		{ name: "varchar",	operators: less_ops,  typeof: /^varchar\(.*\)$/,	regex: /^.*$/		},
		{ name: "int", 		operators: all_ops,   typeof: /^int\(.*\)$/,		regex: /^[0-9]+$/	},
		{ name: "tinyint", 	operators: less_ops,  typeof: /^tinyint\(.*\)$/,	regex: /^[T,F]$/	},
		{ name: "datetime",	operators: all_ops,   typeof: /^datetime$/, regex: /^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/	},
		{ name: "float",	operators: all_ops,   typeof: /^float$/,			regex: /^\d+(\.\d+)?$/	},
	];
	var currentType = null;

	function refreshSelect(){
		$timeout(function() {
			$('select').material_select();
		}, 500);
	}

	// Global Variables (Variables binded into the html view)
	$scope.item = {};
	$scope.regex = /^.+$/; 
	$scope.currentTable = null; 
	$scope.currentAttribute = null;
	$scope.tables 		= [];
	$scope.tableDesc 	= [];
	$scope.operators 	= [];
	$scope.sPredicates	= []; 
	$scope.sections = [
		"Seleccionar Relación",
		"Generar Predicados Simples",
		"Visualizar Predicados Simples",
		"Generar Predicados minitérminos"
	];	
	$timeout(function() { $('.scrollspy').scrollSpy();	}, 1000);

	/** 
	  * Get tables.
	  * Server petition that returns an array of the tables 
	  * names (Strings).
		  */
	$http.get("php/do.php", { params: { "do":"getTables" }
	}).then(function(response){ 
		$scope.tables = response.data;
		refreshSelect();				 
	}); 

	/** 
	  * Get table description.
	  * Server petition that in base of a table returns an array 
	  * of its attributes as objects.
	  *
	  * object {
	  * 	Field: ...,
	  * 	Type:  ...,
	  * 	Null:  ...,
	  * 	Key:   ...,
	  * 	Extra: ...,
	  * 	Default: ...
	  * } 
	*/
	$scope.getTableDesc = function()
	{ 
		$scope.currentTable = $scope.tables[$scope.item.table]; 
		$http.get("php/do.php", { params: { "do":"getTableDesc", "table":$scope.currentTable }
		}).then(function(response){    
			$scope.tableDesc = response.data;
			$scope.getOperator();
			refreshSelect();
		});
	}; 

	/** 
	  * Get the operators.
	  * According the field selected determine the valid
	  * theta operators and determine if the comparation value is
	  * correct. 
	*/
	$scope.getOperator = function(){

		// Validations
		if($scope.item == undefined)			return;
		if($scope.item.attribute == undefined)	return;

		//Get the selected attribute
		$scope.currentAttribute = $scope.tableDesc[$scope.item.attribute]; 

		// Loop through the datatype till find a match		  
		angular.forEach(datatype, function(object, key){
			if(object.typeof.test($scope.currentAttribute.Type)){ 
				// Set the operators and regex to validate the comparation value
				$scope.regex = object.regex; 
				$scope.operators = object.operators;  
				currentType = object.name;
				refreshSelect();
				// Break the loop
				return false;
			}
		}); 
	};

	/** 
	  * Set a new simple predicate.
	  * Push a new simple predicate in the array
	*/
	$scope.setSimplePredicate = function(){ 

		switch(currentType){
			case "varchar":
				$scope.item.value = "\""+ $scope.item.value+"\"";
				break;
		} 

		$scope.sPredicates.push({
			table: $scope.currentTable,
			attr: $scope.currentAttribute,
			operator: all_ops[$scope.item.operator],
			value: $scope.item.value
		}); 
	};

	// Validate the value to the regex datatype
	$scope.matchRegex = function(){ 
		if($scope.item.value == undefined || $scope.item.value == "")
			return false;
		if(!$scope.regex.test($scope.item.value))
			return false;
		return true; 
	};
});