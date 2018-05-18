<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");

session_start();

//検索結果を配列にする
$hits = array();

//受け取った値を変数にする
$query = $_GET["keyword"];

//検索が未入力だった場合、トップページへ誘導する
if(empty($query)){
  echo "キーワードが未入力です。トップページから検索し直してください。".'<br>';
  echo return_top();
  exit;
}

//foreach文用の変数
$i = 0;

if ($query != "") {
  //受け取った値をエンコードしてURL上でやりとりできるようにする
    $query4url = rawurlencode($query);
    $url = "https://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch?appid=$appid&query=$query4url";
    $xml = simplexml_load_file($url);
    //検索件数が0件でない場合,変数$hitsに検索結果を格納する
    if ($xml["totalResultsReturned"] != 0) {
        $hits = $xml->Result->Hit;
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>かごゆめ</title>
    <meta http-equiv="content-type" charset="utf-8">
  </head>
  <body>
    <p><?php echo login_hello(); ?></p>
    <!--繰り返し文で値を取り出す。10件のみ表示させる-->
    <?php
    foreach ($hits as $hit) {
      if($i >= 10){
        break;
      } ?>
    <div>
      <p><ul>
        <?php //ヒットした商品のIDコードを商品詳細ページに引き渡すための変数
        $product_id= h($hit->Code);

        //ヒットした商品のIDコードをurlにエンコードして渡す
        $url2 ="item.php?data=".urlencode($product_id);
        echo $product_id;
        ?>
          <a href="<?=$url2?>">
            <img src="<?php echo h($hit->Image->Medium); ?>" /></a><br>
          <a href="<?=$url2?>"><?php echo h($hit->Name); ?></a><br>
          <li>金額：<?php echo h($hit->Price); ?>円</li>
          <li>商品ID：<?php echo h($hit->Code);?></li>
          <li>商品ID：<?php echo h($hit->Description);?></li>
          <?php $i++ ;?>
        </p></ul>
    </div>
    <?php } ?>
    <?php  echo return_login();?>
    <?php echo return_top();?>
  </body>
</html>
