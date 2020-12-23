<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Purchase extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'quantity_purchased',
    'product_id',
  ];

  /**
   * Carrega o relacionamento entre compra e produto
   */
  public function product()
  {
    return $this->hasOne(Product::class, 'product_id');
  }
}
