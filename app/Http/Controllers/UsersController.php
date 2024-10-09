<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class UsersController extends Controller
{

    public function user_profile_view()
    {
        return Inertia::render('Users/Profile');
    }

    public function users_lists_view()
    {
        return Inertia::render('Users/Lists');
    }

    public function users_details_view($id)
    {
        return Inertia::render('Users/Details', [
            'user_id' => $id,
        ]);
    }

    public function new_user_view()
    {
        return Inertia::render('Users/NewUser');
    }

    // - end of views - //

    public function create_user(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Users())->create_user($post);
            if (isset($result['success']) && $result['success']) {
                $this->commit_transact();
            }

            $res = [
                'message' => $result['message'],
                'status' => $result['success'],
            ];
        } catch (Exception $e) {
            $this->rollback_transact();

            $res = [
                'messtatussage' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function users_lists(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Users())->get_users_lists($post);
            if (isset($result['success']) && $result['success']) {

                $res = [
                    'data' => $result['data'],
                    'count' => $result['count'],
                    'total_count' => $result['total_count'],
                    'has_next' => $result['has_next'],
                    'status' => true,
                ];
            } else {
                $res = [
                    'message' => $result['message'],
                    'status' => false,
                ];
            }
        } catch (Exception $e) {
            Log::error(__METHOD__ . ' - ' . $e->getMessage());

            $res = [
                'message' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function users_details(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Users())->get_user_details($post);
            if (isset($result['success']) && $result['success']) {

                $data = $result['data'];
                unset($data['password']);

                $res = [
                    'data' => $data,
                    'status' => true,
                ];
            } else {
                $res = [
                    'message' => $result['message'],
                    'status' => false,
                ];
            }
        } catch (Exception $e) {
            Log::error(__METHOD__ . ' - ' . $e->getMessage());

            $res = [
                'message' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function update_user_status(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Users())->update_user_status($post);
            if (isset($result['success']) && $result['success']) {
                $this->commit_transact();
            }

            $res = [
                'message' => $result['message'],
                'status' => $result['success'],
            ];
        } catch (Exception $e) {
            $this->rollback_transact();
            Log::error(__METHOD__ . ' - ' . $e->getMessage());

            $res = [
                'message' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function update_delete_flg(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $post['key'] = 'delete_flg';

            $result = (new Users())->update_user_status($post);
            if (isset($result['success']) && $result['success']) {
                $this->commit_transact();
            }

            $res = [
                'message' => $result['message'],
                'status' => $result['success'],
            ];
        } catch (Exception $e) {
            $this->rollback_transact();
            Log::error(__METHOD__ . ' - ' . $e->getMessage());

            $res = [
                'message' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function update_user_details(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Users())->update_user_details($post);
            if (isset($result['success']) && $result['success']) {
                $this->commit_transact();
            }

            $res = [
                'message' => $result['message'],
                'status' => $result['success'],
            ];
        } catch (Exception $e) {
            $this->rollback_transact();
            Log::error(__METHOD__ . ' - ' . $e->getMessage());

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
