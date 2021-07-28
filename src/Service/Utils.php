<?php

namespace App\Service;

use App\Exceptions\TaxeInvalidException;
use InvalidArgumentException;

class Utils
{
  static function getFullname(string $nom, string $prenom)
  {
    $nom = strtoupper($nom);
    $prenom = strtolower($prenom);
    $prenom = ucfirst($prenom);
    return $prenom . ' ' . $nom;
  }
  static function formatPrice(float $price)
  {
    return \NumberFormatter::formatCurrency($price, "EUR");
  }
  static function getTaxTypes()
  {
    return ["TAUX_REDUIT" => 5.5, "TAUX_NORMAL" => 20];
  }
  static function calculateTVA(float $price, string $taxType)
  {
    $taxTypes = self::getTaxTypes();
    if (!key_exists($taxType, $taxTypes)) {
      throw new TaxeInvalidException();
    }
    $tax = $taxTypes[$taxType];
    return $price * $tax / 100;
  }
  /**
   * calculates power of 
   * @param a integer
   * @param n integer must be greater than or equal to 0
   * @throws InvalidArgumentException if n < 0
   */
  static function puissance(int $a, int $n)
  {
    if ($n < 0) throw new InvalidArgumentException();
    $res = 1;
    for ($i = 0; $i < $n; $i++) {
      $res = $a * $res;
    }
    return $res;
  }
}

//https://symfony.com/doc/current/the-fast-track/fr/17-tests.html
//https://symfony.com/doc/current/testing.html#unit-tests


