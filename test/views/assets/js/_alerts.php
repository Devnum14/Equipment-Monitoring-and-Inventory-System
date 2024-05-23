<?php
//put alerts here

//get the current page
$currpage = str_replace('.php', '', basename($_SERVER['PHP_SELF']));

$note = @$_GET['note'];

if ($note == "error") {
    echo "
            <script>
                toastr.error('Error');
            </script>
        ";
} else if ($note == "invalid") {
    echo "
            <script>
                toastr.error('Invalid');
            </script>
        ";
} else {

    if ($currpage == "equipments") {

        if ($note == "added") {
            echo "
                    <script>
                        toastr.success('Equipment has been Add');
                    </script>
                ";
        } else if ($note == "update") {
            echo "
                    <script>
                        toastr.success('Equipment has been Updated');
                    </script>
                ";
        } else if ($note == "delete") {
            echo "
                    <script>
                        toastr.success('Equipment has been Delete');
                    </script>
                ";
        } else if ($note == "borrow") {
            echo "
                    <script>
                        toastr.success('Equipment has been Borrow');
                    </script>
                ";
        } else if ($note == "retry") {
            echo "
            <script>
                toastr.error('You Borrow to much Stock');
            </script>
            ";
        }

    } else if ($currpage == "borrowed") {

        if ($note == "return") {
            echo "
            <script>
                toastr.success('Equipment has been Return');
            </script>
            ";
        }

    }

}
?>