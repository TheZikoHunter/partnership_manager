<html lang="ar" dir="rtl">
<head>
	<base href="/">
	<title>Register</title>
	<link rel="icon" type="image/x-icon" href="/img/favicon.png">
	<link rel="stylesheet" href="css/in.css">
</head>
<?php
require_once ABSOLUTE_PATH . '/classes/User.php';
try{
    $_USER = new User();
}catch(Throwable $t){
    echo "problem in register.php to user.php";
}
try{
	if(isset($_POST['admin-email']) && isset($_POST['admin-username']) && isset($_POST['admin-password'])){
    $_USER -> insertAdmin($_POST['admin-email'], $_POST['admin-username'], $_POST['admin-password']);
}
if(isset($_POST['username']) && isset($_POST['password'])){
    $_USER -> insertUser($_POST['username'], $_POST['password']);
}
if(isset($_POST['log-username']) && isset($_POST['log-password'])){
    $_USER -> logUser($_POST['log-username'],  $_POST['log-password']);
}
}catch(Throwable $t){
	echo 'problem in the post' . $t;
}

try{
    $users = $_USER -> listUsers();
}catch(Throwable $t){
    echo "problem in register.php";
}

?>
<body id="register">
    <!-- Case for log in-->
	<header>
<img src="/img/logo_men.jpg">
</header>
<main>
<?php if(isset($_SESSION['loged']) && $_SESSION['loged'] === '1'): ?>
<form action="" id="signin" method="POST">
    <a href="/" id="back-home">الرئيسية</a>
    <table id="signin-area">
        <tr>
            <td colspan="2">
                تسجيل حساب جديد
            </td>
        </tr>
        <tr>
            <td>
                اسم المستخدم
            </td>
            <td>
                <input type="text" placeholder="pseudo" name="username" required>
            </td>
        </tr>
        <tr>
            <td>
                كلمة السر
            </td>
            <td id="password-area">
                <input type="password" placeholder="******" name="password" id="password" required>
            </td>
        </tr>
        <tr>
            <td>
            <label for="password-reveal">اظهر كلمة السر</label>

            </td>
            <td>
            <input type="checkbox" id="password-reveal">

            </td>
        </tr>
    </table>
    <button type="submit" name="signed-user" value="true">
        تسجيل
    </button>
</form>
<?php else: ?>
	<?php if(empty($users)): ?>
    <form action="" id="signin" method="POST">
    <table id="signin-area">
        <tr>
            <td colspan="2">
                تسجيل حساب
            </td>
        </tr>
        <tr>
            <td>
                ايميل
            </td>
            <td>
                <input type="email" placeholder="exemple@domaine.exp" name="admin-email" required>
            </td>
        </tr>
        <tr>
            <td>
                اسم المستخدم
            </td>
            <td>
                <input type="text" placeholder="pseudo" name="admin-username" required>
            </td>
        </tr>
        <tr>
            <td>
                كلمة السر
            </td>
            <td id="password-area">
                <input type="password" placeholder="******" name="admin-password" id="password" required>
            </td>
        </tr>
        <tr>
            <td>
            <label for="password-reveal">اظهر كلمة السر</label>

            </td>
            <td>
            <input type="checkbox" id="password-reveal">

            </td>
        </tr>
    </table>
    <button type="submit" name="signed-admin" value="true">
        تسجيل
    </button>
</form>
	<?php else: ?>
    <form action="" id="login" method="POST">
    <table id="login-area">
        <tr>
            <td colspan="2">
                تسجيل الدخول
            </td>
        </tr>
        <tr>
            <td>
                اسم المستخدم
            </td>
            <td>
                <input type="text" name="log-username" placeholder="اسم المستخدم" required>
            </td>
        </tr>
        <tr>
            <td>
                كلمة السر
            </td>
            <td>
                <input type="password" name="log-password" placeholder="كلمة السر" required>
            </td>
        </tr>
    </table>
    <button type="submit" name="login" value="signed-in">
        دخول
    </button>
</form>
<?php endif; ?>
<?php endif; ?>
</main>
</body>
