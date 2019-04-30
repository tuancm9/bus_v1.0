<style>
	#thongtintuyenbus{
		position: relative;
		float: left;
		width: 100%;
		height: auto;
	}
	#thongtintuyenbus table tr:hover{
		color:#000;
	}
	.row #box{
		position: relative;
		width:100%;
		float: left; 
		margin-left: 1%;
	}
	.row #box #chitiettuyen{
		position: absolute;
	   top: 35px;
	   left: 0;
	   width: 30%;
	   height: 500px;
	   z-index: 1;
	   overflow:scroll;
	   background-color: #DDD;
	}
	.row #box #chitiettuyen{
		line-height: 1.3;
	}
	.row #box #chitiettuyen .rowStop{
		    margin: 0;
		    padding: 0;
		    border: 0;
		    font-size: 100%;
	}
	#chitiettuyen .dstbus{
		position: relative;
		float: left;
		width: 100%;
		margin:1%;
		font-size: 14px;
		color: #FFF;
		padding: 5px;
		background-color: #34B67A;
		border: 1px solid #34B67A;
		text-align: inherit;
	}
	#chitiettuyen a{
		text-decoration: none;
	}
	#chitiettuyen a:hover{
		text-decoration: none;
		color: #000;
		background-color: #FFF;
	}
	.row #box #chitiettuyen table{
		width: 100%;
	}
	.row #box #chitiettuyen table tr{
		margin: 0;
	    padding: 0;
	    border: 0;
	    font-size: 100%;
		}
	.row #box #chitiettuyen table td{
		text-align: inherit;
		font-size: 14px;
	}
	.row #box #chitiettuyen .orderNo{
		width: 20px;
	    height: 20px;
	    line-height: 20px;
	    border-radius: 50%;
	    -webkit-border-radius: 50%;
	    -moz-border-radius: 50%;
	    vertical-align: middle;
	    text-align: center;
	    color: #fff;
	    background-color: #34B67A;
	}
	.row #box #mapid{
	   position: absolute;
	   top: 35px;
	   right: 0;
	   width: 70%;
	   height: 500px;
	   z-index: 1;
	}
</style>
<div class="tieude" name='<?php echo $_GET['id'] ?>'>THÔNG TIN TUYẾN BUS <?php echo "{$_GET['id']}";?></div>
<?php
include("connect.php");
$sql="SELECT * FROM tuyen_xebus where ma_sotuyen=".$_GET['id']."";
$retval=mysqli_query($conn, $sql) or die('Không kết nối được');
	if(mysqli_num_rows($retval) > 0){
		while($row = mysqli_fetch_assoc($retval)){
				echo "<div id='thongtintuyenbus'>
						<table class='table'>
								<tr><td>Mã Số Tuyến: </td><td>".$row['ma_sotuyen']."</td></tr>
								<tr><td>Tên Tuyến: </td><td>".$row['ten_tuyen']."</td></tr>
								<tr><td>Độ Dài Tuyến: </td><td>".$row['dodai_tuyen']." Km</td></tr>
								<tr><td>Loại Xe: </td><td>".$row['loai_xe']."</td></tr>
								<tr><td>Giá Vé: </td><td>".$row['gia_ve']."</td></tr>
								<tr><td>Tỉnh Thành: </td><td>".$row['ma_tinhthanh']."</td></tr>
								<tr><td>Giản Cách Chuyến: </td><td>".$row['giancach_chuyen']." Phút</td></tr>
								<tr><td>ĐV Đảm Nhận: </td><td>".$row['donvi_damnhan']."</td></tr>
							</table>
						</div>";
			}
	}else echo "Không Có Tuyến Bus Nào!";
