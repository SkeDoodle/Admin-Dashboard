<?php

class Database {

    private $db;
    private $error;
    private $stmt;

    public function __construct() {
        $config = parse_ini_file('/config.ini');
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        try{
            $this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password'], $options);
        }catch(PDOException $e){
            $this->error = $e -> getMessage();
        }
    }
    public function query($query){
        $query = str_replace("à","&acirc;",$query);
        $query = str_replace("â","&agrave;",$query);

        $query = str_replace("é","&eacute;",$query);
        $query = str_replace("è","&egrave;",$query);
        $query = str_replace("ê","&ecirc;",$query);
        $query = str_replace("ë","&euml;",$query);

        $query = str_replace("î","&icirc;",$query);
        $query = str_replace("ï","&iuml;",$query);

        $query = str_replace("ô","&ocirc;",$query);
        $query = str_replace("œ","&oelig;",$query);

        $query = str_replace("û","&ucirc;",$query);
        $query = str_replace("ù","&ugrave;",$query);
        $query = str_replace("ü","&uuml;",$query);

        $query = str_replace("ç","&ccedil;",$query);

        $query = str_replace("<","&lt;",$query);
        $query = str_replace(">","&gt;",$query);
        //$query = str_replace("\n","<br>",$query);
//        $query = str_replace("'","&#039",$query);

        //$queryBis = nl2br($query);
        $this->stmt = $this->db->prepare($query);
    }
    public function bind($param, $value, $type = null){
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute(){
        return $this->stmt->execute();
    }
    public function fetchAll(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function rowCount(){
        return $this->stmt->rowCount();
    }
    public function lastInsertId(){
        return $this->db->lastInsertId();
    }
}
