<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drivers;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\FileUpload;

class DriverController extends Controller
{
    public function get_drivers(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $result = (new Drivers)->get_drivers_lists($post);

                if (isset($result['success']) && $result['success']) {
                    $data = $result['data'];
                    $drivers = $this->format_result($data);

                    foreach ($drivers as &$value) {
                        $value->driver_id = intval($value->id);
                        $value->vehicle_details = [
                            'vehicle_id' => $value->vehicle_id,
                            'vehicle_make' => $value->vehicle_make,
                            'vehicle_model' => $value->vehicle_model,
                            'plate_no' => $value->plate_no,
                            'line_color' => $value->line_color,
                            'vehicle_image' => !empty($value->vehicle_image) ? url($value->vehicle_image) : null,
                        ];

                        unset($value->id);
                        unset($value->vehicle_id);
                        unset($value->vehicle_make);
                        unset($value->vehicle_model);
                        unset($value->plate_no);
                        unset($value->line_color);
                        unset($value->vehicle_image);
                    }

                    $res = [
                        'drivers' => $drivers,
                        'count' => $result['count'],
                        'total_pages' => $result['total_pages'],
                        'has_next' => $result['has_next'],
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
            write_log(__METHOD__ . ' ' . $e->getMessage(), 'error');

            $res = [
                'status' => false,
                'message' => 'Something went wrong',
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function add_new_driver(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $post['profile_image'] = '';

                if (isset($post['has_image']) && $post['has_image'] == env('HAS_IMAGE_UPLOADED')) {
                    // - upload file first
                    $upload = (new FileUpload)->upload($request, 'profile_image');
                    if (isset($upload['success']) && $upload['success']) {
                        $file_url = $upload['file_url'];

                        $post['profile_image'] = $file_url;
                        $post['upload_status'] = true;
                    }
                }

                $result = (new Drivers)->add_new_driver($post);

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
            write_log(__METHOD__ . ' ' . $e->getMessage(), 'error');

            $res = [
                'status' => false,
                'message' => 'Something went wrong',
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function update_driver_status(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $result = (new Drivers)->update_status($post);

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
            write_log(__METHOD__ . ' ' . $e->getMessage(), 'error');

            $res = [
                'status' => false,
                'message' => 'Something went wrong',
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function update_driver_delete_status(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $result = (new Drivers)->update_delete_status($post);

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
            write_log(__METHOD__ . ' ' . $e->getMessage(), 'error');

            $res = [
                'status' => false,
                'message' => 'Something went wrong',
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function get_driver_details(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $result = (new Drivers)->driver_details($post);

                if (isset($result['success']) && $result['success']) {
                    $data = $result['data'];

                    $data->driver_id = intval($data->id);
                    $data->is_deleted = intval($data->is_deleted);
                    $data->status = intval($data->status);
                    $data->password = PW_HASHED;
                    $data->profile_image = empty($data->profile_image) ? url(DEFAULT_PROFILE_IMAGE) : url($data->profile_image);

                    unset($data->id);

                    $res = [
                        'data' => $data,
                        'status' => true,
                    ];
                } else {
                    $res = [
                        'message' => $result['message'],
                        'status' => $result['success'],
                    ];
                }
            } else {
                $res = [
                    'message' => 'Invalid token',
                    'status' => false,
                ];
            }
        } catch (Exception $e) {
            write_log(__METHOD__ . ' ' . $e->getMessage(), 'error');

            $res = [
                'status' => false,
                'message' => 'Something went wrong',
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function update_driver_details(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $login_token = $post['login_token'] ?? null;
            $account_type = $post['account_type'] ?? null;

            if ($this->check_token($login_token, $account_type)) {
                $post['profile_image'] = '';

                if (isset($post['has_image']) && $post['has_image'] == env('HAS_IMAGE_UPLOADED')) {
                    // - upload file first
                    $upload = (new FileUpload)->upload($request, 'profile_image');
                    if (isset($upload['success']) && $upload['success']) {
                        $file_url = $upload['file_url'];

                        $post['profile_image'] = $file_url;
                        $post['upload_status'] = true;
                    }
                }

                $result = (new Drivers)->update_driver_details($post);

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
            write_log(__METHOD__ . ' ' . $e->getMessage(), 'error');

            $res = [
                'status' => false,
                'message' => 'Something went wrong',
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }
}
