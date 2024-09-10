<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class AdminTokens extends Model
{
    protected $table = 'admin_tokens';

    protected $fillable = [
        'admin_id',
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

    public function check_token_by_id($id)
    {
        if (!isset($id) || empty($id)) {
            return [
                'success' => false,
                'message' => 'Token id is required',
            ];
        }

        try {
            $token = self::where('admin_id', $id)->first();

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

    public function create_token($post)
    {
        $admin_id = isset($post['admin_id']) ? $post['admin_id'] : null;
        $token_hash = isset($post['token_hash']) ? $post['token_hash'] : generate_code(17);
        $current_date = date('Y-m-d H:i:s');

        try {
            $validator = Validator::make($post, [
                'admin_id' => 'required|integer|string',
            ]);

            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            }

            $insert_data = [
                'admin_id' => $admin_id,
                'token_hash' => $token_hash,
                'created_at' => $current_date,
            ];

            $token = self::create($insert_data);

            $res = [
                'success' => true,
                'message' => 'Token created successfully',
                'token_hash' => $token_hash,
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }
}
