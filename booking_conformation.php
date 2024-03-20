Starting Point: Script 1
Script 1 establishes a database connection, processes a booking form submission, and displays a simple success message. It lacks detailed feedback about the booking and does not redirect the user after processing the form.

Objective: Transform Script 1 the Original into Version 2
Version 2 aims to: 
•	Fetch and display detailed class information upon successful booking.
•	Store a detailed confirmation message in the session.
•	Redirect the user back to the booking page for a seamless user experience.
•	Step-by-Step Transformation
•	Fetch Class Details Upon Success

After successfully inserting the booking into the database, version 2 will fetch additional details about the booked class (e.g., class name and time) to provide more informative feedback to the user. At the moment script 1 merely confirms the booking ID.
Version 2 will achieve this by executing a secondary SQL query to retrieve the class name and time from the gym_classes table using the class_id.
Store Confirmation Message in Session

Instead of immediately echoing the success message, version 2 stores a detailed confirmation message within a session variable. This approach allows the message to persist across page reloads or redirects, enhancing the application's flow and user experience.
 
Version 2 
The amended script will redirect back to the booking page, this will allow the processing of the form submission and setting the session variable. This redirect helps in preventing form resubmission issues and ensures that the user sees the confirmation message stored in the session.

ADD TO BOOKING.PHP IF YOU ARE USING THAT SCRIPT

    if ($stmt->affected_rows > 0) {
        // If booking is successful, display a message with booking details.
        echo "Booking successful! Booking ID: " . $conn->insert_id;
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close(); // Close the statement.
}

Amend the code 
Using the code below, amend the code so you add in the new instructions and queries. Remember to read the break down below to explain what each line is doing.

if ($stmt->affected_rows > 0) {
        // If booking is successful, display a message with booking details.
        echo "Booking successful! Booking ID: " . $conn->insert_id;
        $bookingId = $conn->insert_id;
        // Fetch class details using the class_id
        $classQuery = "SELECT class_name, class_time FROM gym_classes WHERE class_id = ?";
        $classStmt = $conn->prepare($classQuery);
        $classStmt->bind_param("i", $class_id);
        $classStmt->execute();
        $classResult = $classStmt->get_result();

        if ($classResult->num_rows > 0) {
            $classRow = $classResult->fetch_assoc();
            $className = $classRow['class_name'];
            $classTime = $classRow['class_time'];

            // Store detailed confirmation message in session
            $_SESSION['booking_confirmation'] = "Booking successful! Booking ID: $bookingId. You have successfully booked '$className' on $classTime.";
        } else {
            $_SESSION['booking_confirmation'] = "Booking successful, but class details could not be retrieved.";
        }

        $classStmt->close();
    } else {
        $_SESSION['booking_confirmation'] = "Error: " . $conn->error;
    }

    Reminder of -> Operator

When you create an object (a copy with a new name, think of copying a word document) from a class, you can access its properties (variables) and methods (functions) using the -> operator. Here's how it works:
// Define a class
class MyClass {
    public $property = 'value'; // Property

    public function myMethod() { // Method
        return 'Hello, world!';
    }
}

// Create an instance of the class
$obj = new MyClass();

// Accessing property using -> operator
echo $obj->property; // Outputs: value

// Calling method using -> operator
echo $obj->myMethod(); // Outputs: Hello, world!
In the example above:

$obj->property accesses the property property of the object $obj.
$obj->myMethod() calls the method myMethod() of the object $obj.
So, essentially, -> is used to navigate through an object's structure to access its properties and methods.

Break down of code line by line
if ($stmt->affected_rows > 0) {
This line checks if the previous database operation (represented by $stmt) affected any rows. If it did (i.e., if rows were inserted, updated, or deleted successfully), the code inside the block {} will be executed.
$stmt: This variable holds an instance of a MySQLi prepared statement object, which was created earlier in the script to execute a database query.
->: This is the object operator in PHP, used to access properties and methods of a the $stmt.
affected_rows: This is a property (attribute/characteristic) of the MySQLi prepared statement object $stmt. It indicates the number of rows affected by the most recent query operation, such as INSERT, UPDATE, DELETE, etc.
> 0: This condition checks if the number of affected rows is greater than zero. If it is, it means that the query was successful and affected at least one row in the database.
echo "Booking successful! Booking ID: " . $conn->insert_id;
If the booking was successful, this line prints a message indicating the success along with the booking ID retrieved from the database connection ($conn->insert_id).

$bookingId = $conn->insert_id;
It assigns the booking ID to a variable $bookingId for further use. $conn is an object and insert_id is a property of the object that is being exceuted

$classQuery = "SELECT class_name, class_time FROM gym_classes WHERE class_id = ?";
This line constructs a SQL query to select the class name and class time from the gym_classes table based on a given class ID.

$classStmt = $conn->prepare($classQuery);
It prepares the SQL query for execution.

$classStmt->bind_param("i", $class_id);
This line binds a parameter to the SQL query. It specifies that the parameter ($class_id) will be an integer ("i").

$classStmt->execute();
This line executes the prepared SQL query.

$classResult = $classStmt->get_result();
It retrieves the result set generated by the executed SQL query.

if ($classResult->num_rows > 0) {
This line checks if there are any rows returned by the SQL query.

$classRow = $classResult->fetch_assoc();
$className = $classRow['class_name'];
$classTime = $classRow['class_time'];
If there are rows returned, The first line fetches the affected lines and stores them into the variable $classrow. Then the following two lines use $classrow to retrieve the class name and class time for that row from the fetched result set and store them in variables $className and $classTime, respectively.

$_SESSION['booking_confirmation'] = "Booking successful! Booking ID: $bookingId. You have successfully booked '$className' on $classTime.";
This line constructs a confirmation message containing the booking ID, class name, and class time, and stores it in a session variable $_SESSION['booking_confirmation'] to be displayed to the user later.

$_SESSION['booking_confirmation'] = "Booking successful, but class details could not be retrieved.";
If there are no rows returned by the SQL query, this line sets a message indicating that although the booking was successful, the details of the class could not be retrieved.

$classStmt->close();
This line closes the prepared statement to free up resources.

} else {
This line signifies the beginning of the else block, which is executed if the condition in the if statement (line 1) evaluates to false.

$_SESSION['booking_confirmation'] = "Error: " . $conn->error;
If there was an error during the database operation, this line stores an error message containing the error description obtained from $conn->error in the session variable 
$_SESSION['booking_confirmation'].

