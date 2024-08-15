<?php
$title = 'ارشيف الشراكات';
$page_title = 'ارشيف الشراكات';
$page_name = 'archive';
$page_type = 'index';
if(!isset($_GET['page'])){
    $_GET['page'] = 1;
}
        require_once ABSOLUTE_PATH . '/classes/Partnership.php';
        require_once ABSOLUTE_PATH . '/classes/Form.php';
        require_once ABSOLUTE_PATH . '/classes/Association.php';
        require_once ABSOLUTE_PATH . '/classes/Institution.php';
        require_once ABSOLUTE_PATH . '/classes/Scale.php';
        require_once ABSOLUTE_PATH . '/classes/Table.php';
        $TABLE = new Table();
        $FORM = new Form();
        $show = new Partnership();
        $_part = new Institution();
        $_scale = new Scale();
        $_association = new Association();

        $heads = $show -> heads;
        $open = array();
        $_open = array();

        $page = $_GET['page'];
        ?>
<?php
        if(isset($_POST['restore']))
        {
            require_once(ABSOLUTE_PATH . '/classes/Action.php');
            $action = new Action();
            $now = new DateTimeImmutable('now', new DateTimeZone('WEST'));
            $show -> restore($_POST['restore']);
            
        }
        if(isset($_POST['delete']))
        {
            $show -> delete($_POST['delete']);
            unset($_POST['delete']);
        }
        

        $rank_offset = 1 + ($page - 1 ) * 10;
        $lines = $show -> selectArchived();

        if(isset($_GET['search']))
        {
            $lines = $lines -> nameLike(htmlentities($_GET['search']));
            $_SESSION['search'] = htmlentities($_GET['search']);
        }
        if(isset($_GET['order'])){
            $lines = $lines -> orderByCost($_GET['order']);
        }

        $stmt = $lines -> executeSelect(strval($rank_offset - 1));
        $lines = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt -> closeCursor();?>
        <?php if(empty($lines)): ?>
            <div class="none-page">
                <h1>لا شراكات في الارشيف حالياََ</h1>
            </div>
            
            
        <?php else: ?>
        <table class="part">
		<thead>
		<tr class="part"><th class="part rank"><strong>ر.ت</strong></th>

        <?php foreach($heads as $head): ?>
	    <th class="part"><strong>
		<?php
			if($head==='التكلفة'){
				 $uri_search = (isset($_SESSION['search'])) ? ('&search=' . $_SESSION['search']) : '';
							echo '<a href="?order=DESC'. $uri_search . '"><img id="first-arrow" src="img/arrow.png"></a>';
							echo '<a href="?order=ASC'. $uri_search . '"><img id="second-arrow" src="img/arrow.png"></a>';

			}
			echo $head
		?>

</strong></th>
        <?php endforeach; ?>

        <th class="part op archive"><strong>عمليات</strong></th></tr>
		</thead>
		

        <?php foreach($lines as $entity): ?>
            <tr class="part">
                <td class="part"><?=$rank_offset++ ?></td>
                <?php
                foreach($entity as $name => $value): 
                    if(!(str_contains($name, '_ID'))): ?>
                        <td class="part"><?php $TABLE -> showLine($name, $value) ?></td>
                    <?php endif; ?>
                <?php endforeach; 
        ?>

            <td class="part op archive">


                    <form action="" method="POST" class="archive">
                    <button type="submit" name="restore" value="<?=$entity['_ID']?>" <?= ($_SESSION['loged'] !== '1') ? 'disabled' : '' ?>>اعادة</button>
                    </form>

                    <form action="" method="POST" class="archive">
                    <button type="submit" name="delete" value="<?=$entity['_ID']?>" <?= ($_SESSION['loged'] !== '1') ? 'disabled' : '' ?>>حذف</button>
                    </form>
            </td></tr>
        <?php endforeach; ?>
        </table>

        
         <div class="pagination">
            <ul class="pagination">
                <?php
				
                $total = $show -> count();
                if($total - 10 * ($page - 1) - count($lines) > 0 && $total > 10): 
                
                ?>
                    <li><form method="GET"><button type="submit" name="page" value="<?=$page + 1?>" class="next">التالى</button></form></li>
                    <li><p><?=$page?></p></li>
                <?php endif; ?>

                

                <?php if($page > 1): ?>
                    <li><form method="GET"><button type="submit" name="page" value="<?=$page - 1?>" class="previous">السابق</button></form></li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>