?>
<div id="box">
	<div class="tieude">LỘ TRÌNH TUYẾN BUS <?php echo "{$_GET['id']}";?></div>
	<div id="chitiettuyen">
		<?php
			include("connect.php");
			$sql="SELECT tram_xebus.stt_theotuyen, tram_xebus.ten_tram FROM tuyen_xebus, tram_xebus WHERE tuyen_xebus.ma_sotuyen = tram_xebus.ma_sotuyen AND tuyen_xebus.ma_sotuyen=".$_GET['id']."";
			$retval=mysqli_query($conn, $sql) or die('Không kết nối được');
				if(mysqli_num_rows($retval) > 0){
					while($row = mysqli_fetch_assoc($retval)){
						echo "<a href='#' onclick='' class='dstbus'> 
								<table cellpadding='0' cellspacing='0'>
									<tr class='rowStop'>
										<td class='orderNo'>".$row['stt_theotuyen']."</td>
										<td style='padding-left:5px;'>".$row['ten_tram']."</td>
									</tr>
								</table>
							</a>";
				}
			}else echo "Không có kết quả!";
		?>
	</div>
	<div id="mapid"></div>
</div>
<script>
var map = L.map('mapid').setView([10.775375, 106.705737], 14);
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					maxZoom: 18,
					attributionControl: false,
					prefix: '',
				}).addTo(map);
		L.control.ruler().addTo(map);
// attaching function on map click
map.on('click', onMapClick);
function setMove(chedo){
	Move=chedo;
	if(chedo==0){
		$html="	<div class='tool-map tools-item' id='Move' onclick='setMove(1);'  title='Chế độ di chuyển'> "+		
					"<img src='icon/stopMove.png'/>  "+
				"</div>";

		$('#Move').html($html);
	}
}

function onMapClick(e) {

	if(Move==0) return 0;
	
	 if(tuychon==1){
	 	 nameTram="node";
	 }
    var geojsonFeature = {
        "type": "Feature",
            "properties": {},
            "geometry": {
                "type": "Point",
                "coordinates": [e.latlng.lat, e.latlng.lng]
        }
    }
    var marker;
    L.geoJson(geojsonFeature, {   
        pointToLayer: function(feature, latlng){
            
            marker = L.marker(e.latlng, {
                
                title: nameTram,
                alt: "Resource Location",
                riseOnHover: true,
                draggable: true,

            }).bindPopup("<input type='button' value='Delete this marker' class='marker-delete-button'/>");

            marker.on("popupopen", onPopupOpen);
            marker.on("moveend",function(e){
            	updateline();
            });
  
       		if(tuychon==0) marker.setIcon(getIcon('tram'));
       		if(tuychon==1) marker.setIcon(getIcon('node'));
            return marker;
        }
    }).addTo(map);
    if($click==0){
    	$firstPoint=marker;
    	$click++;
    }
    if($click!=0){
    	console.log($firstPoint._latlng);
		console.log(tinhkhoangcach($firstPoint._latlng, marker._latlng));
	}
    tuychon=1;
    updateline();
    console.log(marker);

}

// -------------------------ham cap nhat icon-------------------------
// input tên icon cần sét, output Icon
function getIcon(name){
	// khai báo icon 
	var tramIcon = L.icon({
    iconUrl: 'icon/tramIcon.png',
    number: 12,
    iconSize:     [30, 30], // size of the icon
    shadowSize:   [10, 60], // size of the shadow
    iconAnchor:   [15, 30], // point of the icon which will correspond to marker's location
    shadowAnchor: [1, 62],  // the same for the shadow
    popupAnchor:  [0, -30] // point from which the popup should open relative to the iconAnchor
	});
	var nodeIcon = L.icon({
    iconUrl: 'icon/nodeIcon.png',
    iconSize:     [15, 15], // size of the icon
    shadowSize:   [60,60], // size of the shadow
    iconAnchor:   [7, 7], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 20],  // the same for the shadow
    popupAnchor:  [0, -15] // point from which the popup should open relative to the iconAnchor
	});
	var Icon=nodeIcon;
	switch(name){
		case 'tram':
			Icon=tramIcon;
			break;
		case 'node':
			Icon=nodeIcon;
			break;
		default:  
			Icon=nodeIcon;
			break;

	}
	return Icon;
}
function newTram(lat,lon,name,value){
	var geojsonFeature = {
        "type": "Feature",
            "properties": {},
            "geometry": {
                "type": "Point",
                "coordinates": [lat, lon]
        }
    }
    var marker;
    L.geoJson(geojsonFeature, {   
        pointToLayer: function(feature, latlng){
            
            marker = L.marker([lat,lon], {
                
                title: name,
                alt: name,
                riseOnHover: true,
                draggable: true,

            }).bindPopup("<input type='button' value='Delete this marker' class='marker-delete-button'/>");

            marker.on("popupopen", onPopupOpen);
            marker.on("moveend",function(e){
            	updateline();
            });
  
       		if(value==0) marker.setIcon(getIcon('tram'));
       		if(value==1) marker.setIcon(getIcon('node'));

            return marker;
        }
    }).addTo(map);
    tuychon=1;

    map.setView([lat, lon], 14);

}

