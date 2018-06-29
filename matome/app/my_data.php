<?php
require_once("../common/defineUtil.php");
require_once("../common/scriptUtil.php");
require_once("../common/dbaccesUtil.php");

session_start();

//もしログインしていなければログインページへ
if(!isset($_SESSION['name'])){
   echo "会員情報を確認するためにはログインが必要です。".'<br>';
   echo '<a href="./login.php">ログイン</a>';
   exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
      <title>会員情報</title>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
      <link rel="stylesheet" href="../css/bootstrap-grid.css" type="text/css" />
</head>
    <body>
      <ol class="breadcrumb fixed-top">
        <li class="breadcrumb-item"><?php  echo return_top();?></li>
        <li class="breadcrumb-item active"><a href="<?php echo MY_HISTORY;?>">購入履歴</a></li>
        <li class="breadcrumb-item"><a href="<?php echo MY_UPDATE;?>">会員情報更新</a></li>
        <li class="breadcrumb-item"><a href="<?php echo MY_DELETE;?>">退会する</a></li>
      </ol>
    <?php
       //UserIDを受け取る
        $UserID = $_SESSION['user_id'];
       //UserIDでレコードを検索
        $result = serch_profiles($UserID);
        //エラーが発生しなければ表示を行う
        if(!empty($result)){
          foreach($result as $hit){
          //セッションに記録させる
          $_SESSION['name']=$hit['name'];
          $_SESSION['password']=$hit['password'];
          $_SESSION['mail']=$hit['mail'];
          $_SESSION['address']=$hit['address'];

        ?>
        <h4>会員情報</h4>
        <table class="table table-hover table-bordered">
        <tr class="table-primary">
        <thead>
        <td>名前</td>
        <td>パスワード</td>
        <td>メールアドレス</td>
        <td>住所</td>
        <td>総購入金額</td>
        </thead>
        </tr>
        <tbody>
        <tr class="table-light">
        <td><?php echo $hit['name'];?></td>
        <td><?php echo $hit['password'];?></td>
        <td><?php echo $hit['mail'];?></td>
        <td><?php echo $hit['address'];?></td>
        <!--セッションに総購入金額を記録させる-->
        <?php $_SESSION['mydata_total']=$hit['total'];?>
        <td><?php echo $hit['total'];?>円</td>
        </tr>
      </tbody>
      </table>
        <?php
        }}else{
            echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$result;
        }?>
    </body>
</html>
