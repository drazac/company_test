<?php

/*
 * This is an example using PDO
 * */

define("DB_HOST", "127.0.0.1");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "sentient_test");
define("DB_CHAR", "utf8");
define("DB_TYPE", "mysql");


class Database extends PDO{

    private $log = array();

    private $db_type = null;
    private $db_host = null;
    private $db_name = null;
    private $db_char = null;
    private $db_user = null;
    private $db_pass = null;
    private $db_options = array();

    public function __construct($type, $host, $name, $char, $user, $pass, $options = array())
    {

        $this->setDbType($type);
        $this->setDbHost($host);
        $this->setDbName($name);
        $this->setDbChar($char);
        $this->setDbUser($user);
        $this->setDbpass($pass);
        $this->setDbOptions($options);

        return $this->connect();

    }

    public function connect(){

        try {

            $dsn = $this->getDbType() . ':host=' . $this->getDbHost() . ';dbname=' . $this->getDbName() . ';charset=' . $this->getDbChar();

            return parent::__construct($dsn, $this->getDbUser(), $this->getDbPass(), $this->getDbOptions());


        } catch (PDOException $PDOEx) {

            die(json_encode(array('db_connection_established'=>false, 'message'=>$PDOEx->getMessage())));

        }


    }

    public function lastId(){

        return parent::lastInsertId();

    }

    public function insertTolog($statement){
        $this->log[] = $statement;
    }

    public function getLog(){
        print_r($this->log);
    }


    public function select($sql, $where = array(), $fetchMode = PDO::FETCH_ASSOC){

        $sth = $this->prepare($sql);

        foreach ($where as $key => $value) {
            $sth->bindValue("$key", $value);
        }

        $sth->execute();

        $this->insertTolog($sth->queryString);

        return $sth->fetchAll($fetchMode);

    }

    public function insert($table, $data){
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();

        $this->insertTolog($sth->queryString);
    }

    /**
     * update
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     * @param string $where the WHERE query part
     */
    public function update($table, $data = array(), $where = '')
    {
        ksort($data);

        $where = (array) $where;

        $fieldDetails = NULL;
        foreach($data as $key => $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');

        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE " . join(' AND ', $where));

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();

        $this->insertTolog($sth->queryString);
    }

    public function joinkv($array, $separator = ' = '){
        $newarray = array();

        foreach($array AS $k => $v) {

            $newarray[] = $k . $separator . $v;

        }

        return $newarray;

    }

    public function delete($table, $where = array()){


        $sth = $this->prepare("DELETE FROM {$table} WHERE " . join(" AND ", $this->joinkv($where)));

        foreach ($where as $key => $value) {
            $sth->bindValue("$key", $value);
        }

        $sth->execute();

        $this->insertTolog($sth->queryString);

    }

    /**
     * @return null
     */
    public function getDbType()
    {
        return $this->db_type;
    }

    /**
     * @param null $db_type
     */
    public function setDbType($db_type)
    {
        $this->db_type = $db_type;
    }

    /**
     * @return null
     */
    public function getDbHost()
    {
        return $this->db_host;
    }

    /**
     * @param null $db_host
     */
    public function setDbHost($db_host)
    {
        $this->db_host = $db_host;
    }

    /**
     * @return null
     */
    public function getDbName()
    {
        return $this->db_name;
    }

    /**
     * @param null $db_name
     */
    public function setDbName($db_name)
    {
        $this->db_name = $db_name;
    }

    /**
     * @return null
     */
    public function getDbChar()
    {
        return $this->db_char;
    }

    /**
     * @param null $db_char
     */
    public function setDbChar($db_char)
    {
        $this->db_char = $db_char;
    }

    /**
     * @return null
     */
    public function getDbUser()
    {
        return $this->db_user;
    }

    /**
     * @param null $db_user
     */
    public function setDbUser($db_user)
    {
        $this->db_user = $db_user;
    }

    /**
     * @return null
     */
    public function getDbPass()
    {
        return $this->db_pass;
    }

    /**
     * @param null $db_pass
     */
    public function setDbPass($db_pass)
    {
        $this->db_pass = $db_pass;
    }

    /**
     * @return array
     */
    public function getDbOptions()
    {
        return $this->db_options;
    }

    /**
     * @param array $db_options
     */
    public function setDbOptions(array $db_options)
    {
        $default = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        );

        $options = array_merge($default, $db_options);

        $this->db_options = $options;
    }


}

/*
 * Design_Model extends default Database Model
 * Put any simple or complex DB queries for sentient_design table in there
 *
 * */

class Design_Model extends Database {

    private $table = 'sentient_design';

    /*
     * Define alias for table columns
     * */
    private $columnNamesAlias = array(
        'id' => 'design_id',
        'name' => 'design_name',
        'percentage' => 'split_percent',
        'template' => 'design_template'
    );

    public function getColumnNames(){

        return $this->columnNamesAlias;

    }

    public function __construct(){

        parent::__construct(DB_TYPE, DB_HOST, DB_NAME, DB_CHAR, DB_USER, DB_PASS);

    }

    public function getAll(){

        $query = 'SELECT * FROM ' . $this->table;
        $rs = parent::select($query);

        return $rs;

    }

    public function getPercentageById($id){

        $alias = $this->columnNamesAlias;

        $query = 'SELECT ' . $alias['percentage'] . ' FROM ' . $this->table . ' WHERE ' . $alias['id'] . ' = ' . $id;

        return parent::select($query, array('id'=>$id));

    }

    public function dm_update($data, $where){

        parent::update($this->table, $data, $where);

    }

    public function dm_delete($where) {

        parent::delete($this->table, $where);

    }

    public function dm_insert($data){

        parent::insert($this->table, $data);

    }

}


?>