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

        $success = "Payment of sh $amount.00 to M-PESA was successful";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipa na M-PESA</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Lipa na m-pesa</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="#">About</a>
                <a class="nav-item nav-link" href="#">Contact</a>

            </div>
        </div>
    </nav>
    <div class="container">



        <div class="d-flex justify-content-center my-5 ">

            <div class="card w-75 ">
                <div class="card-header">
                    <h3 class="text-center mt-3">Lipa na M-PESA stk push</h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <label for="mobile">Mobile Number</label>
                        <div class="form-group">
                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="enter mobile" value="<?php echo $mobile ?>" required pattern="^[2][5][4]+[\d]{9,}$" title="25474356798">
                        </div>
                        <label for=amount">Amount</label>
                        <div class="form-group">
                            <input type="text" name="amount" id=amount" class="form-control" placeholder="enter amount" value="<?php echo $amount ?>" required pattern="^([1-9][0-9]?|100)$" title="sh 1.00 - sh 99.00">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-success" value="make payment">
                        </div>
                    </form>
                    <?php if ($success) : ?>
                        <div class="alert alert-success text-center alert-dismissible "> <?php echo $success ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php endif; ?>
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