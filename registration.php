<!DOCTYPE HTML>

<html>

<head>
  <title>Registration</title>


      <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>



    <!--date picker script-->
    <script>
    $(document).ready(function(){
        var date_input=$('input[name="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>
</head>

<body>



<?php

   include "database.php"; 

    $op = filter_input(INPUT_POST, 'op');
    $name = filter_input(INPUT_POST, 'name');
    $email = filter_input(INPUT_POST, 'email');
    $pass = filter_input(INPUT_POST, 'pass1');

    if ($op=="save")
    {
        // echo "$name - $email - $phone - $pass";

         $sql = "INSERT INTO users (username,email,password)
                  VALUES ('$name','$email',PASSWORD('$pass'))";
         mysqli_query($link,$sql);

         if (mysqli_error($link))  echo "MySQL Error: " . mysqli_error($link);
         else  {
             ?>
                <div class="container p-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">Success!</div>
                                <div class="panel-body">Your registration was successful.</div>
                            </div>
                </div>

               
             <?php

             //echo "Success!" and login user then go to dashboard screen;
                $sql = "SELECT user_id,username FROM users WHERE email='$email' AND PASSWORD('$pass') = password";
            $result = mysqli_query($link,$sql);

            // FAILED LOGIN
            if (mysqli_num_rows($result)==0)
            {
                //echo "Nothing found ";
                $failed=1;
            }

            // SUCCESS LOGIN
            else
            {
                //echo "Found! Login OK!";
                $row = $result->fetch_row();

                $db_id = $row[0];
                $db_name = $row[1];

            

                setcookie("auth_id","$db_id");
                setcookie("auth_email","$email");

                //echo "Success! Cookie value: " . $_COOKIE['auth_id'];
                header("Location:dashboard.php");

                exit;
            }

        }

         //exit;

    }

?>

<div class="container p-3 col-md-4 col-sm-4 col-md-offset-4" style="padding-top: 50px;">

    <div class="panel panel-default">
    <div class="panel-heading"><h3><b>Registration Form</b></h3></div>
    <div class="panel-body">

        <form method=POST action=registration.php>

            <div class="form-group">
                <label>Name:</label>
                <input type="text" class="form-control" name="name" required/>
            </div>
           
            

            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control"  name="email" required/>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" class="form-control"  required name="pass1" onChange="form.pass2.pattern=this.value" />
            </div>

            <div class="form-group">
                <label>Password confirmation:</label>
                <input type="password" class="form-control"  name="pass2" required />
            </div>

            <div class="form-group">
                <label></label>
                <input type="submit" class="form-control btn btn-primary" value="Save data" />
            </div>

            <input type="hidden" name="op" value="save" />
            <div class="form-group">
            <a href="login.php">Or Login</a>
            </div>

        </form>
     </div>
     </div>

</div>

</body>

</html>