
This tutorial works through several steps to set up a ticket booking system. The user can book child or adult tickets and group bookings. It calculates the cost of each ticket, currently set at £30. Children are given a 50% discount. There is also a group booking discount set up. It also shows all the user bookings.  

You must follow every step. Check the code and make changes where necessary. 

To be able to make changes you need to read the breakdown of the code. 

 

 

Step 1 -Database Set UP 

 

Set up the database to have table called gym_classes(but you could give this a new name but you will need to change the table name all the PHP code that references). There are tools that you can use where you can paste the code and ask it to change the name to match your database, table and column names. Notice that max_spaces has been setup. This is the max number of tickets available for any given day.  

A close-up of a computer screen

Description automatically generated 

 

 

 

Step 2-class_retrieval.PHP 

 

Begin by setting up a new php file called class_retrieval.PHP. This file is used to retrieve the type of booking that the user can select (Educational or Non Educational). 

Copy the code and place it into the new file. Remember to change the database name to match yours. 

The name of my table where the classes are stored is called gym_classes, this will need to be changed to match the name of your table. 

You will also need to change the name of the database columns to match yours, mine are called class_id and class_name. 

Notice that this includes the db_connection.php file that setups up the connection. An explanation of how to setup the database file is shown below in Step 3. You cannot connect to the database until this file has been setup. 

<?php 
// class_retrieval.php 
session_start(); 
// Database connection setup 
include 'db_connection.php'; // Assuming db_connection.php contains the function getDatabaseConnection() 
 
// Create a connection to the database 
$conn = getDatabaseConnection(); 
 
// Adjust the query to select both class_id and class_name 
$result = $conn->query("SELECT class_id, class_name FROM gym_classes"); 
$classOptions = ''; 
 
// Check if the result set has rows and then populate the options string 
if ($result && $result->num_rows > 0) { 
    while ($row = $result->fetch_assoc()) { 
        // Use htmlspecialchars to escape any special characters in the class_name 
        $classOptions .= "<option value='" . $row['class_id'] . "'>" . htmlspecialchars($row['class_name']) . "</option>"; 
    } 
} else { 
    $classOptions .= "<option>No classes available</option>"; 
} 
 
$conn->close(); 
?> 

 

Breaking down the code  

 

<?php:  

This line opens the PHP code block. 

 

session_start(); 

Starts a new session or resumes an existing one. This is used to maintain session data across multiple pages including user_id. 

 

include 'db_connection.php'; 

This line includes the db_connection.php file, which contains the function getDatabaseConnection() that establishes a connection to the database. 

 

$conn = getDatabaseConnection(); 

Calls the getDatabaseConnection() function from the included file to establish a connection to the database and assigns it to the variable $conn. 

 

$result = $conn->query("SELECT class_id, class_name FROM gym_classes"); 

Executes an SQL query to select class_id and class_name from the gym_classes table and stores the result in $result. 

 

$classOptions = ''; 

Initializes the variable $classOptions with an empty string. This variable will be used to build the HTML options for a select dropdown. 

 

