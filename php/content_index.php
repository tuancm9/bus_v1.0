<?php
if(isset($_GET['xem'])){
	switch($_GET['xem']){
		case 'thongTintaikhoan':
			include("php/content/thongTintaikhoan.php");
			break;
	}
}
?>