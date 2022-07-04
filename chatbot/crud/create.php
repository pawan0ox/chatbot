<?php
require_once "connection_bot.php";

// Define variables and initialize with empty values
$id= $question = $reply = "";
$id_err = $question_err = $reply_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Validate id
    $input_id = trim($_POST["id"]);
    if (empty($input_id)) {
        $first_name_err = "Please enter a id.";
        echo "Please enter a id.";

    } elseif (!filter_var($input_id, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $first_name_err = "Please enter a valid id.";
        echo "Please enter a valid id.";

    } else {
        $id = $input_id;
    }

    $input_question = trim($_POST["question"]);
    if (empty($input_question)) {
        $first_name_err = "Please enter a question.";
        echo "Please enter a question.";

    } elseif (!filter_var($input_id, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $first_name_err = "Please enter a valid question.";
        echo "Please enter a valid reply.";

    } else {
        $question = $input_question;
    }

// Validate reply
    $input_reply = trim($_POST["reply"]);
    if (empty($input_reply)) {
        $last_name_err = "Please enter a reply.";
        echo "Please enter a reply.";
    } elseif (!filter_var($input_id, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $first_name_err = "Please enter a valid question.";
        echo "Please enter a valid reply.";
    } else {
        $last_name = $input_reply;
    }



    if (empty($id_err) && empty($question_err) && empty($reply_err)) {
// Prepare an insert statement

        $sql = "INSERT INTO chatbot_hints (id, question, reply ) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iss", $id, $question, $reply);

            // Set parameters
            $id = trim($_POST['id']);
            $question = trim($_POST['question']);
            $reply = trim($_POST['reply']);


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                header("location: admin.php");
            } else {
                echo "ERROR: Could not execute query: $sql. " . mysqli_error($conn);
            }
        } else {
            echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
        }

// Close statement
        mysqli_stmt_close($stmt);

// Close connection
        mysqli_close($conn);
    }
}
?>
<html>
<style>
    .container {
        position: absolute;
        background-color: #5e5e5e;
        padding: 10%;
        width: 79%;
        background-size:100%;
        text-align: left;
    }
    .container1 {
        position: center;
        margin: 0%;
        background-color: #00bfbf;
        padding: 0%;
        size: 10cm;
        text-align: center;
    }
    .id {
        position: initial;
        size: 1cm;
        text-align: left;
        background-color: #edfbff;
        width: 800px;
        border: 15px solid green;
        padding: 20px;
        margin: 20px;
    }
    .question {
        position: initial;
        size: 1cm;
        text-align: left;
        background-color: #edfbff;
        width: 800px;
        border: 15px solid green;
        padding: 20px;
        margin: 20px;
    }
    .reply {
        position: initial;
        size: 1cm;
        text-align: left;
        background-color: #edfbff;
        width: 800px;
        border: 15px solid green;
        padding: 20px;
        margin: 20px;
    }
    .button {
        width: 50px;
        margin: 0 auto;
        float: left;
        border: 1px solid green;
        padding: 2px;
        margin: 2px;
    }

    .action_btn {
        width: 50px;
        margin: 0 auto;
        float: right;

    }
</style>
    <div  class=container mt-3">
        <h2 class="container1">Create page</h2>
        <form action="create.php" method="post" enctype="multipart/form-data">
            <div class="id" class="mb-3 mt-3">
                <label  for="id">id:</label>
                <input type="text" class="form-control" id="id" placeholder="enter id" name="id">
            </div>
            <div class="question" class="mb-3">
                <label for="question">question:</label>
                <input type="text" class="form-control" id="question" placeholder="Enter question" name="question">
            </div>
            <div class="reply" class="mb-3">
                <label for="reply">Reply</label>
                <input type="text" class="form-control" id="reply" placeholder="enter reply" name="reply">
            </div>
            <button class="button" type="submit" class="btn btn-primary">Submit</button>
        </form>

        <form id="myForm" action="admin.php">
            <input class="action_btn" type="button" onclick="myFunction()" value="back">
        </form>
        <script>
            function myFunction() {
                document.getElementById("myForm").submit();
            }
        </script>
    </div>
</html>
