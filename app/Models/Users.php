<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Users extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'department_id',
        'organization_id',
        'remember_token',
        'first_name',
        'last_name',
        'school_id',
        'childhood_nickname',
        'bestfriend_name',
        'first_pet_name',
        'password',
        'login_token',
        'account_type',
        'delete_flg',
        'created_at',
        'updated_at',
    ];


    public function create_user(array $post)
    {
        $department_id = $post['department_id'] ?? null;
        $organization_id = $post['organization_id'] ?? null;
        $first_name = $post['first_name'] ?? null;
        $last_name = $post['last_name'] ?? null;
        $school_id = $post['school_id'] ?? null;
        $childhood_nickname = $post['childhood_nickname'] ?? null;
        $bestfriend_name = $post['bestfriend_name'] ?? null;
        $first_pet_name = $post['first_pet_name'] ?? null;
        $password = $post['password'] ?? null;
        $confirm_password = $post['confirm_password'] ?? null;

        $remember_token = $post['login_token'] ?? generate_code(8);
        $account_type = $post['account_type'] ?? null;
        $current_date = now();

        Log::info('create_user: ' . json_encode($post));

        try {
            $validator = Validator::make($post, [
                'first_name' => 'required',
                'last_name' => 'required',
                'school_id' => 'required|unique:users',
                'childhood_nickname' => 'required',
                'bestfriend_name' => 'required',
                'first_pet_name' => 'required',
                'password' => 'required|min:8|max:16',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return [
                    'message' => $validator->errors()->first(),
                    'success' => false,
                ];
            }

            $insert_data  = [
                'department_id' => $department_id,
                'organization_id' => $organization_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'school_id' => $school_id,
                'childhood_nickname' => $childhood_nickname,
                'bestfriend_name' => $bestfriend_name,
                'first_pet_name' => $first_pet_name,
                'password' => Hash::make($password),
                'account_type' => $account_type,
                'remember_token' => $remember_token,
                'created_at' => $current_date,
            ];

            $user = self::create($insert_data);

            $res = [
                'data' => $user,
                'success' => true,
                'message' => 'User created successfully'
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return $res;
    }

    public function get_user_details(array $post)
    {
        $user_id = $post['user_id'] ?? null;
        $school_id = $post['school_id'] ?? null;

        try {
            $query = self::query();

            if ($user_id) {
                $query->where('id', $user_id);
            }

            if ($school_id) {
                $query->where('school_id', $school_id);
            }

            $result = $query->first();

            if ($result) {
                $res = [
                    'success' => true,
                    'data' => $result,
                ];
            } else {
                $res = [
                    'success' => false,
                    'message' => 'User not found'
                ];
            }
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return $res;
    }

    public function update_password(array $post)
    {
        $user_id = $post['user_id'] ?? null;
        $password = $post['password'] ?? null;
        $confirm_password = $post['confirm_password'] ?? null;

        Log::info('update_password: ' . json_encode($post));

        try {
            $validator = Validator::make($post, [
                'user_id' => 'required',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return [
                    'message' => $validator->errors()->first(),
                    'success' => false,
                ];
            }

            $user = self::find($user_id);

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'User not found'
                ];
            }

            $user->password = Hash::make($password);
            $user->save();

            $res = [
                'success' => true,
                'message' => 'Password updated successfully'
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return $res;
    }

    public function get_users_lists(array $post)
    {
        $user_id = $post['user_id'] ?? null;
        $name = $post['name'] ?? null;
        $username = $post['username'] ?? null;
        $email = $post['email'] ?? null;
        $account_type = $post['account_type'] ?? null;

        $account_status = $post['account_status'] ?? ACCOUNT_STATUS_ACTIVE;
        $delete_flg = $post['delete_flg'] ?? NOT_DELETED;
        $from_date = $post['from_date'] ?? null;
        $to_date = $post['to_date'] ?? null;
        $page = $post['page'] ?? 1;
        $limit = $post['limit'] ?? 10;
        $offset = ($page - 1) * $limit;

        try {
            $query = self::select(
                'id',
                'id as user_id',
                'name',
                'username',
                'email',
                'account_type',
                'account_status',
                'created_at',
                'updated_at'
            )->where('delete_flg', $delete_flg)
                ->where('account_status', $account_status);

            if ($user_id) {
                $query->where('id', $user_id);
            }

            if ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            }

            if ($username) {
                $query->where('username', 'like', '%' . $username . '%');
            }

            if ($email) {
                $query->where('email', $email);
            }

            if ($account_type) {
                $query->where('account_type', $account_type);
            }

            if ($from_date && $to_date) {
                $query->whereBetween('created_at', [$from_date, $to_date]);
            }

            $total_count = $query->count();

            $result = $query->offset($offset)
                ->limit($limit)
                ->get();

            $count = $result->count();
            $has_next = ($total_count > ($page * $limit));

            $res = [
                'data' => $result,
                'total_count' => $total_count,
                'count' => $count,
                'has_next' => $has_next,
                'success' => true,
            ];
        } catch (QueryException $e) {
            $res = [
                'message' => $e->getMessage(),
                'success' => false,
            ];
        }

        return $res;
    }

    public function update_user_status(array $post)
    {
        $key = $post['key'] ?? null;
        $value = $post['value'] ?? null;
        $user_id = $post['user_id'] ?? null;

        $columns = ['account_status', 'account_type', 'delete_flg'];

        try {
            $validator = Validator::make($post, [
                'key' => 'required|in:' . implode(',', $columns),
                'value' => 'required|integer|in:0,1,2,3',
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return [
                    'message' => $validator->errors(),
                    'success' => false,
                ];
            }

            $user = self::find($user_id);

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'User not found'
                ];
            }

            $user->$key = $value;
            $user->save();

            $message = "";
            if ($key == 'account_status') {
                $message = 'User status updated successfully';
            } else if ($key == 'account_type') {
                $message = 'User type updated successfully';
            } else if ($key == 'delete_flg') {
                $message = 'User delete status successfully';
            }

            $res = [
                'success' => true,
                'message' => $message
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return $res;
    }

    public function update_user_details(array $post)
    {
        $user_id = $post['user_id'] ?? null;
        $name = $post['name'] ?? null;
        $username = $post['username'] ?? null;
        $email = $post['email'] ?? null;
        $password = $post['password'] ?? null;
        $confirm_password = $post['confirm_password'] ?? null;
        $account_type = $post['account_type'] ?? null;
        $account_status = $post['account_status'] ?? null;

        try {
            $rules = [
                'user_id' => 'required',
                'name' => 'required',
                'username' => ['required', Rule::unique($this->table, 'username')->ignore($user_id)],
                'email' => ['required', 'email', Rule::unique($this->table, 'email')->ignore($user_id)],
                'account_type' => 'required|integer|in:1,2,3',
                'account_status' => 'required|integer|in:0,1',
            ];

            if ($password && $confirm_password) {
                $rules['password'] = 'required|min:8|max:16';
                $rules['confirm_password'] = 'required|same:password';
            }

            $validator = Validator::make($post, $rules);

            if ($validator->fails()) {
                return [
                    'message' => $validator->errors()->first(),
                    'success' => false,
                ];
            }

            $user = self::find($user_id);
            $user->name = $name;
            $user->username = $username;
            $user->email = $email;
            $user->account_type = $account_type;
            $user->account_status = $account_status;

            if ($password) {
                $user->password = Hash::make($password);
            }

            $user->save();

            $res = [
                'success' => true,
                'message' => 'User details updated successfully'
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return $res;
    }


    public function getCreatedAtAttribute($value)
    {
        return date_to_string($value, true);
    }

    public function getUpdatedAtAttribute($value)
    {
        return date_to_string($value, true);
    }

    public function getAccountStatusAttribute($value)
    {
        $statuses = [
            1 => 'Active',
            0 => 'Inactive',
        ];

        return $statuses[$value] ?? 'unknown';
    }

    // public function getAccountTypeAttribute($value)
    // {
    //     $types = [
    //         1 => 'Super Admin',
    //         2 => 'Admin',
    //         3 => 'User/Staff',
    //     ];

    //     return $types[$value] ?? 'unknown';
    // }
}
