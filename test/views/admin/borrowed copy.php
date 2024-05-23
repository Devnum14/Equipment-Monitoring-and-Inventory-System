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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <!--BOOTSTRAP-->

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
                                                <th>Return</th>
                                                <th>Dispose</th>
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
                                                    <td class="text-center">
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
                                                    </td>
                                                </tr>

                                                <!-- RETURN -->

                                                <div class="modal" id="return_<?= $borrows['smi_borrowed_id'] ?>"
                                                    tabindex="-1" role="dialog" aria-labelledby="returnModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="returnModalLabel">Return Action
                                                                </h5>
                                                                <button type="button" class="close" aria-label="Close"
                                                                    onclick="closeReturnModal('<?= $borrows['smi_borrowed_id'] ?>')">
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
                                                                    onclick="closeReturnModal('<?= $borrows['smi_borrowed_id'] ?>')">Close</button>
                                                                <!-- Add additional buttons or actions if needed -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Dispose Modal -->
                                                <div class="modal" id="dispose_<?= $borrows['smi_borrowed_id'] ?>"
                                                    tabindex="-1" role="dialog" aria-labelledby="disposeModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="disposeModalLabel">Dispose
                                                                    Action</h5>
                                                                <button type="button" class="close" aria-label="Close"
                                                                    onclick="closeDisposeModal('<?= $borrows['smi_borrowed_id'] ?>')">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Add content for the Dispose modal here -->
                                                                <p>
                                                                    <?= $borrows['smi_borrowed_id']; ?>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    onclick="closeDisposeModal('<?= $borrows['smi_borrowed_id'] ?>')">Close</button>
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


    <!-- Modal -->

    <script>
        function closeDisposeModal(id) {
            var disposeModal = $('#dispose_' + id);
            disposeModal.modal('hide');
        }

        function closeReturnModal(id) {
            var disposeModal = $('#return_' + id);
            disposeModal.modal('hide');
        }
    </script>

    <script src="../assets/js/table.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
        </script>
    <script src="../assets/js/admin-js.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>

</html>

<!-- <?php
                                                                            $selectid = $borrows['smi_borrowed_id'];
                                                                            $getBorrows1 = selectBorrows1($selectid);
                                                                            while ($Borrows1 = $getBorrows1->fetch(PDO::FETCH_ASSOC)) {
                                                                                $equipmentName = $Borrows1['smi_borrowed_equipmentName'];
                                                                                ?>
                                                                                <option value="<?= $equipmentName ?>">
                                                                                    <?= $equipmentName ?>
                                                                                </option>
                                                                                <?php
                                                                            }
                                                                            ?> -->


    <!-- <script>
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
            setupEquipmentForm('myFormDelete', 'nselectDelete', 'addOptionDelete', 'selectedOptionsContainerDelete', 'selectedEquipmentDelete', 'quantityInputDelete', 'delete');

            function setupEquipmentForm(formId, selectId, addButtonId, selectedOptionsContainerId, selectedEquipmentId, quantityInputId, formType) {
                console.log(`Setting up form: ${formId}`);

                var addButton = document.getElementById(addButtonId);
                if (addButton) {
                    addButton.addEventListener('click', function () {
                        var selectElement = document.getElementById(selectId);
                        var selectedOptionsContainer = document.getElementById(selectedOptionsContainerId);
                        var quantityInput = document.getElementById(quantityInputId); // Update this line

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
                            if (formType === 'delete') {
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
                        var deleteReason = document.getElementById('deleteReason');

                        var selectEquipmentArray = getSelectEquipmentArray(formId);

                        console.log('Selected Equipment Array:', selectEquipmentArray);

                        if (selectEquipmentArray.length === 0) {
                            event.preventDefault();
                            toastr.error('Please add at least one option.');
                        }

                        if (formType === 'delete') {
                            if (deleteReason.value === '') {
                                event.preventDefault();
                                toastr.error('Please fill in the Delete Reason.');
                            } else {
                                var selectEquipmentJSON = JSON.stringify(selectEquipmentArray);
                                document.getElementById(selectedEquipmentId).value = selectEquipmentJSON;
                            }
                        }
                    });
                }
            }

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

                        var selectElement = document.getElementById('nselectDelete');

                        var deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.className = 'close';
                        deleteButton.setAttribute('data-dismiss', 'alert');
                        deleteButton.setAttribute('aria-label', 'Close');
                        deleteButton.textContent = '×';
                        deleteButton.addEventListener('click', function () {
                            var selectElement = document.getElementById('nselectDelete');
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

            setupEquipmentForm('myFormDelete', 'nselectDelete', 'addOptionDelete', 'selectedOptionsContainerDelete', 'selectedEquipmentDelete', 'quantityInputDelete', 'delete');
        });
    </script> -->