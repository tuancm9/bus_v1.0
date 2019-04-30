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
		width: 60%;
		height: auto;
		margin-left: 20%;
	}
	#form input[type='button']{
		margin: 1%;
		width: 30%;
		margin-left: 30%;
	}
	.frompoint{
		padding-left:1%;
		padding-right: 1%;
		margin-bottom: 0%;
	}
	#result .frompoint:hover{
		background-color: #CCC;	
	}

</style>


<body>
<div style="position: absolute;display: none;z-index: 9999999999999;right: 0;width: 100%;">
	<div class='alert-success' id='thongbao' style="padding: 5px;width: 100%;text-align: center;"></div>
</div>
<div id="mapid"></div>
<div id="form">
	        <form action="javascript:submitQuery()" name="search" class="form-group">
	            <label> From</label>
	            <input type="text" name="frompoint"  id='frompoint' autocomplete="off"  onkeyup="getDataFromTo(this);" />
	            <div id='frompoint-result' style="width:80%; margin-top: -8px; background-color:#F0F0F0; color: black;"></div>
	            <label> To </label>
	            <input type="text" name="topoint" autocomplete="off" id='topoint'  onkeyup="getDataFromTo(this);" />
	            <div id='topoint-result' style="width:100%; margin-top: -8px; background-color:#F0F0F0; color: black;"></div>
	            <input class="btn btn-primary mb-2" type="button" value="Submit" id="searchBus"></input>
	        </form>
</div>
<script src="js/timduongnew.js"></script>
<script type="text/javascript">initMap();</script>
</body>