<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminTokens;
use Exception;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function auth_v2(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Admin)->authenticate($post);
            if (isset($result['success']) && $result['success']) {
                $usersData = $result['data'];

                $AdminTokens = new AdminTokens;

                // - check if user has a token
                $adminToken = $AdminTokens->check_token_by_id($usersData->id);
                if (isset($adminToken['success']) && !$adminToken['success']) {
                    // - create token
                    $token = $AdminTokens->create_token([
                        'admin_id' => $usersData->id,
                    ]);

                    if (isset($token['success']) && !$token['success']) {
                        return $this->_response([
                            'message' => $token['message'],
                            'status' => false,
                        ]);
                    }

                    $token_hash = $token['token_hash'];

                    $this->commit_transact();
                } else {
                    $token_hash = $adminToken['token_hash'];
                }

                $session_data = [
                    'user_id' => $usersData->id,
                    'account_type' => $usersData->account_type,
                    'token_hash' => $token_hash,
                    'username' => $usersData->username,
                ];

                $res = [
                    'session' => $session_data,
                    'status' => true,
                    'message' => 'Login successful',
                ];
            } else {
                $res = [
                    'message' => $result['message'],
                    'status' => false,
                ];
            }
        } catch (Exception $e) {
            $this->rollback_transact();

            $res = [
                'message' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }
}
