<?php

namespace App\Admin\Requests;
use App\Http\Requests\JsonFormRequest;
class FormAdmin extends JsonFormRequest
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
            'name' => ['required','min:4','unique:admins,name'],
            'nick_name' => 'required|min:2|max:30',
            'password' => 'required|min:6|max:30',

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
            'nick_name.required' => '用户名称为必填字段',
            'password.required' => '密码为必填字段',
        ];
    }


}
