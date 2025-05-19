<?php
session_start();
include 'database/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password)) {
        // Hash password sebelum disimpan
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, 'user')");
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location.href='login2.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Semua kolom harus diisi.');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - BookView</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(28, 79, 45);
            color: whitesmoke;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .signup-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box: 0px 5px 15px rgba(0, 0, 0, 0.3);
            width: 400px;
            color: crimson;
        }
        .signup-container h2 {
            color: brown;
            margin-bottom: 20px;
            text-align: center;
            

        }
        .btn-signup {
            background:rgb(81, 121, 91);
            color: white;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            transition: 0.3s;
            font-weight: bold;
        }
        .btn-signup:hover {
            background:rgb(56, 217, 86);
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="POST">
            <div class="mb-3">
                <label class="form-label">first name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">last name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn-signup">Daftar</button>
        </form>
        <p class="mt-3">Sudah punya akun? <a href="login2.php">Login di sini</a></p>
    </div>
</body>
</html>