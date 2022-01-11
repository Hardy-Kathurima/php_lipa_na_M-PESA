<?php
$mobile = $amount = $success = "";
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
        <a class="navbar-brand" href="#">Hardy Inc</a>
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
        <div class="row justify-content-center my-4  ">
            <div class="col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Lipa na M-PESA</h3>
                    </div>
                    <div class="card-body">
                        <form action="process.php" method="POST">
                            <label for="mobile">Mobile Number</label>
                            <div class="form-group">
                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="enter mobile" value="<?php echo $mobile ?>" required pattern="^[2][5][4]+[\d]{9,}$" title="25474356798">
                            </div>
                            <label for=amount">Amount</label>
                            <div class="form-group">
                                <input type="text" name="amount" id=amount" class="form-control" placeholder="enter amount" value="<?php echo $amount ?>" required pattern="^([1-9][0-9]?|100)$" title="sh 1.00 - sh 100.00">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-success" value="make payment">
                            </div>
                        </form>
                    </div>
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