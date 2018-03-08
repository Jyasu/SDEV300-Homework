<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Create Student </title>
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
            // Assign post values if exist
            $newproduct = "";

            if (isset($_POST["newproduct"]))
                $newproduct = $_POST["newproduct"];

            echo "<p></p>";
            echo "<h2> Enter New User</h2>";
            echo "<p></p>";
            ?>

            <h5>Add the Product Number that corresponds with its IMG name</h5>
            <form name="main" method="post" action="addProduct.php">
                <table border="1" width="100%" cellpadding="0>

                       <tr><td width="157">Product ID:</td><td><input type="text" name="product" value='<?php echo $product ?>' size="30"></td></tr>

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
            $product = $_POST["product"];

            $user = new UserClass($product);
            // Check for accounts that already exist and Do insert

            $res = insertUser($user);
            echo "<h3><a href=index.php> Continue to store page. </a></h3> ";
        }

        function insertUser($user) {
            // Connect to the database
            $mysqli = connectdb();
            $product = $user->getProductID();


            // Now we can insert
            $Query = "INSERT INTO Products (productID) VALUES ('$product')";
            $Success = false;
            if ($result = $mysqli->query($Query)) {
                $Success = true;
            }
            $mysqli->close();
            return $Success;
        }

        function selectProduct() {
            // Connect to the database
            $mysqli = connectdb();
            // Add Prepared Statement
            $Query = "Select productID from Products";

            $result = $mysqli->query($Query);
            $myProducts = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Assign values
                    $products = $row["productID"];

                    $productData = new Productclass($products);
                    $myProducts[] = $productData;
                }
            }
            $mysqli->close();
            return $myProducts;
        }

        function getDbparms() {
            $trimmed = file('parms/dbparms.txt', FILE_IGNORE_NEW_LINES |
                    FILE_SKIP_EMPTY_LINES);
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
            $myDbparms = new DbparmsClass($mypairs['username'], $mypairs['password'], $mypairs['host'], $mypairs['db']);
            // Display the Paramters values
            return $myDbparms;
        }

        function connectdb() {
            // Get the DBParameters
            $mydbparms = getDbparms();

            // Try to connect
            $mysqli = new mysqli($mydbparms->getHost(), $mydbparms->getUsername(), $mydbparms->getPassword(), $mydbparms->getDb());
            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
            }
            return $mysqli;
        }

        class DBparmsClass {
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

            // property declaration
            private $productid = "";

            // Constructor
            public function __construct($productid) {
                $this->productid = $productid;
            }

            // Get methods
            public function getProductID() {
                return $this->productid;
            }

            // Set methods
            public function setProductID($value) {
                $this->productid = $value;
            }
        }
        ?>
    </body>
</html>