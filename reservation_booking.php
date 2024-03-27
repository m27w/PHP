Step 1 

On the dashboard add a new button/image that when clicked will take the user through to the booking page for Personal Trainer session. 

Example of code 

<div class="image-container"> 

 

<div class="flex-item"> 
     <a href="/php_scripts/pdt.php"> 
    <img src="/images/Tracking.png" alt="PDT Sessions" class="image"> 
    <div class="overlay-text">Book PT Sessions</div> 
</div> 

 

… other images placed in div’s are inside the outer image container div 

 

</div> 

 

 

The  inner div is linked to a CSS class called flex-item the outer div is the container and is linked to a CSS class called image container. 

 

Example of code 

 

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

 

Step 2 -SQL 

 

Add a new table to hold a list of all the Personal Trainers. 

 

 

Columns Needed 

instructor_id:  is a unique identifier for each instructor,  

name:  stores the instructor's name, and  

max_hours_week:  stores the maximum number of hours the instructor can work per week, which is set to 15 by default 

 

Example of SQL Code 

 

CREATE TABLE instructors ( 

    instructor_id INT AUTO_INCREMENT PRIMARY KEY, 

    name VARCHAR(255) NOT NULL, 

    max_hours_week INT DEFAULT 15 

); 

 Then select insert from the top bar. 

When Insert window opens add a new instructor under the values column and then click go. You do not need to add a value for instructor_id as this will automatically be added. 

Add in another new table to book Personal Trainer sessions. Call the table PT sessions. 

Columns Needed  

booking_id:  is a unique identifier for each booking. 

user_id:  references the id in the users table to link the booking to a specific user. 

booking_date is the date the reservation is made 

reservation_date is the date of the reservation 

booking_time: record when the booking is for. 

duration_hours: records the number of hours booked. 

price records: the cost of the booking. 

discount_applied:  is a flag indicating whether a discount was applied to this booking. 

 

 

Example of SQL code 

 

 

CREATE TABLE pt_bookings ( 

    booking_id INT AUTO_INCREMENT PRIMARY KEY, 

    user_id INT NOT NULL, 

    booking_date DATETIME NOT NULL, 

    reservation_date DATETIME NOT NULL, 

    booking_time TIME NOT NULL, 

    duration_hours INT NOT NULL, 

    price DECIMAL(10, 2) NOT NULL, 

    discount_applied BOOLEAN DEFAULT FALSE, 

    instructor_id INT, 

    FOREIGN KEY (instructor_id) REFERENCES instructors(instructor_id), 

    FOREIGN KEY (user_id) REFERENCES users(user_id) 

); 

 

 

Step 3 

 

Create a new file php file called instructors_retrieval.php. This file will contain the script to retrieve the instructors so that it can be displayed on the page for the user to select an instructor.  

 

The code: 

 

<?php 
// instructor_retrieval.php 
session_start(); 
 
if (!isset($_SESSION['user_id'])) { 
    header('Location: login.php'); 
    exit(); 
} 
 
$servername = "localhost"; 
$username = "root"; 
$password = "root"; 
$database = "gymdb"; 
$port = 8889; // This is the default MAMP MySQL port 
 
// Create a new mysqli connection 
$conn = new mysqli($servername, $username, $password, $database, $port); 
 
// Check connection 
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
} 
 
// Prepare SQL statement 
$stmt = $conn->prepare("SELECT instructor_id, name FROM instructors"); 
 
// Execute the prepared statement 
$stmt->execute(); 
 
// Get the result of the query 
$result = $stmt->get_result(); 
 
$instructorOptions = ''; 
 
// Check if the query returned any rows 
if ($result && $result->num_rows > 0) { 
    // Fetch each row and append it to the options string 
    while ($row = $result->fetch_assoc()) { 
        $instructorOptions .= "<option value='" . $row['instructor_id'] . "'>" . htmlspecialchars($row['name']) . "</option>"; 
    } 
} else { 
    $instructorOptions .= "<option>No instructors available</option>"; 
} 
 
// Close the statement and the connection 
$stmt->close(); 
$conn->close(); 
?> 

 

 

 

Break down of the code 

 

// instructor_retrieval.php 

Comment: This is just a comment to indicate the file name or purpose. Comments are ignored by  

PHP. 

 

session_start(); 

Session Start: Initiates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie. 

 

if (!isset($_SESSION['user_id'])) { 

    header('Location: login.php'); 

    exit(); 

} 

Session Check: This checks if the user_id is not set in the session. If it's not set, it redirects the user to the login.php page. exit() ensures the script stops running if the redirection occurs. 

 

$servername = "localhost"; 

$username = "root"; 

$password = "root"; 

$database = "gymdb"; 

$port = 8889; // This is the default MAMP MySQL port 

Database Connection Variables: These lines set up variables with the database connection details like server name, username, password, database name, and port number. 

 

