<?php

if ($_POST) { 

	$purchase_code = $_POST['purchase_code'];  

	$api_key=''; //Your api key here
	$url = 'https://api.envato.com/v3/market/author/sale?code=' .$purchase_code;
	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Envato API Wrapper PHP)' );

	$header = array();
	$header[] = 'Content-length: 0';
	$header[] = 'Content-type: application/json';
	$header[] = 'Authorization: Bearer '. $api_key;

	curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);

	$data = curl_exec( $ch );
	curl_getinfo( $ch,CURLINFO_HTTP_CODE );
	curl_close( $ch );
	$response = json_decode( $data, true ); 

	echo '<div class="row">';
	echo '<div class="col-sm text-center">';

	if(empty($response['error'])){
		echo '<h2>Purchase Information</h2>';
		echo '<p> <b>Item Name:</b> '.$response['item']['name'].'</p>';
		echo '<p> <b>Buyer Name:</b> '.$response['buyer'].'</p>';
		echo '<p> <b>Purchase Date:</b> '.date('Y-m-d', strtotime($response['sold_at'])).'</p>'; 
		
		if(date('Y-m-d') > date('Y-m-d', strtotime($response['supported_until']))){
			echo '<p style="color: red; font-weight: bold;"> Support Expired!</p>';
		}else{
			echo '<p style="color: green;"> Support Available!</p>';
		} 
		
	}else{ 
		echo '<h2 style="color: red; font-weight: bold;">No Sale Found!</h2>';
	}
	echo '</div>';
	echo '</div>'; 
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Envato Validate Purchase Code</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body> 
	<div class="container">
		<?php  if (empty($_POST)) { ?>
			<form action="envato_purchase_validate.php" method="POST" class="form-horizontal"> 
			  	<div class="row">
			    	<div class="col-sm text-center">
			      		<h2>Please Enter Purchase Code</h2>
			    	</div>
			  	</div> 
			  	<div class="row">
			    	<div class="col-sm text-center">
			    		<div class="form-group">
			      			<input type="text" name="purchase_code" id="purchase_code" class="form-control">
			      		</div>
			    	</div>
			   </div>
			   <div class="row">
			    	<div class="col-sm text-center">
			    		<div class="form-group">
			      			<input type="submit" name="submit" value="Submit" class="btn btn-info">
			      		</div>
			    	</div>
			    </div> 
			</form>
		<?php }else{ ?>
			<div class="row">
		    	<div class="col-sm text-center">
		    		<div class="form-group">
		      			<a href="evp.php" class="btn btn-info" role="button">Go Back</a>
		      		</div>
		    	</div>
		    </div>  
		<?php } ?> 
	</div>
</body>
</html>
