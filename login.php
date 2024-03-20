Step 1 
Create a new PHP file called dashboard.php and save it into your PHP script folder.
The file has to be PHP as it includes PHP code and must be executed and actioned on the server. Note the browser cannot action any PHP code.
An example of dashboard code, you will need to replace the name and location of my css with yours, the navigation. 
You also need to change the image source location and name to match yours
Make sure all the links href point to your file in the correction location for example 
        <a href="/php_scripts/booking.php">
This points to the php_scripts file and then booking

Dashboard
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
    <title>Welcome</title>
</head>
<body>
<nav>
    <ul>
        <li><a href="/index.html">Home</a></li>
        <li><a href="/page1.html">Weather</a></li>
        <li><a href="/Widget_Time.html">Widget</a></li>
        <li><a href="/Target Calc.html">Target Calculate</a></li>
        <li><a href="/php_scripts/Booking.php">Make a booking</a></li>
    </ul>
</nav>
<div class="title-wrapper">
    <div class="content_title">
        <h2>Welcome to the Gym!</h2>
        <?php
          if (isset($_SESSION['username'])) {
            $username = htmlspecialchars($_SESSION['username']);
            echo "<p>Hello, $username!</p>";
        }
        ?>
        <p>This is the welcome page. You can customize this page with content relevant to the user.</p>
        <p><a href="logout.php">Logout</a></p>
    </div>
</div>

<div class="image-container">
    <div class="flex-item">
        <a href="/php_scripts/booking.php">
            <img src="/images/Booking.png" alt="Bookings" class="image">
            <div class="overlay-text">Bookings</div>
        </a>
    </div>
    <div class="flex-item">
        <img src="/images/Tracking.png" alt="Your Results" class="image">
        <div class="overlay-text">Your Results</div>
    </div>
    <div class="flex-item">
        <img src="/images/Tracking.png" alt="Classes" class="image">
        <div class="overlay-text">Classes </div>
    </div>
      <div class="flex-item">
    <a href="/php_scripts/account_info.php">
        <img src="/images/Tracking.png" alt="Classes" class="image">
        <div class="overlay-text">Account Information </div>
    </div>
</div>




</body>
</html>

Step 2
Compose and apply the CSS. Below is an example of my CSS.
CSS
/*Dashboard styling */
    .image-container {
            display: flex;
            justify-content: space-around;
            margin: 10px;
        }

        .flex-item {
            position: relative;
            width: 30%
            height: auto;

            margin: 0 10px; /* Adjusted margin */
        }

        .title-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
        width: 100%;

}

        .image {
            width: 100%;
            height: auto;
            display: block;
             opacity: 0.6; /* Adjust the opacity value (0 to 1) as needed */
        }

        .overlay-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: rgba(34, 34, 34, 1); /* Use RGBA to set the color with full opacity */
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            z-index: 1; /* Ensure text appears over the image */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Drop shadow with 2px horizontal offset, 2px vertical offset, 4px blur, and 0.5 alpha */
        }

Step 3
Compose a new login.php file, store the file in your php folder.
Add the code below remembering to change your database name 
<?php
session_start();

echo "test 5!";
$servername = "localhost";
$username = "root";
$password = "root";
$database = "gymdb";
$port = 8889; // MySQL port in MAMP

// Create a new MySQL connection
$conn = new mysqli($servername, $username, $password, $database, $port);
// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 // Retrieve and sanitize user inputs
    //$conn->real_escape_string() is used to escape special characters
    //in the user inputs, preventing SQL injection. This function ensures
    //that user input is treated as data, not as SQL code.
    $username = $conn->real_escape_string($_POST["username"]);
    $password = $conn->real_escape_string($_POST["password"]);
    echo $username;
    echo $password ;
    echo 'password and username reached';
    echo "<br>";

    // Prepare a SQL statement using placeholders
    // In the first line, we define a SQL query using placeholders (?).
    // Placeholders are used as placeholders for actual values that
    // will be substituted later. This helps prevent SQL injection.
    $sql = "SELECT * FROM users WHERE username = ?";
    // The second line prepares the SQL statement using the prepare()
    // method of the MySQLi connection ($conn). The prepared statement
    // is a way of pre-compiling an SQL query so that it can be executed
    // multiple times with different parameters. This also enhances security
    // by separating SQL code from user input.
    $stmt = $conn->prepare($sql);
    echo 'statement reached';
    echo "<br>";
    echo $sql;
    // Bind parameters to the prepared statement
    // The bind_param() method binds values to the placeholders in the prepared statement.
    // It takes two arguments:
    // The first argument ("s") specifies the type of the parameter.
    // In this case, the parameter is a string, so it's "s".
    // The subsequent argument ($username) is the actual value that will replace the placeholder.
    $stmt->bind_param("s", $username);

    // Execute the statement
    // The execute() method is called on the prepared statement ($stmt). This executes
    // the SQL query with the parameters provided in the bind_param() step. It sends
    // the query to the database for execution.
    $stmt->execute();

    // Get the result
    // The get_result() method is used to retrieve the result set from the executed
    // query. This method is applicable when the query is expected to return a result
    // set, such as in a SELECT query.
    $result = $stmt->get_result();
    echo "Number of rows: " . $result->num_rows . "<br>";

     The line below checks if the query result contains any rows. If there are more than 0 rows, it means that a user matching the provided username exists in the database.
    if ($result->num_rows > 0) {
        // Fetches the next row from the result set as an associative array. This row contains the user data from the database, such as the user's hashed password and user_id
        $row = $result->fetch_assoc();
        //Retrieves the hashed password from the user data.
        $hashedPassword = $row['password'];
        //Uses the password_verify function to check if the provided password matches the hashed password stored in the database.
        if (password_verify($password, $hashedPassword)) {
            // If the password is correct, this line sets the user_id from the database in the session, allowing the application to track which user is logged in.
            $_SESSION['user_id'] = $row['user_id'];
            // Password is correct, redirect to a new page
            echo " session id ".$_SESSION['user_id'];
         // Sets the provided username in the session, which can be used      later for various purposes, like displaying the username on the dashboard.
$_SESSION['username'] = $username; // Set the username in the session

            //Sends a header to the client's browser to redirect to dashboard.php, the user dashboard page.
	    header("Location: dashboard.php");
            exit();
        } else {
            // If the password does not match, output an error
            echo "Invalid username or password";
        }
    } else {
        // User not found, display an error message
        echo "Invalid username or password";
    }

    // Close the prepared statement
    $stmt->close();
}


