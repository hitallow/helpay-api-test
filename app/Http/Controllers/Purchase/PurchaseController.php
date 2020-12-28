<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Services\GoogleDrive\GoogleDriveService;
use App\Services\Product\ProductProvider;
use App\Services\Purchase\PurchaseProvider;
use App\Services\XML\XMLProvider;
use Illuminate\Support\Facades\Response;


class PurchaseController extends Controller
{

  private $purchaseProvider;
  private $productProvider;
  private GoogleDriveService $googleDriveService;

  public function __construct()
  {
    $this->purchaseProvider = new PurchaseProvider();
    $this->productProvider = new ProductProvider();
    $this->googleDriveService = new GoogleDriveService();
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

    if (!$this->purchaseProvider->validateStock($values['product_id'], $values['quantity_purchased']))
      return Response::json([
        'message' => 'Erro nos dados enviados',
        'details' => 'O produto não existe ou não há quantidade suficiente.'
      ]);


    $this->productProvider->decreaseStock($values['product_id'], $values['quantity_purchased']);

    $xml = XMLProvider::createPurchaseXML($values);


    $fileName = uniqid('xml-') . '.xml';


    if (!$this->googleDriveService->sendFile($xml, $fileName))
      return Response::json(
        [
          'message' => 'Erro no servidor',
          'details' => 'Não foi possível salvar o xml no drive.'
        ],
        500
      );

    $this->purchaseProvider->notifyNewPurchaseEmail($fileName);

    return $this->purchaseProvider->save($values);
  }
}
