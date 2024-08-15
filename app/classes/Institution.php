<?php
require_once ABSOLUTE_PATH . '/classes/Database.php';
class Institution{

    //Attributes of the Institution table
    public string $select;
	public PDOStatement $selectStmt;
    public array $heads = array('اسم المؤسسة', 'المسؤول', 'المدينة', 'العنوان', 'رقم الهاتف', 'الفاكس', 'ايميل', 'الموقع الالكتروني');

    /** =======================: SELECT InstitutionS :======================================================= */
    public function forSelect()
    {
        $this -> select = "SELECT id as _ID, name as _OPENname FROM Institution";
        return $this;
    }
    public function select(): Institution
	{
		$this -> select = "SELECT id as _ID, name as _OPEN_NAME, 
        responsable as _OPEN_REGULARresponsable, city as _OPEN_REGULARcity, adresse as _OPEN_TEXTadresse, 
        tel as _OPEN_TELtel, fax as _OPEN_TELfax, e_mail as _OPEN_EMAIL, site as _OPEN_URLsite FROM Institution";
		return $this;
	}

    
	public function whereId($id): Institution
	{
		$this -> select .= " WHERE id = $id";
		return $this;
	}

	public function nameLike($name): Institution
	{
		$this -> select .= " WHERE name LIKE '%$name%'";
		return $this;
	}
	public function executeSelect($offset = 0): PDOStatement
	{
        $this -> select .= " LIMIT 10 OFFSET $offset";
		$db = Database::getInstance() -> getConnexion();
		$this -> selectStmt = $db -> query($this -> select);
		return $this -> selectStmt;
	}
    public function count(){
        $db = Database::getInstance() -> getConnexion();
        $query = $db -> query("SELECT COUNT(*) AS count FROM Institution");
        $count = $query -> fetch(PDO::FETCH_NUM);
        return $count[0];
    }
    /** =======================: DELETE Institution :======================================================= */
    public function delete($id)
    {
        //connexion to database
        $db = Database::getInstance() -> getConnexion();

        //building the query
        $query = $db -> prepare("DELETE FROM Institution WHERE id = :id");
        //Execute the query
        $result = $query -> execute([
            ':id' => $id
        ]);
        echo '<div class="alert alert-danger">
        <div class="message-box">
            <h2 class="message">
                <strong>تمت حذف المؤسسة</strong>
            </h2>
        </div>
    </div>';
    }
    /** =======================: INSERT Institution :======================================================= */
    public function insert(array $open): void
    {
        //connexion to database
        $db = Database::getInstance() -> getConnexion();
        //building the query
        
        $last = $db -> query("SELECT name, responsable, city FROM Institution WHERE name = '".$open['_OPEN_NAME']."'
        AND responsable = '".$open['_OPEN_REGULARresponsable']."' AND city = '".$open['_OPEN_REGULARcity']."'") -> fetch(PDO::FETCH_ASSOC);
		/*echo '<pre>';
        var_dump($open, $last);
        echo '</pre>';*/
        if(!$last){
            $query = $db -> prepare("INSERT INTO Institution (
                name,
                responsable,
                city,
                adresse,
                tel,
                fax,
                e_mail,
                site) VALUES
                (".$db -> quote($open['_OPEN_NAME']).",
                ".$db -> quote($open['_OPEN_REGULARresponsable']).",
                ".$db -> quote($open['_OPEN_REGULARcity']).",
                ".$db -> quote($open['_OPEN_TEXTadresse']).",
                ".$db -> quote($open['_OPEN_TELtel']).",
                ".$db -> quote($open['_OPEN_TELfax']).",
                ".$db -> quote($open['_OPEN_EMAIL']).",
                ".$db -> quote($open['_OPEN_URLsite']).")");
            $result = $query -> execute();
            echo '<div class="alert alert-success">
            <div class="message-box">
                <h2 class="message">
                    <strong>تمت اضافة مؤسسة جديدة</strong>
                </h2>
            </div>
        </div>';
        }
        
        
    }
    /** =======================: UPDATE Institution :======================================================= */
    public function update(mixed $id, array $open)
    {

        //connexion to database
        $db = Database::getInstance() -> getConnexion();
        $last = new Institution();
        $last = $last -> select() -> whereId($id) -> executeSelect() -> fetch(PDO::FETCH_ASSOC);
        if(!($open['_OPEN_NAME'] == $last['_OPEN_NAME']
        && $open['_OPEN_REGULARresponsable'] == $last['_OPEN_REGULARresponsable']
        && $open['_OPEN_REGULARcity'] == $last['_OPEN_REGULARcity']
        && $open['_OPEN_TEXTadresse'] == $last['_OPEN_TEXTadresse']
        && $open['_OPEN_TELtel'] == $last['_OPEN_TELtel']
        && $open['_OPEN_TELfax'] == $last['_OPEN_TELfax']
        && $open['_OPEN_EMAIL'] == $last['_OPEN_EMAIL']
        && $open['_OPEN_URLsite'] == $last['_OPEN_URLsite'])){
            //building the query
            /*echo '<pre>';
            var_dump($open, $id);
            echo '</pre>';*/
            /*echo '<pre>';
            var_dump($open, $last);
            echo '</pre>';*/
            $query = $db -> prepare("UPDATE Institution SET
                name = ".$db -> quote($open['_OPEN_NAME']).",
                responsable = ".$db -> quote($open['_OPEN_REGULARresponsable']).",
                city = ".$db -> quote($open['_OPEN_REGULARcity']).",
                adresse = ".$db -> quote($open['_OPEN_TEXTadresse']).",
                tel = ".$db -> quote($open['_OPEN_TELtel']).",
                fax = ".$db -> quote($open['_OPEN_TELfax']).",
                e_mail = ".$db -> quote($open['_OPEN_EMAIL']).",
                site = ".$db -> quote($open['_OPEN_URLsite'])."
                WHERE
                id = '$id'");
            //Execute the query
            $result = $query-> execute();
            echo '<div class="alert alert-success">
            <div class="message-box">
            <h2 class="message">
                <strong>تم التعديل على المؤسسة</strong>
            </h2>
            </div>
            </div>';
        }
        
}
    

}