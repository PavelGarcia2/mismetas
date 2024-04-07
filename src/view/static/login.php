<?php
$message = "";
if (count($_POST) > 0) {
    $isSuccess = 0;
    $conn = mysqli_connect("localhost", "root", "", "taskats");
    $userName = $_POST['userName'];
    $sql = "SELECT * FROM user WHERE username= ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param('s', $userName);
    $statement->execute();
    $result = $statement->get_result();
    while ($row = $result->fetch_assoc()) {
        if (!empty($row)) {
            $hashedPassword = $row["password"];
            //if (password_verify($_POST["password"], $hashedPassword)) {

            //$isSuccess = 1;
            //}
            if ($_POST["password"] == $hashedPassword) {
                $isSuccess = 1;
                echo  'Hola buenas ' . $hashedPassword . ' ' . $_POST["password"];
            }
        }
    }
    if ($isSuccess == 0) {
        $message = "Invalid Username or Password!";
    } else {
        header("Location:  ./index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Inicio</title>
    <link href="../styles/login.css" rel="stylesheet" type="text/css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


</head>

<body>
    <main>
        <div class="logo d-flex justify-content-center">
            <h1>Taskats</h1>
        </div>
        <div class="conatiner">
            <form name="frmUser" method="post" action="">
                <div class="message"><?php if ($message != "") {
                                            echo $message;
                                        } ?></div>

                <h1 class="text-center">Login</h1>

                <div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="userName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block">
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>

</html>