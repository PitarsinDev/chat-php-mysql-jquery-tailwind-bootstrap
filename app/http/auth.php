<?php  
session_start();

# ตรวจสอบว่าได้ส่งชื่อผู้ใช้และรหัสผ่านแล้ว
if(isset($_POST['username']) &&
   isset($_POST['password'])){

   # ไฟล์การเชื่อมต่อฐานข้อมูล
   include '../db.conn.php';
   
   # รับข้อมูลจากคำขอ POST และเก็บไว้ใน var
   $password = $_POST['password'];
   $username = $_POST['username'];
   
   #การตรวจสอบแบบฟอร์มอย่างง่าย
   if(empty($username)){
      # error message
      $em = "Username is required";

      # เปลี่ยนเส้นทาง
      header("Location: ../../index.php?error=$em");
   }else if(empty($password)){
      # error message
      $em = "Password is required";

      # เปลี่ยนเส้นทาง
      header("Location: ../../index.php?error=$em");
   }else {
      $sql  = "SELECT * FROM 
               users WHERE username=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$username]);

      # หากมีชื่อผู้ใช้อยู่
      if($stmt->rowCount() === 1){
        # fetching user data
        $user = $stmt->fetch();

        # หากชื่อผู้ใช้ทั้งสองมีค่าเท่ากัน
        if ($user['username'] === $username) {
           
           # การตรวจสอบรหัสผ่านที่เข้ารหัส
          if (password_verify($password, $user['password'])) {

            # เข้าสู่ระบบเรียบร้อยแล้ว
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_id'] = $user['user_id'];

            # เปลี่ยนเส้นทาง
            header("Location: ../../home.php");

          }else {
            # error message
            $em = "Incorect Username or password";

            # error message
            header("Location: ../../index.php?error=$em");
          }
        }else {
          # error message
          $em = "Incorect Username or password";

          # เปลี่ยนเส้นทาง ข้อความแสดงข้อผิดพลาด
          header("Location: ../../index.php?error=$em");
        }
      }
   }
}else {
  header("Location: ../../index.php");
  exit;
}