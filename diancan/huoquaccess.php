<?php 
$url  = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx2a946bc6cf99afbf&secret=75bd1c65b44f8c83be2e98481bd25c15";
  //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);
    //显示获得的数据
    // print_r($data);
    // ->access_token
    $data2 = json_decode($data);
    $token = $data2->access_token;
    return $token;
 ?>