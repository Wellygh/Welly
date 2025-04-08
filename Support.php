<?php
require_once 'config.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);

// تتبع البيانات المرسلة
file_put_contents('debug_log.txt', print_r($_POST, true));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($phone) || empty($email) || empty($message)) {
        echo "يرجى تعبئة جميع الحقول المطلوبة (الاسم، الهاتف، البريد، الرسالة).";
        return;
    }

    $stmt = $conn->prepare("INSERT INTO support_requests (name, phone, email, message) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        echo "خطأ في التحضير: " . $conn->error;
        return;
    }

    $stmt->bind_param("ssss", $name, $phone, $email, $message);

    if ($stmt->execute()) {
        echo "تم الإرسال بنجاح.";
    } else {
        echo "فشل في تنفيذ الإدخال: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>