$conn = new mysqli($servername, $username, $password, $database, $port); 

Create Connection: Uses the mysqli class to create a new connection to the database using the details provided above. 

 

if ($conn->connect_error) { 

    die("Connection failed: " . $conn->connect_error); 

} 

Check Connection: If the connection to the database fails, the script ends (die()) and prints a message with the connection error. 

 

$stmt = $conn->prepare("SELECT instructor_id, name FROM instructors"); 

Prepare Statement: Prepares an SQL statement for execution. The query is to select instructor_id and name from the instructors table. 

 

$stmt->execute(); 

Execute Statement: Executes the prepared SQL statement. 

 

 

$result = $stmt->get_result(); 

Get Result: Retrieves the result set from the executed statement. 

 

$instructorOptions = ''; 

Initialize Options String: Initializes an empty string to hold HTML option tags. 

 

if ($result && $result->num_rows > 0) { 

    while ($row = $result->fetch_assoc()) { 

        $instructorOptions .= "<option value='" . $row['instructor_id'] . "'>" . htmlspecialchars($row['name']) . "</option>"; 

    } 

} else { 

    $instructorOptions .= "<option>No instructors available</option>"; 

} 

Process Results: 

Checks if the query returned any rows. 

If yes, it loops through each row, fetches data as an associative array (fetch_assoc()), and appends an HTML option tag for each instructor to the instructorOptions string. htmlspecialchars() ensures special characters are converted to HTML entities, preventing XSS attacks. 

If no rows were returned, it appends a "No instructors available" option. 

 

$stmt->close(); 

$conn->close(); 

Close Statement and Connection: Finally, the prepared statement and the database connection are closed to free up resources. 

 

 

Step 4  

Setup a php file that contains a HTML form for the user to be able to make a booking. The page is called pt_bookings.php 

 

<?php 
include 'instructors_retrieval.php'; // Assumes this file contains adjusted code to fetch instructors. 
?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" type="text/css" href="/css_styles/booking.css" /> 
    <title>Instructor Booking</title> 
</head> 
<body> 
 
<nav> 
    <ul> 
        <li><a href="../index.html">Home</a></li> 
        <li><a href="../page1.html">Weather</a></li> 
        <li><a href="../Widget_Time.html">Widget</a></li> 
        <li><a href="../Target Calc.html">Target Calculate</a></li> 
        <li><a href="dashboard.php">Dashboard</a></li> 
    </ul> 
</nav> 
 
<div class="container_booking"> 
    <h2>Personal Training Booking</h2> 
    <form action="pt_booking_script.php" method="post"> 
        <label for="instructor">Select an Instructor:</label> 
        <select name="instructor" id="instructor" required> 
            <?php echo $instructorOptions; // Outputs the instructor options ?> 
        </select> 
 
        <label for="training_hours">Training Hours:</label> 
        <input type="number" name="training_hours" id="training_hours" min="1" max="3" required> 
 
        <label for="reservation_date">Reservation Date:</label> 
        <input type="date" name="reservation_date" id="reservation_date" required> 
 
 
        <label for="booking_time">Time:</label> 
        <input type="time" name="booking_time" id="booking_time" required> 
 
        <button type="submit">Reserve</button> 
    </form> 
 
    <?php 
    if(isset($_SESSION['booking_confirmation'])): ?> 
        <div class="booking_confirmation"> 
            <p><?php echo $_SESSION['booking_confirmation']; ?></p> 
        </div> 
        <?php unset($_SESSION['booking_confirmation']); ?> 
    <?php endif; ?> 
 
 
<div class="bookings"> 
</div> 
    <button type="button" id="viewBookingsBtn">View My Reservation</button> 
    <h2>Your PT Reservations</h2> 
  <div class="bookings-list" id="bookingsContainer"> 
        <!-- Booking list will be inserted here by JavaScript --> 
 
</div> 
 
<script> 
document.getElementById('viewBookingsBtn').addEventListener('click', function() { 
    var xhr = new XMLHttpRequest(); 
    xhr.open('POST', 'show_pt_bookings.php', true); 
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); 
    xhr.send('param1=value1&param2=value2'); 
 
    xhr.onload = function() { 
        if (xhr.status >= 200 && xhr.status < 400) { 
            document.getElementById('bookingsContainer').innerHTML = xhr.responseText; 
        } 
    }; 
}); 
</script> 
</div> 
</body> 
</html> 

 

Break down the code 

 

<?php 
    if(isset($_SESSION['booking_confirmation'])): ?> 
        <div class="booking_confirmation"> 
            <p><?php echo $_SESSION['booking_confirmation']; ?></p> 
        </div> 
        <?php unset($_SESSION['booking_confirmation']); ?> 
    <?php endif; ?> 
</div> 
 
 

