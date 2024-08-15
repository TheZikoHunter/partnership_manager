
<?php 
 
$title = 'معلومات عن الشراكة';
$page_title = 'معلومات عن الشراكة';
$page_name = 'part';
$page_type = 'info';
    require_once ABSOLUTE_PATH . '/classes/Action.php';
        $a = new Action();
        $ac = $a -> selectWHERE($_POST['journal']);
        $statement = $ac -> executeSelect();

        $actions = $statement->fetchAll(PDO::FETCH_ASSOC);
        $single_partnership = new Partnership();
        $info = $single_partnership -> select() -> whereId(explode('_', $_POST['journal'])[0] . '_' . explode('_', $_POST['journal'])[1] . '_' . explode('_', $_POST['journal'])[2]) -> executeSelect() -> fetch(PDO::FETCH_ASSOC);

?>
<div class="container">
    <div class="info-page">
        <h1>الشراكة بين مؤسسة <strong><?=$info['_OPEN_NOEDIT_FORinstitution_name']?></strong> و<strong><?=$info['_OPEN_NOEDIT_FORassociation_name']?></strong></h1>
        <h2>وُقعت يوم: <?=$info['_OPEN_DATEsigning']?></h2>
        <div class="line"></div>
        <h2>موضوع الشراكة: </h2>
        <p>
        <?=$info['_OPEN_TEXTsubject'] ?>
        </p>
        <div class="line"></div>
        <h2>على الصعيد ال<?=$info['_OPEN_NOEDIT_FORscale']?></h2>
        <div class="line"></div>
        <h2>مدة الإنجاز: <?=$info['_OPEN_NUMperiod']?> سنوات <?= ($info['_OPEN_BOOLrenewable'] == 1) ? 'قابلة' : 'غير قابلة' ?> للتجديد</h2>
        <div class="line"></div>
        <h2>الحالة : <?= ($info['_OPEN_BOOL_NOINSERTactive'] == 1) ? 'مفعلة' : 'غير مفعلة' ?>   </h2>
        <div class="line"></div>
        <h2>التكلفة بالدرهم المغربية : <?=$info['_OPEN_CURRENCYcost'] ?>   </h2>
        <?php if(!empty($actions)): ?>
        <table class="part journal">
		<thead>
		<tr class="part journal">
                <th class="part journal">
                    العملية
                </th>
                <th class="part journal">
                    التاريخ
                </th>
            </tr>
		</thead>
            
            <?php foreach($actions as $action): ?>
            <tr class="part journal">
                <td class="part journal">
                    <strong><p class="name">
                        <?=$action['_OPENname'] ?>
                    </p></strong>
                </td>
                <td class="part journal">
                    <p class="name"><?php
                    $time = strtotime($action['_OPENdate']);
                    echo ' يوم  ' . '<strong style="color:blueviolet; border:1px solid white; background:wheat;">' . date('j/m/Y', $time) . '</strong>' . ' على الساعة  ' . '<strong style="color:blueviolet; border:1px solid white; background:wheat;">' . date('H:i', $time) . '</strong>' ?></p>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <h1>لا عمليات بعد</h1>
        <?php endif; ?>
    </div>
</div>
