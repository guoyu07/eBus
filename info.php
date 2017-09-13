<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Info</title>

    <!-- Required stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Required scripts -->
    <script src="js/jquery.min.js" charset="utf-8"></script>
    <script src="js/bootstrap.min.js" charset="utf-8"></script>

  </head>
  <body>
    <!-- Including the navbar -->
    <?php include('connect.php'); ?>

    <!-- Navbar -->
    <nav class="navbar navbar-inverse site-header">
     <div class="container-fluid">
       <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#topNavbar">
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="index.php">eBus</a>
       </div>
       <div class="collapse navbar-collapse" id="topNavbar">
         <ul class="nav navbar-nav">
           <li><a href="index.php">Home</a></li>
           <li><a href="#">Page 1</a></li>
           <li><a href="#">Page 2</a></li>
           <li><a href="#">Page 3</a></li>
         </ul>

         <?php

            if (isset($_SESSION['passenger_id'])) {
              echo('
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                  <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Log out</a></li>
                </ul>
              ');
            } else {
              echo('
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="#" data-toggle="modal" data-target="#signUpModal"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                  <li><a href="#" data-toggle="modal" data-target="#logInModal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                </ul>
              ');
            }

         ?>

         <!-- Modals -->
          <div id="signUpModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-md">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Sign Up</h4>
                </div>
                <div class="modal-body">
                  <form method="post" action="" class="form-horizontal">
                    <div class="form-group">
                      <div class="col-sm-12">
                        <input type="email" class="form-control" name="semail" placeholder="Enter email" maxlength="20" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-12">
                        <input type="password" class="form-control" name="spassword" placeholder="Enter Password" maxlength="30" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-12">
                        <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password" maxlength="30" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="fname" placeholder="First Name" maxlength="20" required>
                      </div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="mname" placeholder="Middle Name" maxlength="20">
                      </div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="lname" placeholder="Last Name" maxlength="20" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-12">
                        <input type="number" class="form-control" name="mobile" placeholder="Enter Mobile Number" maxlength="10" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-2 col-sm-offset-5">
                        <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" name="signup" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div> <!-- /modal-content -->
            </div>
          </div> <!-- /signup modal -->

          <div id="logInModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Log In</h4>
                </div>
                <form method="post" action="">
                  <div class="modal-body">
                    <div class="form-group">
                      <input type="email" class="form-control" name="lemail" placeholder="Enter email" maxlength="20" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="lpassword" placeholder="Enter Password"  maxlength="30" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">Log In</button>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </form>
              </div> <!-- /modal-content -->
            </div>
          </div> <!-- /login modal -->

       </div>
     </div>
    </nav> <!-- /navbar -->


    <?php
    // Login section
    if (isset($_POST['login'])) {
      if (!empty($_POST['lemail']) && !empty($_POST['lpassword'])) {
        $email = mysqli_real_escape_string($conn, $_POST['lemail']);
        $password = mysqli_real_escape_string($conn, $_POST['lpassword']);

        $query = "SELECT passenger_id,email FROM passengers WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $count = mysqli_num_rows($result);

        if ($count == 1) {
          $_SESSION['passenger_id'] = $row['passenger_id'];

          header('Location: index.php');
        }else{
          $_SESSION['message'] = "Something went wrong. Please <a href=\"index.php\">try again</a>.";
          $_SESSION['type'] = "error";

          header('Location: info.php');
        }
      }
    }

    // Signup section
    if (isset($_POST['signup'])) {
      if (!empty($_POST['semail']) && !empty($_POST['spassword']) && !empty($_POST['cpassword']) && !empty($_POST['fname']) &&  !empty($_POST['lname']) && !empty($_POST['mobile'])) {

        $email = mysqli_real_escape_string($conn, $_POST['semail']);
        $password = mysqli_real_escape_string($conn, $_POST['spassword']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $mname = mysqli_real_escape_string($conn, $_POST['mname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

        $query = "INSERT INTO passengers(email, fname, mname, lname, password, mobile) VALUES('".$email."', '".$fname."', '".$mname."', '".$lname."', '".$password."',". $mobile .")";

        $result = mysqli_query($conn, $query);
        if (false===$result) {
          $_SESSION['message'] = "Something went wrong.<br />Details: ". mysqli_error($conn) ."<br />Please <a href=\"index.php\">try again</a>.";
          $_SESSION['type'] = 'error';

          header('Location: info.php');
        }else{
          $_SESSION['message'] = "You've successfully registered. You can <a href=\"index.php\">login</a>.";
          $_SESSION['type'] = 'success';

          header('Location: info.php');
        }
      }
    }

    mysqli_close($conn);

    ?>


    <?php

      $alert_class = '';
      if (isset($_SESSION['message']) && isset($_SESSION['type'])) {
          if ($_SESSION['type'] == 'error') {
            $alert_class = 'alert-danger';
          }elseif ($_SESSION['type'] == 'success') {
            $alert_class = 'alert-success';
          }
      }

    ?>

    <!-- Site body -->
    <div class="container-fluid site-body">
      <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
          <div class="alert <?php echo($alert_class); ?>">
            <?php echo($_SESSION['message']); ?>
            <?php

              unset($_SESSION['message']);
              unset($_SESSION['type']);

            ?>
          </div>
        </div>
      </div>
    </div> <!-- /site-body -->

    <!-- Including the footer -->
    <?php include('footer.php'); ?>
  </body>
</html>
