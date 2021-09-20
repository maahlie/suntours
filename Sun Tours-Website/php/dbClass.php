<?php
class SqlCommands {

    private $dbConnAddress;
    private $name;
    private $password;
    public $pdo;

    public function __construct()
    {
        $this->dbConnAddress = 'mysql:host=localhost;dbname=suntours';
        $this->name = 'suntoursroot';
        $this->password = 'root';
        $this->pdo = new PDO($this->dbConnAddress, $this->name, $this->password); //login op db

    }

    public function connectDB()
    {
        $this->pdo->exec('SET CHARACTER SET UTF8');
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    
    public function selectAllFrom($column, $table) {
        $sql = "SELECT " . $column .  " FROM " . $table . ";";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt) {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_NUM);      
        }

        return $result;
    }

    public function selectWithWhere($column, $column2) {
        $sql = "SELECT username, passwrd FROM users WHERE username = ? AND passwrd = ?;";
        $stmt = $this->pdo->prepare($sql);
        $params = [$column, $column2];
        $stmt->execute($params);

        if ($stmt) {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);      
        }

        return $result;
    }



}

?>