if ($result && $result->num_rows > 0) {  

Checks if $result is not null and has more than 0 rows. 

 

while ($row = $result->fetch_assoc()) { 

Starts a loop to iterate through each row of the result set. fetch_assoc() fetches a row as an associative array. 

 

$classOptions .= "<option value='" . $row['class_id'] . "'>" . htmlspecialchars($row['class_name']) . "</option>"; 

Appends an HTML option element to $classOptions, using class_id as the value and class_name as the displayed text. htmlspecialchars() is used to escape any special characters in class_name to prevent SQL injection attacks. 

 

} else { 

If the result set has no rows, this block will execute. 

 

$classOptions .= "<option>No classes available</option>";  

Appends an option to $classOptions indicating that no classes are available. 

 

}  

Closes the if statement block. 

 

$conn->close(); 

Closes the database connection. 

 

?> 

 Closes the PHP code block.
 
 

Step 3 -db_connection.PHP 

The code above includes a file called db_connection.php, this file contains the connection string code. This makes the code more efficient as you are no longer re-writing it for each php script.  

Only do this next section if you have not prevously set up a connection database file in the login script version 2. 

Make a new php file called 'db_connection.php'. Add the connection string code in here. 

Remember to change the name of the database to the name that you have used, this is highlighted. 

 
<?php 
 
function getDatabaseConnection() { 
    $servername = "localhost"; 
    $username = "root"; 
    $password = "root"; 
    $database = "gymdb"; 
    $port = 8889; // Adjust the port if your MySQL doesn't use 8889 
 
    $conn = new mysqli($servername, $username, $password, $database, $port); 
 
    if ($conn->connect_error) { 
        die("Connection failed: " . $conn->connect_error); 
    } 
 
    return $conn; 
} 
 
?> 

 

Breaking down the code  

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

 

 

 

 

 

 

Step 4- booking.PHP 

Make a new PHP file called booking, this file includes PHP, HTML, and JavaScript.  

A screenshot of a website

Description automatically generated 

 

 

Copy the code below and amend the code to pick up your style sheet, change the navigation and link the divs etc to classes in your style sheet. 

<?php 
include 'class_retrieval.php'; // This will execute the PHP code for retrieving class options. 
 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" type="text/css" href="../css_styles/booking.css" /> 
  <title>Gym Booking</title> 
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
 
<div class="container_booking"> 
    <h1>Gym Class Booking</h1> 
 
    <form id="bookingForm" action="booking_script.php" method="post"> 
        <div class="form-field"> 
            <label for="class">Select a Class:</label> 
            <select name="class" id="class" required> 
                <?php echo $classOptions; ?> 
            </select> 
        </div> 
 
        <div class="form-field"> 
            <label for="adultPlaces">Number of Adult Places:</label> 
            <input type="number" id="adultPlaces" name="adultPlaces" min="0" value="0" required> 
        </div> 
 
        <div class="form-field"> 
            <label for="childPlaces">Number of Child Places:</label> 
            <input type="number" id="childPlaces" name="childPlaces" min="0" value="0" required> 
        </div> 
 
        <div class="form-field checkbox-field"> 
            <label> 
                <input type="checkbox" id="groupBookingCheckbox" name="groupBookingCheckbox"> 
                Group Booking (10+ places) 
            </label> 
        </div> 
 
        <div class="form-field"> 
            <label for="booking_date">Booking Date:</label> 
            <input type="date" id="booking_date" name="booking_date" required> 
        </div> 
 
        <button type="submit">Book Now</button> 
    </form> 
 
    <div id="messageContainer"></div> 
 
    <?php if(isset($_SESSION['booking_confirmation'])): ?> 
    <div class="booking_confirmation"> 
        <p><?php echo $_SESSION['booking_confirmation']; ?></p> 
    </div> 
    <?php unset($_SESSION['booking_confirmation']); endif; ?> 
 
    <div> 
        <button type="button" id="viewBookingsBtn">View My Bookings</button> 
        <div id="bookingsContainer"></div> 
    </div> 
</div> 
 
<script> 
document.addEventListener('DOMContentLoaded', function () { 
    const groupBookingCheckbox = document.getElementById('groupBookingCheckbox'); 
    const adultPlaces = document.getElementById('adultPlaces'); 
    const childPlaces = document.getElementById('childPlaces'); 
    const messageContainer = document.getElementById('messageContainer'); 
 
    function updatePlacesLimit() { 
        if (groupBookingCheckbox.checked) { 
            adultPlaces.min = 0; 
            childPlaces.min = 0; 
            adultPlaces.max = 100; 
            childPlaces.max = 100; 
        } else { 
            adultPlaces.value = 0; 
            childPlaces.value =0; 
            adultPlaces.min = 0; 
            childPlaces.min = 0; 
            adultPlaces.max = 9; 
            childPlaces.max = 9; 
        } 
    } 
 
    groupBookingCheckbox.addEventListener('change', function () { 
        updatePlacesLimit(); 
        messageContainer.innerHTML = ''; // Clear any existing messages 
    }); 
 
    document.getElementById('bookingForm').addEventListener('submit', function (event) { 
        const totalPlaces = parseInt(adultPlaces.value) + parseInt(childPlaces.value); 
        const isGroupBooking = groupBookingCheckbox.checked; 
 
        if (isGroupBooking && totalPlaces < 10) { 
            event.preventDefault(); 
            messageContainer.innerHTML = '<p>Group booking must be for 10 or more places.</p>'; 
        } else if (!isGroupBooking && totalPlaces > 9) { 
            event.preventDefault(); 
            messageContainer.innerHTML = '<p>Individual booking cannot exceed 9 places.</p>'; 
        } else if (adultPlaces.value == 0 && childPlaces.value == 0) { 
            event.preventDefault(); 
            messageContainer.innerHTML = '<p>At least one adult or child ticket must be booked.</p>'; 
        } 
    }); 
 
    updatePlacesLimit(); // Set initial limits 
}); 
</script> 
 
<script> 
    document.getElementById('viewBookingsBtn').addEventListener('click', function() { 
        var xhr = new XMLHttpRequest(); 
        xhr.open('POST', 'show_bookings.php', true); 
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); 
        xhr.send('param1=value1&param2=value2'); 
 
        xhr.onload = function() { 
            if (xhr.status >= 200 && xhr.status < 400) { 
                document.getElementById('bookingsContainer').innerHTML = xhr.responseText; 
            } 
        }; 
        xhr.send(); 
    }); 
