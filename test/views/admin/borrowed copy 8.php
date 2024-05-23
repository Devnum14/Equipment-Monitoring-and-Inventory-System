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
                                                <th>Student ID</th>
                                                <th>Deparment</th>
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
                                                $modalId = 'return_' . $borrows['smi_borrowed_id'];
                                                $formId = 'myFormReturn_' . $borrows['smi_borrowed_id'];
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
                                                    <td class="mt-1">
                                                        <?= $borrows['smi_borrowed_department'] ?>
                                                    </td>
                                                    <td class="text-center mt-1">
                                                        <?= date("M d, Y g:i A", strtotime($borrows['smi_borrowed_dateBorrow'])) ?>
                                                    </td>
                                                    <td class="text-center mt-1">
                                                        <?= date("M d, Y", strtotime($borrows['smi_borrowed_expReturn'])) ?>
                                                    </td>
                                                    <td class="">
                                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                            data-bs-target="#return_<?= $borrows['smi_borrowed_id'] ?>"
                                                            style="font-size: 13px">
                                                            Action
                                                        </button>
                                                    </td>
                                                </tr>

                                                <!-- RETURN -->

                                                <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" role="dialog"
                                                    aria-labelledby="disposeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="disposeModalLabel">Return
                                                                    Action</h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Add content for the Dispose modal here -->
                                                                <form id="<?= $formId ?>" action="_data.php" method="post">
                                                                    <input type="hidden" name="form" value="returnData">

                                                                    <input type="hidden" name="selectedid"
                                                                        value="<?= $borrows['smi_borrowed_id'] ?>">
                                                                    <input type="hidden" name="studentName"
                                                                        value="<?= $borrows['smi_borrowed_studentName'] ?>">
                                                                    <input type="hidden" name="studentId"
                                                                        value="<?= $borrows['smi_borrowed_studentId'] ?>">
                                                                    <input type="hidden" name="dateBorrow"
                                                                        value="<?= $borrows['smi_borrowed_dateBorrow'] ?>">
                                                                    <input type="hidden" name="expReturn"
                                                                        value="<?= $borrows['smi_borrowed_expReturn'] ?>">

                                                                    <div class="form-group">
                                                                        <label
                                                                            for="<?= 'nselectReturn_' . $borrows['smi_borrowed_id'] ?>">Select
                                                                            an Equipments:</label>
                                                                        <select
                                                                            id="<?= 'nselectReturn_' . $borrows['smi_borrowed_id'] ?>"
                                                                            class="form-control select2 text-dark">
                                                                            <option value="">Select an Equipments</option>
                                                                            <?php
                                                                            $selectid = $borrows['smi_borrowed_id'];
                                                                            $getBorrows1 = selectBorrows1($selectid);
                                                                            //populate the table data by looping the array result
                                                                            while ($borrows1 = $getBorrows1->fetch(PDO::FETCH_ASSOC)) {
                                                                                $equipmentName = $borrows1['smi_borrowed_equipmentName'];
                                                                                $myBorrow = explode("\n", $equipmentName);
                                                                                foreach ($myBorrow as $myBorrows) {
                                                                                    list($equipe, $qty) = array_map('trim', explode('-', $myBorrows));
                                                                                    ?>
                                                                                    <option value="<?= $equipe . '|' . $qty ?>">
                                                                                        <!-- <option value="<?= $myBorrows ?>">
                                                                                        <?= $myBorrows ?> -->
                                                                                        <?= $equipe . '|' . $qty ?>
                                                                                    </option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="number" class="form-control" min="0"
                                                                            step="1"
                                                                            id="<?= 'quantityInputReturn_' . $borrows['smi_borrowed_id'] ?>" />
                                                                    </div>

                                                                    <div class="">
                                                                        <label class="radio-inline mx-2">
                                                                            <input class="mx-2" type="radio" name="optradio"
                                                                                value="Good" required>Good
                                                                        </label>
                                                                        <label class="radio-inline mx-2">
                                                                            <input class="mx-2" type="radio" name="optradio"
                                                                                value="Lost" required>Lost
                                                                        </label>
                                                                        <label class="radio-inline mx-2">
                                                                            <input class="mx-2" type="radio" name="optradio"
                                                                                value="Damage" required>Damage
                                                                        </label>
                                                                    </div>

                                                                    <button type="button"
                                                                        id="<?= 'addOptionReturn_' . $borrows['smi_borrowed_id'] ?>"
                                                                        class="btn btn-primary">Return Equipments</button>
                                                                    <div id="<?= 'selectedOptionsContainerReturn_' . $borrows['smi_borrowed_id'] ?>"
                                                                        class="mt-3">
                                                                    </div>
                                                                    <input type="hidden"
                                                                        id="<?= 'selectedEquipmentReturn_' . $borrows['smi_borrowed_id'] ?>"
                                                                        name="selectedEquipmentReturn" />
                                                                    <input type="submit" value="Submit"
                                                                        class="btn btn-success mt-3" />
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close">Close</button>
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

    <?php
    $getBorrows = selectBorrows();
    $borrowsData = [];

    while ($borrows = $getBorrows->fetch(PDO::FETCH_ASSOC)) {
        $borrowsData[] = $borrows;
    }
    ?>



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

        document.addEventListener("DOMContentLoaded", function () {
            var borrowsData = <?php echo json_encode($borrowsData); ?>;
            var allSelectedOptions = [];
            var elementMapping = {};

            for (var i = 0; i < borrowsData.length; i++) {
                (function () {
                    var borrowedId = borrowsData[i]['smi_borrowed_id'];
                    var selectId = 'nselectReturn_' + borrowedId;

                    setupEquipmentForm('myFormReturn_' + borrowedId, selectId, 'addOptionReturn_' + borrowedId,
                        'selectedOptionsContainerReturn_' + borrowedId, 'selectedEquipmentReturn_' +
                    borrowedId, 'quantityInputReturn_' + borrowedId, 'delete');
                })();
            }

            function updateSelectedOptionsContainer(selectedOptionsContainerId, selectEquipmentArray, formId, selectElement) {
                var selectedOptionsContainer = document.getElementById(selectedOptionsContainerId);

                if (selectedOptionsContainer) {
                    selectEquipmentArray.forEach(function (optionObj, index) {
                        var optionDiv = document.createElement('div');
                        optionDiv.className = optionObj.radioValue === 'Good' ? 'alert alert-success alert-dismissible fade show' : 'alert alert-danger alert-dismissible fade show';
                        optionDiv.role = 'alert';

                        const optionName = optionObj.option.split('|')[0];
                        const radioValue = optionObj.radioValue || ''; // Default to an empty string if radioValue is not present
                        optionDiv.textContent = `${optionName} - QTY: ${optionObj.quantity} ${radioValue}`;

                        var deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.className = 'close';
                        deleteButton.setAttribute('aria-label', 'Close');
                        deleteButton.textContent = '×';

                        // Attach a click event to the deleteButton
                        deleteButton.addEventListener('click', function () {
                            // Use the mapping to find the correct index in the array
                            var arrayIndex = elementMapping[optionDiv];

                            // Remove the selected option from the global array
                            allSelectedOptions.splice(arrayIndex, 1);

                            // Remove the alert from the DOM
                            optionDiv.remove();

                            // Recreate and add the <option> back to the <select> only if it doesn't already exist
                            var optionExists = Array.from(selectElement.options).some(function (opt) {
                                return opt.value === optionObj.option;
                            });

                            if (!optionExists) {
                                var recreatedOption = document.createElement('option');
                                recreatedOption.value = optionObj.option;
                                recreatedOption.textContent = optionObj.option;
                                selectElement.appendChild(recreatedOption);
                            }

                            // Update the mapping by removing the deleted elements
                            delete elementMapping[optionDiv];
                        });

                        optionDiv.appendChild(deleteButton);
                        selectedOptionsContainer.appendChild(optionDiv);

                        // Add the optionDiv to the mapping
                        elementMapping[optionDiv] = index;
                    });
                }
            }

            function getSelectEquipmentArray(formId) {
                var formElement = document.getElementById(formId);
                var selectElements = formElement.querySelectorAll('select');
                var selectEquipmentArray = [];

                selectElements.forEach(function (selectElement) {
                    for (var i = 0; i < selectElement.options.length; i++) {
                        if (selectElement.options[i].selected) {
                            var optionValue = selectElement.options[i].value;
                            var optionParts = optionValue.split(' | ');
                            var equipmentName = optionParts[0];
                            var equipmentStock = optionParts[1];

                            selectEquipmentArray.push({
                                option: optionValue,
                                quantity: 1 // You can modify this if you have a different way of handling quantity
                            });
                        }
                    }
                });

                console.log('Form ID:', formId);
                console.log('Select Equipment Array:', selectEquipmentArray);

                // Add the selected options to the global array
                allSelectedOptions = allSelectedOptions.concat(selectEquipmentArray);

                return selectEquipmentArray;
            }

            function setupEquipmentForm(formId, selectId, addButtonId, selectedOptionsContainerId, selectedEquipmentId, quantityInputId, formType) {
                // Inside the setupEquipmentForm function
                var addButton = document.getElementById(addButtonId);
                var selectElement = document.getElementById(selectId);
                var radioButtons = document.getElementsByName('optradio');


                // Define a new object to store total quantities for each equipment
                var totalQuantities = {};

                if (addButton && selectElement) {
                    // Inside the addButton event listener
                    addButton.addEventListener('click', function () {
                        var selectElement = document.getElementById(selectId);
                        var selectedOptionsContainer = document.getElementById(selectedOptionsContainerId);
                        var quantityInput = document.getElementById(quantityInputId);

                        var selectedOptionIndex = selectElement.selectedIndex;
                        var selectedOption = selectElement.options[selectedOptionIndex];
                        var quantity = parseInt(quantityInput.value); // Parse quantity as an integer

                        var isRadioButtonSelected = false;
                        var selectedRadioButtonValue = '';
                        for (var i = 0; i < radioButtons.length; i++) {
                            if (radioButtons[i].checked) {
                                isRadioButtonSelected = true;
                                selectedRadioButtonValue = radioButtons[i].value;
                                break;
                            }
                        }

                        if (!isRadioButtonSelected) {
                            toastr.error('Please select a radio button before adding an option.');
                            return;
                        }

                        if (selectedOption && selectedOption.value !== '' && !isNaN(quantity) && quantity > 0) {
                            var optionValue = selectedOption.value;

                            var equipName = optionValue.split('|')[0];
                            var stock = parseInt(optionValue.split('|')[1]);

                            console.log('the equipment in database: ' + equipName);
                            console.log('the qty in database: ' + stock);

                            console.log();
                            console.log('the equipment i select: ' + equipName);
                            console.log('the qty i input: ' + quantity);

                            // Check if the equipment is already in the allSelectedOptions array
                            // Check if the equipment is already in the allSelectedOptions array
                            var existingEquipmentIndex = allSelectedOptions.findIndex(function (item) {
                                var itemParts = item.option.split('|');
                                return itemParts[0] === equipName && item.radioValue === selectedRadioButtonValue;
                            });

                            if (existingEquipmentIndex !== -1) {
                                // If the equipment with the same radio value already exists, update its quantity
                                var newQuantity = allSelectedOptions[existingEquipmentIndex].quantity + quantity;

                                // Check if the new quantity exceeds the stock
                                if (newQuantity > stock) {
                                    toastr.error('Quantity exceeds available stock.');
                                    return;
                                }

                                allSelectedOptions[existingEquipmentIndex].quantity = newQuantity;
                            } else {
                                // If the equipment with the same radio value doesn't exist, add it to the array
                                if (quantity > stock) {
                                    toastr.error('Quantity exceeds available stock.');
                                    return;
                                }

                                var selectEquipmentObj = {
                                    option: optionValue,
                                    quantity: quantity,
                                    radioValue: selectedRadioButtonValue
                                };
                                allSelectedOptions.push(selectEquipmentObj);

                                totalQuantities[equipName] = (totalQuantities[equipName] || 0) + quantity;

                                console.log('my return qty:');
                                allSelectedOptions.forEach(function (item) {
                                    console.log(item);
                                });



                                console.log('Total Quantity for ' + equipName + ':', totalQuantities[equipName]);
                            }

                            // Update the selected options container
                            updateSelectedOptionsContainer(selectedOptionsContainerId, [selectEquipmentObj], formId, selectElement);

                            // Clear the quantity input
                            quantityInput.value = '';
                        }
                    });
                }



                var formElement = document.getElementById(formId);

                if (formElement) {
                    formElement.addEventListener('submit', function (event) {
                        event.preventDefault();

                        // Log to console to check if this block is executed
                        console.log('Form submission triggered');

                        var selectEquipmentArray = getSelectEquipmentArray(formId);

                        // Modify this part to convert the array to JSON
                        var selectEquipmentJSON = JSON.stringify(allSelectedOptions);
                        document.getElementById(selectedEquipmentId).value = selectEquipmentJSON;
                        console.log(selectEquipmentJSON);

                        if (selectEquipmentJSON === '[]') {
                            toastr.error('Please add at least one option.');
                            return;
                        } else {
                            formElement.submit();
                        }
                    });
                }
            }
        });
    </script>


    <script src="../assets/js/table.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
        </script>
    <script src="../assets/js/admin-js.js"></script>
</body>

</html>