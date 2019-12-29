<?php
error_reporting(0); //warning hide

if(!isset($_POST['full_name'])){
    echo "Direct access restricted";
    exit();
}

if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['submit'])){
    $fullName=$_POST['full_name'];
    $email=$_POST['email_add'];
    $phone_number=$_POST['phone_number'];
    $university=$_POST['university'];
   
}


function rand_string( $length ) {
	$str="";
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++) { $str .= $chars[ rand( 0, $size - 1 ) ]; }
	return $str;
}
function redirect_to_merchant($url) {

	?>
    <html xmlns="http://www.w3.org/1999/xhtml">
      <head><script type="text/javascript">
        function closethisasap() { document.forms["redirectpost"].submit(); } 
      </script></head>
      <body onLoad="closethisasap();">
      
        <form name="redirectpost" method="post" action="<?php echo 'https://sandbox.aamarpay.com/'.$url; ?>"></form>
      </body>
    </html>
    <?php	
    exit;
} 

$cur_random_value=rand_string(10);


$url = 'https://sandbox.aamarpay.com/request.php';
$fields = array(
    'store_id' => '', 'amount' => '200', 'payment_type' => 'VISA',
    'currency' => 'BDT', 'tran_id' => $cur_random_value,
    'cus_name' => $fullName, 'cus_email' => $email,
    'cus_add1' => 'Dhaka', 'cus_add2' => 'Mohakhali DOHS',
    'cus_city' => 'Dhaka', 'cus_state' => 'Dhaka', 'cus_postcode' => '1206',
    'cus_country' => 'Bangladesh', 'cus_phone' => $phone_number,
    'cus_fax' => 'Not¬Applicable', 'ship_name' => $fullName,
    'ship_add1' => 'House B-121, Road 21', 'ship_add2' => 'Mohakhali',
    'ship_city' => 'Dhaka', 'ship_state' => 'Dhaka',
    'ship_postcode' => '1212', 'ship_country' => 'Bangladesh',
    'desc' => $university, 'success_url' => 'http://localhost/edu/success.php',
    'fail_url' => 'http://localhost/edu/fail.php',
    'cancel_url' => 'http://localhost/edu/cancel.php',
    'opt_a' => 'Reshad', 'opt_b' => 'Akil',
    'opt_c' => 'Liza', 'opt_d' => 'Sohel',
    'signature_key' => '');
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
$fields_string = rtrim($fields_string, '&'); 
$ch = curl_init();
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_URL, $url);  
curl_setopt($ch, CURLOPT_POST, count($fields)); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));	
curl_close($ch); 

redirect_to_merchant($url_forward);

?>