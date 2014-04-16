<?
    require_once "assets/includes/mongoconnect.php";
	set_time_limit(60);
	
?><!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/template.dwt" codeOutsideHTMLIsLocked="false" -->
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
  <link rel="shortcut icon" href="bootstrap/assets/ico/favicon.png">
  <!-- InstanceBeginEditable name="doctitle" -->
  <title>Date Breakdown | BYU Analytics</title>
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
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
      
	function drawChart() {
		var jsonData = $.ajax({
		url: "assets/scripts/data.php?action=byHour",
		dataType:"json",
		async: false
		}).responseText;
		
		var obj = JSON.parse(jsonData);
		console.log("data",obj );
		
		//Creating date objects
		for(var i in obj){
			if( i == 0 ) continue;
			
			var date = new Date(obj[i][0]);
			date.setHours(date.getHours() - 6 );
			obj[i] = [ date, obj[i][1] ];	
		}
		
		// Create our data table out of JSON data loaded from server.
		var data = google.visualization.arrayToDataTable(obj);
		
		//var data = new google.visualization.DataTable(mydata);
		
		var options = {
		title: 'Tweets Captured',
		curveType: 'function',
		'legend':'none'
		};
		
		// Instantiate and draw our chart, passing in some options.
		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		chart.draw(data, options);
	}

    </script>
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
		<div id="chart_div" style="width: 100%; height: 700px;"></div>

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
