<?php
//  $conn = new mysqli ("localhost","root","","sign");
//  if(!$conn){
//     die("connection failed".mysqli_error($conn));
//  }




require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();



$host =$_ENV['DB_HOST'];
$user =$_ENV['DB_USERNAME'];
$pass =$_ENV['DB_PASSWORD'];
$dbname =$_ENV['DB_TABLE'];

// echo "$host.$user.$pass.$dbname";

  $conn = new mysqli ($host,$user,$pass,$dbname);

if(!$conn){
    die("connection failed".mysqli_error($conn));

}




 if(isset($_POST['submit'])){
    $email = $_POST['username'];
    $pass = $_POST['pass'];

    $query = $conn->prepare('SELECT * FROM login WHERE mail = ? ');
    $query->bind_param('s', $email);
    $query->execute();
    $result = $query->get_result();
    if($result->num_rows > 0){
        $sql = $conn->prepare('SELECT * FROM login WHERE mail = ? AND pass = ? ');
        $sql->bind_param('ss', $email, $pass);
        $sql->execute();
        $avail = $sql->get_result();
        if($avail->num_rows > 0){
            echo "<script>window.location.href='home.html'</script>";
        }else{
            echo "invalid password";
        }
    }else{
        echo "please enter regester email";
    }
 }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color: #2f45;
            
        }
    </style>
</head>
<body>
    <center>
    <form action="index.php" method="post">
        username: <input type="text" name="username" id="username"><br>
        password: <input type="text" name="pass" id="pass"><br>
        <a href="forget.php">forget ?</a><br>
        <input type="submit" name="submit" id="submit">
    </form>
    </center>
</body>
</html>