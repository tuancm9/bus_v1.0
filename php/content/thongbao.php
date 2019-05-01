
<style type="text/css">
.tabletuyenbus th{
	height: 50px;
}
#phantrang_index{
	position: relative;
	width:96%;
	margin-left: 3%;
	background-color:#9fd1e8;
	float:left;
	margin-top: 5px;
}	
#phantrang_index a{
	margin:2px;
	text-decoration:none;
	color:#FFF;
	display: block;
	float: left;
	text-align: center;
	} 	
#phantrang_index span{
	margin: 2px 2px 2px 45%;
	color:#009;
	float: left;
	} 
#phantrang_index a:hover{
color:#009;	
}
</style>
<?php
#----------------------Hàm rút ngắn nội dung---------------
	function rutgonnoidung($string,$batdau,$sotu){
		$len=strlen($string);
		while($sotu<$len){
			if($string[$sotu]==' ') break;
			$sotu++;
		}
		$string=substr($string,$batdau,$sotu);
		if($len>strlen($string)) $string.='...';
		return $string;
	}
?>

<?php
#-----------------------Hiển thị danh sách thông báo-------------
include("connect.php");
$sql="SELECT * FROM thongbao";
$retval=mysqli_query($conn, $sql) or die('Không kết nối được');
if(mysqli_num_rows($retval) > 0){
		$phantrang=4;
		$sotrang=ceil(mysqli_num_rows($retval)/$phantrang);
			if(isset($_GET['trang']))
			{
				$batdau=$_GET['trang']*$phantrang;
				$tranghienthai=$_GET['trang'];
				}
			else{
				$batdau=0;
				$ketthuc=$phantrang;
				$tranghienthai=0;
				}
	$sql1="SELECT * FROM thongbao order by ma_thongbao DESC limit $batdau, $phantrang";
	$retval1=mysqli_query($conn, $sql1);
	if(mysqli_num_rows($retval1) > 0){	
		while($row = mysqli_fetch_assoc($retval1)){
            echo  "<div class='container'>
        				<div class='post row'>
        					<div class='picture col-4'>
        					<img src='upload/".$row['hinhanh']."'/>
        					</div>
        					<div class='notify col-8'>
	        					<h2><a href='indexUser.php?xem=chitietthongbao&id=".$row['ma_thongbao']."'>".$row['chude']."</a></h2>
	        					<h6>".$row['tieude']."</h6>
	        					<p>".rutgonnoidung($row['noidung'],0,300)."</p>
        					</div>
        				</div>
        			</div>";
		}	
	}
}else echo "Không có thông báo!";
			echo "<center> <div id='phantrang_index'>";
						for($i=0;$i<$sotrang;$i++){
							if($i!=$tranghienthai){
								echo "<a href='indexUser.php?xem=thongbao&trang={$i}'>[ ".($i+1)." ]</a>";
								}
								 	else echo "<span>[ ".($i+1)." ]</span>";
							}
					echo "</div></center>";	
mysqli_close($conn);
?>

