<?php 
    $title = 'معلومات عن المؤسسة';
    $page_title = 'معلومات عن المؤسسة';
	$page_type = 'info';
	$page_name = 'institution';
    require_once ABSOLUTE_PATH . '/classes/Institution.php';

    $a = new Institution();

    $institution = $a -> select() -> whereId($_POST['info']) -> executeSelect() -> fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="info-page">
    <h1 class="name"><?=$institution['_OPEN_NAME'] ?></h1>
        <h2>برئاسة: <?=$institution['_OPEN_REGULARresponsable'] ?></h2>
        <div class="line"></div>
        <h2>بمدينة: <?=$institution['_OPEN_REGULARcity'] ?></h2>
        <div class="line"></div>
        <h2>عنوان: <?=$institution['_OPEN_TEXTadresse'] ?></h2>
        <div class="line"></div>
        <h2>هاتف: <?=$institution['_OPEN_TELtel'] ?></h2>
        <div class="line"></div>
        <h2>فاكس: <?=$institution['_OPEN_TELfax'] ?></h2>
        <div class="line"></div>
        <h2>ايميل: <?=$institution['_OPEN_EMAIL'] ?></h2>
        <div class="line"></div>
        <h2>الموقع الالكتروني: <?=$institution['_OPEN_URLsite'] ?></h2>
    </div>
</div>
