<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "dbevote";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $StudId = $_POST["StudId"];
           $Lname = $_POST["Lname"];
           $Fname = $_POST["Fname"];
           $MI = $_POST["MI"];
           $Course = $_POST["Course"];
           $Year = $_POST["Yr"];
           $Birthday = $_POST["Birthday"];
           $Gender = $_POST["Gender"];

           $errors = array();
           
           $sql = "SELECT * FROM tblstudent WHERE StudId = '$StudId'";
           
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"Student already exists!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{
            
            $sql = "INSERT INTO tblstudent (Lname, Fname, MI, course, yr, birthday, gender) VALUES ( '$Lname', '$Fname', '$MI', '$Course', '$Year', '$Birthday', '$Gender' )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            }else{
                die("Something went wrong");
            }
           }
          

        }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="Hidden" class="form-control" name="StudId">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="Lname" placeholder="Last Name:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="Fname" placeholder="First Name:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="MI" placeholder="Middle Initial:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="Course" placeholder="Course:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="Yr" placeholder="Year:">
            </div>
            <div class="form-group">
                <input type="date" class="form-control" name="Birthday" placeholder="Birthday:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="Gender" placeholder="Gender:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div>
        <div><p>Already Registered <a href="login.php">Login Here</a></p></div>
      </div>
    </div>
</body>
</html>