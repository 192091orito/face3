<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- フォントの読み込み -->
    <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="result.css">

  <title>Document</title>
</head>

<body class="wf-roundedmplus1c">
  <?php
  //POSTで値を取得
  if (isset($_POST['result_data_Q1'])) {
    $result_Q1 = explode(",", $_POST['result_data_Q1']);
    //echo gettype($result_Q1).'/';
  }
  if (isset($_POST['result_data_Q2'])) {
    $result_Q2 = explode(",", $_POST['result_data_Q2']);
    //echo gettype($result_Q2).'/';
  }
  if (isset($_POST['result_data_Q3'])) {
    $result_Q3 = explode(",", $_POST['result_data_Q3']);
    //echo gettype($result_Q3).'/';
  }
  if (isset($_POST['result_data_Q4'])) {
    $result_Q4 = explode(",", $_POST['result_data_Q4']);
    //echo gettype($result_Q4).'/';
  }
  if (isset($_POST['username'])) {
    $username = explode(",", $_POST['username']);
    //echo gettype($username).'/';
  }
  if (isset($_POST['record_random_num'])) {
    $record_random_num = explode(",", $_POST['record_random_num']);
    //echo gettype($record_random_num).'/';
  }
  //テスト用POSTされたサンプルデータ
  // $result_Q1 = [20,30,40];
  // $result_Q2 = [20,30,40];
  // $result_Q3 = [20,30,40];
  // $result_Q4 = [20,30,40];
  // $username = ["Mr.A","Mr.B","Mr.C"];
  // $record_random_num = [0,1,2,3];

  $imgList = array(
    'result_Q1' => $result_Q1,
    'result_Q2' => $result_Q2,
    'result_Q3' => $result_Q3,
    'result_Q4' => $result_Q4,
    'username' => $username,
    'record_random_num' => $record_random_num
  );
  //問題の宣言
  $Question = ["怒りの顔", "うんざりの顔", "怯えた顔","悲しい顔", "驚きの顔", "嬉しい顔"];
  
  ?>
  <script>
    let imgList = JSON.parse('<?php echo json_encode($imgList) ?>');
    //console.log(imgList); //script.jsじゃなくこのconsole.logでも受け取った値を表示可能
    console.log(imgList.result_Q1);
    console.log(imgList.result_Q2);
    console.log(imgList.result_Q3);
    console.log(imgList.result_Q4);
    console.log(imgList.username);
    console.log(imgList.record_random_num);
  </script>

  <table>
    <tbody>
      


      <?php
      for($i=0;$i<count($username);$i++){
        echo'<tr id="Question">';
        echo'<th>'.($i+1).'人目'.$username[$i].'</th>';
          echo'<td class="price" data-label="'.$Question[$record_random_num[0]].'">'.$result_Q1[$i].'点</td>';
          echo'<td class="price" data-label="'.$Question[$record_random_num[1]].'">'.$result_Q2[$i].'点</td>';
          echo'<td class="price" data-label="'.$Question[$record_random_num[2]].'">'.$result_Q3[$i].'点</td>';
          echo'<td class="price" data-label="'.$Question[$record_random_num[3]].'">'.$result_Q4[$i].'点</td>';
        echo'</tr>';
      }
      ?>
    </tbody>
  </table>
</body>

</html>