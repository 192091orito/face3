<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- フォントの読み込み -->
    <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
  <title>ゲーム</title>
  <link rel="stylesheet" href="index.css">
    <link rel="manifest" href="manifest.json">
</head>

<body class="wf-roundedmplus1c">
  <form action="GameView.php" method="post">
    <div class="Form">
      <div class="Form-Item">
        <p class="Form-Item-Label">
          <span class="Form-Item-Label-Required">必須</span>ユーザー名
        </p>
        <br\>
          <div id="ue">
            <input type="text" name="username[]" class="Form-Item-Input" id="a" padding: 5px; placeholder="例）山田太郎">
            <br\>
          </div>
          <p> </p>
          <br\>
            <input type="text" name="username[]" class="Form-Item-Input" id="b" padding: 5px; placeholder="例）鈴木次郎">
            <br\>
              <br\>
                <p> </p>
                <input type="text" name="username[]" class="Form-Item-Input" id="c" padding: 5px; placeholder="例）田中三郎">
                <br\>
      </div>
      <div class="Form-Item">
        <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>人数</p>
        <br\>
          <input id="radio1" class="radiobutton" name="HowMany" type="radio" value="1" onclick="func1()" checked />
          <label for="radio1">1人</label>
          <br\>
            <input id="radio2" class="radiobutton" name="HowMany" type="radio" value="2" onclick="func2()" />
            <label for="radio2">2人</label>
            <br\>
              <input id="radio3" class="radiobutton" name="HowMany" type="radio" value="3" onclick="func3()" />
              <label for="radio3">3人</label>
      </div>


      <div class="Form-Item">
        <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>制限時間</p>
        <br\>
          <input id="radio4" class="radiobutton" name="seconds" type="radio" value="3" />
          <label for="radio4">3秒</label>
          <br\>
            <input id="radio5" class="radiobutton" name="seconds" type="radio" value="5" />
            <label for="radio5">5秒</label>
            <br\>
              <input id="radio6" class="radiobutton" name="seconds" type="radio" value="10" />
              <label for="radio6">10秒</label>
      </div>

      <input type="submit" class="Form-Btn" value="プレイ">
    </div>
  </form>
</body>
<script>
  document.getElementById("a").style.display = "block";
  document.getElementById("b").style.display = "none";
  document.getElementById("c").style.display = "none";

  function func1() {
    document.getElementById("a").style.display = "block";
    document.getElementById("b").style.display = "none";
    document.getElementById("c").style.display = "none";
  }
  function func2() {
    document.getElementById("a").style.display = "block";
    document.getElementById("b").style.display = "block";
    document.getElementById("c").style.display = "none";
  }

  function func3() {

    document.getElementById("b").style.display = "block";
    document.getElementById("c").style.display = "block";
    document.getElementById("a").style.display = "block";
  }
  
     if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('service_worker.js').then(function(registration) {
        console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }).catch(function(err) {
        console.log('ServiceWorker registration failed: ', err);
    });
    }

// スクロール出来ないようにする
document.addEventListener('touchmove', TouchMove, { passive: false });
function TouchMove(event) {
    event.preventDefault();
}
</script>

</html>