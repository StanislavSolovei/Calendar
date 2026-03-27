<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
    $conn = mysqli_connect("localhost", "root", "", "terminarz");

    $month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
    $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
    $user_id = $_SESSION['user_id'];

    $months_pl = [1=>"Styczeń", 2=>"Luty", 3=>"Marzec", 4=>"Kwiecień", 5=>"Maj", 6=>"Czerwiec", 7=>"Lipiec", 8=>"Sierpień", 9=>"Wrzesień", 10=>"Październik", 11=>"Listopad", 12=>"Grudzień"];

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl6.css">
    <title>Zadania na lipiec</title>
</head>
<body>
    <header>
    <section class="baner1">
        <img src="./Foto/logo1.png" alt="logo">
        <h1><?php echo $months_pl[$month] . " " . $year; ?></h1>
    </section>
    <section class="baner2">
        <h1>KALENDARZ</h1>
        <span>Użytkownik: <b><?php echo $_SESSION['user']; ?></b></span><br><br>
        <a href="logout.php" style="color: white">Wyloguj się</a>
    </section>
    </header>
    <div class="controls">
        <form method="get">
            <select name="month">
                <?php foreach($months_pl as $num => $name): ?>
                    <option value="<?= $num ?>" <?= $num == $month ? 'selected' : '' ?>><?= $name ?></option>
                <?php endforeach; ?>
            </select>
            <select name="year">
                <?php for($y=2020; $y<=2030; $y++): ?>
                    <option value="<?= $y ?>" <?= $y == $year ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit">Pokaż</button>
        </form>
    </div>
    <main>
        <?php
        $first_day_of_month = mktime(0, 0, 0, $month, 1, $year);
        $days_in_month = date('t', $first_day_of_month);
        $day_of_week = date('N', $first_day_of_month);

        for ($i = 1; $i < $day_of_week; $i++) {
            echo "<div class='day empty'></div>";
        }

        for ($day = 1; $day <= $days_in_month; $day++) {
            $current_date = sprintf('%04d-%02d-%02d', $year, $month, $day);
            
            echo "<div class='day' onclick='openTaskModal(\"$current_date\")'>";
            echo "<h6>$day</h6>";

            $sql = "SELECT id, wpis FROM zadania WHERE user_id = '$user_id' AND data_zadania = '$current_date'";
            $res = mysqli_query($conn, $sql);
            while($task = mysqli_fetch_assoc($res)) {
                echo "<div class='task-item'>" . htmlspecialchars($task['wpis']) . "</div>";
            }
            
            echo "</div>";
        }
        ?>
    </main>
    <footer>
        <p>Stronę wykonał: 00000000000</p>
    </footer>

    <div id="taskModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modal-body">

            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>

<?php
    $conn -> close();
?>