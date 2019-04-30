
map = L.map('mapid');
makerDiemdi=null;
markerDiemDen=null;
countMarker=1;//default;
/** event * */
// A $( document ).ready() block.
$( document ).ready(function() {
	$('#searchBus').click(function(){
		searchBus();
	});
	$(window).click(function(e){
		id=e.target.id;
		if(id!="frompoint" && id!="topoint"){
			$('#frompoint-result').html("");
			$('#topoint-result').html("");
		};
	});
});


function onMapClick(e) {
	if(	countMarker>2) return 0;
		countMarker++;
		   $('#'+id).val(info);
	   		if(id=='frompoint') {
	        	 action="<input type='button' value='Delete this marker' class='marker-delete-button'/>"+
	            				"<button class='diemden'>set diem den</button>";
	        }
	        if(id=='topoint') {
	        	 action="<input type='button' value='Delete this marker' class='marker-delete-button'/>"+
	            				"<button class='diemdi'>set diem di</button>";
	        }
	 marker = L.marker(e.latlng, {
                alt: "Resource Location",
                riseOnHover: true,
                draggable: true,
	            }).bindPopup(action);
marker.on("popupopen", onPopupOpen);
	 marker.addTo(map);

	 console.log(e.point);
}

function setInfo(lat,lng,id){
	$.post('https://nominatim.openstreetmap.org/reverse?format=xml&lat='+lat+'&lon='+lng+'&zoom=18&addressdetails=1',function(data) {

	   info=(data.getElementsByTagName("result"))[0].innerHTML;
	   $('#'+id).val(info);
	   		if(id=='frompoint') {
	        	 action="<input type='button' value='Delete this marker' class='marker-delete-button'/>"+
	            				"<button class='diemden'>set diem den</button>";
	        }
	        if(id=='topoint') {
	        	 action="<input type='button' value='Delete this marker' class='marker-delete-button'/>"+
	            				"<button class='diemdi'>set diem di</button>";
	        }
	   	  
	   	   marker = L.marker([lat,lng], {
                alt: info,
                title:info,
                trangthai:id,
                riseOnHover: true,
                draggable: true,
	            }).bindPopup(action);   	
	        marker.on("popupopen", onPopupOpen); 
	        marker.addTo(map);
	        marker.on("popupopen", onPopupOpen);
	        if(id=='frompoint') {
	        	makerDiemdi=marker;
	        }
	        if(id=='topoint') {
	        	makerDiemDen=marker;
	        }
	});
}
/*
*khởi tạo bảng đồ
*/
var diemXP = {
	ten_tram: null,
	ma_tram: null,
	ma_sotuyen: null,
	lat: null,
	lon: null,
	stt_theotuyen: null,
	danhsachnode: null
},
	diemDen = {
		ten_tram: null,
		ma_tram: null,
		ma_sotuyen: null,
		lat: null,
		lon: null,
		stt_theotuyen: null,
		danhsachnode: null
	};
var soLanChuyenTuyen = 0;
var dsTuyenDaChon = [];
function initMap(){
	map.setView([10.775375, 106.705737], 14);
	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 18,
				attributionControl: false,
				prefix: '',
			}).addTo(map);
	map.on('click', onMapClick);
	map.locate({setView:true,maxZoom:16});
	map.on('locationfound', function (e) {
	setInfo(e.latlng.lat,e.latlng.lng,'frompoint');
	});
}

function onPopupOpen() {
    var tempMarker = this;

    $(".marker-delete-button:visible").click(function () {
        map.removeLayer(tempMarker);
    });
    $(".diemden:visible").click(function () {
    	 map.removeLayer(tempMarker);
        setInfo(tempMarker._latlng.lat,tempMarker._latlng.lng,'topoint');
    });
    $(".diemdi:visible").click(function () {
    	 map.removeLayer(tempMarker);
        setInfo(tempMarker._latlng.lat,tempMarker._latlng.lng,'frompoint');
    });

}

/*
param element
lấy dữ liệu tên trạm bus
output: none
*/
function clean(){
		$.each(map._layers, function (ml) {
		if (map._layers[ml].feature || map._layers[ml]._path != undefined) {
		 tram=this;
		  map.removeLayer(tram);
		 }	              	             
	});

}
function getDataFromTo(e){


	value=e.value;
	var dataString ='&data='+value;
		$.ajax
		({
		type: "POST",
		url: "php/content/function_ajax/getSearch.php",
		data: dataString,
		success: function(resultData) { 
		if(resultData=='') return;
			tram=resultData.split(';');
			setFormSearch(tram,e);
		//$('#thongbao').html('thành công.').parent().fadeIn().delay(1000).fadeOut('slow');
	  	 },
	  	 error: function(data){
				alert('error!'+data);
				}
		});
	
};

