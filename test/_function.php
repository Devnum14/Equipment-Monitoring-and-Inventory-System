<?php
session_start();

require 'config.php';


if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', true, 403);
    header('Location: 404.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $form = $_POST['form'];

    if ($form === 'signup') {

        $username = $_POST['username'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $usertype = $_POST['usertype'];

        $pass = hash('sha1', $password);

        // Check if the email is already in use
        $sql_check_email = "SELECT COUNT(*) FROM smi_user_tbl WHERE smi_user_email = :email";
        $stmt_check_email = dbConnection()->prepare($sql_check_email);
        $stmt_check_email->execute([':email' => $email]);
        $count_email = $stmt_check_email->fetchColumn();

        $sql_check_username = "SELECT COUNT(*) FROM smi_user_tbl WHERE smi_user_username = :username";
        $stmt_check_username = dbConnection()->prepare($sql_check_username);
        $stmt_check_username->execute([':username' => $username]);
        $count_username = $stmt_check_username->fetchColumn();

        if ($count_email > 0) {
            // The email is already in use, display an error message
            echo "Email has been used";
        }
        elseif ($count_username > 0) {
            echo "Username has been used";
        }
         else {
            // The email is not in use, proceed with the INSERT statement
            $sql = "INSERT INTO smi_user_tbl (smi_user_username, smi_user_name, smi_user_email, smi_user_password, smi_user_type) VALUES (:username, :name, :email, :password, :usertype)";

            // Prepare and execute the statement
            $stmt = dbConnection()->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':name' => $name,
                ':email' => $email,
                ':password' => $pass,
                ':usertype' => $usertype
            ]);
            
            echo "success";
        }

    }

    if ($form === 'signin') {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        $pass = hash('sha1', $password);
    
        $sql = "SELECT smi_user_username, smi_user_name, smi_user_password FROM smi_user_tbl WHERE smi_user_username = :username";
    
        $query = dbConnection()->prepare($sql);
        $query->bindParam(':username', $username);
    
        if ($query->execute()) {
            if ($query->rowCount() > 0) {
                $row = $query->fetch();
                $storedPassword = $row['smi_user_password'];
    
                if (hash_equals($storedPassword, $pass)) {
                    $_SESSION['name'] = $row['smi_user_name'];
                    echo "success";
                } else {
                    echo "failed";
                }
            } else {
                echo "no account";
            }
        } else {
            echo "Error executing the query.";
        }
    }
}

?>