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

        echo "Initial Connection Successful";

        mysqli_close($conn); 
    }

    createNewDatabase();




     // Create
    function createHero($name, $tagline, $bio) {
        echo "hello";
        echo ("<h1>CREATE</h1><pre>" . $name. $tagline. $bio . "</pre>");
        if(isset($_GET['name']) && isset($_GET['tagline']) && isset($_GET['bio'])){
            if(strlen($name) <= 1) {
                echo "name must be at least 2 characters";
            } else {
                
            }
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
    
            
            if ($conn->query($SQL) === TRUE) {
                echo "New Hero created successfully";
                echo '<br>';
            }
            else {
                echo "Error: " . $SQL . "<br>" . $conn->error;
            }
    
            mysqli_close($conn); 
        } else {
            echo "ERROR: To create a hero you need a name, tagline and bio";
        }
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

    // Update
    function updateHero($id, $name, $tagline) {
        echo ("<h1>UPDATE</h1><pre>" . $name. $tagline. $id . "</pre>");

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

    // Delete
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
        };

        // sql to delete a record
        $SQL = "DELETE FROM heroes WHERE id = '$id'";

        if ($conn->query($SQL) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        mysqli_close($conn);
    };

    // echo "end of script"

    // Read heroes, about and abilities
    function readHeroAbilities() {
        echo ("<h1>DISPLAY</h1><pre>" . "</pre>");

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

        $SQL = "SELECT heroes.name, heroes.about_me,
                GROUP_CONCAT(ability_type.ability SEPARATOR ' , ') AS powers
                FROM heroes
                INNER JOIN abilities ON abilities.hero_id=heroes.id
                INNER JOIN ability_type ON ability_type.id=abilities.ability_id
                GROUP BY heroes.name";
        
        $result = $conn->query($SQL);
        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "Name: " . $row["name"]. " " . $row["about_me"]. " " . $row["powers"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    $action = $_GET['action'];


    if($action != "") {
        switch($action) {
            case "create":
                createHero($_GET['name'], $_GET['tagline'], $_GET['bio']);
                echo "Congrats hero has name, tagline, and bio!";
                break;
            case "read":
                readAllHeroes();
                echo "display all heroes";
                break;
            case "update":
                if(isset($_GET['id']) && isset($_GET['name']) && isset($_GET['tagline'])) {
                    updateHero($_POST['id'], $_POST['name'], $_POST['tagline']);
                    echo "updating a hero";
                } else {
                    echo "ERROR: To update a hero, you need an id, name, and tagline";
                }
                break;
            case "delete":
                deleteHero($_GET['id']);
                echo "deleting a hero";
                break;
            case "readPowers":
                readHeroAbilities();
                echo "displaying heroes and abilities";
                break;
            default:
                echo "ERROR: Please give action a value!";
        }
    }
?>