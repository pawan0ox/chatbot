<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .add{
            border: 3px solid green;
            padding: 2px;
            margin: 2px;
        }
    </style>
    <title>Welcome </title>
</head>
<body>
<?php require '../login/nav.php' ?>
<p>Welcome Admin</p>
</body>
</html>
<?php
require_once "connection_bot.php";
$sql="SELECT * FROM chatbot_hints";
if($result=mysqli_query($conn,$sql)){
    if(mysqli_num_rows($result)>0){
        echo '<a class="add" href="create.php">Add new+</a>';
        echo"<table class='table table-striped' border='1'>";
        echo "<tbody>";
        echo"<tr>";
        echo"<th>id</th>";
        echo"<th>Question</th>";
        echo"<th>Reply</th>";
        echo"<th>Edit</th>";
        echo "<th>Delete</th>";
        echo "</tbody>";
        echo"</tr>";
        foreach ($result as $row){
            echo"<tr>";
            echo"<td>".$row['id']."</td>";
            echo"<td>".$row['question']."</td>";
            echo"<td>".$row['reply']."</td>";
            echo '<td><a href="update.php?id=' . $row['id']. '">Edit</a></td>';
            echo '<td><a href="delete_details.php? id=' . $row['id'] .'">Delete</a> </td>';
            echo"</tr>";

        }
        echo"</table>";
        //Free Result Set

        mysqli_free_result($result);
    }else{
        echo"ERROR:Could not able to execute $sql.".mysqli_error($conn);
    }
    mysqli_close($conn);

}
?>