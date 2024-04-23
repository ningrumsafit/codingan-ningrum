<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Album Gallery</title>
    <link rel="icon" href="../img/logo.png" type="image/x-icon">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
</head>
<?php

session_start();
include '../functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_reporting(0);
    // mengambil data dari form login
    $email = $_POST["email"];
    $password = $_POST["password"];

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM user WHERE Email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION["loggedin"] = true;
        $_SESSION["user"] = true;
        $_SESSION["UserID"] = $user['UserID'];
        $_SESSION["username"] = $user['Username'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Email atau password salah";
    }
}

?>

<body style="background-image:url('pink.jpg');background-repeat:no-repeat;background-size: cover;background-position:center center;">

            <div class="container">

                 <div class="row justify-content-center">
                    <div class="d-flex flex-colum">
                        <h4 style="color:pink;" class="mt-5 text-center">Gallery Ku - Login</h4>
                        <div class="d-flex justify-content-center">
                            <img src="../img/logo.png" class="img-fluid" width="100" alt="">
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-12 col-md-9 col-sm-12">

                         <div class="card o-hidden border-0 my-5">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col">
                                        <div class="p-2">
                                            <form class="user" method="POST" action="">
                                                <div class="form-group">
                                                    <input style="background-color:pink" type="text" class="form-control form-control-user"name="email" placeholder="Masukan Email" required>
                                                </div>
                                                <div class="form-group">
                                                    <input style="background-color:pink" type="text" class="form-control form-control-user" name="password" placeholder="Masukan Password" required>
                                                </div>
                                                <button style="background-color:pink;border-color:pink;color white" type="submit"S name="login" class="btn btn primary btn-user btn-block">
                                                    Login
                                                </button>
                                            </form>
                                        </div>
                                  </div>
                            </div>
                        <center>
                            <br><br>
                            <a href="daftar.php">Daftar Akun</a>
                        </center>
</div>
</div>
</div>
</div>
</div>

    <?php include "footer.php"; ?>
    <?php include "plugin.php"; ?>

</body>
</html>