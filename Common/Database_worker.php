<?php
class Database_worker
{

    private $hostname = 'localhost';
    private $username = 'cf08116_diski';
    private $password = 'Diski123';
    private $database = 'cf08116_diski';
    
    public function __construct() {        
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            echo "Ошибка подключения к БД";
            die();
        }
        @$this->do_sql("SET NAMES utf8");
    }

    public function reconnect(){
        if(!mysqli_ping($this->conn)){
            $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        }
    }

    public function do_sql($sql, $to_array = FALSE) {       
        //$this->conn->query("SET NAMES utf8");
        $result = $this->conn->query($sql);
        if (!$result) {
            return FALSE;
        }
        $result_obj_arr = [];
        if ($result->num_rows != 0) {
            if ($to_array) {
                while ($data = $result->fetch_assoc()) {
                    $result_obj_arr[] = $data;
                }
            } else {
                while ($data = $result->fetch_object()) {
                    $result_obj_arr[] = $data;
                }
            }
        }
        return $result_obj_arr;
    }

    public function insert($table_name, $insert_arr) {        
        $sql = "INSERT IGNORE INTO $table_name SET ";
        $tmp_arr = [];
        foreach ($insert_arr as $key => $data) {
            $tmp_arr[] = "$key='".str_replace("'","",$data)."' ";
        }
        $tmp_arr = implode(",", $tmp_arr);
        $sql .= $tmp_arr;        
        //echo $sql;

        $result = $this->conn->query($sql);        
        if (!$result) {
            $result = FALSE;
            echo $sql;
            die();
        } else {
            $result = $this->conn->insert_id;
        }
        return $result;
    }
    
    /*
     public function insert_batch($table_name, $insert_arr){
         $sql = "INSERT INTO $table_name (`link`,`goods_id`,`name`,`value`) VALUES";
         $tmp_arr = [];
         foreach ($insert_arr as $key => $data) {
             mysql
             $tmp_arr[] = "('{$data['link']}','{$data['goods_id']}','{$data['name']}','{$data['value']}')";
         }
         $tmp_arr = implode(",", $tmp_arr);
         $sql .= $tmp_arr;
         
         $result = $this->conn->query($sql);
         if (!$result) {
             $result = FALSE;
         } else {
             $result = FALSE;
         }
         return $result;
     }
     */

    public function update($table_name, $update_arr, $where_arr) {
        $sql = "UPDATE $table_name SET ";
        $tmp_arr = [];
        foreach ($update_arr as $key => $data) {
            $tmp_arr[] = "$key='$data' ";
        }
        $tmp_arr = implode(",", $tmp_arr);
        $sql .= $tmp_arr;
        $sql .= " WHERE id=" . $where_arr;
        $result = $this->conn->query($sql);
        //var_dump($result);
        //echo $sql;
        
        if (!$result) {
            echo $this->conn->error;
            $result = FALSE;            
        } else {
            $result = TRUE;
        }
        return $result;
    }


    public function update_chat_id($table_name, $update_arr, $where_arr) {
        $sql = "UPDATE $table_name SET ";
        $tmp_arr = [];
        foreach ($update_arr as $key => $data) {
            $tmp_arr[] = "$key='$data' ";
        }
        $tmp_arr = implode(",", $tmp_arr);
        $sql .= $tmp_arr;
        $sql .= " WHERE chat_id=" . $where_arr;
        $result = $this->conn->query($sql);
        //var_dump($result);
        //echo $sql;

        if (!$result) {
            echo $this->conn->error;
            $result = FALSE;
        } else {
            $result = TRUE;
        }
        return $result;
    }

    public function add_log_row($source){
        $sql = "SELECT id FROM parsing_source_list WHERE source LIKE '$source'";
        $res = $this->do_sql($sql);
        $this->insert("parsing_logger",["source"=>$source,"source_id"=>$res[0]->id]);
    }
    
}