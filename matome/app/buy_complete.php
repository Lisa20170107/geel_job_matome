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
   </head>
   <body>
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
     <div>
       <p><ul>
           <img src="<?php echo $hit['image'] ; ?>" /><br>
           名前：<?php echo $hit['name']; ?></a><br>
           金額：<?php echo $hit['price'];?>円
           <!--合計金額-->
           <?php $sum += $hit['price'];?>
         </p></ul>
     </div>
   <?php } }
         //合計金額を更新
         $result2=update_item_profile($sum,$UserID);
         //エラーが発生しなければ表示を行う
         if(!isset($result2)){?>
         <p>合計金額:<?php echo $sum;?>円</p>
         <p>配送方法:<?php echo ex_typenum($type);?></p>
         <!-- 合計金額を更新-->
         <?php update_item_profile($sum,$UserID); ?>
         <p>購入が完了しました。</a>
         <br>
       <?php }echo return_top();?><br>
   </body>
 </html>
