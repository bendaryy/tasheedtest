<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        foreach( $request->quantity as $key=>$q){

            return [

                "quantity"[$key]=> $q,
                'amountEGP'[$key] => $request->amountEGP
            ];
        }
    }
}
