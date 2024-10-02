<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\AdminTokens;
use App\Models\UserTokens;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

abstract class Controller
{
    //

    protected function start_transact()
    {
        DB::beginTransaction();
    }

    protected function commit_transact()
    {
        DB::commit();
    }

    protected function rollback_transact()
    {
        DB::rollBack();
    }

    protected function end_transact()
    {
        DB::disconnect();
    }

    protected function _response(array $data, $status = 200)
    {
        return response()->json($data, $status);
    }

    protected function check_token($token, $account_type = null, $returnToken = false)
    {
        $admin_types = [env('ADMIN_ACCOUNT_TYPE_SUPER_ADMIN'), env('ADMIN_ACCOUNT_TYPE_ADMIN')];

        if (in_array($account_type, $admin_types)) {
            $result = (new AdminTokens)->check_token_by_hash($token);
        } else {
            $result = (new UserTokens)->check_token_by_hash($token);
        }

        if (isset($result['success']) && $result['success']) {
            $status = true;

            $res = [
                'success' => true,
                'token' => $result['token_hash'],
            ];
        } else {
            $status = false;

            $res = [
                'success' => false,
                'message' => $result['message'],
            ];
        }


        return $returnToken ? $res : $status;
    }

    protected function fileUpload(Request $request, $fileKey = null)
    {
        try {
            $request->validate([
                $fileKey => 'required|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);

                // Define a unique file name
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Store the file in the 'uploads' directory (you can change this path)
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                $res = [
                    'success' => true,
                    'file_path' => '/storage/' . $filePath,
                    'message' => 'File uploaded successfully!',
                ];
            } else {
                $res = [
                    'success' => false,
                    'message' => 'No file was uploaded.',
                ];
            }
        } catch (\Exception $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }

    public function date_to_string($date, $is_date_time = false)
    {
        if (empty($date) || !isset($date)) return;

        if ($is_date_time) {
            return date("M. d, Y h:i:s A", strtotime($date));
        }
        return date("M. d, Y", strtotime($date));
    }

    protected function _printError($message)
    {
        return $this->_response([
            'success' => false,
            'message' => $message,
        ]);
    }

    protected function format_result($data)
    {
        foreach ($data as $value) {
            if (is_object($value)) {
                if (isset($value->created_at)) {
                    $value->created_at = date_to_string($value->created_at, true);
                }
                if (isset($value->updated_at)) {
                    $value->updated_at = date_to_string($value->updated_at, true);
                }
                if (isset($value->password)) {
                    $value->password = PW_HASHED;
                }
                if (isset($value->account_type)) {
                    if ($value->account_type == ADMIN_TYPE_SUPER) {
                        $value->account_type = 'Super Admin';
                    } else if ($value->account_type == ADMIN_TYPE_ADMIN) {
                        $value->account_type = 'Admin';
                    } else if ($value->account_type == ADMIN_TYPE_STAFF) {
                        $value->account_type = 'Staff';
                    }
                }
                if (isset($value->account_type)) {
                    if ($value->account_status == ACCOUNT_STATUS_INACTIVE) {
                        $value->account_status = 'Inactive';
                    } else if ($value->account_status == ACCOUNT_STATUS_ACTIVE) {
                        $value->account_status = 'Active';
                    }
                }
                if (empty($value->profile_image)) {
                    $value->profile_image = url(DEFAULT_PROFILE_IMAGE);
                } else {
                    $value->profile_image = url($value->profile_image);
                }
            }
            if (is_array($value)) {
                if (isset($value['created_at'])) {
                    $value['created_at'] = date_to_string($value['created_at'], true);
                }
                if (isset($value['updated_at'])) {
                    $value['updated_at'] = date_to_string($value['updated_at'], true);
                }
                if (isset($value['password'])) {
                    $value['password'] = PW_HASHED;
                }
                if (isset($value['account_type'])) {
                    if ($value['account_type'] == ADMIN_TYPE_SUPER) {
                        $value['account_type'] = 'Super Admin';
                    } else if ($value['account_type'] == ADMIN_TYPE_ADMIN) {
                        $value['account_type'] = 'Admin';
                    } else if ($value['account_type'] == ADMIN_TYPE_STAFF) {
                        $value['account_type'] = 'Staff';
                    }
                }
                if (isset($value['account_type'])) {
                    if ($value['account_status'] == ACCOUNT_STATUS_INACTIVE) {
                        $value['account_status'] = 'Inactive';
                    } else if ($value['account_status'] == ACCOUNT_STATUS_ACTIVE) {
                        $value['account_status'] = 'Active';
                    }
                }
                if (empty($value['profile_image'])) {
                    $value['profile_image'] = url(DEFAULT_PROFILE_IMAGE);
                } else {
                    $value['profile_image'] = url($value['profile_image']);
                }
            }
        }

        return $data;
    }

    protected function generate_num($strength = 4)
    {
        $permitted_chars = '0123456789';
        $input_length = strlen($permitted_chars);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }

    protected function generate_code($strength = 20)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($permitted_chars);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return strtolower($random_string);
    }

    protected function genUniqueID($length = 10)
    {
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $uniqueId = "";
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $uniqueId .= $characters[$randomIndex];
        }
        return $uniqueId;
    }
}
