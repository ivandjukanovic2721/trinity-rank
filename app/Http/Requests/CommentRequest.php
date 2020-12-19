<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|max:64',
            'email' => 'required|email',
            'content' => 'required'
        ];
    }
}
