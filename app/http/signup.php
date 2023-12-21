<?php  

# ตรวจสอบว่าชื่อผู้ใช้ รหัสผ่าน ชื่อที่ส่งมา
if(isset($_POST['username']) &&
   isset($_POST['password']) &&
   isset($_POST['name'])){

   # ไฟล์การเชื่อมต่อฐานข้อมูล
   include '../db.conn.php';
   
   # รับข้อมูลจากคำขอ POST และเก็บไว้ใน var
   $name = $_POST['name'];
   $password = $_POST['password'];
   $username = $_POST['username'];

   # การสร้างรูปแบบข้อมูล URL
   $data = 'name='.$name.'&username='.$username;

   #	การตรวจสอบแบบฟอร์ม
   if (empty($name)) {
   	  # error message
   	  $em = "Name is required";

   	  # error message
   	  header("Location: ../../signup.php?error=$em");
   	  exit;
   }else if(empty($username)){
      # error message
   	  $em = "Username is required";

   	  /*
    	เปลี่ยนเส้นทางไปที่ 
		ส่งข้อความและข้อมูลผิดพลาด
      */
   	  header("Location: ../../signup.php?error=$em&$data");
   	  exit;
   }else if(empty($password)){
   	  # error message
   	  $em = "Password is required";

   	  /*
    	เปลี่ยนเส้นทาง
    	ส่งข้อความและข้อมูลผิดพลาด
      */
   	  header("Location: ../../signup.php?error=$em&$data");
   	  exit;
   }else {
   	  # ตรวจสอบฐานข้อมูลว่ามีผู้ใช้ชื่อผู้ใช้หรือไม่
   	  $sql = "SELECT username 
   	          FROM users
   	          WHERE username=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$username]);

      if($stmt->rowCount() > 0){
      	$em = "The username ($username) is taken";
      	header("Location: ../../signup.php?error=$em&$data");
   	    exit;
      }else {
      	# การอัพโหลดรูปโปรไฟล์
      	if (isset($_FILES['pp'])) {
      		# get data and store them in var
      		$img_name  = $_FILES['pp']['name'];
      		$tmp_name  = $_FILES['pp']['tmp_name'];
      		$error  = $_FILES['pp']['error'];

      		# หากไม่มีข้อผิดพลาดเกิดขึ้นขณะอัพโหลด
      		if($error === 0){
               
               # รับส่วนขยายรูปภาพเก็บไว้ใน var
      		   $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);

               /** 
				convert the image extension into lower case 
				and store it in var 
				**/
				$img_ex_lc = strtolower($img_ex);

				/** 
				crating array that stores allowed
				to upload image extension.
				**/
				$allowed_exs = array("jpg", "jpeg", "png");

				/** 
				check if the the image extension 
				is present in $allowed_exs array
				**/
				if (in_array($img_ex_lc, $allowed_exs)) {
					/** 
					 renaming the image with user's username
					 like: username.$img_ex_lc
					**/
					$new_img_name = $username. '.'.$img_ex_lc;

					# การอัพโหลดบนไดเร็ก
					$img_upload_path = '../../uploads/'.$new_img_name;

					# ย้ายภาพที่อัพโหลด
                    move_uploaded_file($tmp_name, $img_upload_path);
				}else {
					$em = "You can't upload files of this type";
			      	header("Location: ../../signup.php?error=$em&$data");
			   	    exit;
				}

      		}
      	}

      	$password = password_hash($password, PASSWORD_DEFAULT);

      	if (isset($new_img_name)) {

            $sql = "INSERT INTO users
                    (name, username, password, p_p)
                    VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name, $username, $password, $new_img_name]);
      	}else {
            $sql = "INSERT INTO users
                    (name, username, password)
                    VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name, $username, $password]);
      	}

      	# success message
      	$sm = "Account created successfully";

      	header("Location: ../../index.php?success=$sm");
     	exit;
      }

   }
}else {
	header("Location: ../../signup.php");
   	exit;
}