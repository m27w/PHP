Rename Your Form: Change register.html to register_form.php. This allows you to include PHP code directly in your form file.

Check your PHP Registration Script (process_form.php or register.php)
Session Management: Ensure the session is started with session_start(); at the beginning of your PHP script. This is essential for accessing and setting session variables.

<?php
session_start(); // Ensure session start is at the very beginning

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Only attempt database connection if form is submitted

?>

Include Error Message Display: Within the div.form-wrapper element, before the form, add PHP code to check for and display any session-stored error messages:

<div class="form-wrapper">
       <h2>Registration-New User</h2>
// Add in this php code
     <?php
   // Display the error message if it exists
   if (!empty($_SESSION['error_message'])): ?>
       <p class="error-message"><?php echo $_SESSION['error_message']; ?></p>
       <?php

   endif;
   ?>
       <form action="/php_scripts/register.php" method="post">

The line first line inside the php tag checks if the error_message key in the $_SESSION superglobal array is not empty. $_SESSION is used to store session variables, which are accessible across multiple pages during a user session. The !empty() function checks if a variable exists and is not empty. The colon : is used as an alternative syntax to open the if statement block.
The <p> HTML line is executed if the if condition above is true. It outputs a paragraph (<p>) element with a class of error-message, which should have a specific style defined in CSS. The <?php echo $_SESSION['error_message']; ?> part is PHP code embedded within HTML that prints the error message stored in $_SESSION['error_message'].
Error-Message CSS Style: In your CSS style sheet you need to add in a new class called error-message. Then style the message as required for your website.

Javascript: To ensure that the message does not disappear when the page is reloaded Javascript code can be added to register_form.php. This code will display the message for a set period of time and then it will disappear. 
This code will be placed in the head section of the code below the title tag

<script>
    // JavaScript to clear the session error message after a delay
    window.onload = function() {
        setTimeout(function() { //creat a function setTimeout
            // Clear the displayed error message after a set number of seconds
            const errorMessage = document.querySelector('.error-message'); //get the error message
            if (errorMessage) {
                errorMessage.style.display = 'none'; 
            }
        }, 10000); // Adjust the time as needed, 1000 is 1 second
    };
</script>

The line setTimeout() function, is used to execute a piece of code after a specified delay. It takes two arguments: the first is another anonymous function defining the code to be executed after the delay, and the second is the delay itself, in milliseconds.
The line that declares a constant errorMessage and assigns to it the first element in the document that matches the CSS selector .error-message. The document.querySelector() method is used to select individual elements from the page. If an element with the class error-message exists, it gets stored in errorMessage; otherwise, errorMessage will be null.
The if errorMessage checks if an element with the class error-message was found by document.quesrySelector(). If true then the lines within if the if are exected. This line hides the error message from view by using none. This is how the error message is cleared

STEP 2: Update the PHP Register.php Script
Error Handling: Modify the register.php script to check for duplicate usernames. If a duplicate is found, store an error message in the session and redirect back to the form:
 Amend the code to add in the inner box above the Insert into line : 

$checkUser = "SELECT username FROM users WHERE username = '$username'";
 $result = $conn->query($checkUser);
 
if ($result->num_rows > 0) {
     $_SESSION['error_message'] = "Username already exists. Please choose another.";
      header("Location: register_form.php");
      exit;

// Insert data into the database
 $sql = "INSERT INTO users (username, password, age, weight, heart_rate, gender, email, mobile, date_recorded)
         VALUES ('$username', '$password', $age, $weight, $heart_rate, '$gender', '$email', '$mobile', '$currentDate')";


This block checks if the submitted username already exists and redirects back to the form with an error message if it does.

$checkUser = "SELECT username FROM users WHERE username = '$username'";

This line of PHP code constructs a SQL query string that selects the username column from the users table in the database, but only for the row(s) where the username matches the $username variable's value. This variable is expected to contain the username submitted by the user through the form. This query is used to check if the submitted username already exists in the database.

$result = $conn->query($checkUser);
This line executes the SQL query stored in $checkUser using the query method of the $conn object. The $conn object represents the connection to the database, and its query method sends the SQL query to the database and returns the result. The result of the query execution is assigned to the $result variable. This variable will be used to assess if any rows in the database match the query, indicating the username's existence.
if ($result->num_rows > 0) {
This conditional statement checks the number of rows in the result returned by the SQL query. The num_rows property of the $result object contains this number. If num_rows is greater than 0, itmeans the query found one or more rows that match the condition (i.e., the username already exists in the database).

    $_SESSION['error_message'] = "Username already exists. Please choose another.";

If the username already exists (as determined by the if statement above), this line sets an error message ("Username already exists. Please choose another.") in the $_SESSION['error_message'] session variable. Session variables are used to store information that needs to be accessible across multiple pages, like error messages that should be displayed after a redirect.

     header("Location: register_form.php");

This line sends a raw HTTP header to the client's browser instructing it to redirect to register_form.php. This redirection is done using the Location: header, which tells the browser to navigate to a different URL. This is used here to send the user back to the registration form page, where the error message can be displayed.
     exit;
The exit; statement terminates the execution of the script immediately. It's used here to ensure that no further code is executed after the redirection header is sent. This is important because without exit;, the script could continue running and potentially send additional output to the browser, which could interfere with the redirection.
 