function updateline(){
            for(i in map._layers) {
        if(map._layers[i]._path != undefined) {
            try {
                map.removeLayer(map._layers[i]);
            }
            catch(e) {
                console.log("problem with " + e + map._layers[i]);
            }
        }
     
    }
       veduong();
}
// Function to handle delete as well as other events on marker popup open
function onPopupOpen() {
    var tempMarker = this;
    $(".marker-delete-button:visible").click(function () {
        map.removeLayer(tempMarker);
        updateline();
    });

}

function ve_duong_all() {


    $.each(map._layers, function (ml) {
        if (map._layers[ml].feature) {
            allMarkers.push(this._latlng);
        }
    	});
    

}
// getting all the markers at once
function veduong() {

    var allMarkersObjArray = [];//new Array();
    $.each(map._layers, function (ml) {
        //console.log(map._layers)
        if (map._layers[ml].feature) {
            
            allMarkersObjArray.push(this);
          
  
        }
    });   
    var pon=[];
    i=0;
    for ( i=0;i<allMarkersObjArray.length;i++){
    	//console.log(allMarkersObjArray[i]);
    	pon.push(allMarkersObjArray[i]._latlng);
    }
polyline = L.polyline(pon, {color: '#00ff00'}).addTo(map);
if(allMarkersObjArray[0]!=null&&allMarkersObjArray[1]!=null)console.log(distance(allMarkersObjArray[0]._latlng,allMarkersObjArray[i-1]._latlng));
}
function getNode(){
	mst=$('.tieude').attr('name');
	var dataString ='&mst='+mst;
			$.ajax
			({
			type: "POST",
			url: "php/content/function_ajax/get_node.php",
			data: dataString,
			success: function(resultData) { 
				alert(resultData);
			  		$ds=resultData.split(';');
			  		for(i=0;i<$ds.length-1;i++){
			  			//console.log($ds[i]);
			  			if($ds[i]=="null"||$ds[i]==null) continue;
			  			tram = jQuery.parseJSON($ds[i]);
				  		newTram(tram.lat,tram.lon,tram.ten_tram,0);
		
				  		//console.log(tram.danhsachnode);
				  		if(tram.danhsachnode=="null"||tram.danhsachnode==null) continue;
				  		$dsnode=jQuery.parseJSON(tram.danhsachnode);

				  		for(j=0;j<$dsnode.length;j++){
				  			newTram($dsnode[j].lat,$dsnode[j].lng,'node',1);
				  		}
		  		}
			updateline();
			//$('#thongbao').html('thành công.').parent().fadeIn().delay(1000).fadeOut('slow');
		  	 },
		  	 error: function(data){
    				alert('error!'+data);
  				}
			});
}
</script>	
<script type="text/javascript">
$(window).bind("load", function() { 
	getNode();   
});
</script>
<script type="text/javascript">initMap();</script>