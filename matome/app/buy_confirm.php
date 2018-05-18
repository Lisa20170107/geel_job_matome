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
  </head>
  <body>
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
    <div>
      <p><ul>
          <img src="<?php echo $hit['image'] ; ?>" /><br>
          名前：<?php echo $hit['name']; ?></a><br>
          金額：<?php echo $hit['price'];?>円
          <!--合計金額-->
          <?php $sum += $hit['price'];?>
        </p></ul>
    </div>
    <?php } ?>
    <p>合計金額:<?php echo $sum;?>円</p>

      <form action="<?php echo BUY_COMPLETE; ?>" method="GET">
        <input type="radio" name="how_buy" value="1" checked>宅配便<br>
        <input type="radio" name="how_buy" value="2">郵便<br>
      <input type="hidden" name="buy_check_complete" value="OK"/>
      <p>以上の内容で購入しますか？</a><br>
      <input type="submit" name="btnSubmit" value="購入する">
      </form>
      <br>
      <form action="<?php echo CART; ?>" method="GET">
      <input type="submit" name="btnSubmit" value="カートに戻る">
      </form>
      <br>
    <?php echo return_top();?><br>
  </body>
</html>
