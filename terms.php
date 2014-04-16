<?
    require_once "assets/includes/mongoconnect.php";
	set_time_limit(60);
	
?><!DOCTYPE html>
<html lang="en" ng-app="myApp"><!-- InstanceBegin template="/Templates/template.dwt" codeOutsideHTMLIsLocked="false" -->
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
  <link rel="shortcut icon" href="bootstrap/assets/ico/favicon.png">
  <!-- InstanceBeginEditable name="doctitle" -->
  <title>Listening Terms | BYU Analytics</title>
  <!-- InstanceEndEditable -->
  <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap/examples/theme/theme.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
	<script src="bootstrap/assets/js/jquery.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.0.8/angular.min.js"></script>
	<script src="bootstrap-gh-pages/ui-bootstrap-tpls-0.6.0.js"></script>
	<!-- InstanceBeginEditable name="head" -->
	<script src="assets/js/terms.js"></script>
	<style>
		#addTable input{ width:100%; }
		a{ cursor:pointer; }
	</style>
	<!-- InstanceEndEditable -->
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">BYU Analytics</a>
        </div>
        <div class="navbar-collapse collapse">
			<?php include ("assets/includes/nav.inc.php");?>
          <!-- 
		  <ul class="nav navbar-nav">
            <li id="navhome" ><a href="index.php">Home</a></li>
            <li id="navreportbuilder"><a href="../reportbuilder.html">Report Tools</a></li>
            
			<li id="navtaxonomy"><a href="../taxonomy.php">Taxonomy Tools</a></li>
            
			
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">SQL Server Tools <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="../sqlserversummary.php">Table Inspector</a></li>
                <li class="divider"></li>
                
                <li><a href="../sqlserver_dataquotas.php">Data Usage</a></li>
              </ul>
            </li>
			
          </ul>
		  -->
        </div><!--/.nav-collapse -->
      </div>
    </div>
	
    <div class="container theme-showcase">
		
		<!-- It all starts here -->
		<!-- InstanceBeginEditable name="EditRegionContainer" -->
		<div ng-controller="MainCtrl" ng-init="getTerms()" >
			
			<!-- Main jumbotron for a primary marketing message or call to action -->
			<!--<div class="jumbotron">
				<h1>Hello BYU!</h1>
				<p>I have some data I'd like you to look at...</p>
				<p><a class="btn btn-primary btn-lg" href="javascript:alert('Coming Soon')">Learn more &raquo;</a></p>
			</div>-->
						
			<h2>Add Listening Term</h2>
			<table id="addTable" class="table table-condensed" style="margin-top:10px;">
				<tr>
					<th>term</th>
					<th>industry</th>
					<th>screen_name</th>
					<th>type</th>
					<th style="text-align:center;">action</th>
				</tr>
				<tr>
					<td><input class="form-control" type="text" placeholder="term (i.e. @twitter)" ng-model="term.term" /></td>
					<td><input class="form-control" type="text" placeholder="industry" ng-model="term.industry" /></td>
					<td><input class="form-control" type="text" placeholder="screen_name" ng-model="term.screen_name" /></td>
					<td><input class="form-control" type="text" placeholder="type" ng-model="term.type" /></td>
					<td style="text-align:center;"><button type="button" class="btn btn-sm btn-info" ng-click="addTerm()">Add</button></td>
				</tr>
			</table>

			<h2>Current Listening Terms</h2>
			<table class="table table-bordered table-condensed" style="margin-top:10px;">
				<tr>
					<th>term</th>
					<th>industry</th>
					<th>screen_name</th>
					<th>type</th>
					<th>action</th>
				</tr>
				<tr ng-repeat="term in terms">
					<td>{{term.term}}</td>
					<td>{{term.industry}}</td>
					<td>{{term.screen_name}}</td>
					<td>{{term.type}}</td>
					<td><a ng-click="deleteTerm(term)">Delete</a></td>
				</tr>
			</table>
			
		</div>

		<!-- /container -->
	<!-- InstanceEndEditable -->
	</div>
	</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bootstrap/assets/js/holder.js"></script>
  </body>
<!-- InstanceEnd --></html>
