<?php

session_start();

// 1. Connect to local MySQL database (shared config, see database.php)
include "includes/database.php";

// 2. Process data when a form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // CASE A: USER SIGN UP (REGISTRATION)
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        //  Insert into table
        $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Registration successful! Your account is saved.');
                    window.location.href = 'auth.html';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Registration failed. Please try again.');
                    window.location.href = 'auth.html';
                  </script>";
        }
    }

    // CASE B: USER LOGIN
    else if (isset($_POST['action']) && $_POST['action'] === 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // ⚠️ Queries your exact table name: user
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && password_verify($password, $row['password'])) {
            // MATCH FOUND! Save session data
            $_SESSION['username'] = $username;

            echo "<script>
                    alert('Login successful! Welcome back, " . $username . ".(ログインに成功せいこうしました！)');
                    window.location.href = 'index.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Login failed! Incorrect username or password. (ログインに失敗しました。ユーザー名またはパスワードが間違っています。)');
                    window.location.href = 'auth.html';
                  </script>";
            exit();
        }
    }
}
$conn->close();