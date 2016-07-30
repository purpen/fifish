<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\User;

class UserController extends BaseController
{
    
    public function showProfile($id)
    {
        $user = User::findOrFail($id); 
        
        //throw new Symfony\Component\HttpKernel\Exception\ConflictHttpException('User was updated prior to your request.');
        //return $this->response->item($user, new UserTransformer);
        return $this->response->array($user->toArray());
    }
    
}
