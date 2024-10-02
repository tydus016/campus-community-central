<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Sizes extends Model
{
    protected $table = 'sizes';

    protected $fillable = [
        'product_id',
        'size_name',
        'price',
        'available_qty',
        'availability_flg',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function sizes_lists(array $post)
    {
        $size_id = $post['size_id'] ?? null;
        $product_id = $post['product_id'] ?? null;
        $variant_name = $post['variant_name'] ?? null;

        $from_date = isset($post['from_date']) ? $post['from_date'] : null;
        $to_date = isset($post['to_date']) ? $post['to_date'] : null;

        $page = isset($post['page']) ? $post['page'] : 1;
        $limit = isset($post['limit']) ? $post['limit'] : 10;
        $offset = ($page - 1) * $limit;

        try {
            $query = $this->select(
                'id as size_id',
                'product_id',
                'size_name',
                'price',
                'available_qty',
                'availability_flg',
            )->where('availability_flg', AVAILABLE_FLG);

            if ($size_id) {
                $query->where('id', $size_id);
            }

            if ($product_id) {
                $query->where('product_id', $product_id);
            }

            if ($variant_name) {
                $query->where('variant_name', 'like', "%$variant_name%");
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
                'success' => true,
                'has_next' => $has_next,
                'count' => $count,
                'data' => $result,
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
