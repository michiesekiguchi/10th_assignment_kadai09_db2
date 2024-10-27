<?php

//1. POSTデータ取得
$username = $_POST["username"];
$bookname = $_POST["bookname"];
$bookurl = $_POST["bookurl"];
$comment = $_POST["comment"];

//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''　サクラサーバーなら自分のID PW
  //$pdo = new PDO('mysql:dbname=_gs_kadai;charset=utf8;host=mysql3101.db.sakura.ne.jp','','');
  $pdo = new PDO('mysql:dbname=gs_kadai;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DB_CONECT:'.$e->getMessage());
}

//３．データ登録SQL作成（idとindateは自動設定のため省略）
$sql = "INSERT INTO gs_kadai_an_table(id,username,bookname,bookurl,comment,indate)VALUES(NULL,:username,:bookname,:bookurl,:comment,sysdate());
;";
$stmt = $pdo->prepare($sql);

// パラメータをバインド
$stmt->bindValue(':username', $username, PDO::PARAM_STR);  
$stmt->bindValue(':bookname', $bookname, PDO::PARAM_STR);  
$stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);  
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  
$status = $stmt->execute(); //SQLの実行　true or false

//４．データ登録処理後
if($status==false){
  // SQL実行時にエラーがあれば表示
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  // 成功メッセージをセッションに保存する
  $_SESSION['success_message'] = '本の内容を登録しました';
  // index.phpへリダイレクト
  header("Location: index.php");
  exit();
}
?>
