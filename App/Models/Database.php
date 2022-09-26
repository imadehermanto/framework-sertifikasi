<?php

namespace App\Models;

class Database  
{
    private $host = "localhost";
	private $uname = "root";
	private $pass = "";
	private $db = "retail";
    private $conn; 

    public $table='';
    public static $query='';


    function __construct(){
        $this->conn = new \mysqli($this->host, $this->uname, $this->pass, $this->db);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }


    public static function all()
    {
        $instance = new static;
        $db = new Database();
        $sql = "SELECT * FROM ".$instance->table;
        $result = $db->conn->query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public static function get() 
    {
        $instance = new static;
        $db = new Database();
        $sql = "SELECT * FROM ".$instance->table.self::$query;
        $result = $db->conn->query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function where($column, $operator, $value) 
    {
        $sql =" WHERE ".$column." ".$operator." '".$value."'";
        self::$query = self::$query.$sql;
        return new static;
    }

    //andWhere
    public static function andWhere($column, $operator, $value) 
    {
        $sql =" AND ".$column." ".$operator." '".$value."'";
        self::$query = self::$query.$sql;
        return new static;
    }

    //orWhere
    public static function orWhere($column, $operator, $value) 
    {
        $sql =" OR ".$column." ".$operator." '".$value."'";
        self::$query = self::$query.$sql;
        return new static;
    }

    //like
    public static function like($column, $value) 
    {
        $sql =" WHERE ".$column." LIKE '%".$value."%'";
        self::$query = self::$query.$sql;
        return new static;
    }

    //first
    public static function first() 
    {
        $instance = new static;
        $db = new Database();
        $sql = "SELECT * FROM ".$instance->table.self::$query;
        $result = $db->conn->query($sql);
        $rows;
        while ($row = $result->fetch_assoc()) {
            $rows = $row;
        }
        return $rows;
    }

    public static function orderBy($column='id', $order='ASC') 
    {
        $sql = " ORDER BY ".$column." ".$order;
        self::$query = self::$query.$sql;
        return new static;
    }

    public static function limit($limit) 
    {
        $sql = " LIMIT ".$limit;
        self::$query = self::$query.$sql;
        return new static;
    }

    //insert
    public static function insert($data) 
    {
        $instance = new static;
        $db = new Database();
        $sql = "INSERT INTO ".$instance->table." (";
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i == 0) {
                $sql = $sql.$key;
            }else{
                $sql = $sql.", ".$key;
            }
            $i++;
        }
        $sql = $sql.") VALUES (";
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i == 0) {
                $sql = $sql."'".$value."'";
            }else{
                $sql = $sql.", '".$value."'";
            }
            $i++;
        }
        $sql = $sql.")";
        $result = $db->conn->query($sql);
        return $result;
    }

    //update
    public static function update($data, $id) 
    {
        $instance = new static;
        $db = new Database();
        $sql = "UPDATE ".$instance->table." SET ";
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i == 0) {
                $sql = $sql.$key."='".$value."'";
            }else{
                $sql = $sql.", ".$key."='".$value."'";
            }
            $i++;
        }
        $sql = $sql." WHERE id=".$id;
        $result = $db->conn->query($sql);
        return $result;
    }

    //delete
    public static function delete($id) 
    {
        $instance = new static;
        $db = new Database();
        $sql = "DELETE FROM ".$instance->table." WHERE id=".$id;
        $result = $db->conn->query($sql);
        return $result;
    }
}
