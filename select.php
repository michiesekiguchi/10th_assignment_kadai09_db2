<?php
//【重要】
//insert.phpをfuncs.phpで修正（関数化）してからselect.phpを開く！！
include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_kadai_an_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>📗ブック登録表示📕</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>

</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
 <!-- 表示する場所だけに、「h」関数を入れる。セキュリティ保護、XSS -->
  <!-- 生のPHPにecoする際には「h」を入れた方が良い -->
  <div>
    <div class="container jumbotron">

    <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    table, th, td {
      border: 1px solid #ccc; /* 灰色の罫線 */
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2; /* ヘッダー行の背景色 */
    }
</style>

      <table>
      <?php foreach($values as $v){ ?>
        <!-- ！！下記、変更を加える！！更新＆削除リンクをつける -->
        <tr>
          <td><?=h($v["id"])?></td>
          <td><?=h($v["username"])?></td>
          <td><?=h($v["bookname"])?></td>
          <td><a href="<?=h($v["bookurl"])?>" target="_blank"><?=h($v["bookurl"])?></a></td>
          <td><?=h($v["comment"])?></td>
          <td><?=h($v["indate"])?></td>
          <td><a href="detail.php?id=<?=h($v["id"])?>">更新</a></td>
          <td><a href="delete.php?id=<?=h($v["id"])?>">削除</a></td>

        </tr>
      <?php } ?>
      </table>

  </div>
</div>
<!-- Main[End] -->

<script>
  const a = '<?php echo $json; ?>';
  console.log(JSON.parse(a));
</script>
</body>
</html>
