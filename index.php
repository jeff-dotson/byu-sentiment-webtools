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
  <title>BYU Analytics | Home</title>
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
				$collection = $db->tweets;
				$count = $collection->count(array("lang" => "en"));
				
				//Getting all the screennames
				$terms = $db->searchTerms;
				$termCursor = $terms->find(array("type" => "user"));
				$screen_name = array();
				foreach($termCursor as $row){
					$screen_name[] = $row["screen_name"];
				}
				//print_r($screen_name);
				//$screen_name = array("Delta","united","JetBlue","SouthwestAir","VirginAmerica","AlaskaAir","AirAsia", "BritishAirways", "flyPAL", "KLM", "TAMAirlines","AmericanAir");
				
				$results = array();
				$resall = array();
				foreach($screen_name as $sn ){
				
					//Putting together the aggregate query
					$match1 = array('$match' =>
								array("entities.user_mentions" => array( 
									'$elemMatch' => array("screen_name" => $sn)
							))
						);
					$match2 = array( '$match' => array('lang' => "en" ) );
					$group = array(
						'$group' => array(
							"_id" => NULL,
							"avgSentiment" => array('$avg' => '$sentiment'),
							"numRows" => array('$sum'=>1)
						)
					);
				
					//Running the query
					$aggregate = array($match1,$match2,$group);			
					$cursor = $collection->aggregate($aggregate);
					
					//echo json_encode($aggregate);
					//exit;
					
					//Outputting Results
					//echo "<tr>\n<td>$sn</td>\n";
					
					//if( empty($doc[0]) ) continue;
					
					foreach($cursor as $doc){
						//echo $sn;
						//print_r($doc);
						@$row  = array(
							"name" => $sn,
							"rows" =>$doc[0]['numRows'],
							"avg" => round($doc[0]['avgSentiment'],3)					
						);
						@$results[(string)round($doc[0]['avgSentiment'],3)] = $row;
						
						//print_r($doc);
						
						//echo "<td>".$doc[0]['numRows']."</td>\n";
						//echo "<td>".round($doc[0]['avgSentiment'],2)."</td>\n";
						break;
		
						//echo $doc["_id"] . "</br>";	
						//if( $i++ == 10) break;
					}
					//echo "</tr>\n";
				
				}
				
				//array_multisort($results,SORT_NUMERIC,
				//print_r($results);
				krsort($results);
				//print_r($results);
				$overallAvgSentiment = 0;
				foreach($results as $r){
					$overallAvgSentiment += (float)$r['avg'];	
				}
				$overallAvgSentiment = $overallAvgSentiment/count($results);
				
				
			?>
			
			<h2 style="margin: 10px auto 15px auto; width:400px; text-align:center;">Airline Sentiment Analysis</h2>
			
			<div style="text-align:center; margin:0 0 10px 0; "><?= $count ?> english tweets @ <?= round($overallAvgSentiment,3) ?></div>
			<table class="table table-bordered" style="width:400px; margin:auto;" >
				<tr>
					<th>#</th>
					<th>Airline</th>
					<th># Tweets</th>
					<th>Avg. Sentiment</th>
				</tr>
				<?
					$i = 0;
					foreach($results as $r){
						$i++;
						echo "<tr><td>$i</td><td><a href='http://twitter.com/{$r['name']}'>{$r['name']}</a></td><td>{$r['rows']}</td><td>{$r['avg']}</td></tr>\n";
					}
				?>
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
