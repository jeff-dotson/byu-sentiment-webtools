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
		<div ng-controller="MainCtrl" >
			
			<!-- Main jumbotron for a primary marketing message or call to action -->
			<!--<div class="jumbotron">
				<h1>Hello BYU!</h1>
				<p>I have some data I'd like you to look at...</p>
				<p><a class="btn btn-primary btn-lg" href="javascript:alert('Coming Soon')">Learn more &raquo;</a></p>
			</div>-->
						
			<?
				//Some initial setup
				$colTweets = $db->tweets;
				$colTerms = $db->searchTerms;
				
				$countTweets = $colTweets->count();
				$countTerms = $colTerms->count();
				
				//Getting the count of tweets collected in the last 3 hours
				$date = new Mongodate(time() - 3*60*60);
				$query = array("date" => array('$gt' => $date) );
				$last3hours = $colTweets->count($query);
				
				//Getting the count of tweets collected in the last 3 days
				$date = new Mongodate(time() - 60*60*24*3);
				$query = array("date" => array('$gt' => $date) );
				$last3days = $colTweets->count($query);
				
				//Getting the count of tweets collected in the last 3 minutes
				$date = new Mongodate(time() - 3*60);
				$query = array("date" => array('$gt' => $date) );
				$last3minutes = $colTweets->count($query);
				
				//Getting the count of tweets collected in the last 3 weeks
				$date = new Mongodate(time() - 3*60*60*24*7);
				$query = array("date" => array('$gt' => $date) );
				$last3weeks = $colTweets->count($query);
				
				//Getting the count of tweets collected in the last 3 months
				$date = new Mongodate(time() - 3*60*60*24*7*30);
				$query = array("date" => array('$gt' => $date) );
				$last3months = $colTweets->count($query);
				
				//Getting the database storage
				//$stats = $colTweets->stats(1024*1024);
				$stats = $db->command(array('dbStats' => 1));
				$size = $stats["dataSize"];
				$storageSize = (float)$stats["storageSize"] / (1024 * 1024); 
				$fileSize = (float)$stats["fileSize"] / (1024 * 1024);
				$dataSize = (float)$stats["dataSize"]/ (1024 * 1024);
				
				//$storageSize = $stats["storageSize"];
				
				
				
			?>
			
			<h2 style="margin: 10px auto 15px auto; width:400px; text-align:center;">Tweet Statistics</h2>
			<table class="table table-bordered" style="width:400px; margin:auto; text-align:right;" >
				<tr>
					<th>Metic</th>
					<th>Value</th>

				</tr>
				<tr>
					<td>Tweets collected in the last 3 <strong>minutes</strong></td>
					<td><?= number_format($last3minutes) ?></td>
				</tr>
				<tr>
					<td>Tweets collected in the last 3 <strong>hours</strong></td>
					<td><?= number_format($last3hours) ?></td>
				</tr>
				<tr>
					<td>Tweets collected in the last 3 <strong>days</strong></td>
					<td><?= number_format($last3days) ?></td>
				</tr> 
				<tr>
					<td>Tweets collected in the last 3 <strong>weeks</strong></td>
					<td><?= number_format($last3weeks) ?></td>
				</tr>
				<tr>
					<td>Tweets collected in the last 3 <strong>months</strong></td>
					<td><?= number_format($last3months) ?></td>
				</tr>
				<tr>
					<td>Tweets collected Total</td>
					<td><?= number_format($countTweets) ?></td>
				</tr>
				<tr>
					<td>Search Terms Total</td>
					<td><?= number_format($countTerms) ?></td>
				</tr>
				<tr>
					<td>dataSize <br>(filesize of data in database)</td>
					<td><?= number_format($dataSize) ?> <br>MB</td>
				</tr>
				<tr>
					<td>fileSize <br>(filesize of all data files that hold the database)</td>
					<td><?= number_format($fileSize) ?> <br>MB</td>
				</tr>
				<tr>
					<td>storageSize <br>(The total amount of space in bytes allocated to collections in this database for document storage)</td>
					<td><?= number_format($storageSize) ?> <br>MB</td>
				</tr>
			</table>
			<div style="text-align:center; margin:10px 0 10px 0; "><i>Retrieved <?= date("Y-m-d h:i:s",time()) ?></i></div>
			
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
