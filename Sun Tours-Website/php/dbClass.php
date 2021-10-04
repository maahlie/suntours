<?php
class SqlCommands {

    private $dbConnAddress;
    private $name;
    private $password;
    private $port;
    public $pdo;


    public function __construct()
    {
        $this->dbConnAddress = 'mysql:host=localhost;dbname=suntours';
        // $this->dbConnAddress = 'mysql:sql11.freemysqlhosting.net;dbname=sql11439693';
        $this->name = 'suntoursroot';
        // $this->name = 'sql11439693';
        $this->password = 'root';
        // $this->password = 'G7Gpwc79fj';
        $this->pdo = new PDO($this->dbConnAddress, $this->name, $this->password); //login op db

    } 

    public function connectDB()
    {
        $this->pdo->exec('SET CHARACTER SET UTF8');
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    
    public function selectFrom($column, $table) {
        $sql = "SELECT " . $column .  " FROM " . $table . ";";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt) {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_NUM);      
        }

        return $result;
    }

    public function selectFromWhere($column, $table, $where, $param) {
        $sql = "SELECT " . $column .  " FROM " . $table . " WHERE " . $where . "= ?";
        $stmt = $this->pdo->prepare($sql);
        $params = [$param];
        // var_dump($column, $table, $where, $param);
        $stmt->execute($params);

        if ($stmt) {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);   
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