/*
param danh sach ten tram bus, element của thẻ input
tạo danh sách sổ xuống các tên trạm bus
output: none
*/
function setFormSearch(dataTram,e){
	id=e.id;
	idResult=id+"-result";
	for(i=0; i< dataTram.length;i++){
		if(!dataTram[i]) continue;
		tramT = jQuery.parseJSON(dataTram[i]);
		document.getElementById(idResult).innerHTML +='<p id="'+id+'" title="'+tramT.ten_tram+
		'" onmouseover="setValueInput(id,title);" onclick=document.getElementById("'+idResult+'").innerHTML="">'
		+tramT.ten_tram +'</p>';
	}
}

/*
* param: id thẻ input
* lấy giá trị khi hover hoặc click vào element gán vào thẻ iput
  output: none
*/
function setValueInput(id,e){
	$('#'+id).val(e);
}



function searchBus(){
	clean();
	diemXP['ten_tram']=$('#frompoint').val();
	diemDen['ten_tram']=$('#topoint').val();
	if(diemXP['ten_tram']==diemDen['ten_tram']){
		thongbao('điểm đi phải khác điểm đến.');
		return ;
	}
	if(diemXP['ten_tram']===""){
		$('#frompoint').focus();
		return ;
	}
	if(diemDen['ten_tram']===""){
		$('#topoint').focus();
		return ;
	}
	getToaDo("getToaDoAll");
}

function getToaDo(action){
	data = {
		action: action,
		data: null
	};
	$.ajax({
			url:"php/content/function_ajax/timduong.php",
			data: data,
			type:'POST',
			success: function(data){
				if(data[0]=='-') {
					thongbao('loi') ;
					return;
				}
				 xuly(data);
			}
		});
}
function getXuatPhat_KT(dstrambus){
	for(i=0;i<dstrambus.length;i++){
		if((dstrambus[i])['ten_tram']==diemXP['ten_tram']){
				diemXP['ma_tram']=(dstrambus[i])['ma_tram'];
				diemXP['ma_sotuyen']=(dstrambus[i])['ma_sotuyen'];
				diemXP['lat']=(dstrambus[i])['lat'];
				diemXP['lon']=(dstrambus[i])['lon'];
				diemXP['stt_theotuyen']=(dstrambus[i])['stt_theotuyen'];
				diemXP['danhsachnode']=(dstrambus[i])['danhsachnode'];
				newTram(diemXP['lat'],diemXP['lon'],diemXP['ten_tram'],0);
				dstrambus.splice(i,1);

		} 
		else if((dstrambus[i])['ten_tram']==diemDen['ten_tram']){
				diemDen['ma_tram']=(dstrambus[i])['ma_tram'];
				diemDen['ma_sotuyen']=(dstrambus[i])['ma_sotuyen'];
				diemDen['lat']=(dstrambus[i])['lat'];
				diemDen['lon']=(dstrambus[i])['lon'];
				diemDen['stt_theotuyen']=(dstrambus[i])['stt_theotuyen'];
				diemDen['danhsachnode']=(dstrambus[i])['danhsachnode'];
				newTram(diemDen['lat'],diemDen['lon'],diemDen['ten_tram'],0);

		}
	}
}
function xuly(data){
	dstrambus=tachdulieu(data);
	getXuatPhat_KT(dstrambus);
	for(i=0;i<dstrambus.length;i++){
		(dstrambus[i])['khoangcach']=tinhkhoangcach(dstrambus[i],diemXP);
		}
	dstrambus=sapxep(dstrambus);
	console.log(dstrambus);
	khongchuyentuyen(dstrambus);
	getNode();

}

