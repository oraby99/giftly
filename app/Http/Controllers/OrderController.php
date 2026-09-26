<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceOrderRequest;
use App\Models\Order;
use App\Services\CartValidationService;
use App\Services\OrderService;
use App\Services\WhatsAppService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(
        private readonly CartValidationService $cartValidation,
        private readonly OrderService $orderService,
        private readonly WhatsAppService $whatsApp,
    ) {}

    public function store(PlaceOrderRequest $request): JsonResponse
    {
        $validated = $this->cartValidation->validateAndPrice($request->validated()['items']);

        if (empty($validated['items'])) {
            return response()->json([
                'message' => 'لا توجد عناصر صالحة في السلة.',
            ], 422);
        }

        $customerData = [
            'customer_name' => $request->validated('customer_name'),
            'customer_phone' => $request->validated('customer_phone'),
            'customer_address' => $request->validated('customer_address'),
            'customer_notes' => $request->validated('customer_notes'),
        ];

        $order = $this->orderService->createFromCart($validated, $customerData);
        $whatsappUrl = $this->whatsApp->generateUrl($order);

        return response()->json([
            'order_number' => $order->order_number,
            'total' => $order->total,
            'whatsapp_url' => $whatsappUrl,
            'confirmation_url' => route('orders.confirmation', $order->order_number),
        ]);
    }

    public function confirmation(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items')
            ->firstOrFail();

        $whatsappUrl = $this->whatsApp->generateUrl($order);

        return view('order-confirmation', compact('order', 'whatsappUrl'));
    }
}
