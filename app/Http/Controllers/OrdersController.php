<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrderedItems;
use App\Models\SavedOrders;
use App\Models\SavedOrdersItems;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    public function create_order(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Orders())->create_order($post);
            if (isset($result['success']) && $result['success']) {
                $this->commit_transact();

                $res = [
                    'order_id' => $result['order_id'],
                    'order_tax' => $result['order_tax'],
                    'order_discount' => $result['order_discount'],
                    'message' => 'Order created successfully',
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

    public function save_order(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();
            $items = json_decode($post['items']) ?? null;

            $result = (new SavedOrders())->create_saved_order($post);
            if (isset($result['success']) && $result['success']) {
                $saved_order_id = $result['data']['id'];

                $save_items = (new SavedOrdersItems())->save_orders([
                    'items' => $items,
                    'saved_order_id' => $saved_order_id,
                ]);

                if (isset($save_items['success']) && $save_items['success']) {
                    $this->commit_transact();

                    $res = [
                        'message' => $result['message'],
                        'status' => $result['success']
                    ];
                } else {
                    $this->rollback_transact();

                    $res = [
                        'message' => $save_items['message'],
                        'status' => false,
                    ];
                }
            } else {
                $res = [
                    'message' => $result['message'],
                    'status' => false,
                ];
            }
        } catch (Exception $e) {
            $this->rollback_transact();

            $res = [
                'message' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function update_order_status(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Orders())->update_order_status($post);
            if (isset($result['success']) && $result['success']) {
                $this->commit_transact();
            }

            $res = [
                'message' => $result['message'],
                'status' => $result['success'],
            ];
        } catch (Exception $e) {
            $this->rollback_transact();

            $res = [
                'message' => $e->getMessage(),
                'status' => false,
            ];
        } finally {
            $this->end_transact();
        }

        return $this->_response($res);
    }

    public function checkout_order(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $orders = $post['orders'] ?? null;
            $ordered_items = $post['ordered_items'] ?? null;

            $result = (new Orders())->checkout_order($orders);
            if (isset($result['success']) && $result['success']) {

                // - save items to ordered_items
                $save_items = (new OrderedItems())->checkout_ordered_items([
                    'items' => $ordered_items,
                    'order_id' => $orders['order_id'],
                ]);

                if (isset($save_items['success']) && $save_items['success']) {
                    $this->commit_transact();

                    $res = [
                        'message' => $result['message'],
                        'status' => $result['success']
                    ];
                } else {
                    $this->rollback_transact();

                    $res = [
                        'message' => $save_items['message'],
                        'status' => false,
                    ];
                }
            } else {
                $res = [
                    'message' => $result['message'],
                    'status' => $result['success'],
                ];
            }
        } catch (Exception $e) {
            $this->rollback_transact();

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
