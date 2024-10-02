<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class Vouchers extends Model
{
    protected $fillable = [
        'id',
        'voucher_code',
        'discount',
        'availability_flg',
        'delete_flg',
        'expiry_date',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'expiry_date' => 'datetime:Y-m-d H:i:s',
    ];

    public function voucher_details(array $post)
    {
        $voucher_id = $post['voucher_id'] ?? null;
        $voucher_code = $post['voucher_code'] ?? null;

        try {
            $validator = Validator::make($post, [
                'voucher_code' => 'required|string',
            ]);

            if ($validator->fails()) {
                return [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ];
            }

            $query = self::query();

            if ($voucher_id) {
                $query->where('id', $voucher_id);
            }

            if ($voucher_code) {
                $query->where('voucher_code', $voucher_code);
            }

            $query->where('delete_flg', NOT_DELETED);

            $result = $query->first();

            $res = [
                'success' => true,
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
