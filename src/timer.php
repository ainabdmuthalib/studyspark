<div id="user-time">
    <span id="total-time">00:00:00</span><br>
    <span class="live-indicator"><span class="live-dot"></span> Online</span>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let totalSeconds = 0; // Total time in seconds
let timerIntervalId = null;

function fetchUserTimeToday() {
    const today = new Date().toISOString().slice(0, 10);
    $.ajax({
        url: 'get_user_time.php?date=' + encodeURIComponent(today),
        type: 'GET',
        success: function(response) {
            try {
                const data = JSON.parse(response);
                if (data.status === 'error' && data.message === 'No active session found') {
                    // Stop timer and redirect to login page
                    stopTimer();
                    window.location.href = 'index.php';
                    return;
                }
                if (data.status === 'success') {
                    // Parse the "HH:MM:SS" format and convert to total seconds
                    const [hours, minutes, seconds] = data.total_time.split(':').map(Number);
                    totalSeconds = hours * 3600 + minutes * 60 + seconds;
                    updateTimerDisplay();
                } else {
                    console.error(data.message);
                }
            } catch (err) {
                console.error('Error parsing response:', err);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}

function updateTimerDisplay() {
    const hours = Math.floor(totalSeconds / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    const seconds = totalSeconds % 60;
    // Update the DOM with the formatted time
    $('#total-time').text(
        `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`
    );
}

// Increment timer locally every second
function startTimer() {
    timerIntervalId = setInterval(() => {
        totalSeconds++;
        updateTimerDisplay();
    }, 1000);
}

function stopTimer() {
    if (timerIntervalId !== null) {
        clearInterval(timerIntervalId);
        timerIntervalId = null;
    }
}

startTimer();

// Fetch updated time from server every 10 seconds
setInterval(fetchUserTimeToday, 10000);

// Fetch time immediately on page load
fetchUserTimeToday();
</script>
<style>
    #user-time {
    font-family: 'Arial', sans-serif;  /* Clean and modern font */
    background-color: #e0f7fa;         /* Light cyan background */
    border: 2px solid #00796b;         /* Teal border */
    border-radius: 15px;               /* Rounded corners */
    padding: 20px;                     /* Padding around the text */
    text-align: center;                /* Center the text */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
    margin: 20px auto;                 /* Center the timer on the page */
    max-width: 300px;                  /* Maximum width for the timer */
}

#total-time {
    font-size: 2.5em;                  /* Larger font size for the timer */
    color: #00796b;                    /* Teal color for the timer text */
    font-weight: bold;                 /* Bold text for emphasis */
    letter-spacing: 2px;               /* Spacing between characters */
}

.live-indicator {
    color: #43a047;
    font-weight: bold;
    margin-left: 10px;
    font-size: 1em;
    vertical-align: middle;
}
.live-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    background: #43a047;
    border-radius: 50%;
    margin-right: 5px;
    animation: blink 1s infinite;
    vertical-align: middle;
}
@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.2; }
}
</style>