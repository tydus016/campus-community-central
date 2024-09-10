<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('date_to_string')) {
    function date_to_string($date, $is_date_time = false)
    {
        if (empty($date) || !isset($date)) return null;

        if ($is_date_time) {
            return date("M. d, Y h:i:s A", strtotime($date));
        }
        return date("M. d, Y", strtotime($date));
    }
}

if (!function_exists('write_log')) {
    function write_log($message = null, $type = 'info')
    {
        if (empty($message) || !isset($message)) return null;

        switch ($type) {
            case 'info':
                Log::info($message);
                break;
            case 'error':
                Log::error($message);
                break;
            case 'warning':
                Log::warning($message);
                break;
            case 'debug':
                Log::debug($message);
                break;
            default:
                Log::info($message);
                break;
        }
    }
}

if (!function_exists('generate_num')) {
    function generate_num($strength = 4)
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
}


if (!function_exists('generate_code')) {
    function generate_code($strength = 20)
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
}

if (!function_exists('format_result')) {
    /**
     * @author eduardo omega
     * @param array $result
     * @description format results to string formats
     * @return array
     */
    function format_result($data)
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
}
