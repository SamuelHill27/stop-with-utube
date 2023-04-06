<?php

    main();

    function openDatabase() {
        $db_host='fdb1032.awardspace.net'; //Should contain the "Database Host" value
        $db_name='4080778_database'; //Should contain the "Database Name" value
        $db_user='4080778_database'; //Should contain the "Database User" value
        $db_pass='f)+{%D1)65SMlFFL'; //Should contain the "Database Password" value

        $mysqli_connection = new MySQLi($db_host, $db_user, $db_pass, $db_name);

        if ($mysqli_connection->connect_error) {
            echo json_encode("Could not connect to $db_user, error: " . $mysqli_connection->connect_error);
            return null;
        } else {
            return $mysqli_connection;
        }
    }

    function main() {
        $data = json_decode($_REQUEST["q"]);
        $mysqli = openDatabase();

        if ($mysqli != null) {
            // selecting whether to get from or update to DB 
            if ($data[1] == null) { // select
                echo json_encode(getData($data, $mysqli));
            } else { // update
                echo json_encode(updateData($data[0], $data[1], $mysqli));
            }

            $mysqli -> close();
        }
    }

    // gets value in text column from table
    function getData($id, $mysqli) {
        $query = "SELECT `text` FROM `motivations` WHERE `id` = ?";

        // bind values to query safely
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $id);

        // upon successfull execution, return data
        if ($stmt->execute()) {
            $stmt->bind_result($text);
            $stmt->fetch();
            return $text;
        } else {
            return null;
        }
    }

    // updates value in text column from table
    function updateData($id, $text, $mysqli) {
        $query = "UPDATE `motivations` SET `text` = ? WHERE `id` = ?";

        // bind values to query safely
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("si", $text, $id);

        // upon successfull execution, return success message
        if ($stmt->execute()) {
            return [$id, $text];
        } else {
            return null;
        }
    }

?>