</script> 
 
</body> 
</html> 

 

Breakdown the code 

 

This HTML document includes PHP code for a gym class booking system. Let's go through each section to understand its purpose: 

 

<?php 

include 'class_retrieval.php';  

?> 

This PHP code includes another PHP file that contains the code to fetch available classes from the database and use them within the html. 

 

<!DOCTYPE html> 

<html lang="en"> 

Defines the document as HTML5 and sets the language to English. 

 

<head> 

    <meta charset="UTF-8"> 

    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

    <link rel="stylesheet" type="text/css" href="../css_styles/booking.css" /> 

    <title>Gym Booking</title> 

</head> 

 

Inside the <head>: meta tags set the character set to UTF-8 and configure the viewport for responsive design, link tag links to an external CSS file for styling and title sets the title of the webpage. 

<body> 

Starts the body of the HTML document. 

 

<nav> 

    <ul> 

        <li><a href="../index.html">Home</a></li> 

        <li><a href="../page1.html">Weather</a></li> 

        <li><a href="../Widget_Time.html">Widget</a></li> 

        <li><a href="../Target Calc.html">Target Calculate</a></li> 

    </ul> 

</nav> 

Defines a navigation bar with links to other pages in the website. Notice the ../ , this tells the program to step out of  the PHP folder and go back to the outer folder, in this case to htdocs to find the files 

 

<div class="container_booking"> 

    <h1>Gym Class Booking</h1> 

Starts a div container for the booking form and sets a heading. 

 

<form id="bookingForm" action="booking_scriptv1.php" method="post"> 

Begins a form with POST method where the data will be sent to booking_scriptv1.php for processing. 

 

<div class="form-field"> 

    <label for="class">Select a Class:</label> 

    <select name="class" id="class" required> 

        <?php echo $classOptions; ?> 

    </select> 

</div> 

A dropdown for class selection populated by classOptions, a variable that has been set in class_retrieval.php that was included at the top of the code. 

 

<div class="form-field"> 

    <label for="adultPlaces">Number of Adult Places:</label> 

    <input type="number" id="adultPlaces" name="adultPlaces" min="0" value="0" required> 

</div> 

Input for specifying the number of adult places to book. 

 

<div class="form-field"> 

    <label for="childPlaces">Number of Child Places:</label> 

    <input type="number" id="childPlaces" name="childPlaces" min="0" value="0" required> 

</div> 

Input for specifying the number of child places to book. 

 

<div class="form-field checkbox-field"> 

    <label> 

        <input type="checkbox" id="groupBookingCheckbox" name="groupBookingCheckbox"> 

        Group Booking (10+ places) 

    </label> 

</div> 

A checkbox to indicate if the booking is a group booking. 

 

<div class="form-field"> 

    <label for="booking_date">Booking Date:</label> 

    <input type="date" id="booking_date" name="booking_date" required> 

</div> 

Date picker for selecting the booking date. 

 

<button type="submit">Book Now</button> 

</form> 

Button to submit the form data to the php file name in the form_id. 

 

<div id="messageContainer"></div> 

A container where messages (like errors or success messages) will be displayed. 

 

<?php if(isset($_SESSION['booking_confirmation'])): ?> 

    <div class="booking_confirmation"> 

        <p><?php echo $_SESSION['booking_confirmation']; ?></p> 

    </div> 

    <?php unset($_SESSION['booking_confirmation']); endif; ?> 

Checks if there is a booking confirmation message in the session, displays it, and then unsets it. 

 

<div> 

    <button type="button" id="viewBookingsBtn">View My Bookings</button> 

    <div id="bookingsContainer"></div> 

</div> 

A button to view bookings and a container to display them. 

 

 

<script> 

Starts a script block where JavaScript code is included to enhance the interactivity of the booking form. 

First JavaScript Code 

This JavaScript code runs when the document content is loaded and it manages the logic for booking places in a gym class, specifically handling group bookings and individual ticket selections. 

 

