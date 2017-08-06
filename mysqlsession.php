<?php
class MySessionHandler implements SessionHandlerInterface
{
  //open
  public function open($savePath,$session_data){
    //连接数据库进行操作
    mysql_connect('127.0.0.1','root','root');
    mysql_query('set names utf8');
    mysql_query('use php59');
    return true;
  }
  //close
  public function close(){
    return mysql_close();
  }
  //write
  public function write($session_id,$session_data){
    $sql = "insert into session value('$session_id','$session_data',".time().")";
    return mysql_query($sql);
  }
  //read
  public function read($session_id){
    $sql = "select session_data from session where session_id = '$session_id'";
    $data = mysql_query($sql);
    if($row = mysql_fetch_assoc($data)){
      return $row['session_data'];
    }else{
      return '';
    }
  }
  //destroy
  public function destroy($session_id){
    $sql = "delete from session where session_id = '$session_id'";
    return mysql_query($sql);
  }
  //gc
  public function gc($maxlifetime){
    $sql = "delete from session where ".time()." - maxlifetime > $maxlifetime";
    return mysql_query($sql);
  }
}
$handler = new MySessionHandler();
session_set_save_handler($handler, true);
session_start();
$_SESSION['name'] = 'php59';
$_SESSION['age'] = 100;
// session_destroy();