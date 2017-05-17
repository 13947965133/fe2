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
$sql = "SELECT dingNum FROM imp where dingId=".$dingid." ";
$result = $conn->query($sql);
 
if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        echo  $row["dingNum"];
    }
} else {
    echo "0 结果";
}
$conn->close();
?>