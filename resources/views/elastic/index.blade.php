@extends ('app_elastic')

<div class="box">
	<div class="box-body">
		<div class="row">			
			<div class="col-md-12">
				<span id="description">All data created to elastic search will save also on PostgreSQL</span>
			</div>	
		</div>
		<br>
		<div class="row">			
			<div class="col-md-12">
				<div class="input-group" style="width:80%;">
				  	<span class="input-group-btn"><button class="btn btn-success" type="button" id="btnTest" onclick="Test()"><span class="fa fa-search"> Test</span></button></span>
				</div>
				<span id="test_desc">Test Elastic Search Installation</span>
			</div>	
		</div>
		<br>
		<div class="row">			
			<div class="col-md-12">
				<div class="input-group" style="width:80%;">
				  	<span class="input-group-btn"><input type="text" class="form-control" id="putIndexTxt" /><button class="btn btn-success" type="button" id="btnIndex" onclick="PutIndex()"><span class="fa fa-search"> Put Index</span></button><button class="btn btn-success" type="button" id="btnGetIndex" onclick="GetIndexData()"><span class="fa fa-search"> Get Index Data</span></button></span>
				</div>
				<span id="put_index">Type new 'index' to put here. Or use this field to fetch 'index' to load existing data. (From Elastic Search Server or PostgreSQL) </span>
			</div>	
		</div>
		<br>
		<div class="row">			
			<div class="col-md-12">
				<div class="input-group" style="width:80%;">
				  	<span class="input-group-btn"><input type="text" class="form-control" id="putTypeTxt" /><button class="btn btn-success" type="button" id="btnType" onclick="PutType()"><span class="fa fa-search"> Put Type</span></button><button class="btn btn-success" type="button" id="btnGetMapping" onclick="GetMappingData()"><span class="fa fa-search"> Get Mapping Data</span></button></span>
				</div>
				<span id="put_index">Type new 'type' to put here. Or use this field to fetch 'type' to load existing data. (From Elastic Search Server or PostgreSQL)</span>
			</div>	
		</div>
		<hr>
		<div class="row">			
			<div class="col-md-12">
				<div class="input-group" style="width:80%;">
				  	<span class="input-group-btn"><input type="text" class="form-control" id="postAddressTxt" /><button class="btn btn-success" type="button" id="btnPostAddress" onclick="PostAddress()"><span class="fa fa-search"> Post Address</span></button></span>
				</div>
				<span id="put_index">Type new 'address' to post here. Or use this field to fetch 'type' to load existing data. (Use '*' to fetch all data). (From Elastic Search Server or PostgreSQL)</span>
			</div>	
		</div>
		<hr>
		<div class="row">			
			<div class="col-md-12">
				<div class="input-group" style="width:80%;">
				<button class="btn btn-success" type="button" id="btnElasticData" onclick="GetExistingElasticData()"><span class="fa fa-search"> Get Existing Elastic Search Data</span></button><button class="btn btn-success" type="button" id="btnPostgreSqlData" onclick="GetExistingPostgreSqlData()"><span class="fa fa-search"> Get Existing PostgreSQL Data</span></button></span>
				</div>
				<span id="put_index">Use these buttons to fetch data (Use '*' to fetch all data). (From Elastic Search Server or PostgreSQL)</span>
			</div>	
		</div>
	</div>
</div>
<br>
<div class="box">
	<div class="box-body">
		<div class="row">			
			<div class="col-md-12">
				<b>Result (JSON):</b>
			</div>
			<div class="col-md-12" id="result">
			</div>				
		</div>
	</div>
</div>

@section ('javascript_per_page')
<script type="text/javascript">	

function Test()
{
	$.ajax({
		  url: '{{ url("elastic/test") }}', 
		  beforeSend: function(){			
			$('#result').html('<small>Loading....</small>');
		  },
		  type:'GET',
		  headers: { 'Content-Type':'application/json' },
		  dataType: 'json',
		  data:{
		  
		  },
		  success: function (res) {	
			$('#result').html('<pre>' + JSON.stringify(res, null, 2) + '</pre>');  
		  },
		  error: function(a, b, c){
			$('#result').html('<pre>' + JSON.stringify(a, null, 2) + '</pre>');
		  }
		});	
}

function PutIndex()
{
	$.ajax({
		  url: '{{ url("elastic/putIndex") }}', 
		  beforeSend: function(){			
			$('#result').html('<small>Loading....</small>');
		  },
		  type:'POST',
		  dataType: 'json',
		  data:{
			'_token':'{{ csrf_token() }}',
			'name': $('#putIndexTxt').val()
		  },
		  success: function (res) {	
			$('#result').html('<pre>' + JSON.stringify(res, null, 2) + '</pre>');  
		  },
		  error: function(a, b, c){
			$('#result').html('<pre>' + JSON.stringify(a, null, 2) + '</pre>');
		  }
		});	
}

