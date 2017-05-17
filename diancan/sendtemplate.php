<?php 
function gettoken(){
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
    echo curl_strerror();
    curl_close($curl);
    //显示获得的数据
    // print_r($data);
    // ->access_token
    $data2 = json_decode($data);
    $token = $data2->access_token;
    return $token;

}
function http_post_data($url, $data_string) {  
  
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_POST, 1);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
            'Content-Type: application/json; charset=utf-8',  
            'Content-Length: ' . strlen($data_string))  
        );  
        ob_start();  
        curl_exec($ch);  
        $return_content = ob_get_contents();  
        ob_end_clean();  
  
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
        return array($return_code, $return_content);  
}  
  
$token2 = gettoken();
$url2 = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$token2;
$qingqiu2 = array(
    "touser"=>"oYHgzv4pw63BN5v2FX1byDGvMG9A",
    "template_id"=>"Z3UermAPXZt6-8WkXBq_MosxzwYSKEHyl0DFmLZmDWE",
    "url"=>"http://www.baidu.com",            
           "data"=>array(
                   "first" => array(
                       "value"=>"商家名称",
                       "color"=>"#173177"
                   ),
                   "keyword1"=>array(
                       "value"=>"20170516185001",
                       "color"=>"#173177"
                   ),
                   "keyword2"=>array(
                       "value"=>"46￥",
                       "color"=>"#173177"
                   ),
                   "keyword3"=>array(
                       "value"=>"24",
                       "color"=>"#173177"
                   ),
                   "keyword4"=>array(
                       "value"=>"现金支付",
                       "color"=>"#173177"
                   ),
                   "remark" => array(
                       "value"=>"感谢您使用剑仙点餐功能",
                       "color"=>"#173177"
                   )
           )

    );  
$data = json_encode($qingqiu2);
  
// list($return_code, $return_content);
$result = http_post_data($url2, $data);  
print_r($result);
 ?>