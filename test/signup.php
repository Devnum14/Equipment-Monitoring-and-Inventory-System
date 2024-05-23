<?php

include "_function.php";

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
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <title>LOGIN</title>

</head>

<body class="h-100" style="background-color: #eee;">

    <section class="login p-sm-0 mx-sm-0 ">
        <div class="container p-5 h-100 ">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-xl-11 shadow round">
                    <div class="row g-0 ">
                        <div class="col-lg-4 d-flex align-items-center" style="background-color: #6A040F;">
                            <div class="text-dark px-3 py-4 p-md-5 mx-md-4 ">
                                <div class="text-center mb-3">
                                    <img src="assets/img/logo.png" style="width: 120px; border-radius: 100%;"
                                        alt="logo">
                                </div>
                                <h4 class="mb-2 text-center fw-bold " style="color: #ffffff; font-weight: bold;">
                                    InSports: "A Comprehensive Sports Equipment Monitoring and Inventory System for UM
                                    Digos College"</h4>
                                <p class="mt-5 fs-5 justify-content-center text-center">
                                    <a href="index.php"><button type="button"
                                            class="btn btn-outline-warning fw-bold fs-6"
                                            style="letter-spacing: 2px;">SIGN IN</button></a>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-8 bg-white">
                            <div class="card-body p-xl-5 p-lg-4 p-md-2 p-sm-1 p-xs-5 p-xs-2 pt-sm-4 px-xs-5 p-4">


                                <form name="signupform" action="_function.php" method="POST" autocomplete="off">
                                    <p class="text-center fw-bold">Please Register your account</p>

                                    <input type="hidden" name="form" value="signup">

                                    <div
                                        class="form-outline mb-2 mt-2 px-xl-5 px-lg-5 px-md-5 px-sm-5 mx-xl-5 mx-lg-5 mx-md-5 mx-sm-5">
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Name" />
                                        <label class="form-label px-1" for="name">Name</label>
                                    </div>

                                    <div
                                        class="form-outline mb-2 mt-2 px-xl-5 px-lg-5 px-md-5 px-sm-5 mx-xl-5 mx-lg-5 mx-md-5 mx-sm-5">
                                        <input type="text" name="username" id="username" class="form-control"
                                            placeholder="Username" />
                                        <label class="form-label px-1" for="username">Username</label>
                                    </div>

                                    <div
                                        class="form-outline mb-2 px-xl-5 px-lg-5 px-md-5 px-sm-5 mx-xl-5 mx-lg-5 mx-md-5 mx-sm-5 ">
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="Email" />
                                        <label class="form-label px-1" for="email">Email</label>
                                    </div>

                                    <div
                                        class="form-outline mb-2 px-xl-5 px-lg-5 px-md-5 px-sm-5 mx-xl-5 mx-lg-5 mx-md-5 mx-sm-5 ">
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Password" />
                                        <label class="form-label px-1" for="password">Password</label>
                                    </div>

                                    <div
                                        class="form-outline px-xl-5 px-lg-5 px-md-5 px-sm-5 mx-xl-5 mx-lg-5 mx-md-5 mx-sm-5 ">
                                        <input type="password" name="retypepassword" id="retypepassword"
                                            class="form-control" placeholder="Retype Password" />
                                        <label class="form-label px-1" for="retypepassword">Retype Password</label>
                                    </div>

                                    <div
                                        class="form-outline px-xl-5 px-lg-5 px-md-5 px-sm-5 mx-xl-5 mx-lg-5 mx-md-5 mx-sm-5 mt-2">
                                        <select id="usertype" name="usertype"
                                            class="form-select form-select-md form-control mb-3 mx-1"
                                            aria-label=".form-select-lg example" style="width: auto;">
                                            <option selected value="">Select User</option>
                                            <option value="1">Student</option>
                                            <option value="2">Coach</option>
                                            <option value="3">Administrator</option>
                                        </select>
                                    </div>

                                    <div class="text-center mb-1 fs-6 col-15 mt-3">
                                        <button type="button" id="signup" class="btn btn-outline-dark fs-6">Register
                                            Now</button>
                                    </div>


                                    <div class="d-flex align-items-center mt-4 justify-content-center">
                                        <p class="mb-0 mx-3 fs-6">Have an account?</p>
                                        <a href="index.php"><button type="button"
                                                class="btn btn-outline-warning fs-6">Login Now</button></a>
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


    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    <script src="assets/js/js.js"></script>
    <script>


    </script>
</body>

</html>