document.addEventListener('DOMContentLoaded', function () { 

This line sets up an event listener that executes the enclosed function once the HTML document is fully loaded. 

The document object in JavaScript represents the entire HTML document and serves as an entry point to the content of the web page, which includes its elements, style, and content.  

addEventListener is a method that document and other DOM (Document Object Model) elements have. It is used to attach an event listener to the document. 

The listener waits for the document to be fully loaded and parsed (but not necessarily for all external resources like images and stylesheets to load). Once the DOMContentLoaded event triggers, the provided function (callback) executes. 

In simple terms, it tells the browser to execute the enclosed JavaScript code only after the entire HTML document is ready, ensuring that all elements referenced in the script are loaded and accessible. 

    const groupBookingCheckbox = document.getElementById('groupBookingCheckbox'); 

    const adultPlaces = document.getElementById('adultPlaces'); 

    const childPlaces = document.getElementById('childPlaces'); 

    const messageContainer = document.getElementById('messageContainer'); 

These lines declare constants referencing HTML elements on the page. They use the getElementById method to access the checkbox for group bookings, the input fields for adult and child places, and the container for messages. 

 function updatePlacesLimit() { 

Defines a function to update the maximum and minimum allowed ticket numbers based on whether a group booking is selected. 

        if (groupBookingCheckbox.checked) { 

            adultPlaces.min = 0; 

            childPlaces.min = 0; 

            adultPlaces.max = 100; 

            childPlaces.max = 100; 

        } else { 

            adultPlaces.value = 0; 

            childPlaces.value = 0; 

            adultPlaces.min = 0; 

            childPlaces.min = 0; 

            adultPlaces.max = 9; 

            childPlaces.max = 9; 

        } 

    } 

Inside this function, an if statement checks whether the group booking checkbox is selected. 

If so, it sets the minimum values to 0 and maximum to 100 for both adult and child ticket inputs. 

If not, it resets the values to 0 and adjusts the maximum to 9, enforcing the limit for individual bookings. 

 

    groupBookingCheckbox.addEventListener('change', function () { 

        updatePlacesLimit(); 

        messageContainer.innerHTML = ''; // Clear any existing messages 

    }); 

Adds an event listener to the group booking checkbox that calls updatePlacesLimit whenever the checkbox's state changes. It also clears any messages in the message container. 

 

    document.getElementById('bookingForm').addEventListener('submit', function (event) { 

Sets an event listener on the booking form that triggers a function when the form is submitted. 

        const totalPlaces = parseInt(adultPlaces.value) + parseInt(childPlaces.value); 

        const isGroupBooking = groupBookingCheckbox.checked; 

Calculates the total number of places booked by adding the adult and child places and checks if it’s a group booking. 

 

        if (isGroupBooking && totalPlaces < 10) { 

            event.preventDefault(); 

            messageContainer.innerHTML = '<p>Group booking must be for 10 or more places.</p>'; 

        } else if (!isGroupBooking && totalPlaces > 9) { 

            event.preventDefault(); 

            messageContainer.innerHTML = '<p>Individual booking cannot exceed 9 places.</p>'; 

        } else if (adultPlaces.value == 0 && childPlaces.value == 0) { 

            event.preventDefault(); 

            messageContainer.innerHTML = '<p>At least one adult or child ticket must be booked.</p>'; 

        } 

    }); 

Validates the total number of tickets based on the booking type. 

For group bookings, if fewer than 10 tickets are selected, it prevents form submission and displays a message. 

For individual bookings, if more than 9 tickets are selected, it also prevents submission and shows a message. 

It ensures that at least one ticket (adult or child) is booked. 

 

    updatePlacesLimit(); // Set initial limits 

}); 

Calls updatePlacesLimit initially to set the appropriate limits when the page loads. 

Second JavaScript Code 

This JavaScript code adds a click event listener to an element with the ID viewBookingsBtn and makes an asynchronous HTTP request to a PHP script to retrieve and display booking information. Here's a breakdown of each line: 

 

document.getElementById('viewBookingsBtn').addEventListener('click', function() { ... }); 

 

document.getElementById('viewBookingsBtn'): This finds and selects the HTML element with the ID viewBookingsBtn. 

.addEventListener('click', function() {...}): Adds a click event listener to the selected element, so the enclosed function executes when the element is clicked. 

 

var xhr = new XMLHttpRequest(); 

This line creates a new instance of the XMLHttpRequest object, which allows you to make HTTP requests from JavaScript to retrieve data from a server without having to refresh the entire page. This object can be used to request data in various formats, including JSON, XML, HTML, and plain text. 

var xhr: This declares a variable named xhr. var is used to declare a variable in JavaScript, and xhr is a common shorthand for "XMLHttpRequest." 

new: This keyword creates a new instance of an object (Remember an object is a class that contains functions and something called a constructor. The constructor is used to set up a new copy of the class/object. A copy has its own name, abit like copying a template and giving it a new name). In this case, it's creating a new instance of the XMLHttpRequest object. 

 

XMLHttpRequest(): This is the constructor (a special piece of code within the  used to build the new object) for the XMLHttpRequest object. When invoked, it creates a new XMLHttpRequest object that you can use to make HTTP requests. 

 

