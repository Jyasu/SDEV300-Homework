<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Delete Product</title>
    </head>
    <body >
        <?php
        // Check to see if Delete name is provided
        if (isset($_GET["productID"])) {
            $toDelete = $_GET["productID"];
            // A bit dangerous without checks and use of getMethod
            deleteIt($toDelete);
            echo "Thanks for the deletion of $toDelete";
            echo "<p></p>";
            echo "<a href=index.php> Return to Store Page </a>";
            echo "<p></p>";
        } else {
            show_form();

            // Provide option for inserting another product
            echo "<a href=index.php> Return to Store Page </a>";
            echo "<p></p>";
        }
        ?>
        <?php

        function show_form() {
            echo "<p></p>";
            echo "<h2> Select the Product to Delete</h2>";
            echo "<p></p>";

            // Retrieve the products
            $product = selectProducts();

            // Loop through table and display
            echo "<table border='1' width='100%' cellpadding='0'>";
            foreach ($product as $data) {
                echo "<td> <a href=deleteProduct.php?productID=" . $data->getProductID() .
                ">" . "Delete" . "</a></td>";
                echo "<tr>";
                
                // Provide Hyperlink for Selection
                echo "<td>" . $data->getProductID() . "</td>";

                echo "</tr>";
            }
            echo "</table>";
        }

        // End Show form
        ?>
        <?php

        function deleteIt($productD) {
            echo "About to Delete " . $productD;
            // Connect to the database
            $mysqli = connectdb();

            // Add Prepared Statement
            $Query = "Delete from Products where productID = ?";

            $stmt = $mysqli->prepare($Query);
            
            // Bind and Execute
            $stmt->bind_param("s", $productD);
            $stmt->execute();
            
            // Clean-up
            $stmt->close();
            $mysqli->close();
        }

        function selectProducts() {
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

                    // Create a Student instance
                    $productData = new
                            Productclass($products);
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
        class Productclass {

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