<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/../../libs/PHPMailer/vendor/autoload.php';
require __DIR__ . '/../../../../sec/email_con.php';
require __DIR__ . '/../../../../sec/pass.php';
require __DIR__ . '/../../libs/google-api-php-client/vendor/autoload.php';

	$pot = $_POST['pot'];
	if (!empty($pot)) {
		return false;
	}

	$fullname = $_POST['fullname'];
	$emailaddress = $_POST['emailaddress'];
	$school = $_POST['school'];
	$grade = $_POST['grade'];
	$major = $_POST['major'];
	$interest = $_POST['interest'];
	$theme = $_POST['theme'];
	$free_time = $_POST['free_time'];
	

if (empty($fullname) || empty($emailaddress) || empty($school) || empty($grade) || empty($major) || empty($interest) || empty($theme) || empty($free_time)) {
    echo '你的问题回答不完整，请返回完善后再提交。';
    return false;
}

if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	//ip from share internet
	$ip = $_SERVER['HTTP_CLIENT_IP'];
}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	//ip pass from proxy
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else{
	$ip = $_SERVER['REMOTE_ADDR'];
}

$connection = mysqli_connect($host, $user, $pass, $db) or die("Unable to connect!");  

$fullname = mysqli_real_escape_string($connection,$fullname);
$emailaddress = mysqli_real_escape_string($connection,$emailaddress);
$school = mysqli_real_escape_string($connection,$school);
$grade = mysqli_real_escape_string($connection,$grade);
$major = mysqli_real_escape_string($connection,$major);
$interest = mysqli_real_escape_string($connection,$interest);
$theme = mysqli_real_escape_string($connection,$theme);
$free_time = mysqli_real_escape_string($connection,$free_time);


mysqli_set_charset($connection,"utf8");
date_default_timezone_set("Asia/Shanghai");
$time = date("Y-m-d h:i:sa");

$sql = "INSERT INTO instructor_2020
(`时间`, `姓名`, `邮箱`, `学校`, `年级`, `专业`, `学术兴趣`, `计划开设的课程名称/主题`, `授课时间段`, `实际IP`) 
VALUES
('$time', '$fullname', '$emailaddress', '$school', '$grade', '$major', '$interest', '$theme', '$free_time', '$ip')"; 

mysqli_query($connection, $sql);
/*		if (mysqli_query($connection, $sql)) {
	   echo "提交成功";
	} else {
	   echo "Error: " . $sql . "" . mysqli_error($connection);
	}*/
	$connection->close(); 


	$success = "
		<p>您好，</p>

		<p>感谢您申请唯理中国在线课程讲师！请阅读附件中的讲师申请要求以了解完成申请所需的信息。期待收到您的申请材料！如有任何问题，请直接联系此邮箱。</p>

		<p>此致，<br>
		唯理中国学术团队</p>
	  ";
	
        $basicinfo = "

    <p>来自{$school}的{$fullname}的申请信息如下：</p>
    <table>
      <tr>
        <td>姓名：</td><td>".$fullname."</td>
      </tr>
      <tr>
        <td>邮箱地址：</td><td>".$emailaddress."</td>
      </tr>
	  <tr>
        <td>学校：</td><td>".$school."</td>
      </tr>
	  <tr>
        <td>目前年级：</td><td>".$grade."</td>
      </tr>
	  <tr>
        <td>目前专业：</td><td>".$major."</td>
      </tr>
	  <tr>
        <td>学术兴趣：</td><td>".$interest."</td>
      </tr>
	  <tr>
        <td>计划开设的课程名称/主题：</td><td>".$theme."</td>
      </tr>
	  <tr>
        <td>您有时间授课的时间段：</td><td>".$free_time."</td>
      </tr>
	</table>
  ";

// $courses = implode(",", $course); 

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->Host = 'smtp.zoho.com';
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;
	$mail->CharSet = 'UTF-8';
	$mail->Username = $email_name;
	$mail->Password = $email_pass;
	$mail->From      = $email_name;
	$mail->FromName  = $fullname;
	$mail->Subject   = "来自{$school}的{$fullname}的在线课程讲师申请信息";
	$mail->Body      = $basicinfo;
	$mail->AddAddress($email_name);
	// $mail->AddAttachment( $_FILES['attachment']['tmp_name'], $_FILES['attachment']['name'] );
	$mail->IsHTML(true);
	$mail->send();
	
	$mail->ClearAddresses();
	
	$mail->From      = $email_name;
	$mail->FromName  = "唯理中国学术团队";
	$mail->Subject   = "申请提交成功";
	$mail->Body      = $success;
	$mail->AddAddress($emailaddress);
	$mail->AddAttachment('files/在线课程讲师申请要求.pdf');
	$mail->AddAttachment('files/课程设计方案样本.pdf');
	$mail->AddAttachment('files/课程设计方案样本2.pdf');
	$mail->IsHTML(true);
	$mail->send();


	$client = new Google_Client();
	$client->setApplicationName("insert_data_to_google_sheet");
	$client->setScopes(Google_Service_Sheets::SPREADSHEETS);
	$client->setAccessType('offline');
	$client->setAuthConfig(__DIR__ . '/../../../sec/data-to-googlesheet.json');
	
	$service = new Google_Service_Sheets($client);
	$spreadsheetId = '1_Ve6YG0EKg0mlLuqxD_PrvbJCAP1HEZcUniWQULNxW4';
	$range = 'Sheet1';
	$valueInputOption = 'RAW';
	
	$values = [
		[$time, $fullname, $emailaddress, $school, $grade, $major, $interest, $theme, $free_time]
	];
	$body = new Google_Service_Sheets_ValueRange([
		'values' => $values
	]);
	$params = [
		'valueInputOption' => $valueInputOption
	];
	$result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
	echo $result->getUpdates()->getUpdatedCells()," cells appended.";

	header('Location: success.html');