function getDSTuyen(mst,data){
		var result=[];
		for(i=0;i<data.length;i++){
			if(data[i]['ma_sotuyen']==mst) result.push(data[i]);
		}
		result.sort(
		function(a , b){
			if ( parseInt(a['stt_theotuyen']) >  parseInt(b['stt_theotuyen'])) return 1;
			if ( parseInt(a['stt_theotuyen']) <  parseInt(b['stt_theotuyen'])) return -1;
			return 0;
		       }
			);
		return result;

}
function khongchuyentuyen(dstrambus){
	var tuyenHienTai= null;
	var stt_bd = -1;
	var stt_kt = -1;
	if(diemXP['ma_sotuyen']==null) {
		tuyenHienTai = dstrambus[0]['ma_sotuyen'];
		tramHientai = dstrambus[0];
		stt_bd =dstrambus[0]['stt_theotuyen'];
	}
	else {
		tuyenHienTai = diemXP['ma_sotuyen'];
		stt_bd = diemXP['stt_theotuyen'];
		tramHientai = diemXP;
	}
	diemBD =tramHientai;
	dsTuyenDaChon =[];
	DStram =  getDSTuyen(tuyenHienTai ,dstrambus);
	for(i=0; i<DStram.length;i++){
		    	tramHientai = DStram[i];
	   if(DStram[i]['ma_tram']==diemDen['ma_tram']) break;
        if(
       	   	      parseFloat(tinhkhoangcach(tramHientai,diemBD))
       	   	     > 
       	   	      parseFloat(tinhkhoangcach(diemBD,diemDen))
       	) break;
        	

    	stt_kt = DStram[i]['stt_theotuyen'];
	}
	dsTuyenDaChon = getDStheotuyen(stt_bd,stt_kt,tuyenHienTai,DStram);
	console.log(stt_kt);
}

function tachdulieu(data){
	dstrambus_raw=data.split(';');
	
	var dstrambus=[];
	for(i=0;i<dstrambus_raw.length;i++){
		if(!dstrambus_raw[i]) continue;
		tmp=JSON.parse(dstrambus_raw[i]);
		dstrambus.push(tmp);
	}
	return dstrambus;
}

function tinhkhoangcach(a,b){
lat_a=a['lat'];
lon_a=a['lon'];
lat_b=b['lat'];
lon_b=b['lon'];
R = 6373.0 ;
 dLat = (lat_b - lat_a) * (Math.PI / 180);
 dLon = (lon_b - lon_a) * (Math.PI / 180);
 la1ToRad = lat_a * (Math.PI / 180);
 la2ToRad = lat_b * (Math.PI / 180);
 a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(la1ToRad)
* Math.cos(la2ToRad) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
 c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
 d = R * c;
return parseFloat(d*1000).toFixed(4);
}

function sapxep(data){
	data.sort(
		function(a , b){
			if ( parseFloat(a['khoangcach']) >  parseFloat(b['khoangcach'])) return 1;
			if ( parseFloat(a['khoangcach']) <  parseFloat(b['khoangcach'])) return -1;
			return 0;
		       }
			);
	console.log(data);
	return data;
}

function getDStheotuyen(stt_bd,stt_kt,mst,data){
	var result=[];
		for(i=0;i<data.length;i++){
			if(data[i]['ma_sotuyen']!=mst) continue;
			if(parseInt(data[i]['stt_theotuyen'])>=parseInt(stt_bd)&&parseInt(data[i]['stt_theotuyen'])<=parseInt(stt_kt))
			result.push(data[i]);
		}
		result.sort(
		function(a , b){
			if ( parseInt(a['stt_theotuyen']) >  parseInt(b['stt_theotuyen'])) return 1;
			if ( parseInt(a['stt_theotuyen']) <  parseInt(b['stt_theotuyen'])) return -1;
			return 0;
		       }
			);
		return result;

}
function thongbao(tb){
	$('#thongbao').html(tb).parent().fadeIn().delay(1000).fadeOut('slow');
}

// function ve duong
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
  
       		if(value==0) marker.setIcon(getIcon('tram'));
       		if(value==1) marker.setIcon(getIcon('node'));

            return marker;
        }
    }).addTo(map);
    tuychon=1;

    map.setView([lat, lon], 14);

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

}

function getNode(){
	if(dsTuyenDaChon.length<=0){
		polyline = L.polyline([{lat: diemDi['lat'],lng: diemDi['lon']},{lat: diemDen['lat'],lng: diemDen['lon']}], {color: '#000000'}).addTo(map);
	}
	var pon = [];
	for(i=0;i<dsTuyenDaChon.length;i++){
		tram =dsTuyenDaChon[i];
		newTram(tram['lat'],tram['lon'],tram['ten_tram'],0);
		latlng = {lat: tram['lat'], lng: tram['lon']};
		pon.push(latlng);
		if(i==dsTuyenDaChon.length-1) break;
		if(tram['danhsachnode']=="null"||tram['danhsachnode']==null) continue;
		dsnode=jQuery.parseJSON(tram['danhsachnode']);
		for(j=0;j<dsnode.length;j++){
			newTram(dsnode[j].lat,dsnode[j].lng,'node',1);
			latlng = {lat: dsnode[j].lat,lng: dsnode[j].lng};
		    pon.push(latlng);
		}

	}
	polyline = L.polyline(pon, {color: '#00ff00'}).addTo(map);
	polyline = L.polyline([latlng,{lat: diemDen['lat'],lng: diemDen['lon']}], {color: '#000000'}).addTo(map);

}