Breaking down the code in more detail
echo "test 5!";
$servername = "localhost";
$username = "root";
$password = "root";
$database = "gymdb";
$port = 8889; // MySQL port in MAMP
 	This code only sets up the variables for the database connection and does not actually establish a connection or interact with the database.
 	It then sets up several variables for a database connection:
 	$servername is set to "localhost", which indicates that the database server is running on the same machine as the PHP code.
 	$username and $password are both set to "root", which are the credentials used to connect to the database server. These are default values for a MySQL server environment, especially in a development setting.
 	$database is assigned the value "gymdb", which is the name of the database you intend to connect to.
 	$port is set to 8889, specifying the port number on which the MySQL server is listening for connections. This is not the default MySQL port (which is 3306), but it is a common alternative, especially in macOS environments or when using MAMP.

Connection String
 	$conn = new mysqli($servername, $username, $password, $database, $port);
 	This line creates a new instance of the mysqli class, which opens a new connection to the MySQL server using the provided parameters: server name, username, password, database name, and port number. The connection is assigned to the variable $conn.
 	if ($conn->connect_error) {
 	This line checks if there's a connection error by accessing the connect_error property of the $conn object.
 	die("Connection failed: " . $conn->connect_error);
 	If there is a connection error, the die() function is called. This function stops the execution of the script and outputs the error message "Connection failed: " followed by the specific connection error from the $conn object.
The -> operator
 	In PHP, the -> operator is used to access methods and properties of an object. 
 	An object can be seen as a copy of class that is created at runtime and only exists whilst the program is running. This concept is part of Object Oriented Programming. 
 	Try and think of the class as a template and a copy has been made (object). Changes to the copy do not alter the template. Hence, why it is used.
 	Property refers to a method or variable that is part of the copied class ie object.
 	When you see $conn->connect_error, it means the code is accessing the connect_error property of the $conn object
 	
if ($_SERVER["REQUEST_METHOD"] == "POST") { ... }: 
Checks if the request from form is submitted using POST method.
$username = $conn->real_escape_string($_POST["username"]);: 
This sanitizes and retrieves the username from the POST data to prevent SQL injection.
$password = $conn->real_escape_string($_POST["password"]);:
This sanitizes and retrieves the password from the POST data to prevent SQL injection.
$sql = "SELECT * FROM users WHERE username = ?";: 
This  defines the SQL query to select user data using placeholders to prevent SQL injection.
$stmt = $conn->prepare($sql);: Prepares the SQL statement for execution using the prepare() method.
$stmt->bind_param("s", $username);: Binds parameters to the prepared statement to insert the sanitized username.
$stmt->execute();: Executes the prepared statement to execute the SQL query.
$result = $stmt->get_result();: Gets the result set from the executed statement.
if ($result->num_rows > 0) { ... }: Checks if there are rows returned by the query.
$row = $result->fetch_assoc();: Fetches the first row from the result set as an associative array.
$hashedPassword = $row['password'];: Retrieves the hashed password from the fetched row.
if (password_verify($password, $hashedPassword)) { ... }: Verifies if the submitted password matches the hashed password.
$_SESSION['user_id'] = $row['user_id'];: Sets the user's ID in the session.
header("Location: dashboard.php");: Redirects the user to the dashboard page after successful login.
exit();: Terminates script execution.
echo "Invalid username or password";: Outputs an error message if the password does not match or no rows are returned by the query.
$stmt->close();: Closes the prepared statement.

