# 📚 SERVICES LAYER DOCUMENTATION

**Purpose:** Memisahkan business logic dari controller untuk code yang lebih clean, reusable, dan testable.

---

## 🎯 Overview

Services layer berisi 3 service utama yang handle business logic:

1. **CartService** - Manage shopping cart operations
2. **StockService** - Manage inventory/stock operations
3. **OrderService** - Manage order & checkout operations

---

## 📦 CartService

**Location:** `app/Services/CartService.php`

### Methods

#### `getOrCreateCart(): Cart`
Get atau create cart untuk authenticated user.

```php
$cartService = new CartService();
$cart = $cartService->getOrCreateCart();
```

#### `addToCart(int $productId, int $qty): CartItem`
Tambah produk ke cart dengan validasi stok.

```php
try {
    $item = $cartService->addToCart($productId, 2);
} catch (\Exception $e) {
    // Handle error: stok tidak cukup
}
```

#### `updateCartItem(CartItem $item, int $qty): CartItem`
Update quantity item dalam cart.

```php
$item = CartItem::find(1);
$item = $cartService->updateCartItem($item, 5);
```

#### `removeFromCart(CartItem $item): bool`
Hapus item dari cart.

```php
$item = CartItem::find(1);
$cartService->removeFromCart($item);
```

#### `clearCart(): bool`
Hapus semua items dalam cart.

```php
$cartService->clearCart();
```

#### `getCartTotal(): float`
Get total harga cart.

```php
$total = $cartService->getCartTotal(); // 500000.00
```

#### `getCartItemCount(): int`
Get jumlah item dalam cart.

```php
$count = $cartService->getCartItemCount(); // 5
```

#### `validateCart(): void`
Validasi cart untuk checkout (cek stok, qty, dll).

```php
try {
    $cartService->validateCart();
} catch (\Exception $e) {
    // Handle error
}
```

### Usage Example

```php
use App\Services\CartService;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        try {
            $item = $this->cartService->addToCart(
                $validated['product_id'],
                $validated['qty']
            );

            return back()->with('success', 'Produk ditambahkan ke cart!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
```

---

## 📦 StockService

**Location:** `app/Services/StockService.php`

### Methods

#### `stockIn(int $productId, int $qty, ?int $supplierId, string $date, string $description): StockIn`
Tambah stok produk (stok masuk).

```php
$stockIn = $stockService->stockIn(
    productId: 1,
    qty: 100,
    supplierId: 1,
    date: '2024-01-15',
    description: 'Stok dari supplier ABC'
);
```

#### `stockOut(int $productId, int $qty, string $date, string $description): StockOut`
Kurangi stok produk (stok keluar).

```php
try {
    $stockOut = $stockService->stockOut(
        productId: 1,
        qty: 10,
        date: '2024-01-15',
        description: 'Stok adjustment'
    );
} catch (\Exception $e) {
    // Stok tidak cukup
}
```

#### `reduceStockForSale(int $productId, int $qty, int $orderId): void`
Kurangi stok untuk penjualan (digunakan di checkout).

```php
$stockService->reduceStockForSale(
    productId: 1,
    qty: 5,
    orderId: 123
);
```

#### `getLowStockProducts(int $threshold): Collection`
Get produk dengan stok menipis.

```php
$lowStockProducts = $stockService->getLowStockProducts(5); // <= 5 items
```

#### `getOutOfStockProducts(): Collection`
Get produk yang stok habis.

```php
$outOfStock = $stockService->getOutOfStockProducts(); // stock == 0
```

#### `getStockHistory(int $productId, int $limit): Collection`
Get riwayat stok untuk produk.

```php
$history = $stockService->getStockHistory(1, 20); // Last 20 records
```

#### `getTotalStockValue(): float`
Get nilai total stok (untuk laporan).

```php
$totalValue = $stockService->getTotalStockValue(); // dalam Rupiah
```

### Usage Example

```php
use App\Services\StockService;

class StockInController extends Controller
{
    protected StockService $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function store(StockInRequest $request)
    {
        try {
            $stockIn = $this->stockService->stockIn(
                productId: $request->product_id,
                qty: $request->qty,
                supplierId: $request->supplier_id,
                date: $request->tanggal_masuk,
                description: $request->keterangan
            );

            return redirect()
                ->route('admin.stock-ins.index')
                ->with('success', 'Stok masuk berhasil dicatat');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
```

---

## 📦 OrderService

**Location:** `app/Services/OrderService.php`

### Methods

#### `checkout(int $shippingAddressId, string $paymentMethod): Order`
Process checkout order dengan transaction.

```php
try {
    $order = $orderService->checkout(
        shippingAddressId: $request->shipping_address_id,
        paymentMethod: $request->payment_method
    );

    return redirect()
        ->route('customer.orders.show', $order)
        ->with('success', 'Order created successfully!');
} catch (\Exception $e) {
    return back()->with('error', $e->getMessage());
}
```

**CRITICAL:** Menggunakan database transaction!
- Validasi stok
- Buat order dengan nomor unik
- Buat order items
- Reduce stok
- Record stock history
- Buat payment
- Clear cart

Jika ada error di step apapun, SEMUA di-rollback!

#### `getUserOrders(int $userId, int $perPage): Paginator`
Get list order user.

```php
$orders = $orderService->getUserOrders(
    userId: Auth::id(),
    perPage: 10
);
```

#### `getOrderDetail(int $orderId): Order`
Get detail order dengan relations.

```php
$order = $orderService->getOrderDetail($orderId);
// Loaded with: user, orderItems, payment, shippingAddress
```

#### `verifyPayment(int $orderId, bool $approved): Order`
Admin verify pembayaran.

