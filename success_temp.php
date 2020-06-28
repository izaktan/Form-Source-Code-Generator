<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/../../libs/PHPMailer/vendor/autoload.php';
require __DIR__ . '/../../../../sec/email_con.php';
require __DIR__ . '/../../../../sec/pass.php';

$info='<tr>
<td>姓名</td><td>".$question1."</td>
</tr>
<tr>
<td>性别</td><td>".$question2."</td>
</tr>
<tr>
<td>在读学校</td><td>".$question3."</td>
</tr>
<tr>
<td>年级</td><td>".$question4."</td>
</tr>
<tr>
<td>电子邮箱</td><td>".$question5."</td>
</tr>
<tr>
<td>微信号（如使用QQ，请标记为QQ号）</td><td>".$question6."</td>
</tr>
<tr>
<td>你通过什么方式了解到唯理工作坊？</td><td>".$question7."</td>
</tr>
<tr>
<td>是否参加过唯理中国的以下活动？</td><td>".$question8."</td>
</tr>
<tr>
<td>你是否正在中国大陆以外的地区上学，或是否在未来有出国学习的意向？</td><td>".$question9."</td>
</tr>
<tr>
<td>请选择你希望报名的主题工作坊（多选）：</td><td>".$question10."</td>
</tr>
<tr>
<td>请简述你报名主题工作坊的原因：</td><td>".$question11."</td>
</tr>
<tr>
<td>Textarea Question 2</td><td>".$question12."</td>
</tr>
</table>';
$connection = mysqli_connect($host, $user, $pass, $db) or die("Unable to connect!");
$question1 = mysqli_real_escape_string($connection, $question1);
$question2 = mysqli_real_escape_string($connection, $question2);
$question3 = mysqli_real_escape_string($connection, $question3);
$question4 = mysqli_real_escape_string($connection, $question4);
$question5 = mysqli_real_escape_string($connection, $question5);
$question6 = mysqli_real_escape_string($connection, $question6);
$question7 = mysqli_real_escape_string($connection, $question7);
$question8 = mysqli_real_escape_string($connection, $question8);
$question9 = mysqli_real_escape_string($connection, $question9);
$question10 = mysqli_real_escape_string($connection, $question10);
$question11 = mysqli_real_escape_string($connection, $question11);
$question12 = mysqli_real_escape_string($connection, $question12);
mysqli_set_charset($connection,"utf8");
date_default_timezone_set("Asia/Shanghai");
$time = date("Y-m-d h:i:sa");
$sql = "INSERT INTO TABLE_NAME
INSERT INTO TABLE_NAME
(`question1`, `question2`, `question3`, `question4`, `question5`, `question6`, `question7`, `question8`, `question9`, `question10`, `question11`, `question12`) 
VALUES
('$question1', '$question2', '$question3', '$question4', '$question5', '$question6', '$question7', '$question8', '$question9', '$question10', '$question11', '$question12')";
mysqli_query($connection, $sql);
    /*		if (mysqli_query($connection, $sql)) {
        echo "提交成功";
        } else {
        echo "Error: " . $sql . "" . mysqli_error($connection);
        }*/
$connection->close(); 
    