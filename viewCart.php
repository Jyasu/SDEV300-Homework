<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Your Cart</title>
    </head>

    <body>
        <?php
        validate_form();

        $shirt1 = $_POST["shirt1"];
        $shirt2 = $_POST["shirt2"];
        $shirt3 = $_POST["shirt3"];
        $shirt4 = $_POST["shirt4"];
        $shirt5 = $_POST["shirt5"];
        $shirt6 = $_POST["shirt6"];
        $shirt7 = $_POST["shirt7"];
        $shirt8 = $_POST["shirt8"];
        $shirt9 = $_POST["shirt9"];
        $shirt10 = $_POST["shirt10"];
        
        //This is just to simulate a fake cart. The number of shirts is multiplied by the its cost $20 to get the total cost
        $total = ($shirt1 + $shirt2 + $shirt3 + $shirt4 + $shirt5 + $shirt6 + $shirt7 + $shirt8 + $shirt9 + $shirt10) * 20;
        ?>

        <table border= "1" ><tr><td>Item</td><td>Quantity</td></tr><br>

            <?php
            if ($shirt1 > 0) {
                echo "<tr><td>Shirt 1</td><td>$shirt1</td></tr>";
            }
            if ($shirt2 > 0) {
                echo "<tr><td>Shirt 2</td><td>$shirt2</td></tr>";
            }
            if ($shirt3 > 0) {
                echo "<tr><td>Shirt 3</td><td>$shirt3</td></tr>";
            }
            if ($shirt4 > 0) {
                echo "<tr><td>Shirt 4</td><td>$shirt4</td></tr>";
            }
            if ($shirt5 > 0) {
                echo "<tr><td>Shirt 5</td><td>$shirt5</td></tr>";
            }
            if ($shirt6 > 0) {
                echo "<tr><td>Shirt 6</td><td>$shirt6</td></tr>";
            }
            if ($shirt7 > 0) {
                echo "<tr><td>Shirt 7</td><td>$shirt7</td></tr>";
            }
            if ($shirt8 > 0) {
                echo "<tr><td>Shirt 8</td><td>$shirt8</td></tr>";
            }
            if ($shirt9 > 0) {
                echo "<tr><td>Shirt 9</td><td>$shirt9</td></tr>";
            }
            if ($shirt10 > 0) {
                echo "<tr><td>Shirt 10</td><td>$shirt10</td></tr>";
            }
            echo "</table><br>";

            echo "<table><tr><td>Total:</td><td>$ $total</td></tr></table>";

            echo "<form name='purchase' method='post' action='purchase.php'> 
                  <input name='btnsubmit' type='submit' value='Confirm Purchase'> 
                  </form>";

            echo "<form name='logout' method='post' action='logout.php'> 
                  <input name='btnsubmit' type='submit' value='Logout'> 
                  </form>";
            ?>

            <h5>Complete the information in the form below and click Submit to purchase. All fields are required.</h5>
            <form name="cart" method="post" action="purchase.php">
                <table border="1" width="100%" cellpadding="0>

                       <tr><td width="157">First Name:</td><td><input type="text" name="fname" value='<?php echo $fname ?>' size="30"></td></tr>

                    <tr><td width="157">Last Name:</td><td><input type="text" name="lname" value='<?php echo $lname ?>' size="30"></td></tr>

                    <tr><td width="157">Street:</td><td><input type="text" name="street" value='<?php echo $street ?>' size="30"></td></tr>

                    <tr><td width="157">City:</td><td><input type="text" name="city" value='<?php echo $city ?>' size="30"></td></tr>

                    <tr><td width="157">State:</td><td><input type="text" name="usState" value='<?php echo $usState ?>' size="30"></td></tr>

                    <tr><td width="157">Zip Code:</td><td><input type="text" name="zip" value='<?php echo $zip ?>' size="30"></td></tr>

                    <tr><td width="157">Phone:</td><td><input type="text" name="phone" value='<?php echo $phone ?>' size="30"></td></tr>

                    <tr><td width="157">Credit Card #:</td><td><input type="text" name="creditCard" value='<?php echo $creditCard ?>' size="16"></td></tr>

                    <tr><td width="157">Credit Card type (Visa,MasterCard):</td><td><input type="creditType" name="creditType" value='<?php echo $creditType ?>' size="30"></td></tr>

                    <tr><td width="157">Card Expiration Date:</td><td><input type="text" name="expiration" value='<?php echo $expiration ?>' size="10"></td></tr>

                    <tr><td width="157">Items Purchased:</td><td><input type="text" name="purcahsed" value='<?php echo $purchased ?>' size="30"></td></tr>

                    <tr>
                        <td width="157"><input type="submit" value="Purchase" name="CreateSubmit"></td>
                    </tr>
                </table>
            </form>
            <?php

            function validate_form() {
                $messages = array();
                $redisplay = false;
                // Assign values
                $username = $_POST["username"];
                $password = $_POST["password"];
                $email = $_POST["email"];

                $res = insertUser($fname, $lname, $street, $city, $usState, $zip, $phone, $creditCard, $creditType, $expiration, $purchased, $username);
                echo "<h3><a href=index.php> Continue to store page. </a></h3> ";
            }

            function insertUser($fname, $lname, $street, $city, $usState, $zip, $phone, $creditCard, $creditType, $expiration, $purchased, $username) {
                // Connect to the database
                $mysqli = connectdb();
                // Now we can insert
                $Query = "INSERT INTO UserDetails (fname, lname, street, city, usState, zip, phone, creditCard, creditType, expiration, purchased, username) VALUES ('$fname', '$lname', '$street', $city, $usState, $zip, $phone, $creditCard, $creditType, $expiration, $purcahsed, $username )";
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
                $myDbparms = new DbparmsClass($mypairs['username'], $mypairs['password'], $mypairs['host'], $mypairs['db']);

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
            ?>
    </body>
</html>