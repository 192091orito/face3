//// 要素の宣言集　ここから
var video = document.getElementById("video");
// 一定間隔で処理を行うintervalのIDを保持
var intervalID;
var count_video = document.getElementById("screen");
var CountDownBar_value = 0;
//一回一回、感情ごとの値を入れる。
var score = [0, 0, 0, 0, 0, 0];
//結果を入れる２次元配列
var result_data = []
    // result_dataの構造
    // result_data = [[1問目1人目,1問目2人目,30],[2問目1人目,30,30],[30,30,30],[30,30,30]]
    // result_data = [[30,30,30],[30,30,30],[30,30,30],[30,30,30]]
    //1問目の値を一時保存する配列
var one_time_save = [];
//問題番号
var q_number = 0;
//問題を解いた人をカウントする
var q_count = 0;
//問題の宣言
Question = ["怒りの顔", "うんざりの顔", "怯えた顔",
    "悲しい顔", "驚きの顔", "嬉しい顔"
];
//解いた問題の番号（result.phpで使う）
var record_random_num = [];
//最初の問題用のランダム（最初の1回しか使わない）
var random_num = Math.floor(Math.random() * 6); //0~5までの数が表示される
//result.phpで使う
record_random_num.push(random_num);
console.log("record_random_num: " + record_random_num);
//POSTされたデータを取得
console.log(imgList); //取得したデータの中身確認用
//POSTデータから人数データを貰う
var HowMany = Number(imgList.HowMany);
//POSTデータから秒数データを貰う
var seconds = Number(imgList.seconds);
//POSTデータからユーザー名を貰う
var username = imgList.username;
//人数によってusernameを宣言する
var username1, username2, username3 = "";
switch (HowMany) {
    case 3:
        username3 = username[2];
    case 2:
        username2 = username[1];
    case 1:
        username1 = username[0];
        break;
}
switch (HowMany) {
    case 3:
        document.getElementById("username").value = [username1, username2, username3];
        break;
    case 2:
        document.getElementById("username").value = [username1, username2];
        break;
    case 1:
        document.getElementById("username").value = [username1];
        break;
}
//スタートを押していないのに感情アイコンが変わったり、ゲームデータを取得するのを防ぐ
//0は停止　1は起動
var showEmotionData_switch = 0;
//// 要素の宣言集　ここまで

// iPhoneで使用するのに必要
video.setAttribute('autoplay', '');
video.setAttribute('muted', '');
video.setAttribute('playsinline', '');
// getUserMedia によるカメラ映像の取得
var media = navigator.mediaDevices.getUserMedia({
    video: { facingMode: "user" }, // カメラの映像を使う（スマホならインカメラ）
    audio: false // マイクの音声は使わない
});
media.then((stream) => { // メディアデバイスが取得できたら
    video.srcObject = stream; // video 要素にストリームを渡す
});

// clmtrackr の開始
var tracker = new clm.tracker(); // tracker オブジェクトを作成
tracker.init(pModel); // tracker を所定のフェイスモデル（※）で初期化
tracker.start(video); // video 要素内でフェイストラッキング開始

// 感情分類の開始
var classifier = new emotionClassifier(); // ★emotionClassifier オブジェクトを作成
classifier.init(emotionModel); // ★classifier を所定の感情モデル（※2）で初期化

// drawLoop 関数をトリガー
drawLoop();

//CountDownVideoが終わったら値をリセット
count_video.addEventListener('ended', (event) => {
    //1秒ごとにバーを伸ばす（1000ミリ秒=1秒）
    //1秒（1000ミリ秒）ごとにupdate_CountDownBar()を実行している
    intervalID = setInterval("update_CountDownBar()", 1000);
});

//スクロール禁止設定
document.addEventListener('touchmove', TouchMove, { passive: false });


//// function集　ここから
// 感情データの表示
function showEmotionData(emo) {
    var str = "";
    var max_value = 0;
    var max_emotion = "";

    console.log("showEmotionData_switch:" + showEmotionData_switch);
    if (showEmotionData_switch == 1) {
        // 全ての感情（6種類）について
        for (var i = 0; i < emo.length; i++) {
            // 感情名+感情の程度（小数第一位まで）
            str += emo[i].emotion + ": " + emo[i].value.toFixed(1) * 100 + '%' + "<br>";
            // それぞれの感情の値が前回より大きかったら更新する（感情６種類）
            if (score[i] < emo[i].value.toFixed(1) * 100) {
                score[i] = emo[i].value.toFixed(1) * 100;
                // console.log("score[" + i + "]: " + score[i]);
            }
            // 感情アイコン切り替えのための最高値を取得
            if (max_value < emo[i].value.toFixed(1) * 100) {
                max_value = emo[i].value.toFixed(1) * 100;
                max_emotion = emo[i].emotion;
            }
        }
        // 一番高い値とその感情をconsoleに表示
        //console.log("max_value:" + max_value);
        //console.log("max_emotion:" + max_emotion);
        // 値が一番高い感情のアイコンに切り替える
        switch (max_emotion) {
            case 'happy':
                //console.log("happy");
                document.getElementById("face_icon").src = "happy.png";
                break;
            case 'sad':
                //console.log("sad");
                document.getElementById("face_icon").src = "sad.png";
                break;
            case 'surprised':
                //console.log("surprised");
                document.getElementById("face_icon").src = "surprised.png";
                break;
            case 'angry':
                //console.log("angry");
                document.getElementById("face_icon").src = "angry.png";
                break;
            case 'disgusted':
                //console.log("disgusted");
                document.getElementById("face_icon").src = "disgusted.png";
                break;
            case 'fear':
                //console.log("fear");
                document.getElementById("face_icon").src = "fear.png";
                break;
        }
    } else if (showEmotionData_switch == 0) {
        document.getElementById("face_icon").src = "normal.png";
    }

}

