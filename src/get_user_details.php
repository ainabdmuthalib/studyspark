<?php
// Include database connection
include('dbcon.php');

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare SQL query to fetch user details
    $stmt = $conn->prepare("SELECT firstname, lastname, location FROM student WHERE student_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Create a response array
        $response = [
            'status' => 'success',
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'avatar' => 'admin/' . $user['location'], // Assuming location stores the avatar's relative path
        ];

        // Send JSON response
        echo json_encode($response);
    } else {
        // No user found
        echo json_encode([
            'status' => 'error',
            'message' => 'User not found.',
        ]);
    }
} else {
    // No ID provided
    echo json_encode([
        'status' => 'error',
        'message' => 'No user ID provided.',
    ]);
}
?>
