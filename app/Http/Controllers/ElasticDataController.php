<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Index;
use App\Type;
use App\SearchData;
use Response;

class ElasticDataController extends Controller {

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('elastic.index');
	}
	
	public function GetCurl($url)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		
		return $response;
	}
	
	public function PutIndexCurl($url)
	{
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json') );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT");
		
		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}
	
	public function PutTypeCurl($url, $params)
	{
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json') );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $params);
		
		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}
	
	public function PostAddressCurl($url, $params)
	{
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json') );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $params);
		
		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}
	
	public function test()
	{
		return self::GetCurl(env('ELASTIC_URL'));
	}
	
	public function putIndex(Request $request)
	{
		$response = self::PutIndexCurl(env('ELASTIC_URL').'/'.$request->name);
		$resArr = json_decode($response);
		
		if(!empty($resArr->acknowledged))
		{
			if($resArr->acknowledged)
			{
				$newIndex = new Index();
				$newIndex->name = $request->name;
				$newIndex->save();
			}
		}
		return $response;
	}
	
	public function getIndexData(Request $request)
	{
		return self::GetCurl(env('ELASTIC_URL').'/'.$request->name);
	}
	
	public function getMappingData(Request $request)
	{
		return self::GetCurl(env('ELASTIC_URL').'/'.$request->name.'/_mapping/'.$request->type);
	}
	
	public function putType(Request $request)
	{
		$response = self::PutTypeCurl(env('ELASTIC_URL').'/'.$request->name.'/_mapping/'.$request->type, 
			'{ "' 
				. $request->type . '" :  { 
					"properties" : {
						"address" : {"type" : "string"}
					}
				}
			 }'				
		);
		
		$resArr = json_decode($response);
		
		if(!empty($resArr->acknowledged))
		{
			if($resArr->acknowledged)
			{
				$oldIndex = Index::where('name', '=', $request->name)->first();
				
				$newType = new Type();
				$newType->name = $request->type;
				$newType->index_id = $oldIndex->id;
				$newType->save();
			}
		}
		return $response;
	}
	
	public function postAddress(Request $request)
	{
		$response = self::PostAddressCurl(env('ELASTIC_URL').'/'.$request->name.'/'.$request->type, 
			'{ 
				"address": "' . $request->address . '"
			 }'				
		);
		
		$resArr = json_decode($response);
		
		if(!empty($resArr->created))
		{
			if($resArr->created)
			{
				$oldType = Type::where('name', '=', $request->type)->first();
				
				$searchData = new SearchData();
				$searchData->address_id = $resArr->_id;
				$searchData->address = $request->address;
				$searchData->type_id = $oldType->id;
				$searchData->save();
			}
		}
		return $response;
	}
	
	public function GetExistingElasticData(Request $request)
	{
		return self::GetCurl(env('ELASTIC_URL').'/'.$request->name.'/'.$request->type.'/_search?q='.$request->address);
	}
	
	public function GetExistingPostgreSqlData(Request $request)
	{
		$type = Type::where('name', '=', $request->type)->first();
		if(count($type) > 0) $searchDataCount = SearchData::where('type_id', '=', $type->id)->count();
		 if(count($type) > 0) $index = Index::where('id', '=', $type->index_id)->first();
		
		if(empty($type) || empty($index))
		{
			return Response::json(
            [
			  'response' => 'Success',
			  'message' => 'No Result Found',
              'total' => 0
            ]
		  );
		}
		
		if($request->address == '')
		{
			return Response::json(
            [
			  'response' => 'Success',
			  'message' => 'No Result Found',
              'total' => 0
            ]
          );
		}
		
		if($request->address == '*')
		{			
			$searchDatas = SearchData::where('type_id', '=', $type->id)->get();
		}
		else
		{
			$searchDatas = SearchData::where('address', '=', $request->address)->get();			
		}
			
		$searchDataArr = array();
		if(!empty($searchDatas))
		{
			foreach($searchDatas as $k => $v)
			{
				$searchDataArr[$k] = new \stdClass();
				$searchDataArr[$k]->id = $v->id;
				$searchDataArr[$k]->address_id = $v->address_id;
				$searchDataArr[$k]->address = $v->address;
			}
			return Response::json(
			[
			  'response' => 'Success',
			  'index' => $index->name,
			  'type' => $type->name,
			  'data' => $searchDataArr,
			  'total' => count($searchDatas)
			]
		  );
		}
		else
		{
			return Response::json(
            [
			  'response' => 'Success',
			  'message' => 'No Result Found',
              'total' => 0
            ]
		  );
		}
	}
	

}