```php
// Approve payment
$order = $orderService->verifyPayment($orderId, true);

// Reject payment
$order = $orderService->verifyPayment($orderId, false);
```

#### `updateOrderStatus(int $orderId, string $status): Order`
Update order status.

```php
// Valid statuses: pending, processed, shipped, completed, cancelled
$order = $orderService->updateOrderStatus($orderId, 'shipped');
```

#### `cancelOrder(int $orderId): Order`
Cancel order dan refund stok.

```php
try {
    $order = $orderService->cancelOrder($orderId);
    // Stok otomatis dikembalikan!
} catch (\Exception $e) {
    // Hanya pending/processed order bisa dibatalkan
}
```

#### `getOrderStats(): array`
Get order statistics.

```php
$stats = $orderService->getOrderStats();
// Returns:
// [
//     'total_orders' => 100,
//     'pending_orders' => 10,
//     'completed_orders' => 85,
//     'total_revenue' => 50000000,
//     'unpaid_amount' => 5000000,
// ]
```

### Usage Example

```php
use App\Services\OrderService;

class CheckoutController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(OrderRequest $request)
    {
        try {
            $order = $this->orderService->checkout(
                shippingAddressId: $request->shipping_address_id,
                paymentMethod: $request->payment_method
            );

            return redirect()
                ->route('customer.orders.show', $order)
                ->with('success', 'Order berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
```

---

## 🔧 Dependency Injection

Services digunakan via dependency injection:

```php
// Via constructor
class MyController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function someMethod()
    {
        $cart = $this->cartService->getOrCreateCart();
    }
}

// Via method injection
public function store(Request $request, CartService $cartService)
{
    $item = $cartService->addToCart($productId, $qty);
}

// Manual instantiation (tidak recommended)
$cartService = new CartService();
$cart = $cartService->getOrCreateCart();
```

---

## 💡 Best Practices

### 1. **Always use Services for Business Logic**
```php
// ❌ BAD - Logic di controller
public function store(Request $request)
{
    $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
    // ... more logic
}

// ✅ GOOD - Logic di service
public function store(Request $request, CartService $cartService)
{
    $cart = $cartService->getOrCreateCart();
}
```

### 2. **Use Transactions for Critical Operations**
Services sudah menggunakan transactions untuk operasi critical!

```php
// ✅ Checkout, StockIn, StockOut, CancelOrder
// Semua menggunakan DB::transaction()
```

### 3. **Always Validate Input**
```php
// Di service
if ($qty <= 0) {
    throw new \Exception("Qty harus lebih dari 0");
}

// Di controller
try {
    $cartService->addToCart($productId, $qty);
} catch (\Exception $e) {
    return back()->with('error', $e->getMessage());
}
```

### 4. **Use Specific Exceptions**
```php
// ✅ GOOD
throw new \Exception("Stok tidak mencukupkan!");

// Atau lebih specific:
throw new InsufficientStockException("Stok tidak mencukupkan!");
```

### 5. **Log Important Operations**
```php
// Di service methods (optional)
\Log::info("Stock reduced for order $orderId", [
    'product_id' => $productId,
    'qty' => $qty,
]);
```

---

## 🧪 Testing Services

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\CartService;
use App\Services\StockService;
use App\Services\OrderService;

class CartServiceTest extends TestCase
{
    protected CartService $cartService;

    public function setUp(): void
    {
        parent::setUp();
        $this->cartService = new CartService();
    }

    public function test_can_add_to_cart()
    {
        $this->actingAs($user = User::factory()->create());

        $item = $this->cartService->addToCart(1, 2);

        $this->assertNotNull($item);
    }

    public function test_cannot_add_if_insufficient_stock()
    {
        $this->expectException(\Exception::class);
        
        $product = Product::factory()->create(['stock' => 1]);
        $this->cartService->addToCart($product->id, 10);
    }
}
```

---

## 📊 Service Architecture Diagram

```
┌─────────────────────────────────────────────────────────┐
│                     Controllers                         │
│  (Handle HTTP requests & responses)                     │
└────────────┬────────────────────┬──────────────────────┘
             │                    │
       ┌─────▼──────┐      ┌──────▼─────┐
       │   Cart     │      │   Order    │
       │ Controller │      │ Controller │
       └─────┬──────┘      └──────┬─────┘
             │                    │
             │    Dependency      │
             │    Injection       │
             ▼                    ▼
┌────────────────────────────────────────────────────────┐
│                   Services Layer                       │
│  (Business logic, validation, transactions)           │
├────────────────────────────────────────────────────────┤
│  • CartService      - Cart operations                 │
│  • StockService     - Stock management                │
│  • OrderService     - Order & checkout                │
└────────────┬────────────────────┬─────────────────────┘
             │                    │
             ▼                    ▼
┌────────────────────────────────────────────────────────┐
│                    Models & Database                   │
│  (Data persistence, relationships)                    │
├────────────────────────────────────────────────────────┤
│  • Cart, CartItem                                     │
│  • Order, OrderItem, Payment                          │
│  • Product, StockHistory, StockIn, StockOut          │
└────────────────────────────────────────────────────────┘
```

---

## ✅ Summary

Services layer membuat code lebih:
- **Clean** - Logic terpisah dari controller
- **Reusable** - Bisa digunakan di multiple places
- **Testable** - Mudah untuk unit test
- **Maintainable** - Fokus pada satu responsibility
- **Scalable** - Mudah untuk extend dengan features baru

**Status:** ✅ **Fully Implemented & Production Ready!**

---

**Last Updated:** May 13, 2026  
**Version:** 1.0
