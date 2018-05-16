<?php
 require_once '../common/defineUtil.php';
//よく使うユーザー定義関数をまとめる場所


//取得したアプリケーションIDを設定（Yahoo!ショッピングWeb API
$appid = "********";


//トップへ戻る
   function return_top(){
       return "<a href='".TOP_URL."'>トップへ戻る</a>";
   }

//loginページへいく
   function return_login(){
       return "<a href='".LOGIN."'>ログイン/ログアウト</a>";
   }


  //フォームの再入力時に、すでにセッションに対応した値があるときはその値を返却する
   function form_value($name){
       if(isset($_POST['mode']) && $_POST['mode']=='REINPUT'){
           if(isset($_SESSION[$name])){
               return $_SESSION[$name];
           }
       }
   }



//ポストからセッションに存在チェックしてから値を渡す。
//二回目以降のアクセス用に、ポストから値の上書きがされない該当セッションは初期化する

   function bind_p2s($name){
       if(!empty($_POST[$name])){
           $_SESSION[$name] = $_POST[$name];
           return $_POST[$name];
       }else{
           $_SESSION[$name] = null;
           return null;
       }
   }


//htmlspecialchars()を使いやすくするための関数。
 function h($str)
 {
   return htmlspecialchars($str, ENT_QUOTES);
 }

//種別番号から実際の種別名を返却する
 function ex_typenum($type){
     switch ($type){
         case 1;
             return "宅配便";
         case 2;
             return "郵便";
     }
 }


 ?>
