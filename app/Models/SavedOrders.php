<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class SavedOrders extends Model
{
    protected $table = 'saved_orders';

    protected $fillable = [
        'order_id',
        'discount',
        'subtotal',
        'tax',
        'total',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'discount' => 'float',
        'subtotal' => 'float',
        'tax' => 'float',
        'total' => 'float',
    ];

    public function create_saved_order(array $post)
    {
        $order_id = $post['order_id'] ?? null;
        $discount = $post['discount'] ?? null;
        $subtotal = $post['subtotal'] ?? null;
        $tax = $post['tax'] ?? null;
        $total = $post['total'] ?? null;
        $current_date = now();

        try {
            $validator = Validator::make($post, [
                'order_id' => 'required',
                'discount' => 'required',
                'subtotal' => 'required',
                'tax' => 'required',
                'total' => 'required',
            ]);

            if ($validator->fails()) {
                return [
                    'message' => $validator->errors(),
                    'success' => false,
                ];
            }

            $insert_data = [
                'order_id' => $order_id,
                'discount' => $discount,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'created_at' => $current_date,
            ];

            $order = self::create($insert_data);

            $res = [
                'data' => $order,
                'success' => true,
                'message' => 'Order saved successfully',
            ];
        } catch (QueryException $e) {
            if ($e->getCode() == '23000' && str_contains($e->getMessage(), '1452')) {
                return [
                    'message' => 'Order ID not found',
                    'success' => false,
                ];
            }

            $res = [
                'message' => $e->getMessage(),
                'success' => false,
            ];
        }

        return $res;
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('F d, Y h:i:s A');
    }

    // Accessor for updated_at
    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('F d, Y h:i:s A');
    }
}
