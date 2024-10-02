<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillables = [
        'id',
        'category_name',
        'delete_flg',
        'created_at',
        'updated_at',
    ];

    public function categories_lists(array $post)
    {
        $category_id = $post['category_id'] ?? null;
        $category_name = $post['category_name'] ?? null;
        $delete_flg = $post['delete_flg'] ?? null;

        $from_date = isset($post['from_date']) ? $post['from_date'] : null;
        $to_date = isset($post['to_date']) ? $post['to_date'] : null;

        $page = isset($post['page']) ? $post['page'] : 1;
        $limit = isset($post['limit']) ? $post['limit'] : 10;
        $offset = ($page - 1) * $limit;

        try {
            $query = $this->select(
                'id',
                'category_name as title',
                'delete_flg',
                'created_at',
                'updated_at',
            );

            if ($category_id) {
                $query->where('id', $category_id);
            }

            if ($category_name) {
                $query->where('category_name', 'like', "%$category_name%");
            }

            if ($delete_flg) {
                $query->where('delete_flg', $delete_flg);
            }

            if ($from_date && $to_date) {
                $query->whereBetween('created_at', [$from_date, $to_date]);
            }

            $query->orderBy('category_name', 'asc');

            $total = $query->count();
            $result = $query->offset($offset)->limit($limit)->get();

            $has_next = $total > ($page * $limit);

            $res = [
                'data' => $result,
                'count' => $total,
                'has_next' => $has_next,
                'success' => true,
            ];
        } catch (\Exception $e) {
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
