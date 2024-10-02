<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Users)->get_user_details($post);
            if (isset($result['success']) && $result['success']) {
                $user = $result['data'];

                $session_data = [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'login_token' => $user->login_token,
                    'account_type' => $user->account_type,
                ];

                if (Hash::check($post['password'], $user->password)) {
                    $res = [
                        'status' => true,
                        'message' => 'Login successful',
                        'data' => $session_data,
                    ];
                } else {
                    $res = [
                        'status' => false,
                        'message' => 'Invalid username or password',
                    ];
                }
            } else {
                $res = [
                    'message' => $result['message'],
                    'status' => false,
                ];
            }
        } catch (Exception $e) {
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
