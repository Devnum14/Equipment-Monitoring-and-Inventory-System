<?php

include '../../config.php';

session_start();

if (!empty($_SESSION["name"])) {

    //----------EQUIPMENT REALTIME UPDATE--------------//

    $equipeTotal = dbConnection()->prepare("SELECT SUM(equipment_stock) FROM smi_equipment_tbl");
    $equipeTotal->execute();
    $fetchEquipeTotal = $equipeTotal->fetch();
    $TotalEquipe = $fetchEquipeTotal[0];

    $equipeDate = dbConnection()->prepare("SELECT MAX(equipment_dateadd) FROM smi_equipment_tbl");
    $equipeDate->execute();
    $fetchEquipeDate = $equipeDate->fetch();
    $DateEquipe = $fetchEquipeDate[0];


    if (empty($DateEquipe) || empty($TotalEquipe)) {
        $formattedDate_Equipe = "No Equipments Add";
        $formattedTotal_Equipe = 0;
    } else {
        $formattedDate_Equipe = date("M d, Y g:i A", strtotime($DateEquipe));
        $formattedTotal_Equipe = $TotalEquipe;
    }


    //----------BORROWED REALTIME UPDATE--------------//

    $individualQuantities = dbConnection()->prepare("SELECT smi_borrowed_equipmentName FROM smi_borrowed_tbl");
    $individualQuantities->execute();
    $fetchIndividualQuantities = $individualQuantities->fetchAll(PDO::FETCH_COLUMN);

    // Initialize total sum
    $totalSum = 0;

    // Loop through each individual quantity
    foreach ($fetchIndividualQuantities as $quantityString) {
        // Use regular expression to extract numeric values
        preg_match_all('/\d+/', $quantityString, $matches);

        // Add up the extracted numeric values
        $totalSum += array_sum($matches[0]);
    }

    // Now $totalSum contains the sum of all numeric values in smi_borrowed_equipmentName

    // Rest of your code remains the same

    $borrowDate = dbConnection()->prepare("SELECT MAX(smi_borrowed_dateBorrow) FROM smi_borrowed_tbl");
    $borrowDate->execute();
    $fetchBorrowDate = $borrowDate->fetch();
    $DateBorrow = $fetchBorrowDate[0];

    if (empty($DateBorrow) && empty($TotalBorrow)) {
        $formattedDate_Borrow = "No Borrows";
        $formattedTotal_Borrow = 0;
        $formattedTotal_BorrowDetails = "No Borrows";
    } else {
        $formattedDate_Borrow = date("M d, Y g:i A", strtotime($DateBorrow));
        $formattedTotal_Borrow = $totalSum; // Use $totalSum instead of $TotalBorrow
        $formattedTotal_BorrowDetails = implode('+', $fetchIndividualQuantities);
    }

    // Now you can use $formattedTotal_Borrow as the sum of numeric values
// and $formattedTotal_BorrowDetails as the formatted string.


    // Use $formattedTotal_BorrowDetails as needed

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




    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-light.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>





</head>

<style>
    @media (max-width: 768px) {
        .justify-content-center.al {
            text-align: center;
            margin-bottom: 20px;
        }

        .justify-content-center.al img {
            display: block;
            margin: 0 auto;
        }

        .justify-content-center.al .text-center {
            margin-top: 10px;
        }
    }

    .btn-menu {
        visibility: hidden;
        display: block;
    }

    .menu {
        visibility: hidden;
        display: none;
    }


    @media (max-width: 990px) {
        #sidebar {
            margin-left: -234px;
            max-width: 234px;
            min-width: 234px;
            transition: all 0.35s ease-in-out;
            box-shadow: 0 0 35px 0 rgba(49, 57, 66, 0.5);
        }

        #sidebar.collapsed {
            margin-left: 20px;
        }

        .menu {
            visibility: visible;
            display: block;
        }

        .btn-menu {
            visibility: visible;
            display: block;
        }
    }

    #calendar {
        max-width: 768px;
        height: auto;
        margin: 0 auto;
    }
</style>

