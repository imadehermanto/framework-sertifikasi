<?php

namespace App\Models;

class Database implements Config
{
    private $host = Config::DB_HOST;
    private $uname = Config::DB_USER;
    private $pass = Config::DB_PASS;
    private $db = Config::DB_NAME;
    private $conn;

    protected $table = '';
    public static $query = '';


    //method untuk koneksi ke database
    function __construct()
    {
        $this->conn = new \mysqli($this->host, $this->uname, $this->pass, $this->db);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function primaryKey()
    {
        return 'id';
    }

    //method untuk mengeksekusi query
    //all() : untuk menampilkan semua data
    //get() : untuk menampilkan data berdasarkan query yang dibuat
    //first() : untuk menampilkan data pertama 
    public static function all()
    {
        $instance = new static;
        $db = new Database();
        $sql = "SELECT * FROM " . $instance->table;
        $result = $db->conn->query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public static function get($column = '*')
    {
        $instance = new static;
        $db = new Database();
        $sql = "SELECT " . $column . " FROM " . $instance->table . self::$query;
        $result = $db->conn->query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public static function first()
    {
        $instance = new static;
        $db = new Database();
        $sql = "SELECT * FROM " . $instance->table . self::$query;
        $result = $db->conn->query($sql);
        $rows = '';
        while ($row = $result->fetch_assoc()) {
            $rows = $row;
        }
        return $rows;
    }


    //method untuk membuat query 
    //where() : untuk membuat query where
    //where() : untuk membuat query where
    //andWhere() : untuk membuat query and where
    //orderBy() : untuk membuat query order by
    //limit() : untuk membuat query limit


    //parameter:
    //$column adalah nama kolom yang akan dijadikan patokan
    //$operator adalah operator yang akan digunakan
    //$value adalah nilai yang akan dibandingkan
    public static function where($column, $operator, $value)
    {
        $sql = " WHERE " . $column . " " . $operator . " '" . $value . "'";
        self::$query = self::$query . $sql;
        return new static;
    }

    //parameter:
    //$column adalah nama kolom yang akan dijadikan patokan
    //$operator adalah operator yang akan digunakan
    //$value adalah nilai yang akan dibandingkan
    public static function andWhere($column, $operator, $value)
    {
        $sql = " AND " . $column . " " . $operator . " '" . $value . "'";
        self::$query = self::$query . $sql;
        return new static;
    }

    //parameter:
    //$column adalah nama kolom yang akan dijadikan patokan
    //$operator adalah operator yang akan digunakan
    //$value adalah nilai yang akan dibandingkan
    public static function orWhere($column, $operator, $value)
    {
        $sql = " OR " . $column . " " . $operator . " '" . $value . "'";
        self::$query = self::$query . $sql;
        return new static;
    }

    //parameter:
    //$column adalah nama kolom yang akan dijadikan patokan
    //$value adalah nilai yang akan dibandingkan
    public static function like($column, $value)
    {
        $sql = " WHERE " . $column . " LIKE '%" . $value . "%'";
        self::$query = self::$query . $sql;
        return new static;
    }

    //parameter:
    //$column adalah nama kolom yang akan dijadikan patokan (default: prymary key)
    //$order adalah jenis order (default: ASC)
    public static function orderBy($column, $order = 'ASC')
    {
        $instance = new static;

        if ($column == '') {
            $column = $instance->primaryKey();
        }
        $sql = " ORDER BY " . $column . " " . $order;
        self::$query = self::$query . $sql;
        return new static;
    }

    //parameter:
    //$limit adalah nilai yang akan dibandingkan (default: 1)
    public static function limit($limit = 1)
    {
        $sql = " LIMIT " . $limit;
        self::$query = self::$query . $sql;
        return new static;
    }


    //method ini untuk menambah data ke database
    //parameter : $data = array yang berisi nama kolom dan value
    public static function insert($data)
    {
        $instance = new static;
        $db = new Database();
        $sql = "INSERT INTO " . $instance->table . " (";
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i == 0) {
                $sql = $sql . $key;
            } else {
                $sql = $sql . ", " . $key;
            }
            $i++;
        }
        $sql = $sql . ") VALUES (";
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i == 0) {
                $sql = $sql . "'" . $value . "'";
            } else {
                $sql = $sql . ", '" . $value . "'";
            }
            $i++;
        }
        $sql = $sql . ")";
        $result = $db->conn->query($sql);
        return $result;
    }

    //method ini untuk mengubah data di database
    //parameter : 
    //$data = array yang berisi nama kolom dan value
    //$id = id yang akan diubah
    public static function update($data, $id)
    {
        $instance = new static;
        $db = new Database();
        $sql = "UPDATE " . $instance->table . " SET ";
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i == 0) {
                $sql = $sql . $key . "='" . $value . "'";
            } else {
                $sql = $sql . ", " . $key . "='" . $value . "'";
            }
            $i++;
        }
        $sql = $sql . " WHERE " . $instance->primaryKey() . "=" . $id;
        $result = $db->conn->query($sql);
        return $result;
    }

    //method ini untuk menghapus data di database
    //parameter :
    //$id = id yang akan dihapus
    public static function delete($id)
    {
        $instance = new static;
        $db = new Database();
        $sql = "DELETE FROM " . $instance->table . " WHERE " . $instance->primaryKey() . "=" . $id;
        $result = $db->conn->query($sql);
        return $result;
    }

    //method ini untuk melakukan inner join antara tabel
    //parameter :
    //$table = nama tabel yang akan dijoin
    //$column1 = nama kolom yang akan dijadikan patokan pada tabel yang dipanggil
    //$column2 = nama kolom yang akan dijadikan patokan pada tabel yang dijoin
    //$operator = operator yang akan digunakan
    public static function join($table, $column1, $operator, $column2)
    {
        //example: join('obat', 'obat.id', '=', 'transaksi.id_obat')
        $sql = " INNER JOIN " . $table . " ON " . $column1 . " " . $operator . " " . $column2;
        self::$query = self::$query . $sql;
        return new static;
    }

    //method ini digunakan untuk menghitung jumlah data
    public static function count()
    {
        $instance = new static;
        $db = new Database();
        $sql = "SELECT COUNT(*) AS total FROM " . $instance->table . self::$query;
        $result = $db->conn->query($sql);
        $rows = 0;
        while ($row = $result->fetch_assoc()) {
            $rows = $row['total'];
        }

        return (int)$rows;
    }
}
