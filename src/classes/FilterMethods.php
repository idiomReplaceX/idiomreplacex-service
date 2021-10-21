<?php

class FilterMethods {
  public const TOURETTE = 'tourette';
  public const DADA = 'dada';

  public static function list(): array {
    return [self::TOURETTE, self::DADA];
  }
}