<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");

session_start();

//検索結果を配列にする
$hits = array();

//受け取った値を変数にする
$query = $_GET["keyword"];
$category_id_url = $_GET["category_id"];
$sort4url_url = $_GET["sort"];


//検索が未入力だった場合、トップページへ誘導する
if(empty($query)){
  echo "キーワードが未入力です。トップページから検索し直してください。".'<br>';
  echo return_top();
  exit;
}

//foreach文用の変数
$i = 0;

//ページ送り用
if(empty($_GET['page'])){
  $offset=0;
}
else{
   $offset=$_GET['page'];
}

if ($query != "") {
  //受け取った値をエンコードしてURL上でやりとりできるようにする
  //offsetは何件目から表示させるかを操作する（デフォルトは0から）
    $query4url = rawurlencode($query);
    $category_id = rawurlencode($category_id_url);
    $sort4url = rawurlencode($sort4url_url);
    $url = "https://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch?appid=$appid&query=$query4url&category_id=$category_id&sort=$sort4url&hits=50&offset=$offset";
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
    <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="../css/bootstrap-grid.css" type="text/css" />
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  </head>
  <body>
    <ol class="breadcrumb fixed-top">
      <li class="breadcrumb-item active"><?php echo return_top();?></li>
      <li class="breadcrumb-item active"><?php  echo return_login();?></li>
    </ol>
    <p><?php echo login_hello(); ?></p>
    <!--件数を表示する-->
    <p><?php echo $offset+1 ;?>件～<?php echo $offset+10 ;?>件を表示</p>
    <!-- もしも検索数が0の場合-->
    <?php
    $cnt = count($hits);
    if($cnt==0){
      echo "ヒット件数は0です。条件を変えてお試しください。";
    }
    ?>

    <!--繰り返し文で値を取り出す。10件のみ表示させる-->
    <?php
    foreach ($hits as $hit) {
      if($i >= 10){
        break;}?>
      <div align="center">
      <div class="col-12 col-md-6">
        <div class="card text-center mb-3">
            <?php //ヒットした商品のIDコードを商品詳細ページに引き渡すための変数
        $product_id= h($hit->Code);

        //ヒットした商品のIDコードをurlにエンコードして渡す
        $url2 ="item.php?data=".urlencode($product_id);
        ?>

          <a href="<?=$url2?>">
          <div align="center" >
          <img style="margin-top:20px;" src="<?php echo h($hit->Image->Medium); ?>" alt=="Card image" /></a><br>
          </div>
          <div class="card-body">
          <p class="card-text">
          <a href="<?=$url2?>"><?php echo h($hit->Name); ?></a></p><br>
          <ul class="list-group list-group-flush">
          <li class="list-group-item">金額：<?php echo h($hit->Price); ?>円</li>
          <li class="list-group-item">商品ID：<?php echo h($hit->Code);?></li>
          <li class="list-group-item">商品ID：<?php echo h($hit->Description);?></li>
        </ul>
        <?php $i++ ;?>
    </div>
    </div>
   </div>
 </div>
<?php } $item_i=$i; ?>
    <!--ページ送り-->
    <?php
    //$_GET['page']の初期値設定
    if(empty($_GET['page'])){
      $_GET['page']=0;
    }
    //商品が10以上だった場合、ページ送りを表示させる（戻る）
    if($offset>9){?>
      <a href="http://localhost/matome_css/app/search.php?page=<?php echo $offset-10; ?>&keyword=<?php echo h($query); ?>&category_id=<?php echo h($category_id); ?>&sort=<?php echo h($sort4url); ?>">戻る</a>
    <?php }
    //商品が10以上だった場合、ページ送りを表示させる
    if($item_i>9){?>
      <!--URLを利用してGETで値を渡す-->
      <!-- $offsetは前回の値を覚えているため、+10をすることで、表示件数を操作する-->
      <a href="http://localhost/matome_css/app/search.php?page=<?php echo $offset+10; ?>&keyword=<?php echo h($query); ?>&category_id=<?php echo h($category_id); ?>&sort=<?php echo h($sort4url); ?>">次へ</a>

  <?php   }  ?>
  <!--JavaScriptでページのトップへ戻るボタンを表示-->
<p id="page-top"><a href="#">PAGE TOP</a></p>


  </body>
</html>
