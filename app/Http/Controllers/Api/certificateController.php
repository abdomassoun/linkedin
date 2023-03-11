<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\certificate;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Resources\certificateResource;

class certificateController extends Controller
{
    public function get($id){
        if(certificate::find($id)){
            return $this->apiResponse(new certificate(certificate::find($id)),'ok',200);
        }else{
            return $this->apiResponse(null,'The certificate Not Found',404);
        }
    }
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            // 'title' => 'required|max:255',
            // 'body' => 'required',
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
