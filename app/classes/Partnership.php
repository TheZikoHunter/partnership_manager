<?php
require_once ABSOLUTE_PATH . '/classes/Database.php';
require_once ABSOLUTE_PATH . '/classes/Table.php';
require_once ABSOLUTE_PATH . '/classes/Action.php';
require_once ABSOLUTE_PATH . '/classes/Association.php';
require_once ABSOLUTE_PATH . '/classes/Institution.php';
require_once ABSOLUTE_PATH . '/classes/Scale.php';
class Partnership{

    //Attributes of the Partnership table
    private string $select;
	private PDOStatement $selectStmt;
    private Action $action;
    public array $heads = array('نوع الشريك', 'اسم الجمعية الشريكة', 'موضوع اتفاقية الشراكة', 'المجال الجغرافي', 'تاريخ التوقيع', 'سنوات الانجاز', 'قابلة للتجديد', 'مفعلة', 'التكلفة');

    /** =======================: SELECT Partnership :======================================================= */
    public function select(): Partnership
	{
        
		$this -> select = "SELECT CONCAT(a.id, '_', i.id, '_', signing_date) AS _ID, 
        i.name AS _OPEN_NOEDIT_FORinstitution_name, 
        a.name AS _OPEN_NOEDIT_FORassociation_name, 
        subject AS _OPEN_TEXTsubject, 
        s.name AS _OPEN_NOEDIT_FORscale, 
        s.id AS _OPENFOR_scale_ID, 
        date_format(signing_date, '%d/%m/%Y') AS _OPEN_DATEsigning,
		signing_date AS _DATEsigning_UPDATE,	
        period AS _OPEN_NUMperiod, 
        renewable AS _OPEN_BOOLrenewable, 
        active AS _OPEN_BOOL_NOINSERTactive,
        cost AS _OPEN_CURRENCYcost
        FROM Partnership p 
        INNER JOIN Association a ON a.id = p.association_id
        INNER JOIN Institution i ON i.id = p.institution_id 
        INNER JOIN Scale s ON s.id = p.scale_id 
        WHERE archived = '0'";

		return $this;
	}

    public function selectArchived(): Partnership
	{
        
		$this -> select = "SELECT CONCAT(a.id, '_', i.id, '_', signing_date) AS _ID, 
        i.name AS _OPEN_NOEDIT_FORinstitution_name, 
        a.name AS _OPEN_NOEDIT_FORassociation_name, 
        subject AS _OPEN_TEXTsubject, 
        s.name AS _OPEN_NOEDIT_FORscale, 
        s.id AS _FORscale_ID, 
        date_format(signing_date, '%d/%m/%Y') AS _OPEN_DATEsigning, 
        period AS _OPEN_NUMperiod, 
        renewable AS _OPEN_BOOLrenewable, 
        active AS _OPEN_BOOL_NOINSERTactive,
        cost AS _OPEN_CURRENCYcost
        FROM Partnership p 
        INNER JOIN Association a ON a.id = p.association_id
        INNER JOIN Institution i ON i.id = p.institution_id 
        INNER JOIN Scale s ON s.id = p.scale_id 
        WHERE archived = '1'";

		return $this;
	}

    
	public function whereId($id):Partnership
	{
		$this -> select .= " AND p.association_id = '" . explode('_', $id)[0] . "' AND p.institution_id = '" . explode('_', $id)[1] . "' AND signing_date = '" . explode('_', $id)[2] . "'";
		return $this;
	}

    /**
     * We caan add more than that here like associations and institutions
     */
	public function nameLike($name): Partnership
	{
		$this -> select .= " AND a.name LIKE '%$name%' OR i.name LIKE '%$name%'";
		return $this;
	}

