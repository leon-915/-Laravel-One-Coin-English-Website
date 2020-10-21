<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Services extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'title', 'status', 'description', 'length', 'length_type', 'padding_minutes',
        'padding_type', 'price', 'capacity', 'is_flexible_appointment_start_time',
        'flexible_appointment_start_time', 'is_system_service', 'receive_credit_on_booking',
        'receive_credit_on_booking_type', 'service_name_en',
        'prepayment_type', 'prepayment', 'available_lessons', 'no_of_days', 'is_available_in_trial','hide_price','service_type','is_reg_fee_required', 'is_onepage_fee_required', 'category_ids', 'zoho_item_id'];

    public function checkAddedInCart($service_id)
    {
        $cart = Cart::where('user_id', Auth::id())->get()->toArray();
        if (count($cart) > 0) {
            $serviceArray = array_column($cart, 'service_id');
            if (in_array($service_id, $serviceArray)) {
                return 1;
            } else {
                return 0;
            }
        }
        return 0;
    }
}
