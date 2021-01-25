<?php

    if ( isset($_POST['cancel'])){
        //Redirecting to the autos.php
        header("Location: index.php");
        return;
    }

    $salt = 'XyZzy12*_';
    $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

    $failure = false; //If there's no POST data

    //If we have some POST data and we do process it
    if (isset($_POST['who']) && isset($_POST['pass'])){
        if (strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1){
            $failure = "Email and password are required";
        } else {
          $check = hash('md5',$salt.$_POST['pass']);

          if(!stristr($_POST['who'],"@") || !stristr($_POST['who'],".")){
            $failure = 'Email must have an at-sign (@)';
            error_log("Login fail ".$_POST['who']);
            
        }

            else if ( $check == $stored_hash ){
                //Redirect to autos.php
                header("Location:autos.php?name=".urlencode($_POST['who']));
                error_log("Login success ".$_POST['who']);
                return;
            }


            else {
                $failure = "Incorrect password";
                error_log("Login fail ".$_POST['who']." $check");
            }
        }
    }


    //Fall through into the View
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <?php require_once "ibootstrap.php"; ?>
            <title>Christian Afreh's Login Page</title>
        </head>
        <body>
            <div class= "container">
                <h1>Please Log In</h1>
                <?php
                if ( $failure !== false ){
                    echo('<p style="color:#ff0000;">' .htmlentities($failure)."</p>\n:");
                }
                ?>

                <form method= "POST">
                    <label for="nam">User Name</label>
                    <input type="text" name='who'id='nam'><br/>
                    <label for="id_1723">Password</label>
                    <input type="text" name="pass" id="id_1723"></br>
                    <input type="submit" value="Log In">
                    <input type="submit" name="cancel" value="Cancel">

                </form>
                <p>
                    For a password hint, view source and find a password hint
                    in the HTML comments.
                    <!-- Hint: The password is the three character name of the
programming language used in this class (all lower case)
followed by 123. -->
                </p>
            </div>
        </body>
    </html>
