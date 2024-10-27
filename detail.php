<?php
$id = $_GET["id"];

//１．PHP
include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_kadai_an_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//一つのデータだけ持ってくる
$v =  $stmt->fetch(); 
// $json = json_encode($values,JSON_UNESCAPED_UNICODE);
?>

<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
理由：入力項目は「登録/更新」はほぼ同じ画面になるからです。
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Book登録更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
  div{padding: 10px;font-size:16px;}
  td{border: 1px solid red;}
</style>
</head>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<?php if( !empty($success_message) ): ?>
    <!-- <p class="success_message">--<?php /*echo $success_message; */?> </p> -->
    <p class="success_message" style="color:green; font-weight: bold;"><?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

<form method="post" action="update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>📗Book登録更新📕</legend>
     <td>ユーザー名：<input type="text" name="username" value="<?=$v["username"]?>"></td><br>
     <td>本のタイトル：<input type="text" name="bookname" value="<?=$v["bookname"]?>"></td><br>
     <td>本のURL：<input type="text" name="bookurl" value="<?=$v["bookurl"]?>"></td><br>
     <td>コメント：<textArea name="comment" rows="5" cols="50"><?=$v["comment"]?></textArea></td><br>
     <input type="hidden" name="id" value="<?=$v["id"]?>">
     <input type="submit" value="送信" class="form">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->

</html>




