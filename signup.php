<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        echo "يرجى تعبئة جميع الحقول.";
        exit;
    }

    // التحقق من وجود البريد الإلكتروني مسبقاً
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        echo "البريد الإلكتروني مستخدم بالفعل.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "تم التسجيل بنجاح!";
        } else {
            echo "حدث خطأ أثناء إدخال البيانات.";
        }

        $stmt->close();
    }

    $check->close();
    $conn->close();
}
?>
