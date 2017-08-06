<?php
class MySessionHandler implements SessionHandlerInterface
{
  //封装mysqli对象
  private $mysqli;
  //构造方法
  public function __construct(){
    //连接数据库
    $mysqli = new Mysqli('127.0.0.1','root','root','php59');
    $mysqli->query('set names utf8');
    $this->db = $mysqli;
  }
  //open
  public function open($savePath,$session_name){
    return true;
  }
  //close
  public function close(){
    $this->db->close();
  }
  //write
  public function write($session_id,$session_data){
    $sql = "insert into session value ('$session_id','$session_data',".time().")";
    return $this->db->query($sql);
  }
  //read
  public function read($session_id){
    $sql = "select session_data from session where session_id = '$session_id' ";
    //连接数据库
    $object = $this->db->query($sql);
    if($rows = $object->fetch_assoc()){
      return $rows['session_data'];
    }else{
      return '';
    }
  }
  //destroy
  public function destroy($session_id){
    $sql = "delete from session where session_id = '$session_id'";
    return $this->db->query($sql);
  }
  //gc
  public function gc($maxlifetime){
    return true;
  }
}
$handler = new MySessionHandler();
session_set_save_handler($handler,true);
session_start();
$_SESSION['test'] = time();