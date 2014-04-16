<?
	
	//Connecting to the database
	require_once "../includes/mongoconnect.php";
	
	set_time_limit(0);
	
	$request_body = json_decode(file_get_contents('php://input'));	
	
	//Getting a random reportsuite
	if( empty($request_body) ){
		
		//Send error headers and redirect
		header('HTTP/1.0 400 Not Found');	
		echo json_encode(array("Error" => "No Request Body"));
		exit;
	
	}elseif( $request_body->action == "getTerms"){
		
		$terms = $db->searchTerms;
		$termCursor = $terms->find();
		$data = array();
		foreach($termCursor as $row){
			$data[] = $row;
		}
		
		header('Content-type: application/json');
		echo json_encode($data);
		exit;
	
	} elseif( $request_body->action == "deleteTerm" && is_object($request_body->term) ){
	 
		$terms = $db->searchTerms;
		$query = array("term" => $request_body->term->term);
		$termCursor = $terms->remove($query);
		
		header('Content-type: application/json');
		echo json_encode($request_body->term);
		exit;
	
	} elseif( $request_body->action == "addTerm" && is_object($request_body->term) ){ 
	 	
		$terms = $db->searchTerms;
		$termCursor = $terms->insert((array)$request_body->term);
		
		header('Content-type: application/json');
		echo json_encode($request_body->term);
		exit;
		
	} else {
		
		//Send error headers and redirect
		header('HTTP/1.0 404 Not Found');	
		echo json_encode(array("Error" => "Wrong Parameters","requestBody"=> $request_body));
		exit;
		
	}