<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponserTrait;

class OrderController extends Controller
{
    use ApiResponserTrait;

    public function index()
    {
        $orders = Order::with('orderDetails')->get();
        return $this->successResponse($orders, 'All Orders');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_date' => 'required|date',
            'status' => 'required|string',
            'details' => 'required|array',
            'details.*.product_name' => 'required|string',
            'details.*.quantity' => 'required|integer',
            'details.*.price' => 'required|numeric',
        ]);

        $order = Order::create([
            'user_id' => $validated['user_id'],
            'order_date' => $validated['order_date'],
            'status' => $validated['status'],
        ]);

        foreach ($validated['details'] as $detail) {
            $order->orderDetails()->create($detail);
        }

        return $this->successResponse($order->load('orderDetails'), "Order Placed");
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return $this->errorResponse('Order not found', 404);
        }

        $validated = $request->validate([
            'order_date' => 'required|date',
            'status' => 'required|string',
        ]);

        $order->update($validated);

        return $this->successResponse($order, "Order Status Updated");
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return $this->errorResponse('Order not found', 404);
        }

        $order->delete();
        return $this->successResponse($order, 'Order deleted successfully');
    }

    public function userOrders($id)
    {
        $user = User::with('orders.orderDetails')->find($id);
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        return $this->successResponse($user->orders);
    }
}
