<?php
// Database credentials
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'studyspark';

// Firebase credentials (replace with your Firebase credentials file path)
require_once 'vendor/autoload.php';

// Create MySQL connection
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Firebase setup
use Kreait\Firebase\Factory;

$factory = (new Factory)->withServiceAccount('serviceAccountKey.json');
$firebase = $factory->createDatabase();

$firebase_url = 'https://study-spark-8e3b3-default-rtdb.asia-southeast1.firebasedatabase.app/';
$firebase_path = '/activity_tracking';

// Function to log user activity in both MySQL and Firebase
function logActivity($user_id, $time_spent, $date) {
    global $conn, $firebase, $firebase_path;

    // Store in MySQL
    $stmt = $conn->prepare("INSERT INTO activity_tracking (user_id, activity_date, time_spent) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $date, $time_spent);
    $stmt->execute();

    // Store in Firebase
    $firebase_data = [
        'activity_date' => $date,
        'time_spent' => $time_spent
    ];

    // Push data to Firebase
    $firebase->getReference($firebase_path . '/' . $user_id)
             ->push($firebase_data);
}

// Function to get total time spent by user from Firebase
function getTotalTimeSpent($user_id) {
    global $firebase, $firebase_path;

    // Get user activity data from Firebase
    $data = $firebase->getReference($firebase_path . '/' . $user_id)->getValue();

    // Calculate total time spent
    $total_time_spent = 0;
    foreach ($data as $entry) {
        $total_time_spent += $entry['time_spent'];
    }

    return $total_time_spent;
}

// Function to display activity logging form and user stats
function displayActivityForm() {
    ?>
    <form method="POST" action="">
        <label for="user_id">User ID:</label><br>
        <input type="text" id="user_id" name="user_id" required><br><br>

        <label for="time_spent">Time Spent (in minutes):</label><br>
        <input type="number" id="time_spent" name="time_spent" required><br><br>

        <label for="activity_date">Activity Date:</label><br>
        <input type="date" id="activity_date" name="activity_date" required><br><br>

        <input type="submit" name="submit_activity" value="Log Activity">
    </form>
    <?php
}

// Handle form submission for activity logging
if (isset($_POST['submit_activity'])) {
    $user_id = $_POST['user_id'];
    $time_spent = $_POST['time_spent'];
    $activity_date = $_POST['activity_date'];

    // Log the activity
    logActivity($user_id, $time_spent, $activity_date);
    echo "Activity logged successfully!<br>";

    // Display total time spent by user
    $total_time = getTotalTimeSpent($user_id);
    echo "Total time spent by user $user_id: $total_time minutes.<br>";
} else {
    displayActivityForm();
}

?>

<!-- Footer -->
<hr>
<p>Activity Tracking System</p>
