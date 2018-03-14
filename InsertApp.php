<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Create Accont </title>
    </head>
    <body>
        <?php
        if (isset($_POST["CreateSubmit"])) {
            validate_form();
        } else {
            $messages = array();
            show_form($messages);
        }
        ?>
        <?php

        function show_form($messages) {
            $firstname = "";
            $lastname = "";

            $email = "";
            if (isset($_POST["firstname"]))
                $firstname = $_POST["firstname"];
            if (isset($_POST["lastname"]))
                $lastname = $_POST["lastname"];
            if (isset($_POST["email"]))
                $email = $_POST["email"];
            echo "<p></p>";
            echo "<h2> Enter New User</h2>";
            echo "<p></p>";
            ?>
            <h5>Complete the information in the form below and click Submit to
                create your account. All fields are required.</h5>
            <form name="main" method="post" action="InsertApp.php">
                <table border="1" width="100%" cellpadding="0>

                       <tr><td width="157">Username:</td><td><input type="text" name="username" value='<?php echo $username ?>' size="30"></td></tr>

                    <tr><td width="157">Password:</td><td><input type="text" name="password" value='<?php echo $password ?>' size="30"></td></tr>

                    <tr>
                        <td width="157">Email:</td>
                        <td><input type="text" name="email" value='<?php
                            echo
                            $email
                            ?>' size="30"></td>
                    </tr>

                    <tr>
                        <td width="157"><input type="submit" value="Submit" name="CreateSubmit"></td>

                        <td>&nbsp;</td>
                    </tr>
                </table>
            </form>
            <?php
        }

        // End Show form
        ?>
        <?php

        function validate_form() {
            $messages = array();
            $redisplay = false;
            // Assign values
            $username = $_POST["username"];
            $password = $_POST["password"];
            $email = $_POST["email"];

            $user = new UserClass($username, $password, $email);
            $count = countUser($user);
            
            // Check for accounts that already exist and Do insert
            if ($count == 0) {
                $res = insertUser($user);
                echo "<h3><a href=index.php> Continue to store page. </a></h3> ";
            } else {
                echo "<h3>A account with that username already exists.</h3> ";
            }
        }

        function countUser($user) {
            // Connect to the database
            $mysqli = connectdb();
            $username = $user->getUsername();
            $password = $user->getPassword();
            $email = $user->getEmail();

            // Connect to the database
            $mysqli = connectdb();

            $Myquery = "SELECT count(*) as count from Users where tychoName='$username'";

            if ($result = $mysqli->query($Myquery)) {
                /* Fetch the results of the query */
                while ($row = $result->fetch_assoc()) {
                    $count = $row["count"];
                }
                /* Destroy the result set and free the memory used for it */
                $result->close();
            }
            $mysqli->close();

            return $count;
        }

        function insertUser($user) {
            // Connect to the database
            $mysqli = connectdb();
            $username = $user->getUsername();
            $password = $user->getPassword();
            $email = $user->getEmail();

            // Now we can insert
            $Query = "INSERT INTO Users (username,password,email) VALUES ('$username', '$password', '$email')";
            $Success = false;
            if ($result = $mysqli->query($Query)) {
                $Success = true;
            }
            $mysqli->close();
            return $Success;
        }

        function getDbparms() {
            $trimmed = file('parms/dbparms.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $key = array();
            $vals = array();
            foreach ($trimmed as $line) {
                $pairs = explode("=", $line);
                $key[] = $pairs[0];
                $vals[] = $pairs[1];
            }
            // Combine Key and values into an array
            $mypairs = array_combine($key, $vals);

            // Assign values to ParametersClass
            $myDbparms = new
                    DbparmsClass($mypairs['username'], $mypairs['password'], $mypairs['host'], $mypairs['db']);
            // Display the Paramters values
            return $myDbparms;
        }

        function connectdb() {
            // Get the DBParameters
            $mydbparms = getDbparms();

            // Try to connect
            $mysqli = new mysqli($mydbparms->getHost(), $mydbparms->getUsername(), $mydbparms->getPassword(), $mydbparms->getDb());
            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '
                        . $mysqli->connect_error);
            }
            return $mysqli;
        }

        class DBparmsClass {

            // property declaration
            private $username = "";
            private $password = "";
            private $host = "";
            private $db = "";

            // Constructor
            public function __construct($myusername, $mypassword, $myhost, $mydb) {
                $this->username = $myusername;
                $this->password = $mypassword;
                $this->host = $myhost;
                $this->db = $mydb;
            }

            // Get methods
            public function getUsername() {
                return $this->username;
            }

            public function getPassword() {
                return $this->password;
            }

            public function getHost() {
                return $this->host;
            }

            public function getDb() {
                return $this->db;
            }

            // Set methods
            public function setUsername($myusername) {
                $this->username = $myusername;
            }

            public function setPassword($mypassword) {
                $this->password = $mypassword;
            }

            public function setHost($myhost) {
                $this->host = $myhost;
            }

            public function setDb($mydb) {
                $this->db = $mydb;
            }

        }

        // End DBparms class
        // Class to construct Users with getters/setter

        class UserClass {

            private $username = "";
            private $password = "";
            private $email = "";

            // Constructor
            public function __construct($username, $password, $email, $tychoname) {
                $this->username = $username;
                $this->password = $password;
                $this->email = $email;
            }

            // Get methods
            public function getUsername() {
                return $this->username;
            }

            public function getPassword() {
                return $this->password;
            }

            public function getEmail() {
                return $this->email;
            }

            // Set methods
            public function setUsername($value) {
                $this->username = $value;
            }

            public function setPassword($value) {
                $this->password = $value;
            }

            public function setEmail($value) {
                $this->email = $value;
            }

        }

        // End Userclass
        ?>
    </body>
</html>
