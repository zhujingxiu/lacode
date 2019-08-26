<?php

namespace App\Http\Requests;
use App\Http\Requests\JsonFormRequest;
use Illuminate\Validation\Rule;
class FormMember extends JsonFormRequest
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
            'name' => ['required','min:4','unique:members,name'],
            'nick_name' => 'required|min:2|max:30',
            'password' => 'required|min:6|max:30',
            'rate' => 'sometimes|required|numeric',
            'credit' => 'sometimes|required|numeric',
            'roulette' => ['sometimes','required', Rule::in(['a', 'b', 'c']), ],
        ];
    }


    /**
     * 获取已定义的验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '用户账户为必填字段',
            'nick_name.required' => '名称标题为必填字段',
            'credit.required'  => '信用额度为必填字段',
            'credit.numeric'  => '信用额度为数字字段',
            'roulette.required'  => '盘口为必填字段',
            'roulette.in'  => '盘口选择错误',
            'rate.required'  => '占成为必填字段',
            'rate.numeric'  => '占成为数字字段',
        ];
    }
}
