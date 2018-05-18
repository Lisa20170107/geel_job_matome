<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");
require_once("../common/dbaccesUtil.php");

session_start();

//もしログインしていなければログインページへ
if(!isset($_SESSION['name'])){
   echo "購入履歴を確認するためにはログインが必要です。".'<br>';
   echo '<a href="./login.php">ログイン</a>';
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
      <title>購入履歴</title>
</head>
    <body>
    <h2>購入履歴</h2><br>
    <?php
       //UserIDを受け取る
        $UserID = $_SESSION['user_id'];
       //UserIDでレコードを検索
        $result = serch_item_profiles($UserID);
        //エラーが発生しなければ表示を行う
        if(!empty($result)){
          //繰り返し文でbuy_tテーブルから履歴を取り出す
          foreach($result as $hit){
            //取り出したitemcodeから商品名と画像を取り出す
            $itmecode=$hit['itemCode'];
            if ($itmecode != ""){
              //受け取った値をエンコードしてURL上でやりとりできるようにする
                $query4url = rawurlencode($itmecode);
                $url = "https://shopping.yahooapis.jp/ShoppingWebService/V1/itemLookup?appid=$appid&itemcode=$query4url&responsegroup=medium";
                $xml = simplexml_load_file($url);
                //検索件数が0件でない場合,変数$hitsに検索結果を格納する
                if ($xml["totalResultsReturned"] != 0) {
                    $hits = $xml->Result->Hit;
                }
            }
            //繰り返し文で、yahoo api から商品名と画像を取り出す
            foreach($hits as $hit_2){
        ?>
        <div>
        <ul>
        <img src="<?php echo h($hit_2->Image->Medium); ?>" /><br>
        <li>商品名:<?php echo h($hit_2->Name);?><br></li>
        <li>発送方法:<?php echo ex_typenum($hit['type']);?><br></li>
        <li>購入日時:<?php echo $hit['buyDate'];?><br></li>
        <li>金額:<?php echo h($hit_2->Price);?>円<br></li>
        </div>
        </ul>
        <p>総購入金額:<?php echo $_SESSION['mydata_total'];?>円</p>
        <?php }}}else{
            echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$result; }?>
     <?php  echo return_top();?>
    </body>
</html>
