<?php  

session_start();

# ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (isset($_SESSION['username'])) {
	
	# ไฟล์การเชื่อมต่อฐานข้อมูล
	include '../db.conn.php';

	# รับชื่อผู้ใช้ที่เข้าสู่ระบบจาก SESSION
	$id = $_SESSION['user_id'];

	$sql = "UPDATE users
	        SET last_seen = NOW() 
	        WHERE user_id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

}else {
	header("Location: ../../index.php");
	exit;
}