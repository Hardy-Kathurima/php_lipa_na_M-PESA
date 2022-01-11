<?php

$mobile = $amount = $success = "";
$mobileRegex = "/^[2][5][4]+[\d]{9,}$/";
$amountRegex = "/^([1-9][0-9]?|100)$/";


if (isset($_POST["submit"])) {
    if (empty($_POST['mobile']) || empty($_POST["amount"])) {
        $mobile = $_POST["mobile"];
        $amount = $_POST["amount"];
    } else {
        $mobile = $_POST["mobile"];
        $amount = $_POST["amount"];
        if (preg_match($mobileRegex, $_POST['mobile'])) {
            $mobile = $_POST["mobile"];
        }
        if (preg_match($amountRegex, $_POST['amount'])) {
            $amount = $_POST["amount"];
        }

        date_default_timezone_set('Africa/Nairobi');

        # access token
        $consumerKey = 'PAFQk3PsEJApwhZEt3OdPPdppbmIr7cb'; //Fill with your app Consumer Key
        $consumerSecret = '534idfFAjtkAGCVR'; // Fill with your app Secret

        # define the variales
        # provide the following details, this part is found on your test credentials on the developer account
        $BusinessShortCode = '174379';
        $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

        /*
    This are your info, for
    $PartyA should be the ACTUAL clients phone number or your phone number, format 2547********
    $AccountRefference, it maybe invoice number, account number etc on production systems, but for test just put anything
    TransactionDesc can be anything, probably a better description of or the transaction
    $Amount this is the total invoiced amount, Any amount here will be 
    actually deducted from a clients side/your test phone number once the PIN has been entered to authorize the transaction. 
    for developer/test accounts, this money will be reversed automatically by midnight.
  */

        $PartyA = $_POST['mobile']; // This is your phone number, 
        $AccountReference = '2255';
        $TransactionDesc = 'Test Payment';
        $Amount = $_POST['amount'];;

        # Get the timestamp, format YYYYmmddhms -> 20181004151020
        $Timestamp = date('YmdHis');

        # Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
        $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

        # header for access token
        $headers = ['Content-Type:application/json; charset=utf8'];

        # M-PESA endpoint urls
        $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        # callback url
        $CallBackURL = 'https://lipa-na-m-pesa-hardy.herokuapp.com//callback_url.php';

        $curl = curl_init($access_token_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);
        $access_token = $result->access_token;
        curl_close($curl);

        # header for stk push
        $stkheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

        # initiating the transaction
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $initiate_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => $Password,
            'Timestamp' => $Timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $BusinessShortCode,
            'PhoneNumber' => $PartyA,
            'CallBackURL' => $CallBackURL,
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionDesc
        );

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);

        $success = "Payment of sh $amount.00 to M-PESA was successful";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process payment</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center my-4">
            <div class="col-md-8">
                <div class="payment">
                    <div class="alert alert-success text-center alert-dismissible "> <?php echo $success ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                    <h3 class="text-center"><?php echo $success ?></h3>
                    <p class="text-center">Thankyou for shopping with us</p>
                    <a href="index.php">Go Back to shopping</a>
                </div>

            </div>
        </div>
    </div>
    <script src="public/jquery-3.4.1.min.js"></script>
    <script src="public/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".alert").delay(3000).slideDown(200, function() {
                $(this).alert('close');
            });
        });
    </script>
</body>

</html>