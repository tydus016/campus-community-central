<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class CategoriesController extends Controller
{
    public function categories_lists(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $result = (new Categories())->categories_lists($post);
            if (isset($result['success']) && $result['success']) {
                $data = $result['data']->toArray();

                array_unshift($data, [
                    'id' => 0,
                    'title' => 'All Products',
                    'delete_flg' => null,
                    'created_at' => null,
                    'updated_at' => null,
                ]);

                $res = [
                    'data' => $data,
                    'status' => true,
                    'has_next' => $result['has_next'],
                    'count' => $result['count'],
                ];
            } else {
                $res = [
                    'message' => $result['message'],
                    'status' => false,
                ];
            }
        } catch (Exception $e) {
            $res = [
                'message' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }
}
