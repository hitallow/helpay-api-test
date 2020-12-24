<?php

namespace App\Providers\Product;

use App\Models\Product;

use Illuminate\Support\Facades\Validator;

class ProductProvider
{


  /**
   * Retorna a lista de produtos salvos
   * @return Product[]
   */
  public function find()
  {
    return Product::all();
  }

  /**
   * Salva um novo produto
   */
  public function save(array $values): Product
  {

    $product = new Product;
    $product->name = $values['name'];
    $product->amount = $values['amount'];
    $product->qty_stock = $values['qty_stock'];

    $product->save();

    return $product;
  }

  /**
   * Faz o decremento da quantidade vendida
   */
  public function decreaseStock(int $product_id, int $qty_stock)
  {

    $product = $this->findOne($product_id);

    if (!$product) return null;

    $product->qty_stock  = $product->qty_stock - $qty_stock;

    $product->save();

    return $product;
  }

  /**
   * Faz a pesquisa de um produto pelo seu id
   */
  public function findOne(int $id): ?Product
  {
    return Product::find($id);
  }

  /**
   * Valida se o produto esta apto a ser salvo
   * @return String[] || Null
   */
  public function validate(
    $productDTO
  ) {
    $validator = Validator::make($productDTO, [
      'name' => 'required',
      'amount' => 'required',
      'qty_stock' => 'required|integer'
    ]);

    if ($validator->fails()) {
      return $validator->errors();
    }
    return null;
  }

  /**
   * Remove um produto (soft delete)
   */
  public function delete(int $id): ?Product
  {
    $product = Product::find($id);

    if (!$product) return null;

    $product->delete();

    return $product;
  }
}
