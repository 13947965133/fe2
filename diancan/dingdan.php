<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dc";
$dingid = $_POST['id']; 
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}  
$sql = "SELECT * FROM imp where dingId=".$dingid." ";
$result = $conn->query($sql);
 echo $result;
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        $ding1= $row["dingId"];
        $ding2= $row["shangName"];
        $ding3= $row["zhId"];
        $ding4= $row["Mid"];
        $ding5= $row["dingStat"];
        $ding6= $row["time"];
    }
} else {
    echo "0 结果";
}
$conn->close();
?>
<html ng-app="ionicApp">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
        <title><?php echo $ding2; ?></title>
        <link rel="stylesheet" type="text/css" href="./ionic.css">
        <script src="./jquery.min.js" charset="utf-8"></script>
        <!-- <link href="https://cdn.bootcss.com/ionic/1.3.2/css/ionic.css" rel="stylesheet"> -->
        <!-- <script src="https://cdn.bootcss.com/ionic/1.3.2/js/ionic.bundle.min.js"></script> -->
    </head>
    <body>

    <div class="bar bar-header">
      <div class="h1 title"><?php  echo $ding3; ?></div>
    </div>

    <div class="content has-header">

      <div class="card">
        <div class="item item-text-wrap">
      <ul class="list">


      </ul>

        </div>
      </div>

    </div>
    <script type="text/javascript">
    $(document).ready(function(){
      list = [
  {
    "id": 1,
    "name": "麻辣烫",
    "num": 2,
    "jiage": 15
  },
  {
    "id": 2,
    "name": "火锅",
    "num": 2,
    "jiage": 15
    }];
    var mid = "<?php echo  $ding1; ?>";
    var fkzt = "<?php echo $ding5; ?>";
    var ssj = "<?php  echo $ding6; ?>";
    var jine = "<?php echo $ding4; ?>";
        $("li").click(function(){
            $(this).hide();
        });
        function init(){
          $("ul").append('<li class="item">订单编号:'+mid+'</li>');
          $("ul").append('<li class="item">时间:'+ssj+'</li>');

    //       $.post("/getdingdan.php",
    // {
    //     id:"2017051602539",
    // },
    //     function(data,status){
    //       alert(data);
    //       for (var i = 0; i <list.length; i++) {
    //         var str = '<li class="item">'+list[i].name+'X2</li>';
    //         $("ul").append(str);
    //       }
    // });

          $("ul").append('<li class="item">支付状态:'+fkzt+'</li>');
          $("ul").append('<li class="item">消费金额:'+jine+'</li>');
        }
        init();
    });
    </script>
  </body>
</html>