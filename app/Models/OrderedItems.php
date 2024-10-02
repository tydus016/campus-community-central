<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class OrderedItems extends Model
{
    protected $table = 'ordered_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'size_id',
        'quantity',
        'on_sale_flg',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function checkout_ordered_items(array $post)
    {
        $items = json_decode($post['items'], true) ?? [];
        $order_id = $post['order_id'] ?? null;
        $current_date = now();

        try {
            $validator = Validator::make($post, [
                'order_id' => 'required|exists:orders,order_id',
                'items' => 'required',
            ]);

            if ($validator->fails()) {
                return [
                    'message' => $validator->errors(),
                    'success' => false,
                ];
            }

            $insert_data = [];
            foreach ($items as $item) {
                $arr = [];

                $arr['product_id'] = $item['itemId'];
                $arr['variant_id'] = $item['variantId'];
                $arr['size_id'] = $item['sizeId'];
                $arr['quantity'] = $item['quantity'];
                $arr['order_id'] = $order_id;
                $arr['on_sale_flg'] = $item['is_on_sale'] ? ON_SALE_FLG : NOT_ON_SALE_FLG;
                $arr['created_at'] = $current_date;

                $insert_data[] = $arr;
            }

            $create = self::insert($insert_data);

            $res = [
                'success' => true,
                'message' => 'Items saved successfully',
            ];
        } catch (QueryException $e) {
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

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('F d, Y h:i:s A');
    }
}
