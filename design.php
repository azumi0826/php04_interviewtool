<?php
include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM design";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$json = json_encode($values,JSON_UNESCAPED_UNICODE); //JSON化してJSに渡す場合

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>インタビュー設計</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { padding-top: 60px; }
  </style>
</head>

<body class="bg-light">
  <!-- ナビゲーションバー -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">インタビュー管理システム</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="design.php">インタビュー設計</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="respondent.php">インタビュアーリスト</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="answer.php">回答入力</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="analysis_2.php">結果分析</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="user.php">ユーザー登録</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">ログアウト</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <!-- 質問の新規作成フォーム -->
    <div class="card mb-5 shadow">
      <div class="card-header bg-secondary text-white">
        <h2 class="h4 mb-0">新規作成</h2>
      </div>
      <div class="card-body">
        <form method="POST" action="design.insert.php">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="purpose" name="purpose" placeholder="把握したいこと">
            <label for="purpose">把握したいこと</label>
          </div>
          <div class="form-floating mb-3">
            <textarea class="form-control" id="question" name="question" style="height: 100px" placeholder="質問"></textarea>
            <label for="question">質問</label>
          </div>
          <button type="submit" class="btn btn-info">作成</button>
        </form>
      </div>
    </div>
    
    <!-- 作成済み質問の表示 -->
    <div class="card shadow">
      <div class="card-header bg-success text-white">
        <h2 class="h4 mb-0">質問リスト</h2>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>把握したいこと</th>
                <th>質問</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($values as $v){ ?>
                <tr>
                  <td><?=h($v["purpose"])?></td>
                  <td><?=h($v["question"])?></td>
                  <td>
                    <a href="design.detail.php?id=<?=h($v["id"])?>" class="btn btn-sm btn-info">編集</a>
                    <a href="design.delete.php?id=<?=h($v["id"])?>" class="btn btn-sm btn-danger">削除</a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>