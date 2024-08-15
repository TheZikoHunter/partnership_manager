<?php
class Scale{
    //Attributes of the Geographic table
    public string $select;
	public PDOStatement $selectStmt;

    /** =======================: SELECT ASSOCIATIONS :======================================================= */
    public function forSelect():Scale
    {
        $this -> select = "SELECT id AS _ID, name AS _OPENname FROM Scale";
        return $this;
    }
    public function whereId($id): Scale
	{
		$this -> select .= " WHERE id = '$id'";
		return $this;
	}
    public function executeSelect($offset = 0): PDOStatement
	{
        $this -> select .= " LIMIT 10 OFFSET $offset";
		$db = Database::getInstance() -> getConnexion();
		$this -> selectStmt = $db -> query($this -> select);
		return $this -> selectStmt;
	}

    public function insert(string $name){
        $db = Database::getInstance() -> getConnexion();

        $query = $db -> query("INSERT INTO Scale (name) VALUES ('$name');");
        $query -> execute();
    }
}