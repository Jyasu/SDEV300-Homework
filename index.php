<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>FGC Shop </title>
    </head>
    <body> 

        <?php
        // Retrieve Post Data
        $username = $_POST["username"];
        $email = $_POST["emailadd"];
        $password = $_POST["password"];

        // Set the session information
        session_start();
        $_SESSION['appusername'] = $username;
        $_SESSION['appemail'] = $email;
        $_SESSION['apppassword'] = $password;
        $_SESSION['timeout'] = time();

        // Provide a button to logout
        ?>
        <h1>Welcome to FGC Shop! </h1>
        <p>
    </body>

    <p> 
        $20 Per Shirt!
    </p>
    <form name="main" action="viewCart.php" method="post">
        <table>
            <tr><td>Description</td><td>Photo</td></tr><br>
            <?php
            $products = selectProduct();
            foreach ($products as $data) {
                $result = $data->getProductID();
                echo "<tr>";

                // Provide Hyperlink for Selection
                echo "<td>Street Fighter Shirt $result </td>";
                echo "<td><img src="
                ?>"images/<?php echo "$result.jpg" ?>" width="200" height="250"/>
                Quantity: <select name="shirt<?php echo "$result" ?>">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
                </td>
                <?php
                echo "</tr>";
            }
            ?>
            <tr> 
                <td colspan="2" align="center"><input name="btnsubmit" type="submit" value="Submit Purchase"></td> 
            </tr>
        </table>
    </form>


    <!-- Add Table of Hyperlinks -->
    <p>
        Click on any link in the table below to see some affliated websites:
    </p>
    <table border = "1"> 
        <tr><td>FGC Sites</td><td>Web Address</td></tr>
        <tr><td>Shoryuken</td><td><a href="shoryuken.com">Shoryuken</a></td></tr>
        <tr><td>Smashboards</td><td><a href="smashboards.com">Smashboards</a></td></tr>
        <tr><td>Eventhubs</td><td><a href="eventhubs.com">EventHubs</a></td></tr>
    </table>
    
    <?php

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
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
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

    class ProductClass {

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

// End Userclass
    echo "<form name='logout' method='post' action='logout.php'> 
          <input name='btnsubmit' type='submit' value='Logout'> 
          </form>";
    echo "<form name='addProduct' method='post' action='addProduct.php'> 
          <input name='btnsubmit' type='submit' value='Add Product'> 
          </form>";
    echo "<form name='deleteProduct' method='post' action='deleteProduct.php'> 
          <input name='btnsubmit' type='submit' value='Remove Product'> 
          </form>";
    ?>
</body>
</html>