xhr.open('POST', 'show_bookings.php', true); 

xhr.open() initializes a new request (or re-initializes an existing one). 

'POST': Specifies the HTTP method to use for the request. 

'show_bookings.php': Specifies the URL to send the request to, in this case, a PHP script on the server.(the show_bookings.php will be setup at later in this worksheet) 

true: Indicates that the request should be asynchronous, allowing the rest of the script to run while the request processes. 

 

xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); 

This sets the value of an HTTP request header, which tells the server the type of content being sent. Here, it specifies that the content type of the request body is URL-encoded form data. 

 

xhr.send('param1=value1&param2=value2'); 

Sends the request to the server with the specified data ('param1=value1&param2=value2') as the request body. 

 

xhr.onload = function() { ... }; 

Defines a function to be called when the onload event is triggered, which occurs when the request completes successfully. 

if (xhr.status >= 200 && xhr.status < 400) { ... } 

This checks the HTTP status code of the response. Status codes in the range 200-399 indicate success. If the condition is true, it means the request was successful. 

 

document.getElementById('bookingsContainer').innerHTML = xhr.responseText; 

Finds an element with the ID bookingsContainer and sets its HTML content to the response text received from the server (xhr.responseText). This is where the data fetched from show_bookings.php is displayed in the web page. 

The second xhr.send(); is redundant and should be removed because the request has already been sent earlier in the script. 

 

This script essentially fetches and displays booking details from the server in response to a user's click action, without reloading the web pa 

 

</script> 

Closes the script block. 

 

</body> 

Closes the body of the code 

 

Step 5-CSS 

CSS 

This is an example of the CSS used for the navigation and to style the booking form. This can be amended as needed 

/* Reset styles */ 
* { 
    margin: 0; 
    padding: 0; 
    box-sizing: border-box; 
} 
 
/* Navigation bar styles */ 
nav { 
    background: #170253; 
    color: #E0CCFF; 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    padding: 10px 20px; 
} 
 
nav ul { 
    list-style-type: none; 
    display: flex; 
    justify-content: flex-start; 
    gap: 20px; 
} 
 
nav ul li { 
    margin: 10px; 
} 
 
nav ul li a:link, nav ul li a:visited { 
    color: #FFF5FF; 
    text-decoration: none; 
} 
 
nav ul li a:hover { 
    color: hotpink; 
    text-decoration: none; 
} 
 
/* Container styles for the booking form */ 
.container_booking { 
    display: flex; 
    flex-direction: column; 
    justify-content: center; 
    align-items: center; 
    padding: 20px; 
    border-radius: 5px; 
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
    margin: 20px auto; /* Center container with automatic horizontal margins */ 
    width: calc(100% - 40px); /* Adjusted for padding */ 
} 
 
/* Form field styling */ 
.form-field { 
    display: flex; 
    flex-direction: column; 
    margin-bottom: 20px; 
    width: 100%; /* Full width */ 
} 
 
/* Adjustments for the checkbox field */ 
.checkbox-field label { 
    display: flex; 
    align-items: center; /* Aligns checkbox with its label */ 
} 
 
.checkbox-field input[type="checkbox"] { 
    margin-right: 10px; /* Space between checkbox and label text */ 
} 
 
/* Input, select, button styling */ 
input[type="number"], input[type="date"], select, .container_booking button { 
    width: 100%; /* Match parent width */ 
    padding: 8px; 
    margin-top: 5px; /* Space after label */ 
    border: 1px solid #ccc; 
    border-radius: 4px; 
    box-sizing: border-box; /* Include padding and border in the element's total width and height */ 
} 
 
/* Label styling */ 
.container_booking label { 
    margin-bottom: 5px; /* Space before inputs */ 
} 
 
/* Button styling */ 
.container_booking button { 
    background-color: #007BFF; 
    color: #fff; 
    cursor: pointer; 
    display: block; /* Ensure the button is displayed */ 
    border: none; /* Button-specific style */ 
} 
 
.container_booking button:hover { 
    background-color: #0056b3; 
} 
 
/* Booking confirmation message styling */ 
.booking_confirmation { 
    display: flex; 
    justify-content: center; 
    align-items: center; 
    padding: 20px; 
    margin-bottom: 20px; 
    background-color: #e0ffe0; 
    color: #007BFF; 
    border-radius: 5px; 
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); 
    width: 100%; 
} 
 
/* Additional styles for booking list, if used */ 
.bookings { 
    display: flex; 
    justify-content: center; 
    align-items: center; 
    padding: 20px; 
    margin-top: 20px; 
} 
 
.bookings h2 { 
    margin-bottom: 10px; 
} 
 
