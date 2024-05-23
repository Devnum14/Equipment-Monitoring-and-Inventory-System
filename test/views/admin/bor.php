<?php

require '_function.php';

session_start();

if (!empty($_SESSION["name"])) {

} else {
    header('Location: ../../index.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <!-- <link rel="stylesheet" href="../../assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <!-- BOOTSTRAP -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">


    <!-- DataTables and Buttons JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <link rel="stylesheet" href="../assets/css/table.min.css">

    <style>
        @media screen and (min-width: 1200px) {
            .margined {
                margin-right: 130px;
                /* Adjust the margin value as needed */
            }
        }

        @media screen and (max-width: 1200px) {
            .margined {
                margin-right: 90px;
                /* Adjust the margin value as needed */
            }
        }
    </style>

</head>



<body class="text-dark">
    <div class="wrapper">
        <!-- Sidebar -->
        <?php
        require 'sidebar.php';
        ?>
        <!-- Main Component -->
        <div class="main">
            <nav class="navbar navbar-fluid p-2 border-bottom nav-bar text-center">
                <!-- Button for sidebar toggle -->
                <button class="btn" type="button" data-bs-theme="dark">
                    <i class="fa-sharp fa-solid fa-bars menu"></i>
                </button>


                <?php
                require 'ses_name.php';
                ?>

            </nav>

            <main class="content mx-4 items-align-center p-3">
                <div class="row mt-2 margined">
                    <div class="col-xl-10 col-lg-9 col-md-12">
                        <div class="card">
                            <div class="card-header fw-bold fs-5">
                                Borrowed List
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table" id="myTable1" style="font-size: 14px;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th>Equipment</th>
                                                <th>Quantity</th>
                                                <th>Borrower</th>
                                                <th>School ID</th>
                                                <th>Borrowed Date</th>
                                                <th>Expected Return</th>
                                                <th>Action</th>
                                                <!-- <th class="text-center">Return</th>
                                                <th class="text-center">Dispose</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // pull the method selectFruits() out of function.php to get the fruits
                                            $getBorrows = selectBorrows();

                                            //populate the table data by looping the array result
                                            while ($borrows = $getBorrows->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?= $borrows['smi_borrowed_id'] ?>
                                                    </td>
                                                    <?php
                                                    $equipmentList = explode("\n", $borrows['smi_borrowed_equipmentName']);
                                                    echo '<td class="text-center">';
                                                    foreach ($equipmentList as $equipment) {
                                                        list($equipmentName, $quantity) = explode(' - ', $equipment);
                                                        $words = explode(' ', $equipmentName);

                                                        if (count($words) === 1) {
                                                            echo '<div class="mt-0 fw-bold">' . $words[0] . ',</div><br>';
                                                        } else {
                                                            $lastIndex = count($words) - 1;
                                                            foreach ($words as $index => $word) {
                                                                echo '<div class="mt-0 fw-bold">' . $word;
                                                                if ($index < $lastIndex) {
                                                                    echo ',';
                                                                }
                                                                echo '</div><br>';
                                                            }
                                                        }
                                                    }
                                                    echo '</td>';
                                                    echo '<td class="text-center">';
                                                    foreach ($equipmentList as $equipment) {
                                                        list($equipmentName, $quantity) = explode(' - ', $equipment);
                                                        $words = explode(' ', $quantity);

                                                        foreach ($words as $word) {
                                                            echo '<div class="fw-bold">' . $word . ',</div><br>';
                                                        }

                                                    }
                                                    echo '</td>';
                                                    ?>

                                                    <!-- <td style="max-width: 250px !important;">
                                                        <?php
                                                        $equipmentList = explode("\n", $borrows['smi_borrowed_equipmentName']);
                                                        foreach ($equipmentList as $equipment) {
                                                            list($equipmentName, $quantity) = explode(' - ', $equipment);
                                                            echo '<div class="row">
                                                            <div class="col-lg-8" mt-1>
                                                                <span class="fw-bold fs-6">' . $equipmentName . '</span>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <span class="fs-6">' . $quantity . '</span>
                                                            </div>
                                                        </div>';
                                                        }
                                                        ?>
                                                    </td> -->
                                                    <td class="mt-1">
                                                        <?= $borrows['smi_borrowed_studentName'] ?>
                                                    </td>
                                                    <td class="mt-1">
                                                        <?= $borrows['smi_borrowed_studentId'] ?>
                                                    </td>
                                                    <td class="text-center mt-1">
                                                        <?= date("M d, Y g:i A", strtotime($borrows['smi_borrowed_dateBorrow'])) ?>
                                                    </td>
                                                    <td class="text-center mt-1">
                                                        <?= date("M d, Y", strtotime($borrows['smi_borrowed_expReturn'])) ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-md-group">
                                                            <button type="button"
                                                                class="btn-primary btn-sm dropdown-toggle "
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                                    data-target="#returnModal_<?= $borrows['smi_borrowed_id'] ?>">Return</a>
                                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                                    data-target="#disposeModal_<?= $borrows['smi_borrowed_id'] ?>">Dispose</a>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <!-- <td class="text-center">
                                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                            data-bs-target="#return_<?= $borrows['smi_borrowed_id'] ?>"
                                                            style="font-size: 13px">
                                                            Return
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#dispose_<?= $borrows['smi_borrowed_id'] ?>"
                                                            style="font-size: 13px">
                                                            Dispose
                                                        </button>
                                                    </td> -->
                                                </tr>

                                                <!-- RETURN -->

                                                <div class="modal" id="returnModal_<?= $borrows['smi_borrowed_id'] ?>"
                                                    tabindex="-1" role="dialog" aria-labelledby="returnModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="returnModalLabel">Return Action
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Add content for the Return modal here -->
                                                                <p>
                                                                    <?php echo $borrows['smi_borrowed_id']; ?>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <!-- Add additional buttons or actions if needed -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <?php include '../assets/js/_scripts.php'; ?>
    <?php include '../assets/js/_alerts.php'; ?>


    <!-- Modal -->\

    <script>
        $(document).ready(function () {
            // Initialize Bootstrap dropdown
            $('.dropdown-toggle').dropdown();
        });
    </script>


    <script src="../assets/js/table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>


    <script src="../assets/js/admin-js.js"></script>


</body>

</html>