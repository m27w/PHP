
This code takes the basic login script and breaks it up into functions. It also removes the nested if statements as this is seen as bad practice.  

Remember to change the names of columns to match the names used in your table. Also, the input fields used in your form. I have highlighted areas that may need to be changed. 

You will need to read the break down of the code to be able to understand what needs to changed and where. There are tools that can help you do this. You would need to provide the column names in your table, the name of your database and names of the input fields used in the form. Provide it with the code and ask it to change to match the new column names, database name and input fields from the form. 

Database Table Users for Reference 

 

Step 1 – Amended PHP Code 

Remove the previous code and replace with the code below. Remember to make comments on the code. 

 

<?php 
function getDatabaseConnection() { 
    $servername = "localhost"; 
    $username = "root"; 
    $password = "root"; 
    $database = "gymdb"; 
    $port = 8889; // MySQL port in MAMP 
 
    $conn = new mysqli($servername, $username, $password, $database, $port); 
    if ($conn->connect_error) { 
        die("Connection failed: " . $conn->connect_error); 
    } 
 
    return $conn; 
} 
 
function authenticateUser($conn, $username, $password) { 
    $sql = "SELECT user_id, password FROM users WHERE username = ?"; 
    $stmt = $conn->prepare($sql); 
    if (!$stmt) { 
        echo "Prepare failed: " . $conn->error; 
        return false; 
    } 
 
    $stmt->bind_param("s", $username); 
    $stmt->execute(); 
    $result = $stmt->get_result(); 
 
    if ($result->num_rows == 0) { 
        return false; // User not found 
    } 
 
    $row = $result->fetch_assoc(); 
    if (!verifyPassword($password, $row['password'])) { 
        return false; // Password does not match 
    } 
 
    return $row['user_id']; // Return user ID on successful authentication 
} 
 
 
function verifyPassword($password, $hashedPassword) { 
    return password_verify($password, $hashedPassword); 
} 
 
 
function user_check($userId) { 
    if (!$userId) { 
        echo "Invalid username or password<br>"; 
        return; 
    } 
 
    $_SESSION['user_id'] = $userId; 
    header("Location: dashboard.php"); 
    exit(); 
} 
 
 
session_start(); 
// Get the database connection 
$conn = getDatabaseConnection(); 
 
// Handle form submission 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) { 
    $username = $conn->real_escape_string($_POST["username"]); 
    $password = $conn->real_escape_string($_POST["password"]); 
 
    $userId = authenticateUser($conn, $username, $password); 
 
   user_check($userId); 
} 
 
 
$conn->close(); 
 
 
?> 

 

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

$database is assigned the value "gymdb", which is the name of the database but this must change to match the database you intend to connect to. 

$port is set to 8889, specifying the port number on which the MySQL server is listening for connections. This is not the default MySQL port (which is 3306), but it is a common alternative, especially in macOS environments or when using MAMP. 

 

Connection String 

$conn = new mysqli($servername, $username, $password, $database, $port); 

This line creates a new instance of the mysqli class, which opens a new connection to the MySQL server using the provided parameters: server name, username, password, database name, and port number. The connection is assigned to the variable $conn. 

