<style type="text/css">
	.row #mapid{
		position: relative;
		float: left;
		width: 100%;
	}
	#mapid{
		width: 1080px;
		height: 600px;
		z-index: 0;
		margin-left: 1%;
	}
	#form{
		width: 100%;
		float: left;
		padding: 0 10px 10px 10px;
		display: block;
		margin-bottom: 20px;
	}
	#form input[type='button']{
		position: relative;
		margin: 0;
		padding: 0;
		width: 150px;
		height: 30px;
		float: left;
		line-height: 30px;
	}
    #form .title-input{
        float: left;
        line-height: 30px;
        height: 30px;
        margin: 0;
    }
	 #form .frompoint{
		width: 200px;
		height: 30px;
		margin:0;
	}
	 #form .topoint{
		width: 200px;
		height: 30px;
		margin:0;
	}
	 #form .topoint-content,.frompoint-content{
		float: left;
		position: relative;
		margin: 0 10px;
	}
	#frompoint-result,#topoint-result{
		position: absolute;
		z-index: 99999999;
		background: #FFF;
		max-height: 300px;
		overflow: scroll;
		width: 100%;
		overflow-x:hidden;
	}
	#form .list-point{
		padding: 5px 20px;
		margin: 0;
	}
	#form .list-point:hover{
		background-color: #ccc;
	}
	#form .list-point:first-child{
		margin-top: 20px;
	}
	#result .frompoint:hover{
		background-color: #CCC;	
	}

</style>


<body>
<div style="position: absolute;display: none;z-index: 9999999999999;right: 0;width: 50%;">
	<div class='alert-success' id='thongbao' style="padding: 5px 20px;width: 100%;text-align: center;"></div>
</div>
<!-- form -->

<form id="form" action="javascript:submitQuery()" name="search">
    <div class='frompoint-content'>
		<input type="text" name="frompoint" placeholder="Nhập điểm đi" id='frompoint' class='frompoint' autocomplete="off"  onkeyup="getDataFromTo(this);" />
		<div id='frompoint-result'></div>
    </div>
    <div class='topoint-content'>
	    <input type="text" name="topoint" placeholder="Nhập điểm đến" autocomplete="off" id='topoint' class='topoint'  onkeyup="getDataFromTo(this);" />
	    <div id='topoint-result' ></div>
    </div>
    <input class="btn btn-primary" type="button" value="Submit" id="searchBus"></input>
</form>

<!-- map -->
<div id="mapid"></div>

<script src="js/timduongnew.js"></script>
<script type="text/javascript">initMap();</script>
</body>