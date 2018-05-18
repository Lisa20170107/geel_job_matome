<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");

//もしitem.php以外からのアクセスがあったら
if(!isset($_GET['data'])){
   echo "アクセスが不正です。トップページへお戻りください。".'<br>';
   echo return_top();;
   exit;
}

//item.phpから商品コードを受け取る
$itemcode=$_GET['data'];

if ($itemcode != "") {
  //受け取った値をエンコードしてURL上でやりとりできるようにする
    $query4url = rawurlencode($itemcode);
    $url = "https://shopping.yahooapis.jp/ShoppingWebService/V1/itemLookup?appid=$appid&itemcode=$query4url&responsegroup=large";
    $xml = simplexml_load_file($url);
    //検索件数が1件の場合,変数$hitsに検索結果を格納する
    if ($xml["totalResultsReturned"] == 1) {
        $hits = $xml->Result->Hit;
    }
}
//sessionに商品の情報を記憶させる
session_start();

// 1商品を連想配列にまとめる
$product = array('code'=>$itemcode, 'name'=>h($hits->Name),'image'=>h($hits->Image->Small), 'price'=>h($hits->Price));

// セッションの商品情報の有無チェック
$prodcuts = array();
if (isset($_SESSION['selects'])) {
  // 既に選んだ商品があるので取り出し
  $products = $_SESSION['selects'];
}
// 商品情報追加
$products[] = $product;

// セッションへ格納
$_SESSION['selects'] = $products;

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
       <p>
         <?php
         ?>
           <img src="<?php echo h($hit->Image->Medium); ?>" /><br>
           <?php echo h($hit->Name); ?><br>
           <li>評価<br><?php echo h($hit->Review->Rate);?></li>
           <li>金額：<?php echo h($hit->Price); ?>円</li>
           <li>商品説明<br><?php echo $hit->Description; ?></li>
           </form>
          以上の商品をカートにいれました。
         </p>
     </div>
     <?php } ?>
     <?php  echo return_top();?>
     <?php  echo return_login();?>
     <a href="<?php echo CART ?>">カートの中身を確認する</a>

   </body>
 </html>
