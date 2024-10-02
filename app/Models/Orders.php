<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'order_id',
        'discount',
        'tax',
        'voucher_id',
        'total',
        'amount_paid',
        'amount_change',
        'payment_method',
        'order_status',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'discount' => 'float',
        'tax' => 'float',
        'total' => 'float',
        'amount_paid' => 'float',
        'amount_change' => 'float',
    ];

    public function create_order(array $post)
    {
        $order_id = $post['order_id'] ?? genUniqueID();
        $current_date = now();

        try {
            $insert_data = [
                'order_id' => $order_id,
                'order_status' => ORDER_STATUS_ONGOING,
                'created_at' => $current_date,
            ];

            $order = self::create($insert_data);

            $res = [
                'success' => true,
                'order_id' => $order_id,
                'order_discount' => DUMMY_DISCOUNT,
                'order_tax' => DUMMY_TAX,
            ];
        } catch (QueryException $e) {
            $res = [
                'message' => $e->getMessage(),
                'success' => false,
            ];
        }

        return $res;
    }

    public function update_order_status(array $post)
    {
        $order_id = $post['order_id'] ?? null;
        $order_status = $post['order_status'] ?? null;

        $statuses = [
            ORDER_STATUS_ONGOING,
            ORDER_STATUS_COMPLETED,
            ORDER_STATUS_VOIDED,
        ];
        $statuses = implode(',', $statuses);

        try {
            $validator = Validator::make($post, [
                'order_id' => 'required|exists:orders,order_id',
                'order_status' => "required|in:$statuses",
            ]);

            if ($validator->fails()) {
                return [
                    'message' => $validator->errors(),
                    'success' => false,
                ];
            }

            $order = self::where('order_id', $order_id)->first();

            $order->order_status = $order_status;
            $order->save();

            if ($order_status == ORDER_STATUS_ONGOING) {
                $message = 'Order marked as ongoing.';
            } elseif ($order_status == ORDER_STATUS_COMPLETED) {
                $message = 'Order marked as completed.';
            } elseif ($order_status == ORDER_STATUS_VOIDED) {
                $message = 'Order has been voided successfully.';
            }

            $res = [
                'success' => true,
                'message' => $message,
            ];
        } catch (QueryException $e) {
            $res = [
                'message' => $e->getMessage(),
                'success' => false,
            ];
        }

        return $res;
    }

    public function apply_voucher(array $post)
    {
        $order_id = $post['order_id'] ?? null;
        $voucher_id = $post['voucher_id'] ?? null;

        try {
            $validator = Validator::make($post, [
                'order_id' => 'required|exists:orders,order_id',
                'voucher_id' => 'required|exists:vouchers,id',
            ]);

            if ($validator->fails()) {
                return [
                    'message' => $validator->errors(),
                    'success' => false,
                ];
            }

            $order = self::where('order_id', $order_id)->first();

            $order->voucher_id = $voucher_id;
            $order->save();

            $res = [
                'success' => true,
                'message' => 'Voucher applied successfully',
            ];
        } catch (QueryException $e) {
            $res = [
                'message' => $e->getMessage(),
                'success' => false,
            ];
        }

        return $res;
    }

    public function checkout_order(array $post)
    {
        $order_id = $post['order_id'] ?? null;
        $discount = $post['discount'] ?? null;
        $tax = $post['tax'] ?? null;
        $total = $post['total'] ?? null;
        $amount_paid = $post['amount_paid'] ?? null;
        $amount_change = $post['amount_change'] ?? null;
        $payment_method = $post['payment_method'] ?? null;


        try {
            $validator = Validator::make($post, [
                'order_id' => 'required|exists:orders,order_id',
                'discount' => 'required',
                'tax' => 'required',
                'total' => 'required',
                'amount_paid' => 'required',
                'amount_change' => 'required',
                'payment_method' => 'required',
            ]);

            if ($validator->fails()) {
                return [
                    'message' => $validator->errors()->first(),
                    'success' => false,
                ];
            }

            $order = self::where('order_id', $order_id)->first();

            $order->discount = $discount;
            $order->tax = $tax;
            $order->total = $total;
            $order->amount_paid = $amount_paid;
            $order->amount_change = $amount_change;
            $order->payment_method = $payment_method;

            $order->save();

            $res = [
                'success' => true,
                'message' => 'Order checked out successfully',
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
