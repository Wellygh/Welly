<?php
require_once 'config.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        echo "يرجى تعبئة جميع الحقول.";
        return;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        echo "تم تسجيل الدخول بنجاح.";
    } else {
        echo "بيانات الدخول غير صحيحة.";
    }

    $stmt->close();
    $conn->close();
}
?>