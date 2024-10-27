<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

//1. POSTデータ取得
$username = $_POST["username"];
$bookname = $_POST["bookname"];
$bookurl = $_POST["bookurl"];
$comment = $_POST["comment"];
$id = $_POST["id"];

//2. DB接続します（funcs.phpの、//DB接続関数：db_conn()にコピペする箇所）
include("funcs.php");  //外部ファイル読み込み
$pdo = db_conn();

//３．データ登録SQL作成　（update文変更箇所：48,51行目）
//update.phpで48行目を追加（update文はこれがデフォルト、nameなど必要項目が適宜変わる）
$sql = "UPDATE gs_kadai_an_table SET username=:username, bookname=:bookname, bookurl=:bookurl, comment=:comment, indate=sysdate() WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);  
$stmt->bindValue(':bookname', $bookname, PDO::PARAM_STR);  
$stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);  
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  
$stmt->bindValue(':id',$id,PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行 true or false

//４．データ登録処理後（2箇所、funcs.phpの//SQLエラー関数：sql_error($stmt)&リダイレクト関数にコピペする箇所）
if($status==false){
    sql_error($stmt);  
}else{
    redirect("select.php");   //update.php（更新処理）からselectに戻したいのでselect.phpに記述変更
}

?>
