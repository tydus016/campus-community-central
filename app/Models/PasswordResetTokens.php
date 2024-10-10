<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PasswordResetTokens extends Model
{
    protected $table = 'password_reset_tokens';

    protected $fillable = [
        'email',
        'token',
        'created_at',
        'updated_at',
        'user_id',
    ];

    public function create_token($user_id)
    {
        try {
            $validate = Validator::make(['user_id' => $user_id], [
                'user_id' => 'required|integer|exists:users,id|unique:password_reset_tokens,user_id',
            ]);

            if ($validate->fails()) {
                return [
                    'success' => false,
                    'message' => $validate->errors()->first(),
                ];
            }

            $token = generate_code(15);

            $insert_data  = [
                'email' => 'otenan',
                'token' => $token,
                'user_id' => $user_id,
            ];

            $result = $this->create($insert_data);

            if ($result) {
                $res = [
                    'success' => true,
                    'message' => 'Password reset token created successfully',
                    'token' => $token,
                ];
            } else {
                $res = [
                    'success' => false,
                    'message' => 'An error occurred while creating password reset token',
                ];
            }
        } catch (\Exception $e) {
            Log::error('PasswordResetTokens create_token error: ' . $e->getMessage());

            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        Log::info('PasswordResetTokens create_token result: ' . json_encode($result));

        return $res;
    }

    public function delete_one($id) {

    }
}
