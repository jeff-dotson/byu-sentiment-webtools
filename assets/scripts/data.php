<?
	
	//Connecting to the database
	require_once "../includes/mongoconnect.php";
	
	set_time_limit(0);
	
	@$request_body = json_decode(file_get_contents('php://input'));	
	
	//Getting a random reportsuite
	//if( empty($request_body) ){
		
	//	//Send error headers and redirect
	//	header('HTTP/1.0 400 Not Found');	
	//	echo json_encode(array("Error" => "No Request Body"));
	//	exit;
	
	//}else
	if( !empty($_GET["action"]) && $_GET["action"] == "byHourTest" ){
		
		$terms = $db->tweets;
		$keyf = new MongoCode("function(doc) {
			if( typeof doc.date == 'object' )
		   return { 'date' : doc.date.getFullYear() + '-' + (doc.date.getMonth()+1)+'-'+doc.date.getDate() + ' '+ doc.date.getHours() + ':' + '0' + ':' + '0'
					};
			else return {};
		}");
		$keys = array('$keyf' => $keyf);
		$initial = array("count" => 0);
		$reduce = new MongoCode("function(obj, prev) { prev.count++; }");
		$g = $terms->group($keyf, $initial, $reduce);
		
		print_r($g);
		
		//echo json_encode($g['retval']);
		
		//header('Content-type: application/json');
		//echo json_encode($g);
		exit;
	
	} elseif( !empty($_GET["action"]) && $_GET["action"] == "byHour"){
		// construct map and reduce functions
		$map = new MongoCode("function Map() {
		emit(
			this.date.getFullYear() + \"-\" + (this.date.getMonth()+1)+\"-\"+this.date.getDate() + \" \" + this.date.getHours() + \":\" + \"0\" + \":\" + \"0\",		
			{count:1}
		);}");
		$reduce = new MongoCode("function Reduce(key, values) {
			var reduced = {count:0};
			values.forEach(function(val) {
				reduced.count += val.count; 
			});
			return reduced;	
		}");
		$finalize = new MongoCode("function Finalize(key,reduced){ 
			var realdate = new Date(key);
			reduced.realdate = realdate;
			reduced.date = key;
			return reduced; 
		}");
		
		$data = $db->command(array(
			"mapreduce" => "tweets", 
			"map" => $map,
			"reduce" => $reduce,
			"finalize" => $finalize,
			//"query" => array("type" => "sale"),	//a custom query first
			//"out" => array("inline" => 1) //write to inline
			"out" =>"mr_dayhouraggr" //write to inline
		));
		
		$cursor = $db->mr_dayhouraggr->find();
		$cursor->sort(array("value.realdate" => 1));
		$data = array( array("Date","Tweets Captured") );
		foreach($cursor as $doc){
			$data[] = array($doc["value"]["date"],$doc["value"]["count"]);
		}
		
		header('Content-type: application/json');
		echo json_encode($data);
		exit;


	} else {
		
		//Send error headers and redirect
		header('HTTP/1.0 404 Not Found');	
		echo json_encode(array("Error" => "Wrong Parameters","requestBody"=> $request_body,"get"=>$_GET));
		exit;
		
	}