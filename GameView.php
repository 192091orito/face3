<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>顔認識</title>
  <link rel="stylesheet" href="GameView.css">
  <!-- フォントの読み込み -->
  <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
</head>

<body>
  <!-- ～注意点～〜
・↓のdivタグの中は全てdisplay:noneでコードにのみ表示されるようになってる！
・jsで受け取った値を使うために見えない形で表示させjsでIDを使って値を取得する予定！
・時間があったらもっと楽な方法で値を受け取れる用に改善してね！！
・時間無い、間に合うかな、、、 -->

  <div class="none">
    <?php
    //POSTで値を取得
    if (isset($_POST['username'])) {
      $username = $_POST['username'];
    }
    if (isset($_POST['HowMany'])) {
      $HowMany = $_POST['HowMany'];
    }
    if (isset($_POST['seconds'])) {
      $seconds = $_POST['seconds'];
    }
    // jsファイルで使えるようにオブジェクトにする
    $imgList = array(
      'username' => $username,
      'HowMany' => $HowMany,
      'seconds' => $seconds,
    );
    ?>
  </div>

  <script>
    let imgList = JSON.parse('<?php echo json_encode($imgList) ?>');
    //console.log(imgList); //script.jsじゃなくこのconsole.logでも受け取った値を表示可能
  </script>

  <div id="container">
    <!-- カウントダウンのvideo -->
    <!-- 注意点 iPhone　1,低電力モードでは再生されないかも -->
    <video id="screen" src="CountDownVideo.mp4" width="100%" height="100%" muted playsinline></video>
    <!-- カメラの映像 -->
    <video id="video" width="414" height="736" autoplay></video>
  </div>
  <!-- 初期の表情アイコン -->
  <img src="normal.png" id="face_icon" alt="初期表情アイコン">
  
  <!-- カウントダウンバー -->
  <div id="CountDownBar_area">
    <progress id="CountDownBar" value="0" max="100">0%</progress>
  </div>
  <!-- テキスト -->
  <div id=text_area>
    <!-- ホームアイコン -->
    <a href="index.php" id="home_icon_area"><img src="home_icon.png" id="home_image" alt="ホームボタン"></a>
    <div id="text" class="wf-roundedmplus1c"></div>
    <div id="Question_text" class="wf-roundedmplus1c"></div>
  </div>
  <!-- カウントダウンスタードボタン -->
  <!-- <input type="submit" id="StartButton" value="ゲーム開始!!" size="150px" class="StartButton" onclick="style.display='none';StartButton_onClick()"> -->
  <input type="image" id="StartButton" src="button_image_start.png" onclick="style.display='none';StartButton_onClick()">

  <form action="result.php" method="post" id="result_form">
    <input type="text" name="result_data_Q1" id="result_data_Q1" class="none" value="1">
    <input type="text" name="result_data_Q2" id="result_data_Q2" class="none" value="2">
    <input type="text" name="result_data_Q3" id="result_data_Q3" class="none" value="3">
    <input type="text" name="result_data_Q4" id="result_data_Q4" class="none" value="4">
    <input type="text" name="username" id="username" class="none" value="">
    <input type="text" name="record_random_num" id="record_random_num" class="none" value="">
    <input type="image" src="button_image_result.png" name="to_result" id="to_result" size="150px">
    <!-- <input type="submit" value="送信" name="to_result" id="to_result" size="150px"> -->


  </form>


  <!-- js系ファイルの読み込み -->

  <!-- clmtrackr 関連ファイルの読み込み -->
  <script src="clmtrackr.js"></script>
  <!-- clmtrackr のメインライブラリの読み込み -->
  <script src="model_pca_20_svm.js"></script>
  <!-- 顔モデル（※）の読み込み -->
  <script src="model_pca_20_svm_emotion.js"></script>
  <!-- ★顔モデル（※1）の読み込み -->
  <script src="emotionClassifier.js"></script>
  <!-- ★感情を分類する外部関数の読み込み -->
  <script src="emotionModel.js"></script>
  <!-- scriptファイル読み込み -->
  <script src="script.js"></script>
</body>

</html>