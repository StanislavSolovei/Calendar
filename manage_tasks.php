<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "terminarz");

if (!isset($_SESSION['user_id'])) exit();

$user_id = $_SESSION['user_id'];

if (isset($_GET['get_form'])) {
    $date = mysqli_real_escape_string($conn, $_GET['date']);
    
    $sql = "SELECT * FROM zadania WHERE user_id = '$user_id' AND data_zadania = '$date'";
    $res = mysqli_query($conn, $sql);
    
    echo "<h3>Zadania na $date</h3>";
    
    if (mysqli_num_rows($res) > 0) {
        echo "<form method='post' action='manage_tasks.php'>";
        echo "<input type='hidden' name='date' value='$date'>";
        while ($task = mysqli_fetch_assoc($res)) {
            echo "<div style='margin-bottom: 10px; display: flex; gap: 5px;'>";
            echo "<input type='text' name='tasks[".$task['id']."]' value='".htmlspecialchars($task['wpis'])."'>";
            echo "<a href='manage_tasks.php?delete=".$task['id']."' style='color:red; text-decoration:none;'>[X]</a>";
            echo "</div>";
        }
        echo "</form><hr>";
    }
    
    echo "<h4>Dodać nowe zadanie:</h4>";
    echo "<form method='post' action='manage_tasks.php'>";
    echo "<select name='type'>";
    echo "<option>spotkanie</option>";
    echo "<option>zadanie</option>";
    echo "<input type='time' name='time'>";
    echo "<input type='hidden' name='date' value='$date'>";
    echo "<textarea name='new_task' required></textarea>";
    echo "<button type='submit' name='add_task'>Dodać zadanie</button>";
    echo "</form>";
    exit;
}

if (isset($_POST['add_task'])) {
    $date = $_POST['date'];
    $text = mysqli_real_escape_string($conn, $_POST['new_task']);
    $typ = $_POST['type'];
    $time = $_POST['time'];
    mysqli_query($conn, "INSERT INTO zadania (user_id, data_zadania, time, wpis, typ) VALUES ('$user_id', '$date', '$time', '$text', '$typ')");
    header("Location: kalendarz.php?month=".date('n', strtotime($date))."&year=".date('Y', strtotime($date)));
}

if (isset($_POST['update_tasks'])) {
    foreach ($_POST['tasks'] as $id => $text) {
        $id = (int)$id;
        $text = mysqli_real_escape_string($conn, $text);
        $typ = $_POST['type'];
        mysqli_query($conn, "UPDATE zadania SET wpis='$text' AND typ='$typ' AND time='$time' WHERE id='$id' AND user_id='$user_id'");
    }
    header("Location: kalendarz.php");
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM zadania WHERE id='$id' AND user_id='$user_id'");
    header("Location: kalendarz.php");
}
?>