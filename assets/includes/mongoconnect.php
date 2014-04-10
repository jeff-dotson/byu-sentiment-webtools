<?

try{
	// Connecting to mongo
	$dbhost = 'localhost';
	$dbname = 'byu';
	//$dbhost = "10.122.213.49:27017";
	
	$m = new Mongo("mongodb://$dbhost");
	$db = $m->$dbname;
} catch(Exception $ex){
	
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);	
	exit;
}