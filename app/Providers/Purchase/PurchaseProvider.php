<?php

namespace App\Providers\Purchase;

use App\Models\Purchase;
use Illuminate\Support\Facades\Validator;

/**
 * Provider referente as informacoes de compra
 */
class PurchaseProvider
{
  /**
   * Valida o input de uma compra
   */
  public function validate(array $values)
  {

    $validator = Validator::make($values, [
      'quantity_purchased' => ['required', 'integer'],
      'product_id' => ['required', 'integer'],
      'card.owner' => ['required', 'string'],
      'card.card_number' => ['required', 'integer'],
      'card.date_expiration' => ['required'],
      'card.flag' => ['required', 'string'],
      'card.cvv' => ['required', 'integer']
    ], []);

    if ($validator->fails())
      return $validator->errors();

    return null;
  }

  public function save(array $values): Purchase
  {
    $purchase = new Purchase($values);
    $purchase->save();
    return $purchase;
  }
}
