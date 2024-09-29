<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UpdateProfileRequest;
use App\Traits\ResponseAPI;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ResponseAPI;
    public function index()
    {
        return $this->requestSuccessData(Auth::guard('api')->user());
    }

    public function update(UpdateProfileRequest $updateProfileRequest)
    {
        $input = $updateProfileRequest->only('name', 'email');
        Auth::guard('api')->user()->update($input);
        return $this->requestSuccessData(auth('api')->user(), 'success', 'Profile has been successfully updated.');
    }
}
