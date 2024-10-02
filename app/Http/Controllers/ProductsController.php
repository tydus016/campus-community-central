<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    public function products_lists(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Products())->products_lists($post);
            if (isset($result['success']) && $result['success']) {
                $res = [
                    'data' => $result['data'],
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

    public function product_detail(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Products())->product_detail($post);
            if (isset($result['success']) && $result['success']) {
                $res = [
                    'data' => $result['data'],
                    'status' => true,
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