<body class="text-dark">
    <div class="wrapper">
        <?php
        require 'sidebar.php';
        ?>
        <div class="main">
            <nav class="navbar navbar-fluid p-3 border-bottom nav-bar text-center">
                <button class="btn btn-menu" type="button" data-bs-theme="dark">
                    <i class="fa-sharp fa-solid fa-bars menu"></i>
                </button>

                <?php

                include 'ses_name.php';

                ?>

            </nav>

            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-3 grid-margin stretch-card mt-2 mx-1">
                        <div class="card" style="border: 3px solid #6A040F; border-radius: 10px;">
                            <a class="text-decoration-none btn-card-hovers p-2" href="equipments">
                                <div class="card-body">
                                    <p class="card-title text-xl-left fs-6 fw-bold">Total Equipment</p>
                                    <div
                                        class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">
                                            <?= $formattedTotal_Equipe ?>
                                        </h3>
                                    </div>
                                    <p class="mb-0 mt-2"
                                        style="letter-spacing: 1px; font-weight: 600; font-size: 14px;">Last Added:
                                    </p><span class="ms-0"><small>
                                            <?= $formattedDate_Equipe ?>
                                        </small></span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 grid-margin stretch-card mt-2 mx-1">
                        <div class="card" style="border: 3px solid #6A040F; border-radius: 10px;">
                            <a class="text-decoration-none btn-card-hovers p-2" href="Borrowed">
                                <div class="card-body">
                                    <p class="card-title text-xl-left fs-6 fw-bold">Total Borrowed Equipment</p>
                                    <div
                                        class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">
                                            <?= $formattedTotal_Borrow ?>
                                        </h3>
                                    </div>
                                    <p class="mb-0 mt-2"
                                        style="letter-spacing: 1px; font-weight: 600; font-size: 14px;">Last Added:
                                    </p><span class="ms-0"><small>
                                            <?= $formattedDate_Borrow ?>
                                        </small></span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 grid-margin stretch-card mt-2 mx-1">
                        <div class="card" style="border: 3px solid #6A040F; border-radius: 10px;">
                            <a class="text-decoration-none btn-card-hovers p-2" href="https://example.com">
                                <div class="card-body">
                                    <p class="card-title text-xl-left fs-6 fw-bold">Total Damage/Lost</p>
                                    <div
                                        class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">0</h3>
                                    </div>
                                    <p class="mb-0 mt-2"
                                        style="letter-spacing: 1px; font-weight: 600; font-size: 14px;">Last Added:
                                    </p><span class="ms-0"><small>
                                            <?= $formattedDate_Equipe ?>
                                        </small></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-expand px-4 mt-3">



                <!-- <div class="row-xs float-start shadow mx-4">
                    <!-- <div class="row px-3">
                    <div class="col-lg-12 px-3">
                        <h2>List View</h2>
                        <ul id="eventList"></ul>
                    </div>
                </div> -->


                <!-- <div class="col px-3">
                    <h2>List View</h2>
                    <ul id="eventList"></ul>
                </div> -->

            </div>
            <?php

            function print_specific_days()
            {
                $current_date = new DateTime();
                $current_day = $current_date->format('N'); // Numeric representation of the day (1 = Monday, 7 = Sunday)
                $day_name = $current_date->format('l'); // Full textual representation of the day
            
                if ($current_day == 1 || $current_day == 3 || $current_day == 5) {
                    echo '<div style="margin-bottom: 10px; margin-top: 20px;">Today is ' . $current_date->format('F j, Y') . ' (' . $day_name . ')</div>';
                    echo '<div class="fw-bold">VOLLEYBALL - (MEN AND WOMEN)</div>
                        5:30 - 7:30 = IN FRONT OF UMDC GYM<br>';
                    echo '<div class="fw-bold mt-3">BASKETBALL</div>
                        5:30 - 7:30 = UMDC GYM<br>';
                    echo '<div class="fw-bold mt-3">SEPAK TAKRAW</div>
                        5:30 - 7:30 = UMDC GYM<br>';
                    echo '<div class="fw-bold mt-3">TAEKWONDO - (MEN AND WOMEN)</div>
                        5:30 - 7:30 = UMDC GYM<br>';
                    echo '<div class="fw-bold mt-3">TRACK N FIELD - (MEN AND WOMEN)</div>
                        5:30 - 7:30 = UMDC GYM<br>';

                } else {
                    echo '<div style="margin-bottom: 10px; margin-top: 20px;">Today is ' . $current_date->format('F j, Y') . ' (' . $day_name . ')</div>';
                    echo '<div class="fw-bold">' . "There's no practice scheduled for today." . '</div>';
                }
            }


            ?>




            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div id="calendar" class="mb-5"></div>
                    </div>
                    <div class="col-lg-4 mx-0 mb-5">
                        <h3 class="">Schedule Practice</h3>
                        <?php
                        print_specific_days();
                        ?>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close1">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- First Column -->
                                <div class="col-lg-5 col-sm-12 mt-1">
                                    <span class="fw-bold fs-6">Equipment Name: </span>
                                </div>

                                <div class="col-lg-6 col-sm-12 mt-1">
                                    <span class="fs-6" id="eventID"></span>
                                </div>
                                <div class="col-lg-5 col-sm-12 mt-1">
                                    <span class="fw-bold fs-6">Borrower Name: </span>
                                </div>

                                <div class="col-lg-6 col-sm-12 mt-1">
                                    <span class="fs-6" id="borrowerName"></span>
                                </div>
                                <div class="col-lg-5 col-sm-12 mt-1">
                                    <span class="fw-bold fs-6">Student ID: </span>
                                </div>

                                <div class="col-lg-6 col-sm-12 mt-1">
                                    <span class="fs-6" id="StudentId"></span>
                                </div>
                                <div class="col-lg-5 col-sm-12 mt-1">
                                    <span class="fw-bold fs-6">Borrowed Date: </span>
                                </div>
                                <div class="col-lg-6 col-sm-12 mt-1">
                                    <span class="fs-6" id="eventStartDate"></span>
                                </div>
                                <div class="col-lg-5 col-sm-12 mt-1">
                                    <span class="fw-bold fs-6">Expected Return: </span>
                                </div>
                                <div class="col-lg-6 col-sm-12 mt-1">
                                    <span class="fs-6" id="eventEndDate"></span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="close">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            // Add an event listener to the close button
            document.getElementById('close').addEventListener('click', function () {
                // Hide the modal using Bootstrap's modal hide method
                $('#exampleModal').modal('hide');
            });

            document.getElementById('close1').addEventListener('click', function () {
                // Hide the modal using Bootstrap's modal hide method
                $('#exampleModal').modal('hide');
            });
        });

        $(document).ready(function () {
            display_events();
        });

        function display_events() {
            var events = new Array();
            $.ajax({
                url: 'display_event.php',
                dataType: 'json',
                success: function (response) {
                    var result = response.data;
                    $.each(result, function (i, item) {
                        events.push({
                            event_id: result[i].smi_borrowed_id,
                            title: ' -> ' + result[i].smi_borrowed_studentId + ' Borrow: ' + result[i].totalQuantity,
                            title1: result[i].smi_borrowed_equipmentName, // Use the equipmentName as the event title
                            borrower: result[i].smi_borrowed_studentName,
                            studentId: result[i].smi_borrowed_studentId,
                            start: result[i].smi_borrowed_dateBorrow,
                            end: result[i].smi_borrowed_expReturn,
                        });


                        // Populate the list view
                        // $('#eventList').append('<li>' + result[i].smi_borrow_equipment_name + ' - ' +
                        //     result[i].smi_borrower_name + ' - ' +
                        //     moment(result[i].smi_borrowed_date).format('YYYY-MM-DD') + '</li>');
                    });

                    var calendar = $('#calendar').fullCalendar({
                        defaultView: 'month',
                        timeZone: 'local',
                        editable: false,
                        selectable: false,
                        selectHelper: false,
                        select: function (start, end) {
                            $('#event_start_date').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                            $('#event_end_date').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                            $('#exampleModal').modal('show');
                        },
                        events: events,
                        eventRender: function (event, element, view) {
                            element.find('.fc-title').css({
                                'margin-left': '2px'
                            });

                            element.bind('click', function () {
                                // Update the modal content with equipmentName
                                $('#eventID').html(event.title1.replace(/\n/g, '<br>'));
                                $('#borrowerName').text(event.borrower);
                                $('#StudentId').text(event.studentId);
                                $('#eventStartDate').text(moment(event.start).format('MMMM DD, YYYY HH:mm:ss'));
                                $('#eventEndDate').text(moment(event.end).format('MMMM DD, YYYY'));
                                $('#exampleModal').modal('show');
                            });


                        }
                    });
                },
                error: function (xhr, status) {
                    alert(response.msg);
                }
            });
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="../assets/js/admin-js.js"></script>
    <script>

    </script>
</body>

</html>