<?
	
	//Connecting to the database
	require_once "../includes/sqlsrvconnect.php";
	
	//Logging a user in
	if( !empty($_REQUEST["email"]) && !empty($_REQUEST["password"]) && empty($_REQUEST["register"]) ){
		
		//Verifying the user is in the DB
		$query = "SELECT COUNT(*) as count FROM tx_users WHERE email = '{$_REQUEST['email']}' AND password = '" .sha1($_REQUEST["password"])."'";
		$request = sqlsrv_query($conn,$query);
		$row = sqlsrv_fetch_object($request);
		
		//If we found the user, log them in
		if( $row->count == "1" ){
			
			//Grab the user and store it in the session
			$query = "SELECT * FROM tx_users WHERE email = '{$_REQUEST['email']}' AND password = '" .sha1($_REQUEST["password"])."'";
			$request = sqlsrv_query($conn,$query);
			$row = sqlsrv_fetch_object($request);
			
			if( $row->authorized == "0" ){
				header("location:../../login.php?msg=notauthorized");
				exit;
			}
			
			$_SESSION["user_id"] = $row->user_id;
			$_SESSION["email"] = $row->email;
			$_SESSION["authorized"] = (int)$row->access;
			
			
				
			//Send them to the right page
			header("location:../../taxonomyExt.php");
			exit;
		
		} else {
			header("location:../../login.php?msg=usernotfound");
			exit;
		}
	
	} elseif(!empty($_REQUEST["email"]) && !empty($_REQUEST["password"]) && !empty($_REQUEST["register"]) && $_REQUEST["register"] == "true"){			
			
			//Verifying the user is in the DB
			$query = "SELECT COUNT(*) as count FROM tx_users WHERE email = '{$_REQUEST['email']}' ";
			$request = sqlsrv_query($conn,$query);
			$row = sqlsrv_fetch_object($request);
			
			if( (int)$row->count > 0 ){
				header("location:../../login.php?msg=userexists");
				exit;	
			} else {
			
				//Verifying the user is in the DB
				$query = "INSERT INTO tx_users (email,password) VALUES('{$_REQUEST['email']}','" .sha1($_REQUEST["password"])."')";
				$request = sqlsrv_query($conn,$query);
				//echo $query;
				//exit;
				
				header("location:../../login.php?msg=registersuccess");
				exit;	
			
			}
		
	} else {
		
		//Send error headers and redirect
		header("location:../../login.php?msg=badparameters");
		exit;
		
	}