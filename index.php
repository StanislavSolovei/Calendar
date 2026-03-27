<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "terminarz");

if (isset($_POST['register'])) {
    $login = $_POST['login'];
    $pass = $_POST['haslo'];
    mysqli_query($conn, "INSERT INTO uzytkownicy (login, haslo) VALUES ('$login', '$pass')");
    echo "<p>Profil został utworzony! Zaloguj się </p>";
}

if (isset($_POST['login_btn'])) {
    $login = $_POST['login'];
    $pass = $_POST['haslo'];
    $res = mysqli_query($conn, "SELECT id, login FROM uzytkownicy WHERE login='$login' AND haslo='$pass'");

    if ($row = mysqli_fetch_assoc($res)) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user'] = $row['login'];
        header("Location: kalendarz.php");
    } else {
        echo "<p>Nie prawidłowy login lub haslo!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie/Rejestracja</title>
    <link rel="stylesheet" href="styl6.css">
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h2>Logowanie / Rejestracja</h2>
        <form method="post">
            <input type="text" name="login" placeholder="Login" required><br><br>
            <input type="password" name="haslo" placeholder="Haslo" required><br><br>
            <button type="submit" name="login_btn">Zaloguj się</button>
            <button type="submit" name="register">Zarejestruj się</button>
        </form>
    </div>
</body>
</html>

<?php

$conn -> close();

?>