<ul class="nav navbar-nav">
	<!-- Core Digital Index Member Tools -->
	<? if( !empty($_SESSION["authorized"]) && $_SESSION["authorized"] == 2 ) { ?>
	<li id="navhome" ><a href="/login.php">Home</a></li>
	<!--<li id="navreportbuilder"><a href="/reportbuilder.php">Report Tools</a></li>-->
	<li id="navreportbuilder" class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Report Tools<b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="/index.php">Reports Running</a></li>
			<li><a href="/reportbuilder.php">Report Tools</a></li>
			<li><a href="/taxonomy_rss_admin.php">ReportSuiteSets Administration</a></li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">SQL Server Tools <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="/sqlserversummary.php">Table Inspector</a></li>
			<!-- <li class="divider"></li> -->
			<!--<li class="dropdown-header">Other Tools</li>-->
			<li><a href="/sqlserver_dataquotas.php">Data Usage</a></li>
		</ul>
	</li>
	<? } ?>
	
	<!-- Login/Logout -->
	<? if( !empty($_SESSION["email"]) ){ ?>
	<!-- Taxonomy Tools -->
	<li id="navtaxonomy" class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Taxonomy Tools<b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="/taxonomyExt.php">Classification</a></li>
			
			<? if( !empty($_SESSION["authorized"]) && $_SESSION["authorized"] == 2 ) { ?>
			<li class="divider"></li>
			<li><a href="/taxonomyInt.php">Internal Classification</a></li>
			<li><a href="/taxonomy.php">Old Classification</a></li>
			<li><a href="/taxonomy_arbitration.php">Arbitration</a></li>
			<li><a href="/taxonomy_listadmin.php">List Administration</a></li>
			<? } ?>
			
		</ul>
	</li>
	<li><a href="/assets/scripts/logout.php" style="color:yellow;"><?= $_SESSION["email"] ?> &nbsp; <span style="font-size:10px;">Logout</span></a></li>	
	<? } else { ?>
	<li><a href="/login.php">Login</a></li>
	<? } ?>
	
</ul>