<?php

namespace App\Admin\Requests;

use App\Http\Requests\JsonFormRequest;
use \Auth;
use \Hash;
use Illuminate\Support\Facades\Validator;
class ResetPassword extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function addValidator()
    {
        Validator::extend('check_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, Auth::guard('admin')->user()->password);
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->addValidator();
        return [
            'original_password' => 'sometimes|required|check_password',
            'password' => 'sometimes|required|min:6|confirmed',
            'password_confirmation' => 'sometimes|required',
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
            'original_password.required' => '原密码必须',
            'original_password.check_password' => '原密码输入不正确',
            'password.required'  => '新密码必填',
            'password.confirmed'  => '新密码与确认密码输入不一致',
            'password_confirmation.required'  => '确认密码必填',
        ];
    }
}