.bookings ul { 
    list-style-type: none; 
    padding: 0; 
} 
 
.bookings li { 
    margin-bottom: 10px; 
} 

 

Step 6- booking table in Database 

 

You will need to create a new table in your database for the booking, I have called this class_bookings. An example of the table I have used is shown below. 

Remember, if you change the names then they will need to be changed in the PHP.  

You can use tools to do this. You can provide the tool with names of columns in your database, the name of the table and a copy of the code and ask it to make changes to match the new table/column names. 

I have also highlighted in the code where the changes need to be made. 

A screenshot of a computer

Description automatically generated 

 

Step 7 -booking_Script.PHP 

 

Create a new php file called booking_script.PHP. This PHP script handles the booking process for a gym class. 

The same with any of the scripts you will need to make sure the connection file links to your database. 

In the bookin.php form the names of labels/input fields in the form need to match the names used in this script. They are part of the IF server == Post section below, they have been highlighted. You will need to change them. 

The SQL insert statement below, inserts the data into the database, the names used in the statement in this PHP statement must match the column names in the database. I have highlighted them for you to change. 

<?php 
session_start(); 
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL); 
 
include 'db_connection.php';  // Assume this file contains the function getDatabaseConnection() 
 
// Get the database connection 
$conn = getDatabaseConnection(); 
 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class'])) { 

//checks if the form has been submitted using the POST method and  

//whether the 'class' input field has been set in the form data 
    $user_id = $_SESSION['user_id'] ?? null; 
    $class_id = $_POST['class']; // Get the data from input field class in //the form 
    $adult_places_booked = $_POST['adultPlaces'] ?? 0;  
    $child_places_booked = $_POST['childPlaces'] ?? 0; 
    $total_places_booked = $adult_places_booked + $child_places_booked; 
    $booking_date = $_POST['booking_date']; 
    $adult_ticket_price = 30; // Adult ticket price 
    $child_ticket_price = $adult_ticket_price * 0.5; // Child ticket price is 50% of adult's 
    $discount = 0; 
 
    // Check total places booked for individual or group 
    $is_group_booking = $total_places_booked >= 10; 
 
    // Fetch maximum spaces available for the class 
    $maxSpacesQuery = "SELECT max_spaces FROM gym_classes WHERE class_id = ?"; 
    $stmt = $conn->prepare($maxSpacesQuery); 
    $stmt->bind_param("i", $class_id); 
    $stmt->execute(); 
    $result = $stmt->get_result(); 
    $max_spaces_info = $result->fetch_assoc(); 
    $max_spaces = $max_spaces_info['max_spaces'] ?? 0; 
    $stmt->close(); 
 
    // Calculate the total booked places for the class on the booking date 
    $totalBookedQuery = "SELECT SUM(total_places_booked) AS total_booked FROM class_bookings WHERE class_id = ? AND booking_date = ?"; 
    $stmt = $conn->prepare($totalBookedQuery); 
    $stmt->bind_param("is", $class_id, $booking_date); 
    $stmt->execute(); 
    $bookedResult = $stmt->get_result(); 
    $booked_info = $bookedResult->fetch_assoc(); 
    $total_booked = $booked_info['total_booked'] ?? 0; 
    $stmt->close(); 
 
    // Check if there are enough spaces left 
    if ($total_places_booked + $total_booked <= $max_spaces) { 
        if ($is_group_booking) { 
            $discount = $total_places_booked >= 20 ? 10 : 5; 
        } 
 
        // Calculate total cost considering the different prices for adults and children 
        $total_cost_before_discount = ($adult_ticket_price * $adult_places_booked) + ($child_ticket_price * $child_places_booked); 
        $discount_amount = ($total_cost_before_discount * $discount) / 100; 
        $total_cost = $total_cost_before_discount - $discount_amount; 
 
        // Generate a unique booking reference 
        $booking_reference = uniqid('booking_'); 
 
        // Insert booking into the database 
        $insertQuery = "INSERT INTO class_bookings (user_id, class_id, booking_date, adult_places_booked, child_places_booked, total_places_booked, discount, total_cost, booking_reference) VALUES (?, ?, ?, ?, ?, ?, ?,?,?)"; 
        $stmt = $conn->prepare($insertQuery); 
        $stmt->bind_param("iisiiiids", $user_id, $class_id, $booking_date, $adult_places_booked, $child_places_booked, $total_places_booked, $discount, $total_cost, $booking_reference); 
        $stmt->execute(); 
 
        if ($stmt->affected_rows > 0) { 
            $_SESSION['booking_confirmation'] = "Booking successful!<br>Booking Reference: $booking_reference.<br>You have booked: $total_places_booked places for class ID $class_id on $booking_date.<br>Total Cost: £$total_cost<br>Discount: $discount%"; 
        } else { 
            $_SESSION['booking_confirmation'] = "Error in booking: " . $conn->error; 
        } 
        $stmt->close(); 
    } else { 
        $spaces_left = $max_spaces - $total_booked; 
        $_SESSION['booking_confirmation'] = "Cannot book: Only $spaces_left spaces left for this class on the selected date."; 
    } 
} 
 
