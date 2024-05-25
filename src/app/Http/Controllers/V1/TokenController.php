<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    use ApiResponses;

    public function __invoke() {
        $token = Str::random(40);
        $expiration = now()->addMinutes(40)->toDateTimeString();

        DB::table('tokens')->insert([
            'token' => $token,
            'expires_at' => $expiration,
            'used' => false,
        ]);
        return $this->success('I love chess', 200,[
            'token' => $token,
            'expires_at' => $expiration,
        ]);
    }
}
