<?php
header('Content-Type: application/json; charset=utf-8');
$db=new PDO('sqlite:'.__DIR__.'/bookings.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE IF NOT EXISTS bookings(id TEXT PRIMARY KEY,name TEXT NOT NULL,mobile TEXT NOT NULL,size TEXT NOT NULL,qty INTEGER NOT NULL,created_at TEXT NOT NULL)");
$db->exec("CREATE TABLE IF NOT EXISTS sessions(token TEXT PRIMARY KEY,created_at INTEGER NOT NULL)");
$input=json_decode(file_get_contents('php://input'),true) ?: [];
$action=$_GET['action'] ?? ($input['action'] ?? '');
function out($x){echo json_encode($x,JSON_UNESCAPED_UNICODE);exit;}
function admin_ok(){
 global $db;
 $h=$_SERVER['HTTP_AUTHORIZATION'] ?? '';
 if(!$h) return false;
 $s=$db->prepare("SELECT token FROM sessions WHERE token=? AND created_at>?");$s->execute([$h,time()-86400]);
 return (bool)$s->fetch();
}
if($action==='login'){
 $u=$input['username']??'';$p=$input['password']??'';
 /* CHANGE THESE BEFORE GOING LIVE */
 if($u==='admin' && $p==='Morya@2026'){
   $t=bin2hex(random_bytes(24));$q=$db->prepare("INSERT INTO sessions VALUES(?,?)");$q->execute([$t,time()]);out(['ok'=>true,'token'=>$t]);
 }
 out(['ok'=>false,'error'=>'Invalid username or password']);
}
if($action==='book'){
 $name=trim($input['name']??'');$mobile=trim($input['mobile']??'');$size=$input['size']??'';$qty=(int)($input['qty']??0);
 if($name==='' || !preg_match('/^[0-9]{10}$/',$mobile) || !in_array($size,['S','M','L','XL','XXL','XXXL'],true) || $qty<1 || $qty>20) out(['ok'=>false,'error'=>'Please enter valid booking details.']);
 $id='MOR'.date('ymdHis').random_int(10,99);$q=$db->prepare("INSERT INTO bookings VALUES(?,?,?,?,?,?)");$q->execute([$id,$name,$mobile,$size,$qty,date('d-m-Y H:i:s')]);out(['ok'=>true,'id'=>$id]);
}
if($action==='list'){
 if(!admin_ok()) out(['ok'=>false,'error'=>'Unauthorized']);
 $rows=$db->query("SELECT * FROM bookings ORDER BY rowid DESC")->fetchAll(PDO::FETCH_ASSOC);out(['ok'=>true,'bookings'=>$rows]);
}
if($action==='delete'){
 if(!admin_ok()) out(['ok'=>false,'error'=>'Unauthorized']);
 $q=$db->prepare("DELETE FROM bookings WHERE id=?");$q->execute([$input['id']??'']);out(['ok'=>true]);
}
out(['ok'=>false,'error'=>'Unknown action']);
?>