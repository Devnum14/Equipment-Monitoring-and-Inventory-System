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
                            data-bs-toggle="modal" data-bs-target="#borrow">BORROW</button>
                        <button type="button" id="editButton" class="btn btn-danger card-button mx-3"
                            data-bs-toggle="modal" data-bs-target="#create">DELETE</button>
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
                            <label for="" class="form-label">Brand</label>
                            <input type="text" class="form-control" name="equipmentBrand" id="equipmentBrand" required>
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



    <div class="modal fade" tabindex="-1" role="dialog" id="edit">
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

                    <input type="hidden" name="form" value="editData">

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
                                <option value="<?= $equipmentName . ' | ' . $equipmentStock ?>">
                                    <?= $equipmentName . ' - ' . $equipmentStock ?>
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
    </div>

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
                                <option value="<?= $equipmentName . ' | ' . $equipmentStock ?>" <?= $isDisabled ?>>
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

        // Initialize selectEquipment outside the event listener
        // Initialize selectEquipment outside the event listener
        var selectEquipmentEdit = [];
        var selectEquipmentBorrow = [];

        // Function to initialize the select equipment array based on the form ID
        // Function to initialize the select equipment array based on the form ID
        function getSelectEquipmentArray(formId) {
            if (formId === 'myFormEdit') {
                return selectEquipmentEdit;
            } else if (formId === 'myFormBorrow') {
                return selectEquipmentBorrow;
            }
        }

        function setupEquipmentForm(formId, selectId, addButtonId, selectedOptionsContainerId, selectedEquipmentId, quantityInputId) {
            console.log(`Setting up form: ${formId}`);

            var addButton = document.getElementById(addButtonId);
            if (addButton) {
                addButton.addEventListener('click', function () {
                    console.log(`Button clicked in form: ${formId}`);

                    var selectElement = document.getElementById(selectId);
                    var selectedOptionsContainer = document.getElementById(selectedOptionsContainerId);
                    var quantityInput = document.getElementById(quantityInputId);

                    console.log('Select Element:', selectElement);
                    console.log('Selected Options Container:', selectedOptionsContainer);
                    console.log('Quantity Input:', quantityInput);

                    // Get the selected option and quantity from the form
                    var selectedOptionIndex = selectElement.selectedIndex;
                    var selectedOption = selectElement.options[selectedOptionIndex];
                    var quantity = quantityInput.value;

                    var selectEquipmentArray = getSelectEquipmentArray(formId);

                    // Validate if quantity is not empty and does not exceed the stock
                    if (selectedOption && selectedOption.value !== '' && quantity !== '') {
                        var stock = parseInt(selectedOption.value.split('|')[1]);
                        if (parseInt(quantity) > stock) {
                            toastr.error('Quantity exceeds available stock.');
                            return; // Stop execution if quantity exceeds stock
                        }

                        selectEquipmentArray.push({
                            option: selectedOption.value,
                            quantity: quantity
                        });

                        // Remove the selected option from the dropdown list
                        selectElement.remove(selectedOptionIndex);

                        updateSelectedOptionsContainer(selectedOptionsContainerId, selectEquipmentArray, formId);
                        // Reset quantity input
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

                    var selectEquipmentArray = getSelectEquipmentArray(formId);

                    console.log('Selected Equipment Array:', selectEquipmentArray);

                    if (selectEquipmentArray.length === 0) {
                        event.preventDefault();
                        toastr.error('Please add at least one option.');
                    } else if (studentNameInput.value === '') {
                        event.preventDefault();
                        toastr.error('Please fill in the student Name.');
                    } else if (studentIdInput.value === '') {
                        event.preventDefault();
                        toastr.error('Please fill in the student ID.');
                    } else if (expectedReturnInput.value === '') {
                        event.preventDefault();
                        toastr.error('Please select the expected return date.');
                    } else {
                        var selectEquipmentJSON = JSON.stringify(selectEquipmentArray);
                        document.getElementById(selectedEquipmentId).value = selectEquipmentJSON;
                    }
                });
            }
        }

        // Function to update the displayed selected options
        function updateSelectedOptionsContainer(selectedOptionsContainerId, selectEquipmentArray, formId) {
            var selectedOptionsContainer = document.getElementById(selectedOptionsContainerId);
            if (selectedOptionsContainer) {
                selectedOptionsContainer.innerHTML = '';
                selectEquipmentArray.forEach(function (optionObj, index) {
                    var optionDiv = document.createElement('div');
                    optionDiv.className = 'alert alert-info alert-dismissible fade show';
                    optionDiv.role = 'alert';

                    // Extract the equipment name without stock from the option string
                    const optionName = optionObj.option.split('|')[0];

                    optionDiv.textContent = `${optionName} - QTY: ${optionObj.quantity}`;

                    var selectElement = document.getElementById(
                        selectedOptionsContainerId === 'selectedOptionsContainer' ? 'mselect' : 'nselect' + (formId === 'myFormEdit' ? 'Edit' : '')
                    );

                    // Add a delete button for each option
                    var deleteButton = document.createElement('button');
                    deleteButton.type = 'button';
                    deleteButton.className = 'close';
                    deleteButton.setAttribute('data-dismiss', 'alert');
                    deleteButton.setAttribute('aria-label', 'Close');
                    deleteButton.textContent = '×'; // Use textContent instead of innerHTML
                    deleteButton.addEventListener('click', function () {
                        // Add the deleted option back to the dropdown list
                        var selectElement = document.getElementById(
                            selectedOptionsContainerId === 'selectedOptionsContainer' ? 'mselect' : 'nselect' + (formId === 'myFormEdit' ? 'Edit' : '')
                        );
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

        setupEquipmentForm('myFormEdit', 'nselectEdit', 'addOptionEdit', 'selectedOptionsContainerEdit', 'selectedEquipmentEdit', 'quantityInputEdit');
        setupEquipmentForm('myFormBorrow', 'mselect', 'addOption', 'selectedOptionsContainer', 'selectedEquipment', 'quantityInput');

    </script>

    <script src="../assets/js/table.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
        </script>
    <script src="../assets/js/admin-js.js"></script>

</body>

</html>