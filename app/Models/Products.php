<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use App\Models\Variants;
use App\Models\Sizes;
use Illuminate\Support\Facades\Log;

class Products extends Model
{
    protected $table = "products";

    protected $fillable = [
        'id',
        'category_id',
        'product_name',
        'price',
        'quantity',
        'availability_flg',
        'on_sale_flg',
        'delete_flg',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function products_lists(array $post)
    {
        $product_id = isset($post['product_id']) ? $post['product_id'] : null;
        $category_id = isset($post['category_id']) ? $post['category_id'] : null;
        $product_name = isset($post['product_name']) ? $post['product_name'] : null;
        $category_name = isset($post['category_name']) ? $post['category_name'] : null;
        $search_value = isset($post['search_value']) ? $post['search_value'] : null;
        $availability_flg = isset($post['availability_flg']) ? $post['availability_flg'] : null;
        $on_sale_flg = isset($post['on_sale_flg']) ? $post['on_sale_flg'] : null;
        $delete_flg = isset($post['delete_flg']) ? $post['delete_flg'] : null;

        $from_date = isset($post['from_date']) ? $post['from_date'] : null;
        $to_date = isset($post['to_date']) ? $post['to_date'] : null;

        $page = isset($post['page']) ? $post['page'] : 1;
        $limit = isset($post['limit']) ? $post['limit'] : 10;
        $offset = ($page - 1) * $limit;

        try {
            $query = self::select(
                'products.id',
                'products.category_id',
                'products.product_name',
                'products.price',
                'products.quantity',
                'products.availability_flg as is_on_stock',
                'products.on_sale_flg as is_on_sale',
                'products.delete_flg',
                'products.created_at',
                'products.updated_at',
                'categories.category_name',
                'products_image_gallery.image_path'
            )->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->leftJoin('products_image_gallery', 'products_image_gallery.product_id', '=', 'products.id');

            if ($product_id) {
                $query->where('products.id', $product_id);
            }

            if ($category_id) {
                $query->where('category_id', $category_id);
            }

            if ($product_name) {
                $query->where('products.product_name', 'like', "%$product_name%");
            }

            if ($category_name) {
                $query->where('categories.category_name', 'like', "%$category_name%");
            }

            if ($search_value) {
                $query->where(function ($query) use ($search_value) {
                    $query->where('products.product_name', 'like', "%$search_value%")
                        ->orWhere('categories.category_name', 'like', "%$search_value%");
                });
            }

            if ($availability_flg) {
                $query->where('availability_flg', $availability_flg);
            }

            if ($on_sale_flg) {
                $query->where('on_sale_flg', $on_sale_flg);
            }

            if ($delete_flg) {
                $query->where('delete_flg', $delete_flg);
            }

            if ($from_date && $to_date) {
                $query->whereBetween('created_at', [$from_date, $to_date]);
            }

            $total_count = $query->count();

            $result = $query->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();

            $formattedResult = [];
            foreach ($result as $value) {
                $arr = [];

                $arr['id'] = $value['id'];
                $arr['title'] = $value['product_name'];
                $arr['price'] = $value['price'];
                $arr['image'] = $value['image_path'] ?? 'https://via.placeholder.com/150';
                $arr['category_id'] = $value['category_id'];
                $arr['category_name'] = $value['category_name'];
                $arr['attributes'] = [
                    'is_on_stock' => $value['is_on_stock'] == STOCK_STATUS_IN_STOCK,
                    'is_on_sale' => $value['is_on_sale'] == ON_SALE_FLG,
                ];
                $arr['quantity'] = $value['quantity'];
                $arr['variants'] = [];
                $arr['sizes'] = [];

                $variants = (new Variants)->variant_lists(['product_id' => $product_id]);
                if ($variants['success']) {
                    $arr['variants'] = $this->formatVariants($variants['data']);
                }

                $sizes = (new Sizes)->sizes_lists(['product_id' => $product_id]);
                if ($sizes['success']) {
                    $arr['sizes'] = $this->formatSizes($sizes['data']);
                }

                $arr['created_at'] = $value['created_at'];
                $arr['updated_at'] = $value['updated_at'];

                $formattedResult[] = $arr;
            }

            $count = $result->count();
            $has_next = ($total_count > ($page * $limit));

            $res = [
                'success' => true,
                'has_next' => $has_next,
                'count' => $count,
                'data' => $formattedResult,
            ];
        } catch (QueryException $e) {
            $res = [
                'message' => $e->getMessage(),
                'success' => false,
            ];
        }

        return $res;
    }

    public function product_detail(array $post)
    {
        $product_id = $post['product_id'] ?? null;
        $category_id = $post['category_id'] ?? null;

        try {
            $query = self::select(
                'products.id as product_id',
                'products.category_id',
                'products.product_name',
                'products.price',
                'products.quantity',
                'products.availability_flg',
                'products.on_sale_flg as is_on_sale',
                'products.delete_flg',
                'products.created_at',
                'products.updated_at',
                'categories.category_name'
            )->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->where('products.delete_flg', NOT_DELETED);

            if ($product_id) {
                $query->where('products.id', $product_id);
            }

            if ($category_id) {
                $query->where('products.category_id', $category_id);
            }

            $result = $query->first();

            $formattedResult = [];
            if ($result) {

                $formattedResult['id'] = $result->product_id;
                $formattedResult['title'] = $result->product_name;
                $formattedResult['price'] = $result->price;
                $formattedResult['image'] = 'https://via.placeholder.com/150';
                $formattedResult['category_id'] = $result->category_id;
                $formattedResult['category_name'] = $result->category_name;
                $formattedResult['attributes'] = [
                    'is_on_stock' => $result->product_id == STOCK_STATUS_IN_STOCK,
                    'is_on_sale' => $result->product_id == ON_SALE_FLG,
                ];
                $formattedResult['quantity'] = $result->quantity;

                $formattedResult['variants'] = [];
                $formattedResult['sizes'] = [];

                $variantsModel = new Variants();
                $variants = $variantsModel->variant_lists(['product_id' => $product_id]);
                if ($variants['success']) {
                    $formattedResult['variants'] = $this->formatVariants($variants['data']);
                }

                $sizesModel = new Sizes();
                $sizes = $sizesModel->sizes_lists(['product_id' => $product_id]);
                if ($sizes['success']) {
                    $formattedResult['sizes'] = $this->formatSizes($sizes['data']);
                }

                $formattedResult['created_at'] = $result->created_at;
                $formattedResult['updated_at'] = $result->updated_at;
            }

            $res = [
                'success' => true,
                'data' => $formattedResult,
            ];
        } catch (QueryException $e) {
            $res = [
                'message' => $e->getMessage(),
                'success' => false,
            ];
        }

        return $res;
    }

    private function formatVariants($variants)
    {
        $result = [];
        foreach ($variants as $variant) {
            $arr = [];

            $arr['id'] = $variant['variant_id'];
            $arr['product_id'] = $variant['product_id'];
            $arr['name'] = $variant['variant_name'];
            $arr['price'] = $variant['price'];
            $arr['available_qty'] = $variant['available_qty'];
            $arr['availability_flg'] = $variant['availability_flg'] == AVAILABLE_FLG;

            $result[] = $arr;
        }

        return $result;
    }

    private function formatSizes($sizes)
    {
        $result = [];
        foreach ($sizes as $size) {
            $arr = [];

            $arr['id'] = $size['size_id'];
            $arr['product_id'] = $size['product_id'];
            $arr['name'] = $size['size_name'];
            $arr['price'] = $size['price'];
            $arr['available_qty'] = $size['available_qty'];
            $arr['availability_flg'] = $size['availability_flg'] == AVAILABLE_FLG;

            $result[] = $arr;
        }

        return $result;
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
