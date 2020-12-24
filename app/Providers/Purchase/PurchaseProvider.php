<?php

namespace App\Providers\Purchase;

use App\Models\Purchase;
use App\Providers\Product\ProductProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPurchaseEmail;

/**
 * Provider referente as informacoes de compra
 */
class PurchaseProvider
{
  private ProductProvider $productProvider;


  function __construct()
  {
    $this->productProvider = new ProductProvider();
  }
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

  /**
   * Valida se o produto tem estoque suficiente para finalizar a venda
   */
  public function validateStock($productId, $quantity): bool
  {

    $product = $this->productProvider->findOne($productId);

    if ($product)
      return $product->qty_stock >= $quantity;

    return false;
  }
  /**
   * Envia um email de notificacao para o email repassado, ou carrega a informacao do
   * env
   * @param xmlURL endereco de acesso ao xml
   * @param userEmail caixa de entrada do email
   */
  public function notifyNewPurchaseEmail(string $xmlURL, $userEmail = NULL)
  {
    $mailTo = $userEmail ? $userEmail : env('MAIL_TO');

    return Mail::to($mailTo)->send(new SendPurchaseEmail($xmlURL));
  }
}
