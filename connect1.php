<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['Password']) &&
        isset($_POST['RobotId'])){ 
        
        $username = $_POST['username'];
        $RobotId = $_POST['RobotId'];
        $Password = $_POST['Password'];
       
        

        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "test";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT RobotId FROM patient WHERE RobotId = ? LIMIT 1";
            $Insert = "INSERT INTO patient(username, RobotId , Password) values(?, ?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $RobotId);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sss",$username, $RobotId, $Password);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this RobotId.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>