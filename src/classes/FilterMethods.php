<?php

class FilterMethods {

  public const KACKSPECHT = 'Kackspecht';
  public const TEXTOFF = 'Text aus';

  public const XX = 'Xtrem';

  public const HILFE = 'Gefängnis';

  public const NOVERB = 'Verben aus';
  public const MULTIMIX = 'Multimix (langsam)';

  public const BASISFORM = 'Basisform';

  public const LAUT = 'Laut';

  public const WEICHSPUELER = 'Weichspüler';

  public const KLARSPUELER = 'Klarspüler';

  public const VERNIS = 'Vernis';

  public const POLYNESIEN = 'Polynesien';

  public const LESEBRILLE = 'Lesebrille';
  
  public const POCKEN = 'Pocken';

  public const TIPPEX = 'Tipp-Ex';

  public const TIPPEX2 = 'Tipp-Ex Extrem';

  public const FONTSIZE = 'Font-Size Remix';

  public const CSVREPL = 'Liste Replace Test';

  public static function list(): array {
    $list = [
      FilterMethods::filterMethod(self::KACKSPECHT, "Andreas Kohlbecker", "2021", NULL),
      FilterMethods::filterMethod(self::LAUT, "Nils Menrad", "2022", NULL),
      FilterMethods::filterMethod(self::XX, "Nils Menrad", "2022", NULL),
      FilterMethods::filterMethod(self::TEXTOFF, "Nils Menrad", "2022", NULL),
      FilterMethods::filterMethod(self::HILFE, "Nils Menrad", "2022", NULL),
      FilterMethods::filterMethod(self::BASISFORM, "Nils Menrad", "2022", NULL),
      FilterMethods::filterMethod(self::NOVERB, "Nils Menrad", "2022", NULL),
      FilterMethods::filterMethod(self::MULTIMIX, "Nils Menrad", "2022", NULL),
      FilterMethods::filterMethod(self::LESEBRILLE, "Ann Cotten", "2022", NULL),
      FilterMethods::filterMethod(self::WEICHSPUELER, "Ann Cotten", "2022", NULL),
      FilterMethods::filterMethod(self::KLARSPUELER, "Ann Cotten", "2022", NULL),
      FilterMethods::filterMethod(self::VERNIS, "Ann Cotten", "2022", NULL),
      FilterMethods::filterMethod(self::POLYNESIEN, "Ann Cotten", "2022", NULL),
      FilterMethods::filterMethod(self::POCKEN, "Ann Cotten", "2022", NULL),
      FilterMethods::filterMethod(self::TIPPEX, "Nils Menrad", "2022", self::TIPPEX . ".css"),
      FilterMethods::filterMethod(self::TIPPEX2, "Nils Menrad", "2022", NULL),
      FilterMethods::filterMethod(self::FONTSIZE, "Nils Menrad", "2022", NULL),
      FilterMethods::filterMethod(self::CSVREPL, "Nils Menrad", "2022", NULL)
    ];
    $dynamic = Db::getFilter();
    foreach ($dynamic as $dyn){
      if(!is_array($dyn)){
       $list[] = FilterMethods::filterMethod($dyn);
      } else {
        $list[] = $dyn;
      }
    }
    return $list;
  }

  static function filterMethod($name, $author = NULL, $year = NULL, $cssFile = NULL): array {
    return [
      "name" => $name,
      "author" => $author,
      "year" => $year,
      "cssFile" => $cssFile,
    ];
  }

}