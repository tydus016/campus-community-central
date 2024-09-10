<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use App\Models\FileUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'username',
        'password',
        'account_type',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function add_new_admin(array $post)
    {
        $username = $post['username'] ?? null;
        $password = $post['password'] ?? null;
        $confirm_password = $post['confirm_password'] ?? null;
        $account_type = $post['account_type'] ?? null;
        $current_date = now();

        try {
            // Validation rules
            $validator = Validator::make($post, [
                'username' => 'required|string|unique:admins,username',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|string|same:password',
                'account_type' => 'required|string',
            ]);

            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            }

            // Insert data
            $insert_data = [
                'username' => $username,
                'password' => Hash::make($password),
                'account_type' => $account_type,
                'created_at' => $current_date,
            ];

            $admin = self::create($insert_data);

            if ($admin) {
                return [
                    'success' => true,
                    'message' => 'Admin account added successfully',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to add admin account',
                ];
            }
        } catch (QueryException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function get_admin_lists(array $post)
    {
        $admin_id = isset($post['id']) ? $post['id'] : null;
        $username = isset($post['username']) ? $post['username'] : null;
        $account_type = isset($post['type']) ? $post['type'] : null;
        $account_status = isset($post['account_status']) ? $post['account_status'] : null;
        $from_date = isset($post['from_date']) ? $post['from_date'] : null;
        $to_date = isset($post['to_date']) ? $post['to_date'] : null;

        $page = isset($post['page']) ? $post['page'] : 1;
        $limit = isset($post['limit']) ? $post['limit'] : 10;
        $offset = ($page - 1) * $limit;

        Log::debug("REQUEST -> " . json_encode($_REQUEST, true));
        Log::debug("SERVER -> " . json_encode($_SERVER, true));

        try {
            $query = self::query();

            if ($admin_id) {
                $query->where('id', $admin_id);
            }

            if ($username) {
                $query->where('username', 'like', '%' . $username . '%');
            }

            if ($account_type) {
                $query->where('account_type', $account_type);
            }

            if ($account_status) {
                $query->where('account_status', $account_status);
            }

            if ($from_date && $to_date) {
                $query->whereBetween('created_at', [$from_date, $to_date]);
            }

            $total_count = $query->count();

            $result = $query->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();

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

    public function update_profile(array $post)
    {
        $update_admin_id = isset($post['update_admin_id']) ? $post['update_admin_id'] : null;
        $username = isset($post['username']) ? $post['username'] : null;
        $password = isset($post['password']) ? $post['password'] : null;
        $confirm_password = isset($post['confirm_password']) ? $post['confirm_password'] : null;
        $update_account_type = isset($post['update_account_type']) ? $post['update_account_type'] : null;
        $update_account_status = isset($post['update_account_status']) ? $post['update_account_status'] : null;

        $current_date = now();

        try {
            $rules = [
                'update_account_type' => 'required|string|int',
                'update_account_status' => 'required|string|int',
            ];

            if (isset($password) && isset($confirm_password)) {
                $rules['password'] = 'required|string|min:8';
                $rules['confirm_password'] = 'required|string|same:password';
            }

            if (isset($username)) {
                $in_use = self::where('username', $username)->where('id', '!=', $update_admin_id)->count();
                if ($in_use > 0) {
                    return [
                        'success' => false,
                        'message' => 'The username has already been taken.',
                    ];
                }
            }

            $validator = Validator::make($post, $rules);
            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            }

            $admin = self::find($update_admin_id);
            if (!$admin) {
                return [
                    'success' => false,
                    'message' => 'Admin account not found',
                ];
            }

            if (!empty($post['profile_image']) && $post['upload_status']) {
                $admin->profile_image = $post['profile_image'];
            }

            $admin->username = $username;
            $admin->password = Hash::make($password);
            $admin->account_type = $update_account_type;
            $admin->account_status = $update_account_status;
            $admin->updated_at = $current_date;

            $admin->save();

            $res = [
                'success' => true,
                'message' => 'Admin account updated successfully',
            ];
        } catch (QueryException $e) {
            $res = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        return $res;
    }

    public function admin_details(array $post)
    {
        $admin_id = isset($post['id']) ? $post['id'] : null;

        try {
            $validator = Validator::make($post, [
                'id' => 'required|int',
            ]);

            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            }

            $query = self::find($admin_id);
            if ($query) {
                $res = [
                    'success' => true,
                    'data' => $query,
                ];
            } else {
                $res = [
                    'success' => false,
                    'message' => 'Admin account not found',
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

    public function authenticate(array $post)
    {
        $username = isset($post['username']) ? $post['username'] : null;
        $password = isset($post['password']) ? $post['password'] : null;

        try {
            $validator = Validator::make($post, [
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            }

            $admin = self::where('username', $username)->first();
            if (!$admin) {
                return [
                    'success' => false,
                    'message' => 'Invalid username or password',
                ];
            }

            if (Hash::check($password, $admin->password)) {
                $res = [
                    'success' => true,
                    'message' => 'Login successful',
                    'data' => $admin,
                ];
            } else {
                $res = [
                    'success' => false,
                    'message' => 'Invalid username or password',
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

    public function getFormattedCreatedAtAttribute()
    {
        return date_to_string($this->attributes['created_at'], true);
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return date_to_string($this->attributes['updated_at'], true);
    }
}
