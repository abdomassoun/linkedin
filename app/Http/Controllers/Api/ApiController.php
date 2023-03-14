<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


// use App\Models\Api;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApiRecource;
use App\services\ApiQuery;


class ApiController extends Controller
{
    use apiResponse;
    protected $validationarry;
    protected $recourcearry;
    protected $modelname;

    protected $model;
    protected $safeParms ;
    protected $columnMap ;
    public function __construct($modelname,$model,$validationarry,$recourcearry,$safeParms,$columnMap)//must add validation and recourcearray
    {
        $this->modelname=$modelname;
        $this->model = $model;
        $this->validationarry=$validationarry;
        $this->recourcearry=$recourcearry;
        $this->safeParms=$safeParms;
        $this->columnMap=$columnMap;
        
    }

    public function index(Request $request){
        $filter=new ApiQuery($this->safeParms,$this->columnMap);
        $queryItems=$filter->transform($request);//['colemn','operator'.'valye']
        if(count($queryItems)==0){
            return $this->apiResponse(ApiRecource::collection($this->model::paginate()),'ok',200);
        }else{
            $cert=ApiRecource::collection($this->model::where($queryItems)->paginate());
            if(count($cert)==0){
            // return $this->apiResponse($cert,'null',404);
            return $this->apiResponse(null,"The $this->modelname Not Found",404);
            }
            return $this->apiResponse($cert,'ok',200);
        }
    /// based class what i need 
    }

    public function get($id){
        $model=$this->model::find($id);
        if($model){
            return $this->apiResponse(new ApiRecource($model,$this->recourcearry),'ok',200);
        }else{
            return $this->apiResponse(null,"The $this->modelname Not Found",404);
        }
    }
    public function create(Request $request){
        $validator = Validator::make($request->all(),$this->validationarry);

        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $model = $this->model::create($request->all());

        if($model){
            return $this->apiResponse(new ApiRecource($model,$this->recourcearry),"The $this->modelname Save",201);
        }

        return $this->apiResponse(null,"The $this->modelname Not Save",400);
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), $this->validationarry);

        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $model=$this->model::find($id);

        if(!$model){// "The $this->modelname Save"
            return $this->apiResponse(null,"The $this->modelname Not Found",404);
        }

        $model->update($request->all());

        if($model){
            return $this->apiResponse(new ApiRecource($model,$this->recourcearry),"The $this->modelname update",201);
        }

    }
    public function destroy($id){
        $model=$this->model::find($id);        
        if(!$model){
            return $this->apiResponse(null,"The $this->modelname Not Found",404);
        }

        $model->delete($id);

        if($model){
            return $this->apiResponse(null,"The $this->modelname deleted",200);
        }


    }
}
