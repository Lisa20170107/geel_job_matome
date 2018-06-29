<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");

session_start();

$itemcode=$_GET['data'];

//カートに追加したあと、検索結果に戻れるようにするための変数
// 前ページを取得して、セッションに記録する
$before_url= $_SERVER['HTTP_REFERER'];
$_SESSION['before_url_cart']=$before_url;



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
     <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
     <link rel="stylesheet" href="../css/bootstrap-grid.css" type="text/css" />
   </head>
   <body>
     <ol class="breadcrumb fixed-top">
       <li class="breadcrumb-item active"><?php echo return_top();?></li>
       <li class="breadcrumb-item active"><?php  echo return_login();?></li>
     </ol>
     <p><?php echo login_hello(); ?></p>
     <!--繰り返し文で値を取り出す。10件のみ表示させる-->
     <?php
     foreach ($hits as $hit) {
 ?>
<div align="center">
 <div class="col-12 col-md-6">
  <div class="card text-center mb-3">
       <?php
         //ヒットした商品のIDコードを商品詳細ページに引き渡すための変数
         $product_id= h($hit->Code);
         //ヒットした商品のIDコードをurlにエンコードして渡す
         $url2 ="item.php?data=".urlencode($product_id);
         ?>
           <a href="<?=$url2?>">
           <div align="center">
           <img style="margin-top:20px;" src="<?php echo h($hit->Image->Medium); ?>" alt=="Card image"/></a><br>
           </div>
           <div class="card-body">
           <p class="card-text">
           <a href="<?=$url2?>"><?php echo h($hit->Name); ?></a></p><br>
           <ul class="list-group list-group-flush">
           <li class="list-group-item">評価<br><?php echo h($hit->Review->Rate);?></li>
           <li class="list-group-item">金額：<?php echo h($hit->Price); ?>円</li>
           <li class="list-group-item">商品説明<br><?php echo $hit->Description; ?></li>
         </ul>
       </div>
    </div>
   </div>
</div>
           <form action="<?php echo ADD; ?>" method="GET">
             <input type="hidden" name="data" value="<?php echo $_GET['data']; ?>">
               <button type="submit" class="btn btn-primary" name="delete" value="カートに入れる">カートに入れる</button>
           </form>

         </p></ul>
     </div>
     <?php } ?>
   </body>
 </html>
