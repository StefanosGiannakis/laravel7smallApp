<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Payment;

class Client extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $payment=Payment::where('client_id',$this->id)->orderBy('payments.updated_at', 'DESC')->first();

        return [
            'id'            =>  $this->id,
            'name'          =>  $this->name,
            'surname'       =>  $this->surname,
            'amount'        =>  $payment->amount??null,
            'latest_payment'=>  $payment->updated_at??null
        ];
    }
}
