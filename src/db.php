<?php

namespace Amit76\Db;

class db{
    public $connection;
    public $sql;
    public function __construct()
    {
        $this->connection = mysqli_connect("localhost","root","","amit");
    }

    public function insert($table,$data){
        $columns = "";
        $values = "";
        foreach($data as $key => $value){
            $columns .= "`$key` ,"; 
            $values .= "'$value' ,";
        }

        $columns =  rtrim($columns,",");
        $values =  rtrim($values,",");

        $this->sql = "INSERT INTO `$table` ($columns) VALUES ($values)";
        return $this;
    }


    public function update($table,$data){

        $row= "";
        foreach($data as $key => $value){
            $row .= "`$key` = '$value' ,"; 
        }

        $row =  rtrim($row,",");
        $this->sql = "UPDATE `$table` SET $row";
        return $this;
    }
    public function select(string $table,string $columns)
    {
        $this->sql = "SELECT $columns FROM `$table`";
        return $this;
    }

    public function delete($table){
        $this->sql = "DELETE FROM `$table`";
        return $this;
    }

    public function excute(){
        mysqli_query($this->connection,$this->sql);
        return mysqli_affected_rows($this->connection);
    }

    public function where($column,$operator,$value){
        $this->sql .= " WHERE `$column` $operator '$value'";
        return $this;
    }

    
    public function andWhere($column,$operator,$value){
        $this->sql .= " AND `$column` $operator '$value'";
        return $this;
    }
    public function orWhere($column,$operator,$value){
        $this->sql .= " OR `$column` $operator '$value'";
        return $this;
    }
    public function first(){
        $q = mysqli_query($this->connection,$this->sql);
        return mysqli_fetch_assoc($q);
    }


    public function all(){
        $q = mysqli_query($this->connection,$this->sql);
        return mysqli_fetch_all($q,MYSQLI_ASSOC);
    }

    public function __destruct()
    {

    }
}