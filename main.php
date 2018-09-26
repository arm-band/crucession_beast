<?php
require_once(__DIR__ . "/extendsMastodon.php");
$t = new mediaMastodon('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'); //function.phpの拡張したクラス。コンストラクタでtoken_accessを受け付け、メディア送信に備える
$t->setMastodonDomain("mstdn.jp"); //設定したインスタンスを入力
$t->setCredentials([
    "client_id" => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    "client_secret" => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    "bearer" => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' //上と重複しているが、テキストトゥートの認可のためにもう一度access_token記述
]);

$response = $t->PostMedia( __DIR__ . DIRECTORY_SEPARATOR . 'PATH/TO/IMG.jpg'); //画像をサーバに送信、レスポンスのjsonを取得
var_dump($response);
$statusses = $t->postStatuses("テスト #テスト", $response['id']); //レスポンス中に含まれている画像のidをパラメータに含めた形でトゥート
var_dump($statusses);