<?php

require '_function.php';

session_start();

if (!empty($_SESSION["name"])) {

} else {
    header('Location: ../../index');
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



</head>

<style>
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

    .card-button-container {
        border-radius: 20px;
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
    }

    .card-button-container .card-body {
        display: flex;
        justify-content: center;
    }

    .card-button {
        /* Your existing button styles */
    }

    .card:hover {
        background-color: #f8f9fa;
        /* Set your desired background color */
    }

    @media (max-width: 520px) {
        .card-button-container {
            bottom: 10px;
            /* Adjust as needed for smaller screens */
        }

        .card-button-container .card-body {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<body class="text-dark" style="height: 150vh;">
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
                <div class="fw-bold fs-5 d-flex justify-content-between mx-3" style="background: transparent;">
                    Equipment List
                    <button type="button px-5" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create"
                        style="font-size: 14px;">Add Equipments</button>
                </div>

                <form action="_redirect.php" method="post">
                    <div class="form-group mt-2">
                        <input type="text" class="form-control" name="fruitSearch" id="fruitSearch"
                            placeholder="search here ..." autofocus required>
                    </div>
                </form>


                <div class="row">

                        <?php

                        $getEquipments = selectEquipments();

                        while ($equipments = $getEquipments->fetch(PDO::FETCH_ASSOC)) {
                            /*echo '
                                // <div class="col-md-3 grid-margin stretch-card mt-2 mx-1">
                                //     <div class="card" style="border: 3px solid #6A040F; border-radius: 10px;">
                                //         <a class="text-decoration-none btn-card-hover" href="#" 
                                //            data-bs-toggle="modal" 
                                //            data-bs-target="#edit_' . $equipments['equipment_id'] . '">
                                //             <div class="card-body">
                                //                 <p class="card-title text-xl-left fs-6 fw-bold">' . $equipments['equipment_name'] . '</p>
                                //                 <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                //                     <h3 class="mb-0 mb-md-2 mb-xl-0">' . $equipments['equipment_stock'] . '</h3>
                                //                 </div>
                                //                 <p class="mb-0 mt-2" style="letter-spacing: 1px; font-weight: 600; font-size: 14px;">
                                //                     Last Added: 
                                //                     <span class="ms-0"><small>' . date("M d, Y g:i A", strtotime($equipments['equipment_dateupdate'])) . '</small></span>
                                //                 </p>
                                //             </div>
                                //         </a>
                                //     </div>
                                // </div>
                            ';*/
                            echo '
                        <div class="col-lg-3 col-md-4 col-sm-6 stretch-card mt-2">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">' . $equipments['equipment_name'] . '</h5>
                                    <p class="card-text">' . $equipments['equipment_stock'] . '</p>
                                </div>
                            </div>
                        </div>';
                        }
                        ?>
                    </div>
                    <div class="card card-button-container">
                        <div class="card-body d-flex">
                            <button type="button" id="editButton" class="btn btn-primary card-button mx-3"
                                data-bs-toggle="modal" data-bs-target="#edit">EDIT</button>
                            <button type="button" id="editButton" class="btn btn-warning card-button mx-3"
                                data-bs-toggle="modal" data-bs-target="#create">BORROW</button>
                            <button type="button" id="editButton" class="btn btn-danger card-button mx-3"
                                data-bs-toggle="modal" data-bs-target="#create">DELETE</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade p-5" tabindex="-1" role="dialog" id="create">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Equipments</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="_data" method="post">

                            <input type="hidden" name="form" value="insertData">

                            <div class="modal-body">



                                <div class="form-group">
                                    <label for="" class="form-label">Equipments Name</label>
                                    <select name="equipmentName" id="equipmentName"
                                        class="form-select form-input text-uppercase mt-1"
                                        aria-label="Default select example" required>
                                        <option value=""></option>

                                        <?php
                                        $equipmentsList = equipmentsList();

                                        while ($listEquipments = $equipmentsList->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $listEquipments['smi_equipmentlist_name'] ?>">
                                                <?= $listEquipments['smi_equipmentlist_name'] ?>
                                            </option>
                                        <?php } ?>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="" class="form-label">Brand</label>
                                    <input type="text" class="form-control" name="equipmentBrand" id="equipmentBrand"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Stock</label>
                                    <input type="number" class="form-control" name="equipmentStock" id="equipmentStock"
                                        min="0" step="1" required>
                                </div>

                            </div>



                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <?php

            $getEquipments = selectEquipments();

            while ($equipments = $getEquipments->fetch(PDO::FETCH_ASSOC)) {

                ?>

                <!-- EDIT  -->


                <div class="modal fade" tabindex="-1" role="dialog" id="edit">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Equipments -
                                    <?= $equipments['equipment_name'] ?>
                                </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="_data?edit=<?= $equipments['equipment_id'] ?>" method="post">

                                <input type="hidden" name="form" value="updateData">

                                <div class="modal-body">

                                    z
                                    <div class="form-group">
                                        <label for="" class="form-label">Stock</label>
                                        <input type="number" class="form-control" name="equipmentStock" id="equipmentStock"
                                            min="0" step="1" value="<?= $equipments['equipment_stock'] ?>" required>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save
                                        Now</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <!-- BORROW -->

                <div class="modal fade" tabindex="-1" role="dialog" id="borrow_<?= $equipments['equipment_id'] ?>">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Borrow Equipments -
                                    <?= $equipments['equipment_name'] ?>
                                </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="_data?borrow=<?= $equipments['equipment_id'] ?>" method="post">

                                <input type="hidden" name="form" value="borrowData">

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="" class="form-label">Equipment
                                            Name</label>
                                        <input type="text" class="form-control" name="equipmentName" id="equipmentName"
                                            value="<?= $equipments['equipment_name'] ?>" readonly>
                                    </div>

                                    <div class="form-group" style="">
                                        <label for="" class="form-label">Stock</label>
                                        <input type="number" class="form-control" name="equipmentStock" id="equipmentStock"
                                            value="<?= $equipments['equipment_stock'] ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="form-label">QTY</label>
                                        <input type="number" class="form-control" name="equipmentQty" id="equipmentQty"
                                            min="0" step="1" max="<?= $equipments['equipment_stock'] ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="form-label">Student
                                            Name</label>
                                        <input type="text" class="form-control" name="studentName" id="studentName"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="form-label">Student ID</label>
                                        <input type="text" class="form-control" name="studentId" id="studentId" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="form-label">Collateral</label>
                                        <input type="text" class="form-control" name="collateral" id="collateral" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="form-label">Expected
                                            Return</label>
                                        <input type="date" class="form-control" name="dateReturn" id="dateReturn" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="event-color">Color</label>
                                        <input type="color" class="form-control" id="color" name="color" value="#3788d8">
                                    </div>



                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning">Borrow
                                        Now</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

                <!-- DELETE -->

                <div class="modal fade" tabindex="-1" role="dialog" id="delete_<?= $equipments['equipment_id'] ?>">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Equipments -
                                    <?= $equipments['equipment_name'] ?>
                                </h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="_data?delete=<?= $equipments['equipment_id'] ?>" method="post">

                                <input type="hidden" name="form" value="deleteData">

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="" class="form-label">Equipment
                                            Name</label>
                                        <input type="text" class="form-control" name="equipmentName" id="equipmentName"
                                            value="<?= $equipments['equipment_name'] ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="form-label">Brand</label>
                                        <input type="text" class="form-control" name="equipmentBrand" id="equipmentBrand"
                                            value="<?= $equipments['equipment_brand'] ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" name="equipmentQty" id="equipmentQty"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="form-label">Reason</label>
                                        <textarea name="deleteReason" id="deleteReason" cols="32" rows="5" required
                                            style="resize: none;"></textarea>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Delete
                                        Now</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <?php
            }
            ;
            ?>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
                crossorigin="anonymous"></script>
            <script src="../assets/js/admin-js.js"></script>
            <script>

            </script>
</body>

</html>

<?php
require 'database_connection.php'; 

$display_query = "SELECT * FROM smi_borrowed_tbl";             
$results = mysqli_query($con, $display_query);   
$count = mysqli_num_rows($results);  

if ($count > 0) {
    $data_arr = array();
    $i = 1;
    
    while ($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $data_arr[$i]['smi_borrowed_id'] = $data_row['smi_borrowed_id'];
        $data_arr[$i]['smi_borrowed_equipmentName'] = $data_row['smi_borrowed_equipmentName'];
        $data_arr[$i]['smi_borrowed_studentId'] = $data_row['smi_borrowed_studentId'];
        $data_arr[$i]['smi_borrowed_studentName'] = $data_row['smi_borrowed_studentName'];
        $data_arr[$i]['smi_borrowed_dateBorrow'] = $data_row['smi_borrowed_dateBorrow'];
        $data_arr[$i]['smi_borrowed_expReturn'] = $data_row['smi_borrowed_expReturn'];
        $i++;
    }

    $data = array(
        'status' => true,
        'msg' => 'successfully!',
        'data' => $data_arr
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'Error!'				
    );
}

echo json_encode($data);
?>

<?php
                                                        $equipmentList = explode("\n", $borrows['smi_borrowed_equipmentName']);
                                                        echo '<table class="table-borderless">';
                                                        foreach ($equipmentList as $equipment) {
                                                            list($equipmentName, $quantity) = explode(' - ', $equipment);
                                                            echo '<tr><td>' . $equipmentName . '-</td><td>' . $quantity . '</td></tr>';
                                                        }
                                                        echo '</table>';
                                                        ?>


<form id="myForm" class="mb-4 px-4" action="_data.php" method="post">

<input type="hidden" name="form" value="borrowData">

<div class="form-group">
    <label for="mselect">Select an Equipments:</label>
    <select id="mselect" class="form-control select2 text-dark">
        <option value="">Select an Equipments</option>
        <?php
        $getEquipments = selectEquipments();
        while ($equipments = $getEquipments->fetch(PDO::FETCH_ASSOC)) {
            $equipmentName = $equipments['equipment_name'];
            $equipmentStock = $equipments['equipment_stock'];
            $isDisabled = $equipmentStock === 0 ? 'disabled' : '';
            ?>
            <option value="<?= $equipmentName . '|' . $equipmentStock ?>" <?= $isDisabled ?>>
                <?= $equipmentName . ' - ' . $equipmentStock ?>
            </option>
            <?php
        }
        ?>
    </select>
</div>
<div class="form-group">
    <input type="number" class="form-control" min="0" step="1" id="quantityInput" />
</div>
<button type="button" id="addOption" class="btn btn-primary">Add Equipments</button>
<div id="selectedOptionsContainer" class="mt-3"></div>
<input type="hidden" id="selectedEquipment" name="selectedEquipment" />
<div class="form-group">
    <label for="studentName" class="form-label">Student Name</label>
    <input type="text" class="form-control" name="studentName" id="studentName" />
</div>
<div class="form-group">
    <label for="studentId" class="form-label">Student ID</label>
    <input type="number" class="form-control" name="studentId" id="studentId" />
</div>
<div class="form-group">
    <label for="expectedReturn" class="form-label">Expected Return</label>
    <input type="date" class="form-control" name="expectedReturn" id="expectedReturn"
        min="<?= date('Y-m-d'); ?>" />
</div>
<input type="submit" value="Submit" class="btn btn-success mt-3" />
</form>