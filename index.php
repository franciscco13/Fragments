<!DOCTYPE html>
<html ng-app = "myApp" ng-cloak>
<head>
	<!-- Title -->
	<title></title>
	<!-- Meta tags -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name = "viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">	
	<meta charset="utf-8">
	<!-- CSS stylesheets -->
	<link rel="stylesheet" href="css/materialize.css">	
	<link rel="stylesheet" href="fonts/material-icons/material-icons.css">	
	<link rel="stylesheet" href="css/index.css">	
	<!-- Javascript files -->
	<script src = "lib/jquery.min.js"></script> 
	<script src = "lib/angular.min.js"></script>	
 	<script src = "lib/angular-sanitize.min.js"></script>
 	<script src = "lib/angular-filters.min.js"></script>
 	<script src = "lib/materialize/bin/materialize.min.js"></script>
</head>
<body ng-controller="main-controller"> 	

	<div class="top-background"></div>	
	<div class="table-of-contents-wrapper">
      	<ul class="section table-of-contents">
        	<li ng-repeat = "s in sections"><a href="#section-{{$index + 1}}">{{s}}</a></li> 
      	</ul>
    </div>
	
	<!-- Select Relation ******************************************************************* -->
	<section id = "section-1" class = "section scrollspy"> 
		<h6>{{sections[0]}}</h6>
		<div class = "input-field">
		    <select ng-change="getTableDesc()" ng-model="item.table"> 
		    	<option value="" disabled selected>Elige una relación</option>
		      	<option value="{{$index}}" ng-repeat="t in tables">{{t}}</option> 
		    </select>
		    <label>Relación</label>
		</div>
		<table class = "responsive-table">
			<thead><th colspan="{{tableDesc.length}}">{{currentTable}}</th></thead>
			<tbody>
				<tr><td ng-repeat = "td in tableDesc">{{td.Field}}</td></tr>
			</tbody>		
		</table>
	</section>


	<!-- Generate simples predicates  **************************************************** -->
	<section id = "section-2" class = "section scrollspy">	
		<h6>{{sections[1]}}</h6>
		<form name="form">
			<div class = "input-field">
			    <select ng-change="getOperator()" ng-model="item.attribute">
			    	<option value="" disabled selected>Elige un atributo</option>
			      	<option value="{{$index}}" ng-repeat="td in tableDesc">{{td.Field}}</option> 
			    </select>
			    <label>Atributo</label>
			</div>
			<div class = "input-field">
			    <select ng-model="item.operator"> 
			    	<option value="" disabled selected>Elige un operador</option>
			      	<option value="{{$index}}" ng-repeat="o in operators">{{o}}</option> 
			    </select>
			    <label>Operador Θ</label>
			</div>
			<div class="input-field">
	          	<input placeholder="Ingresa un valor" name="item_value" id="item_value" type="text" 
	          		ng-model = "item.value" ng-change = "matchRegex()">
	          	<label for="item_value">Valor</label>
	        </div>
	    </form>
	    <a class="fixed-accept waves-effect waves-light btn blue" 
	    	ng-disabled = "!matchRegex()" 
	    	ng-click = "!matchRegex() || setSimplePredicate()">Generar</a> 
	</section>


	<!-- Visualize simple predicates  ****************************************************** -->
	<section id = "section-3" class = "section scrollspy">		
		<h6>{{sections[2]}}</h6>
		<table class = "responsive-table">
			<tr ng-repeat = "sp in sPredicates">
				<td>{{sp.table}}.{{sp.attr.Field}}</td>
				<td>{{sp.operator}}</td>
				<td>{{sp.value}}</td>
			</tr>			
		</table>
	</section>


	<!-- Generate mini-term predicates  **************************************************** -->
	<section id = "section-4" class = "section scrollspy">	
		<h6>{{sections[3]}}</h6>	
	</section>
 	



 	<!-- angularJS controller -->
	<script src = "js/controller.js"></script>
	<!-- Materialize JS initializitations -->
	<script type="text/javascript">			
		$(function(){
			$('.modal-trigger').leanModal(); 
			$('select').material_select();
			$('.scrollspy').scrollSpy();
			Materialize.updateTextFields();
		});
	</script>


</body>
</html>