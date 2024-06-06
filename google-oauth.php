<?php
// Initialize the session
session_start();
include 'config.php';


// Update the following variables
$google_oauth_client_id = '166228259741-dc63c3kole60brqa0t500h9vqj2khpi3.apps.googleusercontent.com';
$google_oauth_client_secret = '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';
$google_oauth_redirect_uri = 'http://localhost/summittrack/google-oauth.php';
$google_oauth_version = 'v3';
// If the captured code param exists and is valid
if (isset($_GET['code']) && !empty($_GET['code'])) {
    // Execute cURL request to retrieve the access token
    $params = [
        'code' => $_GET['code'],
        'client_id' => $google_oauth_client_id,
        'client_secret' => $google_oauth_client_secret,
        'redirect_uri' => $google_oauth_redirect_uri,
        'grant_type' => 'authorization_code'
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);

    // Make sure access token is valid
    if (isset($response['access_token']) && !empty($response['access_token'])) {
        // Execute cURL request to retrieve the user info associated with the Google account
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/' . $google_oauth_version . '/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
        $response = curl_exec($ch);
        curl_close($ch);

        $profile = json_decode($response, true);

        if (isset($profile['email'])) {
            
            // Authenticate the user
            session_regenerate_id();
            $_SESSION['google_loggedin'] = TRUE;
            $_SESSION['user_email'] = $profile['email']; // Use consistent session variable name
            $_SESSION['fullname'] = $profile['name']; // Store user's full name in session variable
            

            if (isset($profile['picture'])){
                $_SESSION['google_picture'] = $profile['picture'];
            }


            // Check if the user's email is already in the database
            $sql = "SELECT id FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $profile['email']);
            $stmt->execute();
            $result = $stmt->get_result();
        
         
            if ($result->num_rows > 0) {
                // User exists, fetch userID
                $row = $result->fetch_assoc();
                $_SESSION['user_id'] = $row['id'];
            } else {
                // User does not exist, create new user and fetch userID
                $sql = "INSERT INTO users (name, email) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $profile['name'], $profile['email']);
                $stmt->execute();
                $_SESSION['user_id'] = $conn->insert_id;
            }

            // Close the statement
            $stmt->close();


            // Redirect to the welcome page
            header('Location: home.php');
            exit;
        } else {
            exit('Could not retrieve profile information! Please try again later!');
        }
    }else {
        exit('Invalid access token! Please try again later!');
    }

} else{
    // Define params and redirect to Google Authentication page
    $params = [
        'response_type' => 'code',
        'client_id' => $google_oauth_client_id,
        'redirect_uri' => $google_oauth_redirect_uri,
        'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
        'access_type' => 'offline',
        'prompt' => 'consent'
    ];
    header('Location: https://accounts.google.com/o/oauth2/auth?' . http_build_query($params));
    exit;
}
?>