<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");

session_start();

$itemcode=$_GET['data'];

if ($itemcode != "") {
  //受け取った値をエンコードしてURL上でやりとりできるようにする
    $query4url = rawurlencode($itemcode);
    $url = "https://shopping.yahooapis.jp/ShoppingWebService/V1/itemLookup?appid=$appid&itemcode=$query4url&responsegroup=medium";
    $xml = simplexml_load_file($url);
    //検索件数が1件の場合,変数$hitsに検索結果を格納する
    if ($xml["totalResultsReturned"] == 1) {
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
 ?>
     <div>
       <p><ul>
         <?php
         //ヒットした商品のIDコードを商品詳細ページに引き渡すための変数
         $product_id= h($hit->Code);
         //ヒットした商品のIDコードをurlにエンコードして渡す
         $url2 ="item.php?data=".urlencode($product_id);
         ?>
           <a href="<?=$url2?>">
             <img src="<?php echo h($hit->Image->Medium); ?>" /></a><br>
           <a href="<?=$url2?>"><?php echo h($hit->Name); ?></a><br>
           <li>評価<br><?php echo h($hit->Review->Rate);?></li>
           <li>金額：<?php echo h($hit->Price); ?>円</li>
           <li>商品説明<br><?php echo $hit->Description; ?></li>
           <form action="<?php echo ADD; ?>" method="GET">
             <input type="hidden" name="data" value="<?php echo $_GET['data']; ?>">
               <input type="submit" name="delete" value="カートに入れる">
           </form>

         </p></ul>
     </div>
     <?php } ?>
     <?php  echo return_top();?>
     <?php  echo return_login();?>
   </body>
 </html>
