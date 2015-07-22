<?php
$db = new mysqli("localhost", "root", "root", "intro_to_php");
if ($db->connect_errno) {
    echo "Failed to connect to MySQL :(<br>";
    echo $db->connect_error;
    exit();
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $blargle = $db->prepare("DELETE FROM todo_list WHERE id = ?");
    $blargle->bind_param("i", $id);
    $blargle->execute();
}

if (isset($_POST['submit'])) {

    // add the text in 'todo'
    // to the SESSION variable 'list'
    $stmt = $db->prepare("INSERT INTO todo_list (item, date) VALUES (?, ?)");

    $now = date("d F Y");

    $stmt->bind_param("ss", $_POST['todo'], $now);

    // Actually run the statement with the parameters we've substituted
    $stmt->execute();
}

?>

<form action="db_todo.php"
      method="POST">

    <input type="text" name="todo">
    <input type="submit" name="submit">
 <input type="text" name="added">

</form>
<ul>
    <?php
    $sql = "SELECT * FROM todo_list";
    $result = $db->query($sql);
    echo "<table border='1'>\n";
    foreach ($result as $row) {
        echo "<tr><td>$row[item]</td><td>$row[date]</td><td>\n";

        echo "<form action='db_todo.php' method='POST'>";
        echo "<input type='hidden' name='id' value='$row[id]'>";
        echo "<input type='submit' name='delete' value='delete'>";
        echo "</form></td></tr>";
    }
    echo "</table>\n";
    ?>
</ul>
