<?php

namespace App\Providers\XML;

use SimpleXMLElement;

class XMLProvider
{
  public   static function createPurchaseXML($puchaseData): string
  {
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><dados></dados>');

    foreach ($puchaseData as $key => $value) {
      if (!is_array($value))
        $xml->addChild($key, $value);
      // caso seja um objeto(array) com as informacoes, preenche os dados aninhados
      else {
        $nestedNode = $xml->addChild($key);
        foreach ($value as $nestedKey => $nestedData)
          $nestedNode->addChild($nestedKey, $nestedData);
      }
    }

    return $xml->asXML();
  }
}
