<?php
// Include config file
require_once "connection_bot.php";

//Define variables and initialize with empty values
 $question = $reply = "";
 $reply_err = $reply_err = "";
// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
// Get hidden input value
    $id = $_POST["id"];

//Validate question
    $input_question = trim($_POST["question"]);
    if (empty($input_question)) {
        $last_name_err = "Please enter a question";
        echo "Please enter a question.";
    } elseif (!filter_var($input_question, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $last_name_err = "Please enter a valid question";
        echo "Please enter a valid question";

    } else {
        $question = $input_question;
    }
//Validation of reply
    $input_reply = trim($_POST["reply"]);
    if (empty($input_reply)) {
        $email_err = "Please enter a reply";
        echo "Please enter a reply";
    } else {
        $reply = $input_reply;
    }

// Check input errors before inserting in database
    if (empty($question_err) && empty($reply_err)) {
        // Prepare an update statement

            $sql = "UPDATE chatbot_hints SET  question=?, reply=? WHERE id=?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssi", $param_question, $param_reply, $param_id);

                // Set parameters
                $param_question = $question;
                $param_reply = $reply;
                $param_id = $id;
            }
       else {
            $sql = "UPDATE  chatbot_hints SET  question=?, reply=? WHERE id=?";
            if ($stmt = mysqli_prepare($conn, $sql)) {

                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssi",  $param_question, $param_reply,  $param_id);
                // Set parameters
                $param_question = $question;
                $param_reply = $reply;
                $param_id = $id;
            }
        }

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {

            // Records updated successfully. Redirect to landing page
            header("location: admin.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }


// Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($conn);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);
        // Prepare a select statement
        $sql = "SELECT * FROM chatbot_hints WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result);

                    // Retrieve individual field value
                    $last_name = $row["question"];
                    $email = $row["reply"];

                } else {

                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<br><br>
<div class="container">
    <h1>Edit page</h1>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="text" class="form-control" name="question" value="<?php echo $question; ?>"<br><br>
        <input type="text" class="form-control" name="reply" value="<?php echo $reply; ?>" <br><br>
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <input type="submit" class="btn btn-primary" value="Update">
    </form>
</div>
</body>
</html>