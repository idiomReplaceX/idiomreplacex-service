<?php

class FilterMethods {
  public const KACKSPECHT = 'Kackspecht';
  public const TOURETTE = 'tourette';
  public const DADA = 'dada';

  public static function list(): array {
    return [self::KACKSPECHT, self::TOURETTE, self::DADA];
  }
}