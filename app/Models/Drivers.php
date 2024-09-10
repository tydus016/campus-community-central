<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use DB;

class Drivers extends Model
{
    protected $table = 'drivers';

    protected $fillable = [
        'name',
        'address',
        'email',
        'contact_no',
        'password',
        'profile_image',
        'status',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = ['id'];

    public function get_drivers_lists(array $post)
    {
        $driver_id = isset($post['driver_id']) ? $post['driver_id'] : null;
        $name = isset($post['name']) ? $post['name'] : null;
        $email = isset($post['email']) ? $post['email'] : null;
        $contact_no = isset($post['contact_no']) ? $post['contact_no'] : null;
        $status = isset($post['status']) ? $post['status'] : null;
        $is_deleted = isset($post['is_deleted']) ? $post['is_deleted'] : NOT_DELETED;

        $page = isset($post['page']) ? $post['page'] : 1;
        $limit = isset($post['limit']) ? $post['limit'] : 10;
        $offset = ($page - 1) * $limit;

        $from_date = isset($post['from_date']) ? $post['from_date'] : null;
        $to_date = isset($post['to_date']) ? $post['to_date'] : null;

        try {
            $query = self::select(
                'drivers.*',
                'vehicles.id as vehicle_id',
                'vehicles.vehicle_make',
                'vehicles.vehicle_model',
                'vehicles.plate_no',
                'vehicles.line_color',
                'vehicles.vehicle_image'
            )->leftJoin('vehicles', 'drivers.id', '=', 'vehicles.driver_id')
                ->where('vehicles.is_deleted', NOT_DELETED);

            if ($driver_id) {
                $query = $query->where('drivers.id', $driver_id);
            }

            if ($name) {
                $query = $query->whereAny([
                    'drivers.name'
                ], 'like', "%{$name}%");
            }

            if ($email) {
                $query = $query->where('drivers.email', $email);
            }

            if ($contact_no) {
                $query = $query->where('drivers.contact_no', $contact_no);
            }

            if ($status) {
                $query = $query->where('drivers.status', $status);
            }

            if ($is_deleted) {
                $query = $query->where('drivers.is_deleted', $is_deleted);
            }

            if ($from_date && $to_date) {
                $query = $query->whereBetween('drivers.created_at', [$from_date, $to_date]);
            }

            $total_count = $query->count();

            $result = $query->orderBy('drivers.created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();

            Log::info('Drivers: ' . json_encode($result, true));

            $total_pages = ceil($total_count / $limit);
            $has_next = ($total_count > ($page * $limit));

            $res = [
                'success' => true,
                'count' => $total_count,
                'total_pages' => $total_pages,
                'has_next' => $has_next,
                'data' => $result,
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }

    public function add_new_driver(array $post)
    {
        $name = isset($post['name']) ? $post['name'] : null;
        $address = isset($post['address']) ? $post['address'] : null;
        $email = isset($post['email']) ? $post['email'] : null;
        $contact_no = isset($post['contact_no']) ? $post['contact_no'] : null;
        $password = isset($post['password']) ? $post['password'] : null;
        $confirm_password = isset($post['confirm_password']) ? $post['confirm_password'] : null;

        $current_date = now();

        try {
            $validator = Validator::make($post, [
                'email' => 'required|string|unique:drivers,email',
                'contact_no' => 'required|string|unique:drivers,contact_no',
                'name' => 'required|string',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|string|same:password',
            ]);

            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            }

            $insert_data = [
                'name' => $name,
                'address' => $address,
                'email' => $email,
                'contact_no' => $contact_no,
                'password' => Hash::make($password),
                'profile_image' => $post['profile_image'],
                'is_deleted' => NOT_DELETED,
                'created_at' => $current_date,
            ];

            $result = self::create($insert_data);

            $res = [
                'success' => true,
                'message' => 'Driver account successfully added',
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }

    public function update_status(array $post)
    {
        $driver_id = isset($post['driver_id']) ? $post['driver_id'] : null;
        $status = isset($post['status']) ? $post['status'] : null;
        $current_date = date("Y-m-d H:i:s");

        try {
            $validator = Validator::make($post, [
                'driver_id' => 'required|int',
                'status' => 'required|int|in:0,1',
            ]);

            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            }

            $driver = self::find($driver_id);
            if (!$driver) {
                return [
                    'success' => false,
                    'message' => 'Driver account not found',
                ];
            }

            $driver->status = $status;
            $driver->updated_at = $current_date;
            $driver->save();

            $res = [
                'success' => true,
                'message' => 'Driver account status updated successfully',
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }

    public function update_delete_status(array $post)
    {
        $driver_id = isset($post['driver_id']) ? $post['driver_id'] : null;
        $is_deleted = isset($post['is_deleted']) ? $post['is_deleted'] : null;
        $current_date = date("Y-m-d H:i:s");

        try {
            $validator = Validator::make($post, [
                'driver_id' => 'required|int',
                'is_deleted' => 'required|int|in:0,1',
            ]);

            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            }

            $driver = self::find($driver_id);
            if (!$driver) {
                return [
                    'success' => false,
                    'message' => 'Driver account not found',
                ];
            }

            $driver->is_deleted = $is_deleted;
            $driver->updated_at = $current_date;
            $driver->save();

            $res = [
                'success' => true,
                'message' => 'Driver account deleted successfully',
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }
    public function driver_details(array $post)
    {
        $driver_id = isset($post['driver_id']) ? $post['driver_id'] : null;

        try {
            $validator = Validator::make($post, [
                'driver_id' => 'required|int',
            ]);

            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            }

            $driver = self::find($driver_id);
            if ($driver) {
                $res = [
                    'success' => true,
                    'data' => $driver,
                ];
            } else {
                $res = [
                    'success' => false,
                    'message' => 'Driver account not found',
                ];
            }
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }

    public function update_driver_details(array $post)
    {
        $driver_id = isset($post['driver_id']) ? $post['driver_id'] : null;
        $name = isset($post['name']) ? $post['name'] : null;
        $address = isset($post['address']) ? $post['address'] : null;
        $email = isset($post['email']) ? $post['email'] : null;
        $contact_no = isset($post['contact_no']) ? $post['contact_no'] : null;
        $password = isset($post['password']) ? $post['password'] : null;
        $confirm_password = isset($post['confirm_password']) ? $post['confirm_password'] : null;
        $current_date = date("Y-m-d H:i:s");

        try {
            $rules = [
                'name' => 'required|string',
            ];
            if ($email) {
                $rules['email'] = 'required|string|unique:drivers,email,' . $driver_id;
            }

            if ($contact_no) {
                $rules['contact_no'] = 'required|string|unique:drivers,contact_no,' . $driver_id;
            }

            if ($password) {
                $rules['password'] = 'required|string|min:8';
                $rules['confirm_password'] = 'required|string|same:password';
            }

            $validator = Validator::make($post, $rules);

            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            }

            $driver = self::find($driver_id);
            if (!$driver) {
                return [
                    'success' => false,
                    'message' => 'Driver account not found',
                ];
            }

            $driver->name = $name;
            $driver->address = $address;
            $driver->email = $email;
            $driver->contact_no = $contact_no;
            if ($password) {
                $driver->password = Hash::make($password);
            }
            if (!empty($post['profile_image']) && $post['upload_status']) {
                $driver->profile_image = $post['profile_image'];
            }
            $driver->updated_at = $current_date;

            $driver->save();

            $res = [
                'success' => true,
                'message' => 'Driver account updated successfully',
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }


    protected function find_one(array $conditions)
    {
        try {
            $query = self::select('*');
            foreach ($conditions as $key => $value) {
                $query = $query->where($key, $value);
            }

            $count = $query->count();

            $result = $query->first();

            $res = [
                'success' => true,
                'count' => $count,
                'data' => $result,
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }
}
