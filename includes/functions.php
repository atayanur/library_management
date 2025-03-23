<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

function login($username, $password) {
    global $conn;
    $sql = "SELECT * FROM pustakawan WHERE username = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['id_pustakawan'] = $row['id_pustakawan'];
                $_SESSION['username'] = $row['username'];
                return true;
            }
        }
    }
    return false;
}

function logout() {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
