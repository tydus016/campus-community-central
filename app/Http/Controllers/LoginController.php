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
                    'login_token' => $user->remember_token,
                    'account_type' => $user->account_type,
                ];

                try {
                    $password_verify = Hash::check($post['password'], $user->password);
                } catch (Exception $e) {
                    $password_verify = password_verify($post['password'], $user->password);
                }

                if ($password_verify) {
                    $request->session()->regenerate();

                    $request->session()->put('user', $session_data);

                    $res = [
                        'status' => true,
                        'message' => 'Login successful',
                        'data' => $session_data,
                        'redirect' => $this->redirect_path($user->account_type),
                        // 'session' => $request->session()->all(),
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

    private function redirect_path($account_type)
    {
        switch ($account_type) {
            case ACCOUNT_TYPE_USER:
                return '/dashboard';
            case ACCOUNT_TYPE_ADMIN:
                return '/admin/home';
            case ACCOUNT_TYPE_HEAD_ADMIN:
                return '/dashboard';

            default:
                return false;
        }
    }
}
