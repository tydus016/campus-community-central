<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class UserTokens extends Model
{
    protected $table = 'user_tokens';

    protected $fillable = [
        'user_id',
        'token_hash',
        'created_at',
        'updated_at',
    ];

    public function check_token_by_hash($token_hash)
    {
        if (!isset($token_hash) || empty($token_hash)) {
            return [
                'success' => false,
                'message' => 'Token hash is required',
            ];
        }

        try {
            $token = self::where('token_hash', $token_hash)->first();

            if ($token) {
                $res = [
                    'success' => true,
                    'token_hash' => $token->token_hash,
                    'data' => $token,
                ];
            } else {
                $res = [
                    'success' => false,
                    'message' => 'Invalid token',
                ];
            }
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }
}
