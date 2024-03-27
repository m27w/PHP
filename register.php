<?php
session_start(); // Ensure session start is at the very beginning

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Only attempt database connection if form is submitted

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" type="text/css" href="/css_styles/styleTH.css" />

    <title>Register</title>

     <script>
        // JavaScript to clear the session error message after a delay
        window.onload = function() {
            setTimeout(function() { //creat a function setTimeout
                // Clear the displayed error message after 5 seconds
                const errorMessage = document.querySelector('.error-message'); //get the error message
                if (errorMessage) {
                    errorMessage.style.display = 'none';
                }
            }, 10000); // Adjust the time as needed
        };
    </script>
</head>
<body>

<nav>
        <ul>
             <li><a href="../index.html">Home</a></li>
            <li><a href="../page1.html">Weather</a></li>
            <li><a href="../Widget_Time.html">Widget</a></li>
            <li><a href="../Target Calc.html">Target Calculate</a></li>
        </ul>
   </nav>



 <div class="form-wrapper">
        <h2>Registration-New User</h2>
      <?php
    // Display the error message if it exists
    if (!empty($_SESSION['error_message'])): ?>
        <p class="error-message"><?php echo $_SESSION['error_message']; ?></p>
        <?php

    endif;
    ?>
        <form action="/php_scripts/register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="firstname">Firstname:</label>
            <input type="text" id="firstname" name="firstname" required>

            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="mobile">Mobile:</label>
            <input type="tel" id="mobile" name="mobile" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="heart_rate">Heart-Rate:</label>
            <input type="number" id="heart_rate" name="heart_rate" required>

            <label for="weight">Weight:</label>
            <input type="number" id="weight" name="weight" required>


            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <button type="submit">Register</button>



        </form>

    </div>


</body>
</html>
