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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">



    <!--BOOTSTRAP-->

    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-light.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <!--JAVASCRIPT-->


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
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

        .dropdown-menu li a:hover {
            background-color: #808080;
            color: white;
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

            <main class="content mx-4 mt-4
             items-align-center px-3 mb-4">
                <div class="row mt-0 margined">
                    <div class="col-xl-10 col-lg-9 col-md-12">
                        <div class="card">
                            <div class="card-header fw-bold fs-5">
                                Returned Equipment
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table" id="myTable1" style="font-size: 14px">
                                        <thead>
                                            <tr>
                                                <th class="text-center">R</th>
                                                <th class="text-center">Equipment</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Reason</th>
                                                <th class="text-center">Date Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // pull the method selectFruits() out of function.php to get the fruits
                                            $getDelete = fetchDelete();

                                            //populate the table data by looping the array result
                                            while ($delete = $getDelete->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?= $delete['smi_delete_id'] ?>
                                                    </td>
                                                    <?php
                                                    $equipmentList = explode("\n", $delete['smi_delete_equipmentName']);
                                                    echo '<td class="text-center">';
                                                    foreach ($equipmentList as $equipment) {
                                                        list($equipmentName, $quantity) = explode(' - ', $equipment);
                                                        $words = explode(' ', $equipmentName);

                                                        foreach ($words as $word) {
                                                            echo '<div class="fw-bold">' . $word . '</div>';
                                                        }

                                                    }
                                                    echo '</td>';
                                                    echo '<td class="text-center">';
                                                    foreach ($equipmentList as $equipment) {
                                                        list($equipmentName, $quantity) = explode(' - ', $equipment);
                                                        $words = explode(' ', $quantity);

                                                        foreach ($words as $word) {
                                                            echo '<div class="fw-bold">' . $word . '</div>';
                                                        }

                                                    }
                                                    echo '</td>';
                                                    ?>
                                                    <td class="text-center">
                                                        <?= $delete['smi_delete_reason'] ?>
                                                    </td>
                                                    <td class="text-center mt-1">
                                                        <?= date("M d, Y g:i A", strtotime($delete['smi_delete_date'])) ?>
                                                    </td>
                                                </tr>

                                                <!-- RETURN -->


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

    <script>
        $(document).ready(function () {
            // Initialize DataTable on page load
            var table1, table2;

            function initializeDataTable1() {
                table1 = $('#myTable').DataTable({
                    lengthMenu: [
                        [10, 20, -1],
                        [10, 20, 'All']
                    ],
                    pageLength: 6,
                    autoWidth: false,
                    ordering: true,
                    searching: true,
                    lengthChange: true,
                    info: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            text: '<i class="fas fa-copy"></i>',
                            className: '<clasbtn btn-primary',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                            init: function (dt, node, config) {
                                $(node).attr('title', 'COPY')
                                $(node).tooltip({
                                    container: 'body'
                                })
                            }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="fas fa-file-csv"></i>',
                            className: 'btn btn-primary',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                            init: function (dt, node, config) {
                                $(node).attr('title', 'CSV')
                                $(node).tooltip({
                                    container: 'body'
                                })
                            }
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel"></i>',
                            className: 'btn btn-primary',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                            init: function (dt, node, config) {
                                $(node).attr('title', 'EXCEL')
                                $(node).tooltip({
                                    container: 'body'
                                })
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fas fa-file-pdf"></i>',
                            className: 'btn btn-primary',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                            init: function (dt, node, config) {
                                $(node).attr('title', 'PDF')
                                $(node).tooltip({
                                    container: 'body'
                                })
                            }
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i>',
                            className: 'btn btn-primary',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6]
                            },
                            init: function (dt, node, config) {
                                $(node).attr('title', 'Print')
                                $(node).tooltip({
                                    container: 'body'
                                })
                            }
                        }
                    ],
                    language: {
                        buttons: {
                            copyTitle: 'Copy to clipboard',
                            copySuccess: {
                                1: 'Copied 1 row to clipboard',
                                _: 'Copied %d rows to clipboard'
                            }
                        }
                    }
                });
            }

            function initializeDataTable2() {
                table2 = $('#myTable1').DataTable({
                    lengthMenu: [
                        [10, 20, -1],
                        [10, 20, 'All']
                    ],
                    pageLength: 6,
                    autoWidth: false,
                    ordering: true,
                    searching: true,
                    lengthChange: true,
                    info: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            text: '<i class="fas fa-copy"></i>',
                            className: 'btn btn-primary',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            },
                            init: function (dt, node, config) {
                                $(node).attr('title', 'COPY')
                                $(node).tooltip({
                                    container: 'body'
                                })
                            }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="fas fa-file-csv"></i>',
                            className: 'btn btn-primary',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            },
                            init: function (dt, node, config) {
                                $(node).attr('title', 'CSV')
                                $(node).tooltip({
                                    container: 'body'
                                })
                            }
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel"></i>',
                            className: 'btn btn-primary',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            },
                            init: function (dt, node, config) {
                                $(node).attr('title', 'EXCEL')
                                $(node).tooltip({
                                    container: 'body'
                                })
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fas fa-file-pdf"></i>',
                            className: 'btn btn-primary',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            },
                            init: function (dt, node, config) {
                                $(node).attr('title', 'PDF')
                                $(node).tooltip({
                                    container: 'body'
                                })
                            }
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i>',
                            className: 'btn btn-primary',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            },
                            init: function (dt, node, config) {
                                $(node).attr('title', 'Print')
                                $(node).tooltip({
                                    container: 'body'
                                })
                            }
                        }
                    ],
                    language: {
                        buttons: {
                            copyTitle: 'Copy to clipboard',
                            copySuccess: {
                                1: 'Copied 1 row to clipboard',
                                _: 'Copied %d rows to clipboard'
                            }
                        }
                    }
                });
            }

            // Initialize DataTables on page load
            initializeDataTable1();
            initializeDataTable2();

            // Handle tab change event
            $('a[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
                // Destroy the DataTable instances on the inactive tabs
                if (table1) {
                    table1.destroy();
                }
                if (table2) {
                    table2.destroy();
                }

                // Re-initialize DataTables on the active tabs
                if (e.target.hash === '#pills-home') {
                    initializeDataTable1();
                } else if (e.target.hash === '#pills-contact') {
                    initializeDataTable2();
                }
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
        </script>

    <script src="../assets/js/admin-js.js"></script>

</body>

</html>