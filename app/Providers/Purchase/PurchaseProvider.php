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

  /**
   * Valida com regex as informaoces do cartao de credito
   */
  public function validCreditCard($creditCard)
  {
    $regexCreditCards = [
      'American Express' => ['valid' => '/^([34|37]{2})([0-9]{13})$/'],
      'Dinners' => ['valid' => '/^([30|36|38]{2})([0-9]{12})$/'],
      'Discover Card' => ['valid' => '/^([6011]{4})([0-9]{12})$/'],
      'MasterCard' => ['valid' => '/^([51|52|53|54|55]{2})([0-9]{14})$/'],
      'Visa' => ['valid' => '/^([4]{1})([0-9]{12,15})$/'],
      'Visa Retired' => ['valid' => '/^([4]{1})([0-9]{12,15})$/'],
    ];

    $cardNumber = $creditCard["card_number"];
    $cardFlag = $creditCard["flag"];

    if (isset($regexCreditCards[$cardFlag])) {

      $cardValidate = $regexCreditCards[$cardFlag];
      return preg_match($cardValidate['valid'], $cardNumber);
    }

    return false;
  }
}
