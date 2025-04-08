<?php
require_once 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        echo "يرجى إدخال البريد الإلكتروني.";
        exit;
    }

    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        echo "تم الاشتراك بنجاح في القائمة البريدية!";
    } else {
        echo "حدث خطأ أثناء الاشتراك.";
    }

    $stmt->close();
    $conn->close();
}
?>
