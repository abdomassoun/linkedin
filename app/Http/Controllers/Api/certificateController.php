<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\certificate;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Resources\certificateResource;
use App\services\certificateQuery;

class certificateController extends Controller
{
    use apiResponse;

    public function index(Request $request){
        $filter=new certificateQuery();
        $queryItems=$filter->transform($request);//['colemn','operator'.'valye']
        if(count($queryItems)==0){

            // return $this->apiResponse(certificateResource::collection(certificate::get()),'ok',200);
            return $this->apiResponse(certificateResource::collection(certificate::paginate()),'ok',200);
            // return new certificateResource(certificate::paginate());
        }else{
            return $this->apiResponse(certificateResource::collection(certificate::where($queryItems)->paginate()),'ok',200);
        }
    /// based class what i need 
    }

    public function get($id){
        $certificate=certificate::find($id);
        if($certificate){
            return $this->apiResponse(new certificateResource($certificate),'ok',200);
        }else{
            return $this->apiResponse(null,'The certificate Not Found',404);
        }
    }
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            // 'title' => 'required|max:255',
            // 'body' => 'required',
            'name' => 'required',
            'note' => 'required',
            'age' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $certificate = certificate::create($request->all());

        if($certificate){
            return $this->apiResponse(new certificateResource($certificate),'The certificate Save',201);
        }

        return $this->apiResponse(null,'The certificate Not Save',400);
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            // 'title' => 'required|max:255',
            // 'body' => 'required',
            'name' => 'required',
            'note' => 'required',
            'age' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $certificate=certificate::find($id);

        if(!$certificate){
            return $this->apiResponse(null,'The certificate Not Found',404);
        }

        $certificate->update($request->all());

        if($certificate){
            return $this->apiResponse(new certificateResource($certificate),'The certificate update',201);
        }

    }
    public function destroy($id){
        $certificate=certificate::find($id);        
        if(!$certificate){
            return $this->apiResponse(null,'The certificate Not Found',404);
        }

        $certificate->delete($id);

        if($certificate){
            return $this->apiResponse(null,'The certificate deleted',200);
        }


    }
}
