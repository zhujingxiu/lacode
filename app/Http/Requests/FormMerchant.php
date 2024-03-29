<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
class FormMerchant extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','min:4','unique:merchants,name'],
            'nick_name' => 'required|min:2|max:32',
            'password' => 'required|min:6|max:32',
            'code' => ['required', Rule::in(['company', 'shareholder', 'agent', 'proxy','admin','child']), ],
            'rate' => 'sometimes|required|numeric',
            'credit' => 'sometimes|required|numeric',
            'charges' => 'sometimes|required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户账户为必填字段',
            'nick_name.required' => '名称标题为必填字段',
            'credit.required'  => '信用额度为必填字段',
            'credit.numeric'  => '信用额度为数字字段',
            'charges.numeric'  => '赚佣为数字字段',
            'rate.required'  => '占成为必填字段',
            'rate.numeric'  => '占成为数字字段',
            'code.required'  => '用户类型异常',
            'code.in'  => '用户类型异常',
        ];
    }
}
