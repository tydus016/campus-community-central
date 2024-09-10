<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class Vehicles extends Model
{
    public function add_new_vehicle(array $post)
    {
        $driver_id = isset($post['driver_id']) ? $post['driver_id'] : null;
        $vehicle_make = isset($post['vehicle_make']) ? $post['vehicle_make'] : null;
        $vehicle_model = isset($post['vehicle_model']) ? $post['vehicle_model'] : null;
        $plate_no = isset($post['plate_no']) ? $post['plate_no'] : null;
        $line_color = isset($post['line_color']) ? $post['line_color'] : null;

        $current_date = date("Y-m-d H:i:s");

        try {
            $validate = Validator::make($post, [
                'driver_id' => 'required|integer|string',
                'vehicle_make' => 'required|string',
                'vehicle_model' => 'required|string',
                'plate_no' => 'required|string',
            ]);

            if ($validate->fails()) {
                return [
                    'success' => false,
                    'message' => $validate->errors()->first(),
                ];
            }



        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
