<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\FileUpload;
use Exception;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function add_new_admin(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $result = (new Admin)->add_new_admin($post);

                if (isset($result['success']) && $result['success']) {
                    $this->commit_transact();

                    $res = [
                        'message' => 'Admin account successfully added',
                        'status' => true,
                    ];
                } else {
                    $res = [
                        'message' => $result['message'],
                        'status' => false,
                    ];
                }
            } else {
                $res = [
                    'message' => 'Invalid token',
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

    public function get_admin_lists(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $result = (new Admin())->get_admin_lists($post);

                if (isset($result['success']) && $result['success']) {
                    foreach ($result['data'] as $key => &$value) {
                        $value->profile_image = $value->profile_image ? url($value->profile_image) : null;
                        $value->password = '*****';
                    }

                    $res = [
                        'admins' => $result['data'],
                        'has_next' => $result['has_next'],
                        'count' => $result['count'],
                        'total_pages' => $result['total_pages'],
                        'status' => true,
                    ];
                } else {
                    $res = [
                        'message' => $result['message'],
                        'status' => false,
                    ];
                }
            } else {
                $res = [
                    'message' => 'Invalid token',
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

    public function update_admin_profile(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                if (isset($post['has_image']) && $post['has_image'] == env('HAS_IMAGE_UPLOADED')) {
                    // - upload file first
                    $upload = (new FileUpload)->upload($request, 'profile_image');
                    if (isset($upload['success']) && $upload['success']) {
                        $file_url = $upload['file_url'];

                        $post['profile_image'] = $file_url;
                        $post['upload_status'] = true;
                    }
                }


                Log::info('UPLOAD : => ' . json_encode($upload, true));
                Log::info('file_url : => ' . $file_url);

                $result = (new Admin)->update_profile($post);

                if (isset($result['success']) && $result['success']) {
                    $this->commit_transact();
                }

                $res = [
                    'message' => $result['message'],
                    'status' => $result['success'],
                ];
            } else {
                $res = [
                    'message' => 'Invalid token',
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

    public function get_admin_details(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $result = (new Admin)->admin_details($post);
                $result['data']->password = '*****';
                $result['data']->profile_image = $result['data']->profile_image ? url($result['data']->profile_image) : null;

                if (isset($result['success']) && $result['success']) {
                    $res = [
                        'admin' => $result['data'],
                        'status' => true,
                    ];
                } else {
                    $res = [
                        'message' => $result['message'],
                        'status' => false,
                    ];
                }
            } else {
                $res = [
                    'message' => 'Invalid token',
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
