<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class JsonFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        if($this->ajax()){
            $errors = collect($validator->errors())->transform(function ($item,$key){
                return implode(", ",$item);
            })->toArray();
            throw new HttpResponseException(response()->json(ajax_return(0,['errors'=>$errors]),422));
        }

        return parent::failedValidation($validator);

    }

}