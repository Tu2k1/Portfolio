<?php 
    require_once "../model/connect.php";

    $sql = "SELECT * FROM messages";
    $result = $mysqli->query($sql);
    
    // Update message
    if (isset($_POST['edit_message'])) {
        $id = $_POST['message_id'];
        $new_title = $_POST['new_title'];
        $new_message = $_POST['new_message'];
        $new_subject = $_POST['new_subject'];
        $edit_sql = "UPDATE messages SET title='$new_title', message='$new_message', subject='$new_subject' WHERE id=$id";
        $mysqli->query($edit_sql);
        header("Refresh:0");
    }
    
    // Delete message
    if (isset($_POST['delete_message'])) {
        $id = $_POST['message_id'];
        $delete_sql = "DELETE FROM messages WHERE id=$id";
        $mysqli->query($delete_sql);
        header("Refresh:0");
    }
    
    $mysqli->close();
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Admin Page</title>
</head>
<body>
    <div id="content">
        <h2>Messages</h2>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "Email: " . $row["email"] . "<br>";
                    echo "Subject: ". $row["subject"]. "<br>";
                    echo "Title: " . $row["title"] . "<br>";
                    echo "Message: " . $row["message"] . "<br>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='message_id' value='" . $row["id"] . "'>";
                    echo "<input type='text' name='new_title' value='".$row["title"]. "'>";
                    echo "<textarea name='new_message' >".$row["message"]."</textarea>";

                    echo "<label for='new_subject'>Select a Subject:<br></label>";
                    echo "<select name='new_subject'>";
                    echo "<option value='General Inquiry'". ($row["subject"] == 'General Inquiry' ? ' selected' : '') .">General Inquiry</option>";
                    echo "<option value='Support Request'". ($row["subject"] == 'Support Request' ? ' selected' : '') .">Support Request</option>";
                    echo "<option value='Feedback'". ($row["subject"] == 'Feedback' ? ' selected' : '') .">Feedback</option>";
                    echo "<option value='Other'". ($row["subject"] == 'Other' ? ' selected' : '') .">Other</option>";
                    echo "</select><br>";
                    
                    echo "<input type='submit' name='edit_message' value='Edit'> <br>";
                    echo "<input type='submit' name='delete_message' value='Delete'>";
                    echo "</form>";
                    echo "</li> <br>";
                }
            } else {
                echo "No messages found.";
            }
            ?>
        </ul>
    </div>
</body>
</html>