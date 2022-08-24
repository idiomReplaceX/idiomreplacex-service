<?php

class FilterMethods {
  public const KACKSPECHT = 'Kackspecht';
  public const XX = 'Xtrem';
  public const HILFE = 'Gefängnis';
  public const NOVERB = 'Verben aus';
  public const BASISFORM = 'Basisform';
  public const LAUT = 'Laut';
  public const WEICHSPUELER = 'Weichspüler';
  public const KLARSPUELER = 'Klarspüler';
  public const VERNIS = 'Vernis';
  public const POLYNESIEN = 'Polynesien';
  public const LESEBRILLE = 'Lesebrille';
  public const TIPPEX = 'Tipp-Ex';
  public const TIPPEX2 = 'Tipp-Ex Extrem';
  public const FONTSIZE = 'Font-Size Remix';
  public const CSVREPL = 'Liste Replace Test';

  public static function list(): array {
    return [self::KACKSPECHT, self::LAUT, self::XX, self::HILFE, self::NOVERB, self::BASISFORM, self::LESEBRILLE, self::WEICHSPUELER, self::KLARSPUELER, self::VERNIS, self::POLYNESIEN,self::TIPPEX,self::TIPPEX2,self::FONTSIZE,self::CSVREPL];
  }
}