<?php
class MySessionHandler implements SessionHandlerInterface
{
    // private $savePath;

    public function open($savePath, $sessionName)
    {
        $savePath = mysql_connect('127.0.0.1', 'root', 'root');
                mysql_query('set names utf8');
                mysql_query('use php59');
        return true;
    }

    public function close()
    {
        return mysql_close();
    }

    public function read($id)
    {
        $sql = "select session_data from `session` where session_id = '$id'";
                $result = mysql_query($sql);
                if($rows = mysql_fetch_assoc($result)){
                    return $rows['session_data'];
                }else{
                    return '';
                }
    }

    public function write($id, $data)
    {
        $sql = "insert into `session` (session_id,session_data,session_time) values('$id','$data', now())
            on duplicate key update session_data = '$data' , session_time = ".time()."
            ";  //这是为了gc()
        // echo $sql;die();
        return mysql_query($sql);
    }

    public function destroy($id)
    {
        // echo __FUNCTION__;
        $sql = "delete from `session` where session_id = '$id'";
        // echo $sql;die();
        return mysql_query($sql);
    }

    public function gc($maxlifetime)
    {
        // echo __FUNCTION__;
        $sql = "delete from `session` where ".time()."-session_time > '$maxlifetime' ";
        return mysql_query($sql);
    }
}

$handler = new MySessionHandler();
session_set_save_handler($handler, true);
session_start();
// $_SESSION['name'] = 'php59';
// $_SESSION['age'] = 100;
// var_dump($_SESSION);
// echo $_SESSION['name'];e
// $handler->destroy('es1o6uru78ml15ftt2mmrdnpr1');
session_destroy();
// session_unset();