function GetIndexData()
{
	$.ajax({
		  url: '{{ url("elastic/getIndexData") }}', 
		  beforeSend: function(){			
			$('#result').html('<small>Loading....</small>');
		  },
		  type:'GET',
		  headers: { 'Content-Type':'application/json' },
		  dataType: 'json',
		  data:{
			'_token':'{{ csrf_token() }}',
			'name': $('#putIndexTxt').val()
		  },
		  success: function (res) {	
			$('#result').html('<pre>' + JSON.stringify(res, null, 2) + '</pre>');  
		  },
		  error: function(a, b, c){
			$('#result').html('<pre>' + JSON.stringify(a, null, 2) + '</pre>');
		  }
		});	
}

function GetMappingData()
{
	$.ajax({
		  url: '{{ url("elastic/getMappingData") }}', 
		  beforeSend: function(){			
			$('#result').html('<small>Loading....</small>');
		  },
		  type:'GET',
		  headers: { 'Content-Type':'application/json' },
		  dataType: 'json',
		  data:{
			'_token':'{{ csrf_token() }}',
			'name': $('#putIndexTxt').val(),
			'type': $('#putTypeTxt').val()
		  },
		  success: function (res) {	
			$('#result').html('<pre>' + JSON.stringify(res, null, 2) + '</pre>');  
		  },
		  error: function(a, b, c){
			$('#result').html('<pre>' + JSON.stringify(a, null, 2) + '</pre>');
		  }
		});	
}

function PutType()
{
	$.ajax({
		  url: '{{ url("elastic/putType") }}', 
		  beforeSend: function(){			
			$('#result').html('<small>Loading....</small>');
		  },
		  type:'POST',
		  dataType: 'json',
		  data:{
			'_token':'{{ csrf_token() }}',
			'name': $('#putIndexTxt').val(),
			'type': $('#putTypeTxt').val()
		  },
		  success: function (res) {	
			$('#result').html('<pre>' + JSON.stringify(res, null, 2) + '</pre>');  
		  },
		  error: function(a, b, c){
			$('#result').html('<pre>' + JSON.stringify(a, null, 2) + '</pre>');
		  }
		});	
}

function PostAddress()
{
	$.ajax({
		  url: '{{ url("elastic/postAddress") }}', 
		  beforeSend: function(){			
			$('#result').html('<small>Loading....</small>');
		  },
		  type:'POST',
		  dataType: 'json',
		  data:{
			'_token':'{{ csrf_token() }}',
			'name': $('#putIndexTxt').val(),
			'type': $('#putTypeTxt').val(),
			'address': $('#postAddressTxt').val()
		  },
		  success: function (res) {	
			$('#result').html('<pre>' + JSON.stringify(res, null, 2) + '</pre>');  
		  },
		  error: function(a, b, c){
			$('#result').html('<pre>' + JSON.stringify(a, null, 2) + '</pre>');
		  }
		});	
}

function GetExistingElasticData()
{
	$.ajax({
		  url: '{{ url("elastic/getExistingElasticData") }}', 
		  beforeSend: function(){			
			$('#result').html('<small>Loading....</small>');
		  },
		  type:'GET',
		  headers: { 'Content-Type':'application/json' },
		  dataType: 'json',
		  data:{
			'_token':'{{ csrf_token() }}',
			'name': $('#putIndexTxt').val(),
			'type': $('#putTypeTxt').val(),
			'address': $('#postAddressTxt').val()
		  },
		  success: function (res) {	
			$('#result').html('<pre>' + JSON.stringify(res, null, 2) + '</pre>');  
		  },
		  error: function(a, b, c){
			$('#result').html('<pre>' + JSON.stringify(a, null, 2) + '</pre>');
		  }
		});	
}

function GetExistingPostgreSqlData()
{
	$.ajax({
		  url: '{{ url("elastic/getExistingPostgresSqlData") }}', 
		  beforeSend: function(){			
			$('#result').html('<small>Loading....</small>');
		  },
		  type:'GET',
		  headers: { 'Content-Type':'application/json' },
		  dataType: 'json',
		  data:{
			'_token':'{{ csrf_token() }}',
			'name': $('#putIndexTxt').val(),
			'type': $('#putTypeTxt').val(),
			'address': $('#postAddressTxt').val()
		  },
		  success: function (res) {	
			$('#result').html('<pre>' + JSON.stringify(res, null, 2) + '</pre>');  
		  },
		  error: function(a, b, c){
			$('#result').html('<pre>' + JSON.stringify(a, null, 2) + '</pre>');
		  }
		});	
}

</script>
@endsection