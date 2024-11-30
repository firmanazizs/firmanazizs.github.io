<?php
include "config.php";
session_start();
error_reporting(0);

if (isset($_SESSION["username"])) {
    header("Location: welcome.php");
    exit();
}

if (isset($_POST["submit"])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST["password"]);
    $cppassword = md5($_POST["cppassword"]);
    $role = $_POST['role']; // Menangkap peran dari form

    if ($password == $cppassword) {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            echo "<script>alert('Oops! Email already exists')</script>";
        } else {
            $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $_SESSION["username"] = $username; // Set session username
                $_SESSION["role"] = $role; // Set session role
                header("Location: welcome.php"); // Redirect to welcome page
                exit();
            } else {
                echo "<script>alert('Oops! Something went wrong')</script>";
            }
        }
    } else {
        echo "<script>alert('Passwords do not match')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="" method="POST" class="login-email">
            <p style="font-size: 2rem; font-weight:850;">REGISTER</p>
            <div class="input-group">
                <input type="text" placeholder="User Name" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="input-group">
                <input type="email" placeholder="Email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Confirm Password" name="cppassword" required>
            </div>
            <div class="input-group">
                <select name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Register</button>
            </div>
            <p class="login-register-text">Have an Account? <a href="index.php">Log In</a></p>
        </form>
    </div>
</body>
</html>