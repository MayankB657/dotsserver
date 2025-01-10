<?php
// List of allowed domains
$allowedDomains = array("https://example.com", "https://subdomain.example.com");

// Get the referring domain
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

// Check if the referring domain is allowed
if (in_array($referer, $allowedDomains)) {
    // Allow access to the file
    header("Access-Control-Allow-Origin: $referer");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    // Set the content type to JSON
    header("Content-Type: application/json");

    // Your PHP code here
    echo json_encode(array("message" => "Access granted."));
} else {
    // Deny access
    http_response_code(403);
    echo json_encode(array("message" => "Access forbidden."));
}

// Connect to the database
function connect() {
    $connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (mysqli_connect_errno($connect)) {
        die("Failed to connect:" . mysqli_connect_error());
    }

    return $connect;
}

$conn = connect();

// Handle the incoming request
$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        // Retrieve users
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            get_user($id);
        } else {
            get_users();
        }
        break;
    case 'POST':
        // Insert a new user
        insert_user();
        break;
    case 'PUT':
        // Update an existing user
        $id = intval($_GET["id"]);
        update_user($id);
        break;
    case 'DELETE':
        // Delete a user
        $id = intval($_GET["id"]);
        delete_user($id);
        break;
    default:
        // Invalid request method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_users() {
    global $conn;
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);
    $users = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    echo json_encode($users);
}

function get_user($id) {
    global $conn;
    $query = "SELECT * FROM users WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        echo json_encode($user);
    } else {
        echo json_encode(array("message" => "User not found."));
    }
}

function insert_user() {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    $name = $data["name"];
    $email = $data["email"];
    $password = password_hash($data["password"], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if (mysqli_query($conn, $query)) {
        echo json_encode(array("message" => "User added successfully."));
    } else {
        echo json_encode(array("message" => "Failed to add user."));
    }
}

function update_user($id) {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    $name = $data["name"];
    $email = $data["email"];
    $password = password_hash($data["password"], PASSWORD_DEFAULT);

    $query = "UPDATE users SET name = '$name', email = '$email', password = '$password' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo json_encode(array("message" => "User updated successfully."));
    } else {
        echo json_encode(array("message" => "Failed to update user."));
    }
}

function delete_user($id) {
    global $conn;
    $query = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo json_encode(array("message" => "User deleted successfully."));
    } else {
        echo json_encode(array("message" => "Failed to delete user."));
    }
}
?>
