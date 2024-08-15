<?php
$userType = $_SESSION['loged'];
		/*echo '<pre><br>';
		var_dump($_SESSION['loged']);
		echo '</pre>';*/
?>
<html lang="ar" dir="rtl">
<head>
	<base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/x-icon" href="/img/favicon.png">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/formStyle.css">
    <link rel="stylesheet" href="css/print.css" media="print">
    <link rel="stylesheet" href="css/tableStyle.css" media="screen">
    <link rel="stylesheet" href="css/info.css">
    <link rel="stylesheet" href="css/alert.css">
    <script src="js/move.js" defer></script>
    <title><?=$title ?></title>
</head>
<body>
<div class="page-container">
<header style="background-color:white;">
	<div class="nav-bar">
        <div id="left"> 
            <a href="/archive">الارشيف</a>
            <a href="/associations">الجمعيات</a>
            <a href="/institutions">المؤسسات</a>
            <a href="/partnerships">الرئيسية</a>
        </div>
        <div id="right">

            
                    <a href="/logout">
                    تسجيل الخروج
                    </a>
					<?php if($userType === '1'): ?>
                    <a href="/addUser">
                    اضافة حساب
                    </a>
					<?php endif; ?>
        </div>
    </div>
    <div class="logo">
        <img src="img\\logo_men.jpg">
    </div>
	<div class="page-title">
		<h1><?=$page_title ?></h1>
	</div>
	<?php if($page_type !== 'info'): ?>
	<div class="control">
		<div>
			<form action="" method="get">
				<input type="text" name="search">
				<button type="submit">بحث</button>
			</form>
		</div>
		<?php if($page_name !== 'archive'): ?>
			<button data-modal-target="#add" class="add" <?= ($userType !== '1') ? 'disabled' : '' ?>><?=$add_button ?></button>
			<?php if($page_name === 'partnerships'): ?>
				<button onclick="window.print()" class="print">طباعة</button>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</header>
	<main>
		<?=$content ?>
	</main>
	<footer>
	<div id="bloc">
	<div id="sep"></div>
		<div id="links">
			<strong style="font-weight: 800;">روابط مهمة</strong>
			<ul>
				<li><a href="https://www.men.gov.ma/ar/Pages/Accueil.aspx" target="_blank">وزارة التعليم</a>
				<li><a href="https://aref-gon.men.gov.ma/ar/Pages/Accueil.aspx" target="_blank">الأكاديمية الجهوية</a>
				<li><a href="https://dp-guelmim.men.gov.ma/ar/Pages/Accueil.aspx" target="_blank">المديرية الاقليمية</a>
			</ul>
		</div>
		
		<div id="sep"></div>
		
		<div id="contact">
			<strong style="font-weight: 800;">للتواصل</strong>
			<ul>
				<li>douihzakaria@gmail.com
			</ul>
		</div>
	</div>
	
		<img src="/img/footer-logo.png" style="width:100px; height:100px;margin-left: 500px;">
		
	</footer>
</div>
</body>
</html>