//カウントダウンスタートボタンを押すと起動
function StartButton_onClick() {
    CountDownBar_value = 0;
    //カウントダウンバーを初期化する
    document.getElementById("CountDownBar").value = 0;
    //StartButtonのsrcを変える
    document.getElementById("StartButton").src = "button_image_next.png";
    //scoreを初期化
    score = [0, 0, 0, 0, 0, 0];
    var v = document.getElementById('screen');
    // カウントダウンvideoを再生する
    v.play();
    //5000=5秒後
    setTimeout('showEmotionData_switch = 1', 5000);
    //if 問題を切り替えるか
    if (q_count >= HowMany) {
        console.log("q_count >= HowMany⇨⇨⇨" + q_count + ">=" + HowMany);
        q_number += 1;
        q_count = 0;
        //結果をresult_dataにpushしてone_time_saveを初期化
        result_data.push(one_time_save);
        one_time_save = [];
        var a = 0;
        while (a == 0) {
            random_num = Math.floor(Math.random() * 6); //0~5までの数が表示される
            for (var b in record_random_num) {
                console.log("b:" + b + "--random_num:" + random_num);
                if (random_num == b) {
                    a = 0;
                    break;
                }
                a = 1;
            }
        }
        //result.phpで使う
        record_random_num.push(random_num);
        console.log("record_random_num: " + record_random_num);
    }
    //問題を表示
    if (q_count + 1 == 1) {
        document.getElementById("text").innerText = String(q_number + 1) + "問目 " +
            username1;
        document.getElementById("Question_text").innerHTML = "「" + Question[random_num] + "」";
    }
    if (q_count + 1 == 2) {
        document.getElementById("text").innerText = String(q_number + 1) + "問" +
            username2;
        document.getElementById("Question_text").innerHTML = "「" + Question[random_num] + "」";

    }
    if (q_count + 1 == 3) {
        document.getElementById("text").innerText = String(q_number + 1) + "問" +
            username3;
        document.getElementById("Question_text").innerHTML = "「" + Question[random_num] + "」";

    }
}

// プログレスバーを更新する
function update_CountDownBar() {
    // プログレスバーの進捗値を更新し、プログレスバーに反映させる
    CountDownBar_value += 1;
    //バーを伸ばすための値↓
    //↓ POSTされた秒数でバーをいっぱいにするために1秒ごとに増えるメモリを表す（端数は切り上げ）
    var memori = Math.ceil(100 / seconds);
    //console.log("seconds:" + seconds);
    //console.log("memori:" + memori);
    document.getElementById("CountDownBar").value = CountDownBar_value * memori;
    document.getElementById("CountDownBar").innerText = CountDownBar_value + "%";
    // CountDownBarが最大値になったら終了
    //  1秒ごとにupdate_CountDownBar()が実行され、CountDownBar_valueが1増えるから
    // 下のifで終了させる制御が出来る
    if (CountDownBar_value == seconds) {
        showEmotionData_switch = 0;
        // CountDownBarを停止させ、CountDownVideoをリセットしてる
        clearInterval(intervalID);

        //scoreを記録
        //result_dataの構造
        //result_data[q_number(問題番号)][q_count(何人目か)]→ここにお題になっている感情の最大値を格納する
        //score[random_num]にはゲームでの感情ごとの最大値が入っている
        console.log("random_num: " + random_num);
        for (a = 0; a < score.length; a++) {
            console.log("score[" + a + "]:" + score[random_num]);
        }

        // result_data[q_number][q_count] = score[random_num];
        one_time_save.push(score[random_num]);
        //display:noneの解除かな？
        document.getElementById("StartButton").style.display = "";
        q_count += 1;

        //結果発表ページへ切り替え
        if (q_number >= 3 && q_count >= HowMany) {
            //すぐ上で解除してしまったのでnoneを上書きする
            document.getElementById("StartButton").style.display = "none";
            document.getElementById("to_result").style.display = "inline-block";
            //結果をresult_dataにpush
            result_data.push(one_time_save);
            //result.phpで使う
            // record_random_num.push(random_num);
            //結果送信フォームにデータを入れる
            for (var a = 0; a < 4; a++) {
                document.getElementById("result_data_Q" + String(a + 1)).value = result_data[a];
            }
            document.getElementById("record_random_num").value = record_random_num;
            // テスト結果表示用
            for (a = 0; a < q_number; a++) {
                for (b = 0; b < q_count; b++) {
                    console.log("result_data[" + a + "][" + b + "]" + result_data[a][b]);
                }
            }
        }
        console.log("update_CountDownBar()　終了");
    }
}

// 繰り返し、顔の位置からパラメータを取得する
function drawLoop() {
    // drawLoop 関数を繰り返し実行
    requestAnimationFrame(drawLoop);
    // 顔部品の現在位置の取得
    var positions = tracker.getCurrentPosition();
    // 現在の顔のパラメータを取得
    var parameters = tracker.getCurrentParameters();
    // そのパラメータから感情を推定して emotion に結果を入れる
    var emotion = classifier.meanPredict(parameters);
    // 感情データを表示
    showEmotionData(emotion);
}

// スクロール出来ないようにする
function TouchMove(event) {
    event.preventDefault();
}

//// function集　ここまで