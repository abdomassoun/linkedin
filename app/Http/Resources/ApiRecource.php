<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiRecource extends JsonResource
{
     /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    protected $MyArray=[];

    protected function transformarray(){
        $array=[];
        foreach($this->MyArray as $key=>$value){
            $array[$key]=$this->$value;
        }
        return $array;
    }
    public function __construct($resource,$MyArray)
    {
        parent::__construct($resource);
        $this->MyArray=$MyArray;

    }

    public function toArray(Request $request): array
    {
        // dd($this->transformarray());
        return $this->transformarray();
    }
}
