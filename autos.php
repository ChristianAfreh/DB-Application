<?php

 if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1 ){
     die('Not logged in.');
 }

 //If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

require_once "pdo.php";
if (isset($_POST['make']) && isset($_POST['year'])
    && isset($_POST['mileage'])) {
    $sql = "INSERT  INTO autos (make,year,mileage) VALUES (:mk, :yr, :mi)";
    // echo("<pre>\n" . $sql . "\n</pre>\n");
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage']
    ));
}
                  $msg = false;

                  if ( isset($_POST['make']) && strlen($_POST['make']) < 1 ){
                      // header("Location:autos.php?name=".urlencode($_POST['name']));
                      $msg='Make is required';
                      error_log('Make is required');
                      // return;
                  }
                    else {

                  if ( (isset($_POST['mileage']) && isset($_POST['year'])) && (! is_numeric($_POST['mileage']) && ! is_numeric($_POST['year']))) {
                      // header("Location:autos.php?name=".urlencode($_POST['name']));
                      $msg='Mileage and year must be numeric';
                      // return;
                }
                else{
                  $msg = 'Record inserted';
                }

                  }



?>

<!DOCTYPE html>
<html>
        <head>
            <title>Christian Afreh's Automobile Tracker</title>
            <?php require_once "ibootstrap.php"?>

        </head>
        <body>

        <div class="container">
          <h1>Tracking Autos for <?php if ( isset($_REQUEST['name']) ) {
      echo htmlentities($_REQUEST['name']);} ?> </h1>

          <?php
          if ( $msg !== false && $msg != 'Make is required' && $msg != 'Mileage and year must be numeric'){
              echo('<p style="color:#00ff00;">'.htmlentities($msg)."</p>\n:");
          }
           else //if ($msg == 'Record inserted')
           {

            echo('<p style="color:#ff0000;">' .htmlentities($msg)."</p>\n:");
          }
            ?>

            <form method="post">
                <p>Make:<input type="text" name="make" size="40"> </p>
                <p>Year:<input type="numeric" name="year"> </p>
                <p>Mileage:<input type="numeric" name="mileage"> </p>
                <p><input type="submit" value="Add">
                <input type="submit" name="logout" value="Logout"></p>
            </form>



        </div>
            <div class="container">
              <h1>Automobiles</h1>
            <?php
            $stmt = $pdo->query("SELECT make,year,mileage FROM autos");
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
              echo "<ul><li>".$row['year'].' '.$row['make'].' '.'/'.' '.$row['mileage'];
              echo "</ul><br>";
            }
            ?>
          </div>

      </body>
</html>
