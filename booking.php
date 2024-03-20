Step 1: PHP Integration for Class Retrieval
Booking.PHP: Compose a new php file called booking.PHP and save it to your php_scripts folder
The Code: Below is  a simple web page for booking gym classes. It incorporates PHP for dynamic content generation, specifically for populating a dropdown menu with class options, and uses external CSS for styling.  Add and amend the code below,  remember to change the link to your style sheet and add in your navigation.

<?php
include 'class_retrieval.php'; // This will execute the PHP code for retrieving class options.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="/css_styles/booking.css" />
    <title>Gym Booking</title>
</head>
<body>

<nav>
        <ul>
             <li><a href="index.html">Home</a></li>
            <li><a href="page1.html">Weather</a></li>
            <li><a href="Widget_Time.html">Widget</a></li>
            <li><a href="Target Calc.html">Target Calculate</a></li>
        </ul>
   </nav>
  <div class="container_booking">
        <h2>Gym Class Booking</h2>
        <form action="booking_script.php" method="post">
            <label for="class">Select a Class:</label>
            <select name="class" id="class" required>
                <?php echo $classOptions; // This will output the class options stored in the variable classOptions?>
            </select>
            <button type="submit">Book Now</button>
        </form>
    </div>
</body>
</html>

<?php
include 'class_retrieval.php'; // This will execute the PHP code for retrieving class options.
?>

The include statement incorporates the PHP code from class_retrieval.php into this file. The class_retrieval.php is used to fetch available gym class options from the SQL database, storing these options in a variable $classOptions for later use.
The remainder of the HTML document structure provides a simple user interface for a gym class booking system, with a navigation menu and a form for booking classes. The PHP code at the beginning includes a script for retrieving available classes, which are then displayed in a 
dropdown menu within the form. The form data is sent to booking_script.php for processing when submitted points to the class container_booking. 
This means that everything inside this div will be style using the container booking class, this includes children of the class ie container_booking label

/*booking styling */
.container_booking {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    margin: 10px; /* Added margin here if you want it around the container */
}

.container_booking label {
    font-weight: bold;
    margin-bottom: 10px; /* Adjusted margin */
}

.container_booking select,
.container_booking button {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 10px; /* Added margin for the bottom of select and button */
}

.container_booking button {
    background-color: #007BFF;
    color: #fff;
    cursor: pointer;
    display: block; /* Ensure the button is not hidden */
}

Step 2: Class Retrieval
class_retrieval.php: Compose a new php file called class_retrieval.php and store it into your php_scripts file. This script will be used to to retrieve classes from the database and display them via the variable $classoptions in booking.php page 

/ class_retrieval.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$database = "gymdb";
$port = 8889;

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT class_id, class_name, instructor, class_time FROM gym_classes");
$classOptions = '';

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $classOptions .= "<option value='" . $row['class_id'] . "'>" . htmlspecialchars($row['class_name']) . " - " . htmlspecialchars($row['instructor']) . " at " . $row['class_time'] . "</option>";
    }
} else {
    $classOptions .= "<option>No classes available</option>";
}

$conn->close();
?>

session_start();

Starts a new session or resumes an existing one: This is necessary for any PHP file that uses session variables. It allows you to access or store data in $_SESSION, which persists across different pages. This will include information such as user_id.
if (!isset($_SESSION['user_id'])) {
Checks if a session variable named user_id is set: This line is used to determine whether the user is logged in. The user_id session variable gets set when a user successfully logs in.

    header('Location: login.php');

This line is executed and redirects the user to login.php if the user is not logged in, ie the if statement resulted in a true to the question if the user_id is NOT set: This line uses the header() function to send a raw HTTP header to the browser, instructing it to navigate to login.php. It's a way to ensure only logged-in users can access this script.
    exit();
Stops further script execution: This function immediately terminates the execution of the script. It's important to call exit() after a redirection to prevent the rest of the script from running unnecessarily.

$servername = "localhost";
$username = "root";
$password = "root";
$database = "gymdb";
$port = 8889;
Database connection parameters: These lines define variables used to connect to your MySQL database. It includes the database server (localhost), the username and password for the database (root and root), the name of the database (gymdb), and the port number (8889).
$conn = new mysqli($servername, $username, $password, $database, $port);
Creates a new database connection: This line initialises a new instance of the mysqli class, using the previously defined variables to establish a connection to the MySQL database.
if ($conn->connect_error) {
Checks for a connection error: After attempting to connect to the database, this line checks if there was an error during the connection attempt.
    die("Connection failed: " . $conn->connect_error);
Terminates the script if a connection error occurred: If there was an error connecting to the database, this line stops the script and displays the error message.
$result = $conn->query("SELECT class_id, class_name, instructor, class_time FROM gym_classes");
Executes a SQL query: This line sends a SQL query to the database to select the class_id, class_name, instructor, and class_time from the gym_classes table. The result of this query is stored in the $result variable.

$classOptions = '';
Initialises the $classOptions variable: Before appending any class options, this variable is set to an empty string. It will later be used to store HTML <option> elements.

if ($result && $result->num_rows > 0) {

Checks if the query was successful and returned rows: This line checks two things: whether the query successfully executed ($result is truthy) and whether any rows were returned ($result->num_rows > 0). Where the num_rows was greater than 0, in other words, classes were found.
    while ($row = $result->fetch_assoc()) {
Loops through the query results: For each row in the result set, fetch_assoc() retrieves it as an associative array (where column names are keys). This allows you to access each column's value by its name. Link the column name to the value as a key to retrieve the value. Similar concept as a dictionary.
        $classOptions .= "<option value='" . $row['class_id'] . "'>" . htmlspecialchars($row['class_name']) . " - " . htmlspecialchars($row['instructor']) . " at " . $row['class_time'] . "</option>";

Appends an <option> element for each class to $classOptions: This line constructs an <option> element for each row (class) returned by the query. It uses htmlspecialchars() to escape any special characters in the class name and instructor to prevent XSS attacks. The class ID is used as the value of the option, and the class name, instructor, and time are displayed to the user.
} else {
    $classOptions .= "<option>No classes available</option>";
}
Handles the case where no classes are available: If the query did not return any rows, this line adds a single <option> element to $classOptions, indicating that there are no classes available.
$conn->close();

Closes the database connection: This is a good practice to free up resources once you're done with the database connection

Step 3: Make a booking

<?php
session_start(); // Start the session to use session variables.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection variables (should be in a separate, secure file)
$servername = "localhost";
$username = "root";
$password = "root";
$database = "gymdb";
$port = 8889;

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assume $user_id comes from a logged-in user session variable.
$user_id = $_SESSION['user_id'] ?? null; // Replace with actual user session variable.

// Check if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class'])) {
    $class_id = $_POST['class'];
    $booking_date = date('Y-m-d H:i:s'); // Current date and time

    // Insert booking into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO class_bookings (user_id, class_id, booking_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $class_id, $booking_date);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // If booking is successful, display a message with booking details.
        echo "Booking successful! Booking ID: " . $conn->insert_id;
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close(); // Close the statement.
}
echo '<pre>';
var_dump($_SESSION);
echo '</pre>';

$conn->close(); // Close the database connection.
?>



