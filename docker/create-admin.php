<?php

if (PHP_SAPI !== 'cli') {
    exit(1);
}

require '/var/www/html/classes/admin_class.php';

[$script, $username, $fullname, $email] = array_pad($argv, 4, null);
if (!$username || !$fullname || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fwrite(STDERR, "Usage: php create-admin.php USERNAME FULL_NAME EMAIL\n");
    exit(1);
}

$password = bin2hex(random_bytes(12));
$db = (new Admin_Class())->db;
$stmt = $db->prepare(
    'INSERT INTO tbl_admin (fullname, username, email, password, user_role)
     VALUES (?, ?, ?, ?, 1) ON CONFLICT DO NOTHING'
);
$stmt->execute([$fullname, $username, $email, md5($password)]);
if ($stmt->rowCount() !== 1) {
    fwrite(STDERR, "The username or email already exists. No account changed.\n");
    exit(1);
}

echo "Username: $username\nPassword: $password\n";