$conn->close(); 
header('Location: bookingv1.php'); 
exit(); 
?> 

 

Bread down of the Code 

<?php:  

Opens the PHP code block. 

 

session_start();  

Starts a session or resumes an existing one, which allows you to use session variables. 

 

ini_set('display_errors', 1); 

 Configures PHP to display errors. 

 

ini_set('display_startup_errors', 1); 

 Configures PHP to display errors that occur during PHP's startup sequence. 

 

error_reporting(E_ALL); 

Sets the error reporting level to show all errors, warnings, and notices. 

 

include 'db_connection.php'; 

Includes the db_connection.php file, which should contain the function getDatabaseConnection() to establish a database connection. 

 

$conn = getDatabaseConnection(); 

Calls the getDatabaseConnection() function to create a connection to the database and stores the connection object in $conn. 

 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class'])) { 

Checks if the form has been submitted (the request method is POST) and if the class field is set. $_SERVER["REQUEST_METHOD"] == "POST":  

This checks if the current request method is POST. In the context of a web application, a POST request usually indicates that form data has been sent to the server. 

&&: This is the logical AND operator. It means that both conditions on either side must be true for the entire condition to be true. 

isset($_POST['class']): This checks if there's an element named class in the $_POST array. The $_POST array contains data sent from a form when its method is POST. 

