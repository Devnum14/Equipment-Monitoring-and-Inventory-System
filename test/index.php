<?php

require "_function.php";


if (!empty($_SESSION["name"])) {
    header('Location: views/admin/dashboard');

} else {

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/login-style.css">
    <link rel="stylesheet" href="assets/css/toastr.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.css">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <title>LOGIN</title>

</head>

<body class="h-100" style="background-color: #eee;">

    <section class="login gradient-form p-sm-0 mx-sm-0 text-wrap m-5">
        <div class="container p-5 h-100 ">
            <div class="row d-flex justify-content-center align-items-center rounder">
                <div class="col-xl-11 shadow rounder">
                    <div class="row g-0 ">
                        <div class="col-lg-4 d-flex align-items-center" style="background-color: #6A040F;">
                            <div class="text-dark px-3 py-4 p-md-5 mx-md-4 ">
                                <div class="text-center mb-3">
                                    <img src="assets/img/logo.png" style="width: 120px; border-radius: 100%;"
                                        alt="logo">
                                </div>
                                <h4 class="mb-2 text-center text-wrap" style="color: #ffffff; font-weight: bold;">
                                    InSports: "A Comprehensive Sports Equipment Monitoring and Inventory System for UM
                                    Digos College"</h4>
                                <p class="mt-5 fs-5 justify-content-center text-center">
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-8 bg-white">
                            <div class="card-body p-xl-4 p-lg-4 p-md-2 p-sm-1 p-xs-5 p-xs-2 pt-sm-4 px-xs-5 p-4">

                                <div class="text-center mb-0">
                                    <img src="assets/img/logobackground.png" style="width: 130px;" alt="logo">
                                    <h4 class="fw-bold mt-1"><b>User Login</b></h4>
                                </div>

                                <form name="signinform" action="" method="POST" autocomplete="off">
                                    <p class="text-center fw-bold">Please Login your account</p>

                                    <input type="hidden" name="form" value="signin">

                                    <div
                                        class="form-outline mb-2 px-xl-5 px-lg-5 px-md-5 px-sm-5 mx-xl-5 mx-lg-5 mx-md-5 mx-sm-5 ">
                                        <input type="text" name="username" id="username" class="form-control"
                                            placeholder="Username" />
                                        <label class="form-label px-1" for="username">Username</label>
                                    </div>

                                    <div
                                        class="form-outline mb-2 px-xl-5 px-lg-5 px-md-5 px-sm-5 mx-xl-5 mx-lg-5 mx-md-5 mx-sm-5 ">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Password" />
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label px-1">Password</label>
                                            <!-- <label class="form-label px-1">Forget Pass</label> -->
                                        </div>
                                    </div>

                                    <div class="text-center mb-1 fs-6 col-15 mt-3">
                                        <button type="button" id="signin" class="btn btn-outline-dark fs-6">Login
                                            Now</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    <script src="assets/js/js.js"></script>
</body>

</html>