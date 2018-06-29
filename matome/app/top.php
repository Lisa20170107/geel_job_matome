<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");

//変数の宣言
//もし$_GET["keyword"]の値が空の場合は表示しない。
$keyword = !empty($_GET["keyword"]) ? $_GET["keyword"] : "";

session_start();
 ?>

<!DOCTYPE html>
<html>
  <head>
    <title>かごゆめ</title>
    <meta http-equiv="content-type" charset="utf-8">
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../css/bootstrap-grid.css" type="text/css" />
  </head>
  <body>
    <ol class="breadcrumb fixed-top">
      <li class="breadcrumb-item"><a href="<?php echo REGISTRATION; ?>">新規登録</a></li>
      <li class="breadcrumb-item active"><?php  echo return_login();?></li>
      <li class="breadcrumb-item"><a href="<?php echo MY_DATA; ?>">会員情報</a></li>
      <li class="breadcrumb-item"><a href="<?php echo CART; ?>">カートの中身を確認する</a></li>
    </ol>
    <div class="jumbotron" style="background:url(../img/4.jpg); background-size:cover;">
     <div class="container">
        <h1><p class="text-white">KAGOYUME</p></h1>
        <p class="text-white">ショッピングデモサイト</p>

        <!--ここからフォーム-->
        <div class="input-group">
        <div class="w-auto p-3 mx-auto">
        <form class="form-inline my-2 my-lg-0" action="<?php echo SEARCH ?>" method="GET">
        <!-- ソート-->
        <div class="form-row">
        <div class="col">
       <select select class="form-control" name="sort">
       <?php foreach ($sortOrder as $key => $value) { ?>
       <option value="<?php echo h($key); ?>"><?php echo h($value);?></option>
       <?php } ?>
       </select>
     </div>
       <!-- カテゴリー選択-->
       <div class="col">
       <select select class="form-control" name="category_id">
       <?php foreach ($categories as $id => $name) { ?>
       <option value="<?php echo h($id); ?>"><?php echo h($name);?></option>
       <?php } ?>
       </select></div>
        <!--検索キーワードをエンコードして渡す-->
        <input class="form-control mr-sm-2" type="text" placeholder="Search" name="keyword" value="<?php echo h($keyword); ?>">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit" name="btnSubmit" value="yahooショッピングで検索する">yahooショッピングで検索する</button>
       </form>
       </div>
       </div>
      </div>
    </div>
  </div>

    <p><?php echo login_hello(); ?></p><br>
    <div class="alert alert-dismissible alert-info">
  『金銭取引が絶対に発生しない』
  『いくらでも、どんなものでも購入できる(気分になれる)』
  『ECサイト』
</div>
</body>
</html>
