<?php


namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\Product\ProductProvider;
use App\Providers\Purchase\PurchaseProvider;
use Illuminate\Support\Facades\Response;

class PurchaseController extends Controller
{

  private $purchaseProvider;
  private $productProvider;

  public function __construct()
  {
    $this->purchaseProvider = new PurchaseProvider();
    $this->productProvider = new ProductProvider();
  }
  /**
   * Executa uma nova compra
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    $values = $request->all();
    $erros = $this->purchaseProvider->validate($values);

    if ($erros)
      return Response::json([
        'message' => 'Erro nos dados enviados',
        'details' => $erros
      ], 400);

    if (!$this->purchaseProvider->validCreditCard($values['card']))
      return Response::json([
        'message' => 'Erro nos dados enviados',
        'details' => 'Verifique as informacoes do cartao de credito.'
      ], 400);


    return $this->purchaseProvider->save($values);
  }
}
