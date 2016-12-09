<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
     * 获取适用于请求的验证规则。
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account' => 'required|unique:users',
            'username' => 'required|unique:users',
        ];
    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     *
     */
    public function messages()
    {
        return [
            'account.required'  => '账号(E-Mail)不能为空',
            'account.unique'  => '账号(E-Mail)已存在',
            'username.required'  => '用户昵称不能为空',
            'username.unique'  => '用户昵称已存在',
        ];
    }
}
