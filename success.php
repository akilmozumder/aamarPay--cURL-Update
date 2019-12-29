<?php
if($_POST['pay_status']=="Successful"){
    $merTxnId= $_POST['mer_txnid'];
    
}

$curl_handle=curl_init();
curl_setopt($curl_handle,CURLOPT_URL,"https://sandbox.aamarpay.com/api/v1/trxcheck/request.php?request_id=$merTxnId&store_id=&signature_key=&type=json");

curl_setopt($curl_handle, CURLOPT_VERBOSE, true);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
$buffer = curl_exec($curl_handle);
curl_close($curl_handle);
$a = (array)json_decode($buffer);
echo "<pre>";
print_r($a);
echo "</pre>";

$paystatus=$a['pay_status'];
$mid=$a['mer_txnid'];
$status=$a['status_code'];


?>