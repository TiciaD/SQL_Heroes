<?php
    echo "start of script";
    echo "<br >";
    function createNewDatabase(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mySuperheroes";
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        echo "Connected Successfully";

        mysqli_close($conn); 
    }

    createNewDatabase();



    $action = $_GET['action'];




     // Create
    function createHero($name, $tagline, $bio) {
        echo "hello";
        echo ("<h1>CREATE</h1><pre>" . $name. $tagline. $bio . "</pre>");

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mySuperheroes";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $SQL = "INSERT INTO heroes (name, about_me, biography) VALUES ('$name', '$tagline', '$bio')";

        $conn;
        if ($conn->query($SQL) === TRUE) {
            echo "New Hero created successfully";
            echo '<br>';
        }
        else {
            echo "Error: " . $SQL . "<br>" . $conn->error;
        }

        mysqli_close($conn); 
    };

    // Read
    function readAllHeroes() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mySuperheroes";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $SQL = "SELECT * FROM heroes";
        $result = $conn->query($SQL);

        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "Name: " . $row["name"]. " " . $row["about_me"]. " " . $row["biography"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    // // Update
    function updateHero($id, $name, $tagline) {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mySuperheroes";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $SQL = "UPDATE heroes SET about_me='$tagline', name='$name' WHERE heroes.id=$id";

        if ($conn->query($SQL) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

        mysqli_close($conn); 
    };

    // // Delete
    function deleteHero($id) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mySuperheroes";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // sql to delete a record
        $SQL = "DELETE FROM heroes WHERE id = '$id'";

        if ($conn->query($SQL) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    };

    // echo "end of script"


    if($action != "") {
        switch($action) {
            case "create":
                if(isset($_GET['name']) && isset($_GET['tagline']) && isset($_GET['bio'])){
                    createHero($_POST['name'], $_POST['tagline'], $_POST['bio']);
                    echo "Congrats hero has name, tagline, and bio!";
                    
                } else {
                    echo "create a hero needs name, tagline and bio";
                }
                break;
            case "read":
                readAllHeroes();
                echo "display all heroes";
                break;
            case "update":
                updateHero($_POST['id'], $_POST['name'], $_POST['tagline']);
                echo "updating a hero";
                break;
            case "delete":
                deleteHero($_GET['id']);
                echo "deleting a hero";
                break;
            default:
                echo "Found nothing!";
        }
    }


?>