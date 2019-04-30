<style type="text/css">
	#danhsachtuyenbus{
		position: relative;
		width: 100%;
	}
	#danhsachtuyenbus .dstuyenbus{
		position: relative;
		float: left;
		width: 32%;
		padding: 5px;
	    margin: 5px;
	    display: inline-block;
	    text-align: left;
	    text-decoration: none;
	    font-size: 14px;
	    vertical-align: middle;
	    color: #FFFFFF !important;
	    background: none repeat scroll 0 0 #34B67A;
	    border: 1px solid #34B67A;
	}
	#danhsachtuyenbus .dstuyenbus:hover{
		text-decoration: none !important;
        color: #121212 !important;
        border: 1px solid #34B67A;
        background: none repeat scroll 0 0 #ffffff;
	}
	#danhsachtuyenbus .dstuyenbus:hover .icon {
        color: #ffffff;
        background-color: #34B67A;
    }
	#danhsachtuyenbus table tr{
		margin: 0;
	    padding: 0;
	    border: 0;
	    font-size: 100%;
	}
	#danhsachtuyenbus a{
		color: #5e9700;
    	text-decoration: none;
	}
	#danhsachtuyenbus .icon{
	    white-space: nowrap;
	    font-size: 18px;
	    font-weight: bold;
	    text-align: center;
	    height: 30px;
	    min-width: 30px;
	    line-height: 30px;
	    margin: 0px;
	    padding: 1px;
	    vertical-align: middle;
	    color: #34B67A;
	    background-color: #ffffff;
	    border: solid 1px #dadada;
	    border-radius: 50%;
	    -webkit-border-radius: 50%;
	}
</style>
<?php
		echo "<div class='tieude'>DANH SÁCH CÁC TUYẾN BUS</div>";
		include("connect.php");
			$sql="SELECT * FROM tuyen_xebus";
			$retval=mysqli_query($conn, $sql);
			if(mysqli_num_rows($retval) > 0){	
				while($row = mysqli_fetch_assoc($retval)){
					echo "<div id='danhsachtuyenbus'>
						<a href='indexUser.php?xem=chitiettuyenbus&id=".$row['ma_sotuyen']."' onclick='' class='dstuyenbus'>
							<table>
								<tr>
									<td class='icon'>".$row['ma_sotuyen']."</td>
									<td>".$row['ten_tuyen']."</td>
								</tr>
							</table>	
						<a>
					</div>";
			}
		}else echo "Không có tuyến bus nào!";
?>