if ($conn->connect_error) { 

This line checks if there's a connection error by accessing the connect_error property of the $conn object. 

die("Connection failed: " . $conn->connect_error); 

If there is a connection error, the die() function is called. This function stops the execution of the script and outputs the error message "Connection failed: " followed by the specific connection error from the $conn object. 

Authentication function 

function authenticateUser($conn, $username, $password) { 

This line defines a new function named authenticateUser which takes three parameters: $conn (database connection object), $username (the username input by the user), and $password (the password input by the user). 

Prepare SQL Query: 

$sql = "SELECT user_id, password FROM users WHERE username = ?"; 

This line creates a SQL query string that selects the user_id and password fields from the users table where the username matches the input. The ? is a placeholder for a parameter that will be bound later to prevent SQL injection. 

Prepare the Statement: 

$stmt = $conn->prepare($sql); 

This line prepares the SQL statement for execution using the prepare() method of the MySQLi object. It returns a statement object ($stmt) which will be used to execute the query. 

Check Statement Preparation: 

 

if (!$stmt) { 

    echo "Prepare failed: " . $conn->error; 

    return false; 

} 

This block checks if the statement preparation was successful. If $stmt is false, it means the preparation failed, so it prints an error message and returns false. 

Bind Parameters: 

$stmt->bind_param("s", $username); 

This line binds the $username variable to the placeholder ? in the SQL statement. The s indicates that the parameter is a string. 

 

Execute the Statement: 

$stmt->execute(); 

This line executes the prepared statement against the database. 

 

Retrieve Result Set: 

$result = $stmt->get_result(); 

After executing the statement, this line gets the result set from the statement execution. 

 

Check for User Existence: 

if ($result->num_rows == 0) { 

    return false; // User not found 

} 

This line checks if any rows were returned in the result set. If no rows were returned (num_rows is 0), it means no user was found with the provided username, so it returns false. 

Fetch User Data: 

$row = $result->fetch_assoc(); 

This line fetches the result as an associative array so that the user data can be accessed by column name. 

Verify Password: 

if (!verifyPassword($password, $row['password'])) { 

    return false; // Password does not match 

} 

Calls the verifyPassword function with the user-provided password and the hashed password retrieved from the database. If verifyPassword returns false, the provided password does not match the stored hash, so authenticateUser returns false. 

Return User ID: 

return $row['user_id']; // Return user ID on successful authentication 

If the password verification succeeds, the function returns the user_id of the authenticated user, indicating successful authentication. 

This function is crucial for the security and functionality of the login process, carefully handling user credentials, executing database operations securely, and ensuring user authenticity. 

 

verifyPassword Function 

Defines a function named verifyPassword which takes two parameters (remember a parameter is the variable used in the function header, the value is the argument): $password and $hashedPassword. 

function verifyPassword($password, $hashedPassword) {: 

The function takes two arguments: $password (the plain text password input by the user) and $hashedPassword (the hashed password stored in the database). 

Verify Password 

function verifyPassword($password, $hashedPassword) { 

 Uses PHP's built-in password_verify function to check if the provided password matches the hashed password. 

Returns true if the password matches the hash, false otherwise. 

    return password_verify($password, $hashedPassword); 

This line calls PHP's built-in password_verify function, which checks if the plain text password matches the hashed password. The result (true or false) of this check is immediately returned by the function. 

Function User_check 

function user_check($userId) {…..} 

Starts the definition of a function named user_check, which takes one parameter, $userId, representing the authenticated user's ID. 

if (!$userId)  

Checks if $userId is false, indicating that the authentication failed or no user ID was retrieved. 

echo "Invalid username or password<br>"; 

 If $userId is false, this line outputs an error message indicating that the username or password is invalid. 

return; 

 Stops the execution of the function if $userId is false. This prevents any further code within the function from running. 

$_SESSION['user_id'] = $userId; 

 If $userId is valid (i.e., not false), the line assigns the user ID to a session variable. This is used for maintaining the user's logged-in state across different pages of the application. 

header("Location: dashboard.php"); 

Sends an HTTP header to the browser to redirect the user to dashboard.php, which is typically the user's dashboard or homepage after logging in. 

exit(); 

Ensures that the script stops executing after the header function call. This is important to prevent the server from executing further code or sending additional output that might interfere with the redirection. 

These functions together provide the functionality to verify a user's password and handle the user's session upon successful authentication. 

Main Logic of the program 

session_start(); 

session_start(): Initializes a new session or resumes an existing session. This function must be called before any output is sent to the browser. It enables the use of session variables to store information that needs to persist across multiple pages, such as user login status. 

$conn = getDatabaseConnection(); 

This line calls the getDatabaseConnection() function (defined elsewhere) that establishes a connection to the database and returns the connection object. The returned object is stored in the variable $conn, which is then used for subsequent database operations. 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) { 

This line checks if the form has been submitted via the POST method. This is a standard way to process form data securely. The isset($_POST['username']) && isset($_POST['password']) part of the condition checks whether the username and password fields are present in the form data. 

    $username = $conn->real_escape_string($_POST["username"]); 

    $password = $conn->real_escape_string($_POST["password"]); 

These lines retrieve the username and password from the submitted form data. The real_escape_string() method is used to escape special characters in the strings to prevent SQL injection, a common security vulnerability. 

Calls the authenticateUser function to check the credentials and returns the user ID if successful, or false if not. 

    $userId = authenticateUser($conn, $username, $password); 

$userId = authenticateUser($conn, $username, $password);: This line calls the authenticateUser() function, passing the database connection object and the sanitized username and password. The function returns the user's ID if the credentials are correct, or false if they are not. 

   user_check($userId); 

This line calls the user_check() function, passing the result of the authentication process. If $userId is valid (i.e., authentication was successful), the function will redirect the user to a new page (typically a dashboard). If $userId is false, it will output an error message indicating invalid credentials. 

In summary, this script segment initiates a session, connects to the database, processes the submitted login form, authenticates the user based on the provided credentials, and either redirects the user upon successful login or displays an error message if the login fails. 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 
