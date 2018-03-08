<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Form Login</title>
    </head>

    <?php
    session_start();

    // Display the Session information
    echo "<h3> Session Data after Logout  </h3><table border='1'><tr><td>Username </td><td> Email </td></tr><tr>";
    echo "<td>" . $_SESSION['appusername'] . "</td>";
    echo "<td>" . $_SESSION['appemail'] . "</td></tr></table>";

    unset($_SESSION['appusername']);
    unset($_SESSION['appemail']);
    unset($_SESSION['apppassword']);

    echo "<form name='purchase' method='post' action='InsertApp.php'> 
          <input name='btnsubmit' type='submit' value='Login'> 
          </form>";
    ?>    

</body>
</html>