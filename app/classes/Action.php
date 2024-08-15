<?php
require_once ABSOLUTE_PATH . '/classes/Database.php';
require_once ABSOLUTE_PATH . '/classes/Partnership.php';
class Action
{
    /**
     * The Journal table is a table that is associated to a partnership, a specific one. 
     * Any Journal has the id of this partnership and an action. 
     * An action has an id, a name, and a datetime.
     */
    public string $select;
	public PDOStatement $selectStmt;

    public function selectWHERE(string $ID): Action
    {
        $this -> select = "SELECT CONCAT(association_id, '_', institution_id, '_', signing_date) AS _ID_PARTNERSHIP, id AS _ID, 
        operation AS _OPENname, time AS _OPENdate
        FROM Action 
        WHERE association_id = '" . explode('_', $ID)[0] . "' 
        AND institution_id = '" . explode('_', $ID)[1] . "' 
        AND signing_date = '" . explode('_', $ID)[2] . "'
        ORDER BY time DESC";
        return $this;
    }

    public function exists(string $ID, DateTimeImmutable $date){
        $this -> select = "SELECT CONCAT(association_id, '_', institution_id, '_', signing_date) AS _ID_PARTNERSHIP, id AS _ID, 
        operation AS _OPENname, time AS _OPENdate
        FROM Action 
        WHERE association_id = " . explode('_', $ID)[0] . " 
        AND institution_id = " . explode('_', $ID)[1] . " 
        AND signing_date = '" . explode('_', $ID)[2] . "'
        AND time = '{$date -> format('Y-m-d H:i:s')}'";
        return $this;
    }

    public function executeSelect(): PDOStatement
	{
		$db = Database::getInstance() -> getConnexion();
		$this -> selectStmt = $db -> query($this -> select);

		return $this -> selectStmt;
	}
    
    public function insert(string $name, DateTimeImmutable $date, string $association, string $institution, string $signing_date): void
    {
        $db = Database::getInstance() -> getConnexion();
        $query = $db -> prepare("INSERT INTO Action (operation, time, association_id, institution_id, signing_date) 
        VALUES ('$name', '{$date -> format('Y-m-d H:i:s')}', '$association', '$institution', '$signing_date')");
        $result = $query -> execute();
    }
    public function delete(string $association, string $institution, string $signing_date): void {
        $db = Database::getInstance() -> getConnexion();
        $query = $db -> prepare("DELETE FROM Action WHERE association_id = '$association' AND institution_id = '$institution' AND signing_date = '$signing_date'");
        $result = $query -> execute();
    }

    public function groubByDate(string $dateime){
        $db = Database::getInstance() -> getConnexion();
        $query = $db -> query("SELECT ");
    }

}
