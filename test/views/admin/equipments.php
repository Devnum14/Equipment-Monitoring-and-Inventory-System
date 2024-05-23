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
        height: 60px;
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

<body class="text-dark mb-5 pb-3" style="height: auto;">
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

            <?php

            function print_specific_days()
            {
                $current_date = new DateTime();
                $current_day = $current_date->format('N');

                if ($current_day == 1 || $current_day == 3 || $current_day == 5) {
                    echo '<div class="alert alert-danger mt-3" style="margin-right: 80px; margin-left: 40px;">' . "Ensure there's enough equipment for today's athlete practice." . '</div>';

                } else {
                    // echo '<div style="margin-bottom: 10px; 
                    //             margin-top: 20px;">Today is ' . $current_date->format('F j, Y') . '</div>';
                    // echo '<div class="fw-bold">' . "There's no practice scheduled for today." . '</div>';
                }
            }

            ?>

            <div class="content-wrapper">
                <div class="fw-bold fs-5 d-flex justify-content-between mx-3" style="background: transparent;">
                    Equipment List
                    <button type="button px-5" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create"
                        style="font-size: 14px;">Add Equipments</button>
                </div>


                <div class="row">

                    <?php
                    $getEquipments = selectEquipments();

                    while ($equipments = $getEquipments->fetch(PDO::FETCH_ASSOC)) {
                        echo '
                        <div class="col-lg-4 col-md-4 col-sm-6 stretch-card mt-2">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body text-center">
                                    <div class="fs-5 fw-bold">' . $equipments['equipment_name'] . '</div>
                                    <div style="font-size: 12px;">Available</div>
                                    <p class="card-text fs-5">' . $equipments['equipment_stock'] . '</p>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>

                </div>
                <div class="card card-button-container">
                    <div class="card-body text-center">
                        <!-- <button type="button" id="editButton" class="btn btn-primary card-button mx-3"
                            data-bs-toggle="modal" data-bs-target="#edit">EDIT</button> -->
                        <!-- <button type="button" id="editButton" class="btn-sm btn  btn-warning btn-smmx-3 px-5 shadow"
                            data-bs-toggle="modal" data-bs-target="#borrow">BORROW</button> -->
                        <button type="button px-5" id="editButton" class="btn btn-warning px-5 mx-2"
                            data-bs-toggle="modal" data-bs-target="#borrow"
                            style="font-size: 14px; margin-top: -8px;">Borrow</button>
                        <!-- <button type="button" id="editButton" class="btn btn-danger card-button mx-3"
                            data-bs-toggle="modal" data-bs-target="#delete">DELETE</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <?php include '../assets/js/_scripts.php'; ?>
    <?php include '../assets/js/_alerts.php'; ?>

    <!-- Modal -->

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
                                class="form-select form-input text-uppercase mt-1" aria-label="Default select example"
                                required>
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
                            <label for="" class="form-label">Stock</label>
                            <input type="number" class="form-control" name="equipmentStock" id="equipmentStock" min="0"
                                step="1" required>
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

    <!-- EDIT -->

    <!-- <div class="modal fade" tabindex="-1" role="dialog" id="edit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Equipments
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="myFormEdit" class="mb-4 px-4" action="_data.php" method="post">

                    <input type="hidden" name="form" value="updateData">

                    <div class="form-group">
                        <label for="nselectEdit">Select an Equipments:</label>
                        <select id="nselectEdit" class="form-control select2 text-dark">
                            <option value="">Select an Equipments</option>
                            <?php
                            $getEquipments = selectEquipments();
                            while ($equipments = $getEquipments->fetch(PDO::FETCH_ASSOC)) {
                                $equipmentName = $equipments['equipment_name'];
                                $equipmentStock = $equipments['equipment_stock'];
                                ?>
                                <option value="<?= $equipmentName . '|' . $equipmentStock ?>">
                                    <?= $equipmentName . '|' . $equipmentStock ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" min="0" step="1" id="quantityInputEdit" />
                    </div>
                    <button type="button" id="addOptionEdit" class="btn btn-primary">Add Equipments</button>
                    <div id="selectedOptionsContainerEdit" class="mt-3"></div>
                    <input type="hidden" id="selectedEquipmentEdit" name="selectedEquipmentEdit" />
                    <input type="submit" value="Submit" class="btn btn-success mt-3" />
                </form>

            </div>
        </div>
    </div> -->

    <!-- DELETE -->
    <!-- 
    <div class="modal fade" tabindex="-1" role="dialog" id="delete">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Equipments
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="myFormDelete" class="mb-4 px-4" action="_data.php" method="post">

                    <input type="hidden" name="form" value="deleteData">

                    <div class="form-group">
                        <label for="nselectDelete">Select an Equipments:</label>
                        <select id="nselectDelete" class="form-control select2 text-dark">
                            <option value="">Select an Equipments</option>
                            <?php
                            $getEquipments = selectEquipments();
                            while ($equipments = $getEquipments->fetch(PDO::FETCH_ASSOC)) {
                                $equipmentName = $equipments['equipment_name'];
                                $equipmentStock = $equipments['equipment_stock'];
                                ?>
                                <option value="<?= $equipmentName . '|' . $equipmentStock ?>">
                                    <?= $equipmentName . '|' . $equipmentStock ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" min="0" step="1" id="quantityInputDelete" />
                    </div>
                    <button type="button" id="addOptionDelete" class="btn btn-primary">Delete Equipments</button>
                    <div id="selectedOptionsContainerDelete" class="mt-3"></div>
                    <input type="hidden" id="selectedEquipmentDelete" name="selectedEquipmentDelete" />
                    <div class="form-group">
                        <label for="deleteReason" class="form-label">Reason</label>
                        <textarea type="text" class="form-control" name="deleteReason" id="deleteReason"
                            style="resize: none;"></textarea>
                    </div>
                    <input type="submit" value="Submit" class="btn btn-success mt-3" />
                </form>

            </div>
        </div>
    </div> -->


    <!-- BORROW -->

    <div class="modal fade" tabindex="-1" role="dialog" id="borrow">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Borrow Equipments
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="myFormBorrow" class="mb-4 px-4" action="_data.php" method="post">

                    <input type="hidden" name="form" value="borrowData">
                    <input type="hidden" name="transvalue" value="<?=
                        rand(0000000, 9999999) ?>">

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
                                    <?= $equipmentName . '|' . $equipmentStock ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" min="0" step="1" id="quantityInputBorrow" />
                    </div>
                    <button type="button" id="addOption" class="btn btn-primary">Add Equipments</button>
                    <div id="selectedOptionsContainerBorrow" class="mt-3"></div>
                    <input type="hidden" id="selectedEquipmentBorrow" name="selectedEquipmentBorrow" />
                    <div class="form-group">
                        <label for="studentName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" name="studentName" id="studentName" />
                    </div>
                    <div class="form-group">
                        <label for="studentName" class="form-label">Student ID</label>
                        <input type="number" class="form-control" name="studentId" id="studentId" />
                    </div>
                    <div class="form-group">
                        <label for="studentName" class="form-label">Department (Optional)</label>
                        <select id="Department" name="Department" class="form-control select2 text-dark">
                            <option value="">Select Deparment</option>
                            <option value="DCJE">Department of Criminal Justice Education</option>
                            <option value="DTP">Department of Technical Program</option>
                            <option value="DTE">Department of Teacher Education</option>
                            <option value="DAS">Department of Arts and Sciences Education</option>
                            <option value="DBA">Department of Business Administration Education</option>
                            <option value="SHS">Senior High School</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="expectedReturn" class="form-label">Expected Return</label>
                        <input type="date" class="form-control" name="expectedReturn" id="expectedReturn"
                            min="<?= date('Y-m-d'); ?>" />
                    </div>
                    <input type="submit" value="Submit" class="btn btn-success mt-3" />
                </form>

            </div>
        </div>
    </div>

    <script>
        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: false,
            progressBar: true,
            positionClass: 'toast-top-right',
            preventDuplicates: false,
            onclick: null,
            showDuration: '300',
            hideDuration: '1000',
            timeOut: '3000',
            extendedTimeOut: '1000',
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };

        var selectEquipmentEdit = [];
        var selectEquipmentBorrow = [];
        var selectEquipmentDelete = [];

        function getSelectEquipmentArray(formId) {
            if (formId === 'myFormEdit') {
                return selectEquipmentEdit;
            } else if (formId === 'myFormBorrow') {
                return selectEquipmentBorrow;
            } else if (formId === 'myFormDelete') {
                return selectEquipmentDelete;
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            var selectedText; // Define selectedText in a broader scope

            $('#borrow').on('show.bs.modal', function () {
                selectedText = "mselect";
                console.log(selectedText);
            });

            $('#delete').on('show.bs.modal', function () {
                selectedText = "nselectDelete";
                console.log(selectedText);
            });

            $('#edit').on('show.bs.modal', function () {
                selectedText = "nselectEdit";
                console.log(selectedText);
            });

            function setupEquipmentForm(formId, selectId, addButtonId, selectedOptionsContainerId, selectedEquipmentId, quantityInputId, formType) {
                console.log(`Setting up form: ${formId}`);
                var selectElement = document.getElementById(selectId);

                var addButton = document.getElementById(addButtonId);
                if (addButton) {
                    addButton.addEventListener('click', function () {
                        var selectElement = document.getElementById(selectId); // Use the passed selectId
                        var selectedOptionsContainer = document.getElementById(selectedOptionsContainerId);
                        var quantityInput = document.getElementById(quantityInputId);

                        var selectEquipmentArray = getSelectEquipmentArray(formId);

                        console.log('Select Element:', selectElement);
                        console.log('Selected Options Container:', selectedOptionsContainer);
                        console.log('Quantity Input:', quantityInput);

                        var selectedOptionIndex = selectElement.selectedIndex;
                        var selectedOption = selectElement.options[selectedOptionIndex];
                        var quantity = quantityInput.value;

                        var selectEquipmentArray = getSelectEquipmentArray(formId);

                        if (selectedOption && selectedOption.value !== '' && quantity !== '') {

                            // Check for form type to exclude this check for the edit modal
                            if (formType === 'borrow' || formType === 'delete') {
                                var stock = parseInt(selectedOption.value.split('|')[1]);
                                if (parseInt(quantity) > stock) {
                                    toastr.error('Quantity exceeds available stock.');
                                    return;
                                }
                            }

                            selectEquipmentArray.push({
                                option: selectedOption.value,
                                quantity: quantity
                            });

                            selectElement.remove(selectedOptionIndex);

                            updateSelectedOptionsContainer(selectedOptionsContainerId, selectEquipmentArray, formId);
                            quantityInput.value = '';
                        }
                    });
                }

                var formElement = document.getElementById(formId);
                if (formElement) {
                    formElement.addEventListener('submit', function (event) {
                        var studentIdInput = document.getElementById('studentId');
                        var studentNameInput = document.getElementById('studentName');
                        var expectedReturnInput = document.getElementById('expectedReturn');
                        var deleteReason = document.getElementById('deleteReason');
                        var Department = document.getElementById('Department');

                        var selectEquipmentArray = getSelectEquipmentArray(formId);

                        console.log('Selected Equipment Array:', selectEquipmentArray);

                        if (selectEquipmentArray.length === 0) {
                            event.preventDefault();
                            toastr.error('Please add at least one option.');
                        }

                        if (formType === 'borrow') {
                            if (studentNameInput.value === '') {
                                event.preventDefault();
                                toastr.error('Please fill in the Student Name.');
                            }
                            else if (studentIdInput.value === '') {
                                event.preventDefault();
                                toastr.error('Please fill in the Student ID.');
                            }
                            else if (expectedReturnInput.value === '') {
                                event.preventDefault();
                                toastr.error('Please select the expected return date.');
                            }
                            else {
                                var selectEquipmentJSON = JSON.stringify(selectEquipmentArray);
                                document.getElementById(selectedEquipmentId).value = selectEquipmentJSON;
                            }
                        }
                        else if (formType === 'edit') {
                            var selectEquipmentJSON = JSON.stringify(selectEquipmentArray);
                            document.getElementById(selectedEquipmentId).value = selectEquipmentJSON;
                        } if (formType === 'delete') {
                            if (deleteReason.value === '') {
                                event.preventDefault();
                                toastr.error('Please fill in the Delete Reason.');
                            } else {
                                var selectEquipmentJSON = JSON.stringify(selectEquipmentArray);
                                document.getElementById(selectedEquipmentId).value = selectEquipmentJSON;
                                console.log(selectEquipmentJSON);
                            }
                        }
                    });
                }
            }


            // ... (your existing code)

            function updateSelectedOptionsContainer(selectedOptionsContainerId, selectEquipmentArray, formId) {
                var selectedOptionsContainer = document.getElementById(selectedOptionsContainerId);
                if (selectedOptionsContainer) {
                    selectedOptionsContainer.innerHTML = '';
                    selectEquipmentArray.forEach(function (optionObj, index) {
                        var optionDiv = document.createElement('div');
                        optionDiv.className = 'alert alert-info alert-dismissible fade show';
                        optionDiv.role = 'alert';

                        const optionName = optionObj.option.split('|')[0];

                        optionDiv.textContent = `${optionName} - QTY: ${optionObj.quantity}`;

                        var deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.className = 'close';
                        deleteButton.setAttribute('data-dismiss', 'alert');
                        deleteButton.setAttribute('aria-label', 'Close');
                        deleteButton.textContent = '×';

                        // Use the selectedText variable instead of the fixed string 'textid'
                        deleteButton.addEventListener('click', function () {
                            var selectElement = document.getElementById(selectedText);
                            var newOption = new Option(optionObj.option, optionObj.option);
                            selectElement.add(newOption);

                            selectEquipmentArray.splice(index, 1);
                            updateSelectedOptionsContainer(selectedOptionsContainerId, selectEquipmentArray, formId);
                        });
                        optionDiv.appendChild(deleteButton);
                        selectedOptionsContainer.appendChild(optionDiv);
                    });
                }
            }

            setupEquipmentForm('myFormBorrow', 'mselect', 'addOption', 'selectedOptionsContainerBorrow', 'selectedEquipmentBorrow', 'quantityInputBorrow', 'borrow');
            setupEquipmentForm('myFormEdit', 'nselectEdit', 'addOptionEdit', 'selectedOptionsContainerEdit', 'selectedEquipmentEdit', 'quantityInputEdit', 'edit');
            setupEquipmentForm('myFormDelete', 'nselectDelete', 'addOptionDelete', 'selectedOptionsContainerDelete', 'selectedEquipmentDelete', 'quantityInputDelete', 'delete');
        });
    </script>


    <script src="../assets/js/table.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
        </script>
    <script src="../assets/js/admin-js.js"></script>

</body>

</html>