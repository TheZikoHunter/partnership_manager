<?php 
$title = 'معلومات عن الجمعية';
$page_title = 'معلومات عن الجمعية';
$page_type = 'info';
$page_name = 'association';
    require_once ABSOLUTE_PATH . '/classes/Association.php';

    $a = new Association();

    $association = $a -> select() -> whereId($_POST['info']) -> executeSelect() -> fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="info-page">
        
        <h1 class="name"><?=$association['_OPEN_NAME'] ?></h1>
        <h2>برئاسة: <?=$association['_OPEN_REGULARresponsable'] ?></h2>
        <div class="line"></div>
        <h2>بمدينة: <?=$association['_OPEN_REGULARcity'] ?></h2>
        <div class="line"></div>
        <h2>عنوان: <?=$association['_OPEN_TEXTadresse'] ?></h2>
        <div class="line"></div>
        <h2>هاتف: <?=$association['_OPEN_TELtel'] ?></h2>
        <div class="line"></div>
        <h2>فاكس: <?=$association['_OPEN_TELfax'] ?></h2>
        <div class="line"></div>
        <h2>ايميل: <?=$association['_OPEN_EMAIL'] ?></h2>
        <div class="line"></div>
        <h2>الموقع الالكتروني: <?=$association['_OPEN_URLsite'] ?></h2>
    </div>
</div>
