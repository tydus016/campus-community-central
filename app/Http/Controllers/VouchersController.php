<?php

namespace App\Http\Controllers;

use App\Models\Vouchers;
use App\Models\Orders;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class VouchersController extends Controller
{
    public function apply_voucher(Request $request)
    {
        try {
            $this->start_transact();

            $post = $request->all();

            $result = (new Vouchers())->voucher_details($post);
            if (isset($result['success']) && $result['success']) {

                $data = $result['data'];

                if (!isset($data['id'])) {
                    $res = [
                        'message' => 'Voucher promo code is invalid',
                        'status' => false,
                    ];
                } else {
                    if ($data['availability_flg'] == UNAVAILABLE_FLG) {
                        $res = [
                            'message' => 'This voucher is no longer available for redemption',
                            'status' => false,
                        ];
                    } else {
                        $update_order = (new Orders)->apply_voucher([
                            'order_id' => $post['order_id'],
                            'voucher_id' => $data['id'],
                        ]);

                        if (isset($update_order['success']) && $update_order['success']) {
                            $this->commit_transact();

                            $res = [
                                'voucher_id' => $data['id'],
                                'voucher_code' => $data['voucher_code'],
                                'discount' => $data['discount'],
                                'status' => true,
                                'message' => 'Voucher applied successfully',
                            ];
                        } else {
                            $res = [
                                'message' => $update_order['message'],
                                'status' => false,
                            ];
                        }
                    }
                }
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
