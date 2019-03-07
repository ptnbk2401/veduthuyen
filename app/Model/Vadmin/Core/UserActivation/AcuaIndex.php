<?php

namespace App\Model\Vadmin\Core\UserActivation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcuaIndex extends Model
{
    protected $table = "user_activations";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    public function createActivation($user)
    {

        $activation = $this->getActivation($user);

        if (!$activation) {
            return $this->createToken($user);
        }
        return $this->regenerateToken($user);

    }

    private function regenerateToken($user)
    {

        $token = $this->getToken();
        UserActivation::where('user_id', $user->id)->update([
            'token' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;
    }

    private function createToken($user)
    {
        $token = $this->getToken();
        UserActivation::insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => new Carbon()
        ]);
        return $token;
    }

    public function getActivation($user)
    {
        return UserActivation::where('user_id', $user->id)->first();
    }


    public function getActivationByToken($token)
    {
        return UserActivation::where('token', $token)->first();
    }

    public function deleteActivation($token)
    {
        UserActivation::where('token', $token)->delete();
    }

}


