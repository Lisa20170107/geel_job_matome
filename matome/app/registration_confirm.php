<?php require_once '../common/defineUtil.php';
      require_once '../common/scriptUtil.php';

session_start();

//ポストの存在チェックとセッションに値を格納しつつ、連想配列にポストされた値を格納
$confirm_values = array(
                        'name' => bind_p2s('name'),
                        'password' => bind_p2s('password'),
                        'mail' =>bind_p2s('mail'),
                        'address' =>bind_p2s('address'),
                      )

?>
<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
      <title>登録確認画面</title>
      <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
      <link rel="stylesheet" href="../css/bootstrap-grid.css" type="text/css" />
</head>
  <body>
    <ol class="breadcrumb fixed-top">
      <li class="breadcrumb-item"><?php echo return_top();?></li>
      <li class="breadcrumb-item"><a href="<?php echo CART; ?>">カートの中身を確認する</a></li>
    </ol>
    <?php
    //入力画面から「確認画面へ」ボタンを押した場合のみ処理を行う
    if(!$_POST['mode']=="CONFIRM"){
        echo 'アクセスルートが不正です。もう一度トップページからやり直してください<br>';
    }else{

        //1つでも未入力項目があったら表示しない
        if(!in_array(null,$confirm_values, true)){
            ?>
            <legend>登録確認画面</legend><br>
            <p>名前：<?php echo $confirm_values['name'];?></p><br>
            <p>パスワード：<?php echo $confirm_values['password'];?></p><br>
            <p>メールアドレス：<?php echo $confirm_values['mail'];?></p><br>
            <p>住所：<?php echo $confirm_values['address'];?></p><br><br>

            <p>上記の内容で登録します。よろしいですか？</p>

            <form action="<?php echo REGISTRATION_RESULT ?>" method="POST">
                <input type="hidden" name="mode" value="RESULT" >
                <button type="submit" class="btn btn-primary" name="yes" value="はい">はい</button>
            </form>
            <br>
            <?php
        }else {
            ?>
            <h1>入力項目が不完全です</h1><br>
            再度入力を行ってください<br>
            <h3>不完全な項目</h3>
            <?php
            //連想配列内の未入力項目を検出して表示
            foreach ($confirm_values as $key => $value){
                if($value == null){
                    if($key == 'name'){
                        echo '名前';
                    }
                    if($key == 'password'){
                        echo 'パスワード';
                    }
                    if($key == 'mail'){
                        echo 'メールアドレス';
                    }
                    if($key == 'address'){
                        echo '住所';
                    }
                    echo 'が未記入です<br>';
                }
            }
        }
        ?>
        <form action="<?php echo REGISTRATION ?>" method="POST">
            <input type="hidden" name="mode" value="REINPUT" >
            <button type="submit" class="btn btn-warning" name="no" value="登録画面に戻る">登録画面に戻る</button>
        </form>
        <?php
    }
    ?>
</body>
</html>
