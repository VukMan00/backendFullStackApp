<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = "answer";
    public function toArray($request)
    {
        return [
            'id'=>$this->resource->id,
            'content'=>$this->resource->content,
            'answer'=>$this->resource->answer,
        ];
    }
}
