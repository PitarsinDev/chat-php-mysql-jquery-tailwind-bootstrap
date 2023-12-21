<?php 

session_start();

# ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (isset($_SESSION['username'])) {

	if (isset($_POST['message']) &&
        isset($_POST['to_id'])) {
	
	# ไฟล์การเชื่อมต่อฐานข้อมูล
	include '../db.conn.php';

	# รับข้อมูลจากคำขอ XHR และเก็บไว้ใน var
	$message = $_POST['message'];
	$to_id = $_POST['to_id'];

	# รับชื่อผู้ใช้ที่เข้าสู่ระบบจาก SESSION
	$from_id = $_SESSION['user_id'];

	$sql = "INSERT INTO 
	       chats (from_id, to_id, message) 
	       VALUES (?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$res  = $stmt->execute([$from_id, $to_id, $message]);
    
    # ถ้ามีข้อความแทรกอยู่
    if ($res) {
    	/**
       check if this is the first
       conversation between them
       **/
       $sql2 = "SELECT * FROM conversations
               WHERE (user_1=? AND user_2=?)
               OR    (user_2=? AND user_1=?)";
       $stmt2 = $conn->prepare($sql2);
	   $stmt2->execute([$from_id, $to_id, $from_id, $to_id]);

	    // การตั้งค่าโซนเวลา
		// ขึ้นอยู่กับตำแหน่งของคุณหรือการตั้งค่าพีซีของคุณ
		define('TIMEZONE', 'Africa/Addis_Ababa');
		date_default_timezone_set(TIMEZONE);

		$time = date("h:i:s a");

		if ($stmt2->rowCount() == 0 ) {
			# แทรกลงในตารางการสนทนา
			$sql3 = "INSERT INTO 
			         conversations(user_1, user_2)
			         VALUES (?,?)";
			$stmt3 = $conn->prepare($sql3); 
			$stmt3->execute([$from_id, $to_id]);
		}
		?>

		<p class="rtext align-self-end
		          border rounded p-2 mb-1">
		    <?=$message?>  
		    <small class="d-block"><?=$time?></small>      	
		</p>

    <?php 
     }
  }
}else {
	header("Location: ../../index.php");
	exit;
}