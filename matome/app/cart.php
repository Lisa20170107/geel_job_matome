<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");

session_start();

//もしログインしていなければログインページへ
if(!isset($_SESSION['name'])){
  header("Location: login.php");
  exit;
}

//商品を削除する
//削除のボタンが押されたら
if(isset($_GET['keyword'])){
  //検索するコードを受け取る
   $keyword=$_GET['keyword'];
   //コードから配列のどこの階層に該当の商品があるか検索する
   $key = array_search("$keyword", array_column($_SESSION['selects'], 'code'), true);
  //階層の1番最初から削除する
  array_splice( $_SESSION['selects'], "$key", 1 );
}


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
      <li class="breadcrumb-item active"><?php echo return_top();?></li>
      <li class="breadcrumb-item active"><?php  echo return_login();?></li>
    </ol>

    <?php //もし何も購入していなかったら（ログインした後、商品を検索せずにここへきた場合）トップページへ
    if(!isset($_SESSION['selects'])){
      echo "カートには何も入っていません。".'<br>';
      echo return_top();
      exit;
    }?>

    <?php
    //合計金額の初期値
    $sum =0;
    //受け取る
    $select = $_SESSION['selects'];
    //繰り返し文で取り出す
    foreach ($select as $hit) {
    //商品のIDコードを商品詳細ページに引き渡すための変数
    $product_id= $hit['code'];
    //商品のIDコードをurlにエンコードして渡す
    $url2 ="item.php?data=".urlencode($product_id);
       ?>
    <div align="center">
    <div class="w-50 p-3">
    <div class="col-12 col-md-6">
    <div class="card text-center mb-3">
    <div align="center">
    <a href="<?=$url2?>"><img style="margin:20px;" src="<?php echo $hit['image'] ; ?>" /></a></div>
    <ul class="list-group list-group-flush">
    <li class="list-group-item">名前：<?php echo $hit['name']; ?></a></li>
    <li class="list-group-item">金額：<?php echo $hit['price'];?>円</li>
    <!--キャンセル用-->
    <?php $item_code=$hit['code'];?>
    <!--合計金額-->
    <?php $sum += $hit['price'];?>
    </ul>
    </div>
    </div>
    </div>
    </div>
    <form action="<?php echo CART;?>" method="GET">
    <!--商品コードを渡す-->
    <input type="hidden" name="keyword" value="<?php echo $item_code ?>"/>
    <button type="submit" class="btn btn-warning" name="btnSubmit" value="キャンセルする">キャンセルする</button>
    </form>
    <br>
    <?php } ?>
    <h5>合計金額:<?php echo $sum;?>円</h5><br>
    <!--カートに商品情報が入っていたら、購入ボタンを押せる-->
    <?php if(!empty($_SESSION['selects'])){?>
      <form action="<?php echo BUY_CONFIRM; ?>" method="GET">
        <!--検索キーワードをエンコードして渡す-->
      <input type="hidden" name="buy_check" value="OK"/>
      <button type="submit" class="btn btn-primary" name="btnSubmit" value="購入手続きに進む">購入手続きに進む</button>
      </form>
      <br><br>
    <?php }?>
  </body>
</html>
