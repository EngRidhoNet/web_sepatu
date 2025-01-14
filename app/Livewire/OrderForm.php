<?php

namespace App\Livewire;

use App\Models\Shoe;
use Livewire\Component;
use App\Services\OrderService;

class OrderForm extends Component
{
    public Shoe $shoe;
    public $orderData;
    public $subTotalAmount;
    public $promoCode = null;
    public $promoCodeId = null;
    public $quantity = 1;
    public $discount = 0;
    public $grandTotalAmount;
    public $totalDiscountAmount;
    public $name;
    public $email;

    protected $orderService;

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function render()
    {
        return view('livewire.order-form');
    }

    public function mount(Shoe $shoe, $orderData)
    {
        $this->shoe = $shoe;
        $this->orderData = $orderData;
        $this->subTotalAmount = $shoe->price;
        $this->grandTotalAmount = $shoe->price;
    }

    public function updatedQuantity()
    {
        $this->validateOnly(
            'quantity',
            [
                'quantity' => 'required|numeric|min:1|max:' . $this->shoe->stock,
            ],
            [
                'quantity.max' => 'Stock tidak tersedia!',
            ]
        );
        $this->calculateTotal();
    }

    protected function calculateTotal()
    {
        $this->subTotalAmount = $this->shoe->price * $this->quantity;
        $this->grandTotalAmount = $this->subTotalAmount - $this->discount;
    }

    public function incrementQuantity()
    {
        if ($this->quantity < $this->shoe->stock) {
            $this->quantity++;
            $this->calculateTotal();
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->calculateTotal();
        }
    }

    public function updatedPromoCode()
    {
        $this->applyPromoCode();
    }

    public function applyPromoCode()
    {
        if (!$this->promoCode) {
            $this->resetDiscount();
            return;
        }

        $result = $this->orderService->applyPromoCode($this->promoCode, $this->subTotalAmount);

        if (isset($result['error'])) {
            session()->flash('error', $result['error']);
            $this->resetDiscount();
        } else {
            session()->flash('message', 'Promo code applied successfully');
            $this->discount = $result['discount'];
            $this->promoCodeId = $result['promo_code_id']; // Updated to match service response
            $this->totalDiscountAmount = $result['discount'];
            $this->grandTotalAmount = $result['grand_total_amount']; // Added to use service calculated total
        }
    }

    protected function resetDiscount()
    {
        $this->discount = 0;
        $this->promoCodeId = null;
        $this->totalDiscountAmount = 0;
        $this->calculateTotal();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'quantity' => 'required|numeric|min:1|max:' . $this->shoe->stock,
        ];
    }

    protected function gatherBookingData(array $validatedData)
    {
        return [

            'shoe_id' => $this->shoe->id,
            'quantity' => $this->quantity,
            'sub_total_amount' => $this->subTotalAmount,
            'promo_code_id' => $this->promoCodeId,
            'total_discount_amount' => $this->totalDiscountAmount,
            'grand_total_amount' => $this->grandTotalAmount,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'discount' => $this->discount,
            'promo_code' => $this->promoCode,
            'shoe_size' => $this->orderData['shoe_size'],
            'size_id' => $this->orderData['size_id'],
        ];
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $bookingData = $this->gatherBookingData($validatedData);

        $this->orderService->updateCustomerData($bookingData);

        return redirect()->route('front.customer_data');
    }
}