This code snippet is a mix of PHP and HTML designed to display a booking confirmation message to the user if such a message exists in the session. Here's a breakdown of each part of the code: 

 

<?php 

This opens the PHP tag, indicating that the following code will be interpreted as PHP. 

 

    if(isset($_SESSION['booking_confirmation'])): 

if: Starts an if statement that checks a condition. 

 

isset(): A PHP function that checks if a variable is set and is not NULL. 

 

$_SESSION['booking_confirmation']: This accesses a session variable named booking_confirmation. Session variables are used to store information to be used across multiple pages. 

 

The condition being checked here is whether the booking_confirmation session variable is set, which would indicate there is a booking confirmation message to display. 

 

‘:’ In this context, it's used as an alternative to { to start the conditional block of code. 

 

        <div class="booking_confirmation"> 

            <p><?php echo $_SESSION['booking_confirmation']; ?></p> 

        </div> 

This HTML code is used to display the booking confirmation message. 

 

<div class="booking_confirmation">: Defines a division or a section in an HTML document, with a  

 

class named booking_confirmation which can be targeted with CSS for styling. 

 

<p>: The paragraph tag, used here to enclose the booking confirmation message. 

 

<?php echo $_SESSION['booking_confirmation']; ?>:  

This PHP code is embedded within the HTML. The echo statement is used to output the booking confirmation message stored in the  

 

$_SESSION['booking_confirmation'] variable. 

 

 

<?php unset($_SESSION['booking_confirmation']); ?> 

unset(): A PHP function that destroys the specified variable. 

$_SESSION['booking_confirmation']: Again, refers to the booking confirmation message stored in the session. 

 

This line of code removes the booking_confirmation message from the session, ensuring it's not displayed again on refresh or navigation to another page. 

 

<?php endif; ?> 

This marks the end of the if statement initiated earlier. The endif; is used as part of the alternative syntax for control structures in PHP. 

 

 

</div> 

This closes the div tag. However, without context from preceding code, it's unclear what this closing tag corresponds to. It seems likely it's closing a parent div element not shown in this snippet. 

This code is a concise way to display a session-based message once, such as a confirmation or success message following a form submission, booking operation, or similar action. After displaying the message, it ensures the message is cleared from the session to prevent it from appearing again. 

 

Break down the code 

 

This JavaScript code snippet is designed to make an asynchronous HTTP (AJAX) request to a server-side script (show_bookings.php) when a button with the ID viewBookingsBtn is clicked, and then display the response inside an element with the ID bookingsContainer. Let's break down each line for better understanding: 

 

<script> 

This tag begins a block of JavaScript code in an HTML document. 

 

// JavaScript for loading and displaying bookings 

This is a comment explaining the purpose of the script: to load and display booking information. 

 

   document.getElementById('viewBookingsBtn').addEventListener('click', function() { 

document.getElementById('viewBookingsBtn') gets the HTML element with the ID viewBookingsBtn, which is presumably a button in this context. 

 

.addEventListener('click', function() {...}) attaches an event listener to the button that listens for click events. When the button is clicked, the function specified as the second argument to addEventListener is executed. 

 

 

var xhr = new XMLHttpRequest(); 

Creates a new instance of the XMLHttpRequest object, which allows JavaScript to make HTTP requests. This object is stored in the variable xhr. 

 

xhr.open('POST', 'show_bookings.php', true); 

Initializes a newly created request. 

 

'POST' specifies the HTTP method to use. 

 

'show_bookings.php' is the URL of the server-side script where the request is sent. 

true sets the request as asynchronous, meaning script execution continues without waiting for the HTTP request to complete. 

 

xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); 

Sets the value of an HTTP request header. In this case, the Content-Type header is set to application/x-www-form-urlencoded, indicating that the body of the request is a URL-encoded string. 

 

 xhr.send('param1=value1&param2=value2'); 

Sends the request to the server with the specified data ('param1=value1&param2=value2'). This is where you'd include any data you want to send to the server, like identifiers or query parameters. 

 

 xhr.onload = function() { 

Defines a function that will be called when the load event is fired, which occurs when the request has successfully completed. 

 

 if (xhr.status >= 200 && xhr.status < 400) { 

Checks the status code of the response. Status codes in the range 200–399 indicate that the request was successful. 

 

 document.getElementById('bookingsContainer').innerHTML = xhr.responseText; 

If the request was successful, this line gets the HTML element with the ID bookingsContainer and sets its innerHTML to the response text from the server (xhr.responseText). This typically would be HTML markup or text data fetched from the server. 

 

            } 

        }; 

    }); 

These lines close the if statement, the onload function, and the event listener function, respectively. 

 

</script> 

Ends the JavaScript block. 

In summary, this script listens for a click event on a button, makes an HTTP POST request to show_bookings.php, and if successful, inserts the response from the server into an element on the page, dynamically updating the content without needing to reload the page. 