If both conditions are true (the request method is POST and there's a class element in the $_POST array), the code inside the curly braces {...} will execute. 

 

$user_id = $_SESSION['user_id'] ?? null; 

Retrieves the user ID from the session or sets it to null if it's not set. 

Inside the if block: 

This line uses the null coalescing operator ?? to assign a value to $user_id. 

The null coalescing operator ?? in PHP is a binary operator that returns the left-hand operand (value) if it is not null, and the right-hand operand (value) otherwise. It's used to provide a default value in case the first operand is null. This operator is particularly useful for setting default values for variables that may not be defined. 

Example: 

expression1 ?? expression2 

If expression1 is not null, then expression1 is returned. 

If expression1 is null, then expression2 is returned. 

$_SESSION['user_id']: This attempts to get the user_id from the session. Sessions are used in PHP to store information across multiple pages. This is typically used to track user information during a login session. 

?? null: If $_SESSION['user_id'] does not exist or is null, then null will be assigned to $user_id. Essentially, this line ensures that $user_id has a value (even if it's null) and prevents undefined index errors. 

 

 

$class_id = $_POST['class']; 

Retrieves the class ID from the posted form data. 

 

$adult_places_booked = $_POST['adultPlaces'] ?? 0; 

Retrieves the number of adult places booked from the form or defaults to 0 if not set. 

 

$child_places_booked = $_POST['childPlaces'] ?? 0; 

Retrieves the number of child places booked from the form or defaults to 0 if not set. 

 

$total_places_booked = $adult_places_booked + $child_places_booked; 

Calculates the total number of places booked by adding adult and child places. 

 

$booking_date = $_POST['booking_date']; 

Retrieves the booking date from the form data. 

 

$adult_ticket_price = 30; 

Sets the value of the variable adult_ticket_price to 30 . 

 

$child_ticket_price = $adult_ticket_price * 0.5; 

Sets the ticket price for children as half of the adult ticket price. It multiplies the ticket price by 0.5 and stores the resulting answer into child_ticket_price 

 

$discount = 0; 

Initializes the discount to 0. 

 

$is_group_booking = $total_places_booked >= 10; 

 Determines whether the booking is a group booking (10 or more places). 

 

$maxSpacesQuery = "SELECT max_spaces FROM gym_classes WHERE class_id = ?"; 

SQL query to fetch the maximum spaces available for the chosen class. 

 

$stmt = $conn->prepare($maxSpacesQuery); 

Prepares the SQL statement for execution. 

 

$stmt->bind_param("i", $class_id); 

Binds the class ID parameter to the prepared SQL statement. Notice the ‘i’, this tells the program that the value in $class_id will be an integer (number) 

 

$stmt->execute(); 

Executes the prepared SQL statement. The creation of a prepared statement before execution helps to prevent SQL injection and improves security. 

 

$result = $stmt->get_result(); 

Retrieves the result set from the executed query. 

 

$max_spaces_info = $result->fetch_assoc(); 

Fetches the result row as an associative array. 

 

$max_spaces = $max_spaces_info['max_spaces'] ?? 0; 

Gets the maximum spaces available for the class or defaults to 0 if not set. 

 

$stmt->close(); 

Closes the prepared statement. 

 

$totalBookedQuery = "SELECT SUM(total_places_booked) AS total_booked FROM class_bookings WHERE class_id = ? AND booking_date = ?"; 

SQL query to calculate the total booked places for the class on the given date. 

 

$stmt = $conn->prepare($totalBookedQuery); 

Prepares the SQL statement for execution. 

 

$stmt->bind_param("is", $class_id, $booking_date); 

Binds the class ID and booking date parameters to the prepared SQL statement. 

 

$stmt->execute(); 

Executes the prepared SQL statement. 

 

$bookedResult = $stmt->get_result(); 

Retrieves the result set from the executed query. 

 

$booked_info = $bookedResult->fetch_assoc(); 

Fetches the result row as an associative array. 

 

$total_booked = $booked_info['total_booked'] ?? 0; 

Gets the total booked places or defaults to 0 if not set. 

 

$stmt->close(); 

Closes the prepared statement. 

 

if ($total_places_booked + $total_booked <= $max_spaces) { 

Checks if there are enough spaces left for the booking. 

 

if ($is_group_booking) { 

Checks if it's a group booking to determine the discount. 

 

$discount = $total_places_booked >= 20 ? 10 : 5; 

Sets the discount based on the number.  

total_places_booked >= 20 ? 10 : 5 is the ternary operation. It's like a shorthand if-else statement. 

total_places_booked >= 20 is the condition being checked. It evaluates whether the total number of places booked is greater than or equal to 20. 

If the condition is true (i.e., if there are 20 or more places booked), the operator returns 10, setting the discount variable to 10%. This means a 10% discount applies for group bookings of 20 or more places. 

If the condition is false (i.e., fewer than 20 places are booked), the operator returns 5, setting the discount variable to 5%. This means a 5% discount applies for group bookings of less than 20 places 

 

$total_cost_before_discount = ($adult_ticket_price * $adult_places_booked) + ($child_ticket_price * $child_places_booked); 

Calculates the total cost before applying the discount. 

 

$discount_amount = ($total_cost_before_discount * $discount) / 100;:  

Calculates the discount amount. 

 

$total_cost = $total_cost_before_discount - $discount_amount; 

Calculates the total cost after applying the discount. 

 

$booking_reference = uniqid('booking_'); 

Generates a unique booking reference. 

 

 $insertQuery = "INSERT INTO class_bookings (user_id, class_id, booking_date, adult_places_booked, child_places_booked, total_places_booked, discount, total_cost, booking_reference) VALUES (?, ?, ?, ?, ?, ?, ?,?,?)";  

SQL query to insert the booking into the database. The column names must match the names in the table in the database. The number of ‘?’ must match the number of columns that data is being inserted into. 

 

$stmt = $conn->prepare($insertQuery); 

Prepares the SQL statement for execution. 

 

$stmt->bind_param("iisiiiids", $user_id, ...); 

Binds the parameters to the prepared SQL statement. 

 

$stmt->execute(); 

Executes the prepared SQL statement. 

 

if ($stmt->affected_rows > 0) { 

Checks if the insert operation was successful. If ther  

 

     $_SESSION['booking_confirmation'] = "Booking successful!<br> 

Booking Reference: $booking_reference.<br> 

You have booked: $total_places_booked places for class ID $class_id on $booking_date.<br> 

Total Cost: £$total_cost<br> 

Discount: $discount%";  

Sets the booking confirmation message in the session. <br> is the html tag for line break. It uses the variables within the message to provide the data. 

 

} else { 

If the insert operation was not successful, 

 

$_SESSION['booking_confirmation'] = "Error in booking: " . $conn->error; 

Sets the error message in the session. 

 

$stmt->close(); 

 Closes the prepared statement. 

 

} else { 

If there are not enough spaces left for the booking, 

 

$spaces_left = $max_spaces - $total_booked;:  

Calculates the remaining spaces. 

 

$_SESSION['booking_confirmation'] = "Cannot book: Only $spaces_left spaces left..."; 

:Sets the error message in the session. 

 

} 

Ends the conditional block for checking space availability. 

 

$conn->close(); 

 Closes the database connection. 

 

header('Location: booking.php'); 

Redirects the browser to booking.php (the page where the user enters the booking information, change this to match the name of your booking page) 

 

exit(); 

Ends the script execution. 

 

?>: Closes the PHP code block. 
 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 
