<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");
require_once("../common/dbaccesUtil.php");
session_start();
//もしbuy_confirm.phpからのアクセスでなければログインページへ
if(!isset($_GET['buy_check_complete'])){
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
     //funcrionを利用するための変数
     $itemcode= $hit['code'];
     $UserID=$_SESSION['user_id'];
     $type=$_GET['how_buy'];
     $price=$hit['price'];
     //データのDB挿入処理。エラーの場合のみエラー文がセットされる。成功すればnull
     $result = insert_item($UserID, $itemcode, $type);
     //エラーが発生しなければ表示を行う
     if(!isset($result)){
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
   <?php } }
         //合計金額を更新
         $result2=update_item_profile($sum,$UserID);
         //エラーが発生しなければ表示を行う
         if(!isset($result2)){?>
        <p>合計金額:<?php echo $sum;?>円</p>
         <p>配送方法:<?php echo ex_typenum($type);?></p>
         <p>購入が完了しました。</p>
         <br>
       <?php
       //カート内の情報を破棄する。
       unset($_SESSION['selects']);
      }?><br>
   </body>
 </html>
