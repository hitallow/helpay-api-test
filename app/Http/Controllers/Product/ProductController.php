<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Providers\Product\ProductProvider;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{

  private $productProvider;

  function __construct()
  {
    $this->productProvider = new ProductProvider();
  }
  /**
   * Retorna todas as lista de produtos salvos
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return $this->productProvider->find();
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Salva um novo produto
   *
   * @param  \Illuminate\Http\Request  $request
   * @return Product
   */
  public function store(Request $request)
  {

    $values = $request->all();
    $erros = $this->productProvider->validate(
      $values
    );

    if ($erros)
      return Response::json([
        'message' => 'Erro nos dados enviados',
        'details' => $erros
      ], 400);

    return $this->productProvider->save($values);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $product = $this->productProvider->findOne($id);
    if (!$product)   return Response::json([
      'message' => 'Erro nos dados enviados',
      'details' => 'Produto nao encontrado'
    ], 404);

    return $product;
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
