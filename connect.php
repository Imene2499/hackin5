<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['Name']) && isset($_POST['password']) &&
        isset($_POST['DoctorId']) && isset($_POST['field'])){ 
        
        $Name = $_POST['Name'];
        $password = $_POST['password'];
        $DoctorId = $_POST['DoctorId'];
        $field = $_POST['field'];
        

        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "test";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT DoctorId FROM doctors WHERE DoctorId = ? LIMIT 1";
            $Insert = "INSERT INTO doctors(Name, DoctorId, password, field) values(?, ?, ?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssss",$Name, $DoctorId, $password, $field);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this DoctorId.";
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