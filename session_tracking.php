<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// check if the user is logged in
if (isset($_SESSION['username']) || isset($_SESSION['dname']) || isset($_SESSION['pid'])) {
    echo "<script>console.log('Session Active');</script>";

    // check if session expiration variables are set
    if (isset($_SESSION['start_time']) && isset($_SESSION['end_time'])) {
        $end_time = $_SESSION['end_time'];
        $current_time = time();
        $time_left = $end_time - $current_time;

        echo "<script>
            console.log('Session End Time: {$end_time}');
            console.log('Current Time: {$current_time}');
            console.log('Time Left: {$time_left}');
            
            // Set up a timer to check session expiration
            setTimeout(() => {
                alert('Your session has expired. Please log in again.');
                console.log('Session Expired');
                window.location.href = 'index1.php';
            }, {$time_left} * 1000); // Convert seconds to milliseconds
        </script>";
    } else {
        echo "<script>console.log('Session Time Variables Not Set');</script>";
    }
} else {
    // redirect to login page if the session is not active
    echo "<script>console.log('Session Not Active');</script>";
    header("Location: index1.php");
    exit();
}
?>

