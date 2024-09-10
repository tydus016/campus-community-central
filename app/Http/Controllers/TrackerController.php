<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Geofence;
use Exception;
use Illuminate\Support\Facades\Log;

class TrackerController extends Controller
{
    public function create_geofence(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $result = (new Geofence)->create_fence($post);

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
            Log::error(__METHOD__ . ' - ' . $e->getMessage());

            $res =  [
                'message' => 'An error occurred',
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function get_active_fence(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $result = (new Geofence)->get_active_fence();

                if (isset($result['success']) && $result['success']) {
                    $data = $result['data'];
                    if (is_string($data->coordinates)) {
                        try {
                            $data->coordinates = json_decode($data->coordinates, true);
                        } catch (Exception $e) {
                            Log::error(__METHOD__ . ' - ' . $e->getMessage());
                        }
                    }

                    $res = [
                        'data' => $data,
                        'status' => true,
                        'message' => 'Geofence retrieved successfully',
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
            Log::error(__METHOD__ . ' - ' . $e->getMessage());

            $res = [
                'message' => 'An error occurred',
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function is_inside_fence(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $result = (new Geofence)->is_inside_fence($post);

                if (isset($result['success']) && $result['success']) {
                    $res = [
                        'status' => true,
                        'is_inside' => $result['inside'],
                        'message' => 'Inside the fence',
                    ];
                } else {
                    $res = [
                        'status' => false,
                        'message' => $result['message'],
                    ];
                }
            } else {
                $res = [
                    'message' => 'Invalid token',
                    'status' => false,
                ];
            }
        } catch (Exception $e) {
            Log::error(__METHOD__ . ' - ' . $e->getMessage());
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function get_geofence_lists(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $result = (new Geofence)->get_fences_lists($post);

                if (isset($result['success']) && $result['success']) {
                    $res = [
                        'data' => $result['data'],
                        'count' => $result['count'],
                        'has_next' => $result['has_next'],
                        'total_pages' => $result['total_pages'],
                        'status' => true,
                        'message' => 'Geofence lists retrieved successfully',
                    ];
                } else {
                    $res = [
                        'status' => false,
                        'message' => $result['message'],
                    ];
                }
            } else {
                $res = [
                    'message' => 'Invalid token',
                    'status' => false,
                ];
            }
        } catch (Exception $e) {
            Log::error(__METHOD__ . ' - ' . $e->getMessage());
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }
}
