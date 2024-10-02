<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class SavedOrdersItems extends Model
{
    protected $table = 'saved_orders_items';

    protected $fillable = [
        'saved_order_id',
        'product_id',
        'variant_id',
        'size_id',
        'quantity',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function save_orders(array $post)
    {
        $items = $post['items'] ?? null;
        $saved_order_id = $post['saved_order_id'] ?? null;
        $current_date = now();
        Log::info("items: " . json_encode($items, true));

        try {
            $insert_data = [];
            foreach ($items as $item) {
                $arr = [];

                $arr['product_id'] = $item->product_id;
                $arr['variant_id'] = $item->variant_id;
                $arr['size_id'] = $item->size_id;
                $arr['quantity'] = $item->quantity;
                $arr['saved_order_id'] = $saved_order_id;
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
