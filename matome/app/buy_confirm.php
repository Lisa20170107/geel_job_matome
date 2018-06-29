<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");

session_start();

//もしcart.phpからのアクセスでなければログインページへ
if(!isset($_GET['buy_check'])){
  header("Location: top.php");
  exit;
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
      <li class="breadcrumb-item"><?php echo return_top();?></li>
      <li class="breadcrumb-item active"><?php  echo return_login();?></li>
      <li class="breadcrumb-item"><a href="<?php echo MY_DATA; ?>">会員情報</a></li>
    </ol>
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
         <img style="margin:20px;" src="<?php echo $hit['image'] ; ?>" /></div>
         <ul class="list-group list-group-flush">
          <li class="list-group-item">名前：<?php echo $hit['name']; ?></a></li>
          <li class="list-group-item">金額：<?php echo $hit['price'];?>円</li>
           <!--合計金額-->
          <?php $sum += $hit['price'];?>
        </ul>
      </div>
  </div>
  </div>
  </div>
    <?php } ?>
    <p>合計金額:<?php echo $sum;?>円</p>

      <form action="<?php echo BUY_COMPLETE; ?>" method="GET">
        <input type="radio" class="form-check-input" name="how_buy" value="1" checked>宅配便<br>
        <input type="radio" class="form-check-input" name="how_buy" value="2">郵便<br>
      <input type="hidden" name="buy_check_complete" value="OK"/>
      <br>
      <p>以上の内容で購入しますか？</a><br>
      <button type="submit" class="btn btn-primary" name="btnSubmit" value="購入する">購入する</button>
      </form>
      <br>
      <form action="<?php echo CART; ?>" method="GET">
      <button type="submit" class="btn btn-warning" name="btnSubmit" value="カートに戻る">カートに戻る</button>
      </form>
      <br>
    <br>
  </body>
</html>
