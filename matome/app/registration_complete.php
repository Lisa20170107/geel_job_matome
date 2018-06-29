<?php require_once '../common/scriptUtil.php';
      require_once '../common/dbaccesUtil.php'; ?>

<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
      <title>登録結果画面</title>
      <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
      <link rel="stylesheet" href="../css/bootstrap-grid.css" type="text/css" />
</head>
    <body>
      <ol class="breadcrumb fixed-top">
        <li class="breadcrumb-item"><?php echo return_top();?></li>
        <li class="breadcrumb-item"><a href="<?php echo CART; ?>">カートの中身を確認する</a></li>
      </ol>
    <?php
    if(!$_POST['mode']=="RESULT"){
        echo 'アクセスルートが不正です。もう一度トップページからやり直してください<br>';
    }else{

        session_start();
        $name = $_SESSION['name'];
        $password = $_SESSION['password'];
        $mail = $_SESSION['mail'];
        $address = $_SESSION['address'];

        //データのDB挿入処理。エラーの場合のみエラー文がセットされる。成功すればnull
        $result = insert_profiles($name, $password, $mail, $address);

        //エラーが発生しなければ表示を行う
        if(!isset($result)){
        ?>
        <legend>登録結果画面</legend><br>
        <p>名前:<?php echo $name;?></p><br>
        <p>パスワード:<?php echo $password;?></p><br>
        <p>メールアドレス:<?php echo $mail;?></p><br>
        <p>住所:<?php echo $address;?></p><br><br>
        <p>以上の内容で登録しました。</p><br>
        <!--UserIDをセッションに記録させる（購入ページで使用するため）-->
        <?php
        //フォームの値をlogin_profiles();に渡し、レコードを検索する。フォームの値と一致したレコードを配列で取得する。
        $result = login_profiles($name,$password);
        //配列の中の名前の値を繰り返し文で取り出す
        foreach($result as $value){
        //注文記録用
          $_SESSION['user_id'] =$value['UserID'];
        ?>
        <?php
      }}else{
            echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$result;
        }
    }
    ?>
    </body>
</html>