	public function orderByCost(string $order = 'DESC'): Partnership
	{
        $db = Database::getInstance() -> getConnexion();
		$this -> select .= " ORDER BY cost " . htmlentities($order);
		return $this;
	}
	public function executeSelect(string $offset = '0'): PDOStatement
	{
        $this -> select .= " LIMIT 10";
        $this -> select .= ($offset === 0) ? "" : " OFFSET $offset";
		$db = Database::getInstance() -> getConnexion();
		$this -> selectStmt = $db -> query($this -> select);

		return $this -> selectStmt;
	}
    public function executePrint(): PDOStatement
	{
		$db = Database::getInstance() -> getConnexion();
		$this -> selectStmt = $db -> query($this -> select);

		return $this -> selectStmt;
	}
    public function count()
    {
        $db = Database::getInstance() -> getConnexion();
        $query = $db -> query("SELECT COUNT(*) AS count FROM Partnership WHERE archived = '0'");
		$count = $query -> fetch(PDO::FETCH_NUM);
        return $count[0];
    }
    public function countArchived()
    {
        $db = Database::getInstance() -> getConnexion();
        $query = $db -> query("SELECT COUNT(*) AS count FROM Partnership WHERE archived = '1'");
        $count = $query -> fetch(PDO::FETCH_NUM);
        return $count[0];
    }
    /** =======================: DELETE Partnership :======================================================= */
    public function delete($id)
    {
        //connexion to database
        $db = Database::getInstance() -> getConnexion();
        require_once ABSOLUTE_PATH . '/models/Action.php';
        $action = new Action();
        
        //building the query
        $query = $db -> prepare("DELETE FROM Partnership WHERE association_id = ".explode('_', $id)[0]." AND institution_id = ".explode('_', $id)[1]." AND signing_date = '".explode('_', $id)[2] . "'");
        //Execute the query
        $action -> delete(explode('_', $id)[0], explode('_', $id)[1], explode('_', $id)[2]);
        $query -> execute();

        
    }
    /** =======================: ARCHIVE Partnership :======================================================= */
    public function archive($id){
        $db = Database::getInstance() -> getConnexion();
        $last = $db -> query("SELECT archived FROM Partnership WHERE association_id = '".explode('_', $id)[0]."' AND  institution_id = '".explode('_', $id)[1]."' AND signing_date = '".explode('_', $id)[2] . "' AND archived = '1'") -> fetch(PDO::FETCH_ASSOC);
        if(empty($last)){
            $query = $db -> prepare("UPDATE Partnership SET archived = 1 WHERE association_id = '".explode('_', $id)[0]."' AND  institution_id = '".explode('_', $id)[1]."' AND signing_date = '".explode('_', $id)[2] . "'");
            $query -> execute();
            $action = new Action();
            $now = new DateTimeImmutable('now', new DateTimeZone('WEST'));
    
            $action -> insert("أرشفة", $now, explode('_', $id)[0], explode('_', $id)[1], explode('_', $id)[2]);
            echo '<div class="alert alert-danger">
            <div class="message-box">
                <h2 class="message">
                    <strong>تمت أرشفة الشراكة</strong>
                </h2>
            </div>
        </div>';
        }
        
    }
    /** =======================: RESTORE Partnership :======================================================= */
    public function restore($id){
        $db = Database::getInstance() -> getConnexion();
        $last = $db -> query("SELECT archived FROM Partnership WHERE (association_id = ".explode('_', $id)[0]." AND  institution_id = ".explode('_', $id)[1].") AND (signing_date = '".explode('_', $id)[2] . "') AND archived = '0'") -> fetch(PDO::FETCH_ASSOC);
        if(empty($last)){
            $query = $db -> prepare("UPDATE Partnership SET archived = 0 WHERE association_id = ".explode('_', $id)[0]." AND institution_id = ".explode('_', $id)[1]." AND signing_date = '".explode('_', $id)[2] . "'");
            $query -> execute();
            $action = new Action();
            $now = new DateTimeImmutable('now', new DateTimeZone('WEST'));
            $last_action = $action -> exists($id, $now) -> executeSelect() -> fetch(PDO::FETCH_ASSOC);
            if(empty($last_action)){
                $action -> insert("إعادة", $now, explode('_', $id)[0], explode('_', $id)[1], explode('_', $id)[2]);
                echo '<div class="alert alert-success">
                <div class="message-box">
                    <h2 class="message">
                        <strong>تمت اعادة الشراكة</strong>
                    </h2>
                </div>
            </div>';
            }
            
           
        }
        
    }
    /** =======================: INSERT Partnership :======================================================= */
    public function insert($open)
    {
        //connexion to database
        $db = Database::getInstance() -> getConnexion();
        //building the query
        $last = $db -> query("SELECT association_id, institution_id, subject FROM Partnership WHERE association_id = '".$open['_OPEN_NOEDIT_FORassociation_name']."' AND
        institution_id = '".$open['_OPEN_NOEDIT_FORinstitution_name']."' AND signing_date = ".$db -> quote($open['_OPEN_DATEsigning'])) -> fetch(PDO::FETCH_ASSOC);
        if(empty($last)){
            $query = $db -> prepare("INSERT INTO Partnership(
                institution_id,
                association_id,
                subject,
                scale_id,
                signing_date,
                period,
                renewable,
                active,
                archived,
                cost) VALUES
                (".$open['_OPEN_NOEDIT_FORinstitution_name'].",
                ".$open['_OPEN_NOEDIT_FORassociation_name'].",
                ". $db -> quote($open['_OPEN_TEXTsubject']).",
                ".$open['_OPEN_NOEDIT_FORscale'].",
                ".$db -> quote($open['_OPEN_DATEsigning']).",
                ".$open['_OPEN_NUMperiod'].",
                ".$open['_OPEN_BOOLrenewable'].",
                '1',
                '0',
                ".$db -> quote($open['_OPEN_CURRENCYcost']).")");
            $result = $query -> execute();
            $action = new Action();
            $now = new DateTimeImmutable('now', new DateTimeZone('WEST'));
            $action -> insert('انشاء الشراكة', $now, $open['_OPEN_NOEDIT_FORassociation_name'], $open['_OPEN_NOEDIT_FORinstitution_name'], $open['_OPEN_DATEsigning']);
    
            echo '<div class="alert alert-success">
            <div class="message-box">
                <h2 class="message">
                    <strong>تمت اضافة شراكة جديدة</strong>
                </h2>
            </div>
        </div>';
        }
        
    }
    /** =======================: UPDATE Partnership :======================================================= */
    public function update(string $id, array $open): void
    {
        //connexion to database
        $db = Database::getInstance() -> getConnexion();
        //EDITABLES : subject, period, renewable, active
        //building the query  
        $last = new Partnership();
        
        $last = $last -> select() -> whereId($id) -> executeSelect() -> fetch(PDO::FETCH_ASSOC);
        
        if(!($open['_OPEN_TEXTsubject'] == $last['_OPEN_TEXTsubject'] && $open['_OPEN_NUMperiod'] == $last['_OPEN_NUMperiod'] && 
        $open['_OPEN_BOOLrenewable'] == $last['_OPEN_BOOLrenewable'] && 
        $open['_OPEN_BOOL_NOINSERTactive'] == '1' && $open['_OPEN_CURRENCYcost'] == $last['_OPEN_CURRENCYcost']
        )){/*
            echo '<pre style="position:absolute; background-color:red; color:white; top:50px;">';
            var_dump($last, $open);
            echo '</pre>';*/
            $query = $db -> prepare("UPDATE Partnership SET 
            subject = ".$db -> quote($open['_OPEN_TEXTsubject']).", 
            period = ".$open['_OPEN_NUMperiod'].",
            renewable = ".$open['_OPEN_BOOLrenewable'].", 
            active = '".$open['_OPEN_BOOL_NOINSERTactive']."',
            cost = '".$open['_OPEN_CURRENCYcost']."' 
            WHERE association_id = '" . explode('_', $id)[0]."'
            AND institution_id = '" . explode('_', $id)[1] . "'
            AND signing_date = '" . explode('_', $id)[2] . "'");
            //Execute the query
            $query-> execute();
            $action = new Action();
            $now = new DateTimeImmutable('now', new DateTimeZone('WEST'));
            if($last['_OPEN_TEXTsubject'] != $open['_OPEN_TEXTsubject']){
                $action -> insert('تعديل موضوع الشراكة من "' . $last['_OPEN_TEXTsubject'] . '" إلى "' . $open['_OPEN_TEXTsubject'] . '"', $now, explode('_', $id)[0], explode('_', $id)[1], explode('_', $id)[2]);
            }
            if($last['_OPEN_NUMperiod'] != $open['_OPEN_NUMperiod']){
                $action -> insert('تعديل مدة الشراكة من "' . $last['_OPEN_NUMperiod'] . '" إلى "' . $open['_OPEN_NUMperiod'] . '"', $now, explode('_', $id)[0], explode('_', $id)[1], explode('_', $id)[2]);
            }
            if($last['_OPEN_BOOLrenewable'] != $open['_OPEN_BOOLrenewable']){
                if($last['_OPEN_BOOLrenewable'] == '1'){
                    $action -> insert('تحويل الشراكة إلى شراكة غير قابلة للتجديد', $now, explode('_', $id)[0], explode('_', $id)[1], explode('_', $id)[2]);
                }else{
                    $action -> insert('تحويل الشراكة إلى شراكة قابلة للتجديد', $now, explode('_', $id)[0], explode('_', $id)[1], explode('_', $id)[2]);
                }
            }
            if($last['_OPEN_BOOL_NOINSERTactive'] != $open['_OPEN_BOOL_NOINSERTactive']){
                if($last['_OPEN_BOOL_NOINSERTactive'] == '1'){
                    $action -> insert('الغاء فعالية الشراكة', $now, explode('_', $id)[0], explode('_', $id)[1], explode('_', $id)[2]);
                }else{
                    $action -> insert('اعادة تفعيل الشراكة', $now, explode('_', $id)[0], explode('_', $id)[1], explode('_', $id)[2]);
                }
            }
            if($last['_OPEN_CURRENCYcost'] != $open['_OPEN_CURRENCYcost']){
                $action -> insert('تعديل تكلفة الشراكة من "' . $last['_OPEN_CURRENCYcost'] . '" إلى "' . $open['_OPEN_CURRENCYcost'] . '"', $now, explode('_', $id)[0], explode('_', $id)[1], explode('_', $id)[2]);
            }  
            echo '
                    <div class="alert alert-success">
                    <div class="message-box success">
                        <h2 class="message">
                            <strong>تم تحديث الشراكة</strong>
                        </h2>
                    </div>
                    </div>';
        }
        
            
}
}