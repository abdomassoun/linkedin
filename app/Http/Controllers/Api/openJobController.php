<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\openjob;
use app\Http\Resources\openJobResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class openJobController extends Controller
{
    public function get($id){
        if(openJob::find($id)){
            return $this->apiResponse(new openJobResource(openJob::find($id)),'ok',200);
        }else{
            return $this->apiResponse(null,'The openJob Not Found',404);
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

        $openJob = openJob::create($request->all());

        if($openJob){
            return $this->apiResponse(new openJobResource($openJob),'The openJob Save',201);
        }

        return $this->apiResponse(null,'The openJob Not Save',400);
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            // 'title' => 'required|max:255',
            // 'body' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),400);
        }

        $openJob=openJob::find($id);

        if(!$openJob){
            return $this->apiResponse(null,'The openJob Not Found',404);
        }

        $openJob->update($request->all());

        if($openJob){
            return $this->apiResponse(new openJobResource($openJob),'The openJob update',201);
        }

    }

    public function destroy($id){
        $openJob=openJob::find($id);

        if(!$openJob){
            return $this->apiResponse(null,'The openJob Not Found',404);
        }

        $openJob->delete($id);

        if($openJob){
            return $this->apiResponse(null,'The openJob deleted',200);
        }


    }
}
