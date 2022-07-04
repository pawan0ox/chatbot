<?php
require_once "connection_bot.php";

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $sql = "DELETE FROM chatbot_hints WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        //set parameter

        $param_id = $_GET["id"];
        if (mysqli_stmt_execute($stmt)) {
            header("location: admin.php");
        }
    }
}
?>

<html>
<head>
    <title>Delete record</title>
</head>
<body>
<h2>Delete record</h2>
<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>">
    <p>Do you want to delete this chat message?</p>
    <p>
        <input type="submit" value="Yes">
        <button><a href="admin.php">No</a></button>
    </p>

</form>
</body>
</html>

