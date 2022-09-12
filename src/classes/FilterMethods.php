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
    $list = [
      filterMethod(self::KACKSPECHT, "Andreas Kohlbecker", "2021", NULL),
      filterMethod(self::LAUT, "Nils Menrad", "2022", NULL),
      filterMethod(self::XX, "Nils Menrad", "2022", NULL),
      filterMethod(self::HILFE, "Nils Menrad", "2022", NULL),
      filterMethod(self::NOVERB, "Nils Menrad", "2022", NULL),
      filterMethod(self::BASISFORM, "Nils Menrad", "2022", NULL),
      filterMethod(self::LESEBRILLE, "Nils Menrad", "2022", NULL),
      filterMethod(self::WEICHSPUELER, "Nils Menrad", "2022", NULL),
      filterMethod(self::KLARSPUELER, "Nils Menrad", "2022", NULL),
      filterMethod(self::VERNIS, "Nils Menrad", "2022", NULL),
      filterMethod(self::POLYNESIEN, "Nils Menrad", "2022", NULL),
      filterMethod(self::TIPPEX, "Nils Menrad", "2022", self::TIPPEX . "css"),
      filterMethod(self::TIPPEX2, "Nils Menrad", "2022", NULL),
      filterMethod(self::FONTSIZE, "Nils Menrad", "2022", NULL),
      filterMethod(self::CSVREPL, "Nils Menrad", "2022", NULL)
    ];
    $dynamic = Db::getFilter();
    foreach ($dynamic as $dyn){
      if(!is_array($dyn)){
       $list[] = filterMethod($dyn);
      } else {
        $list[] = $dyn;
      }
    }
    return $list;
  }

  function filterMethod($name, $author = NULL, $year = NULL, $cssFile = NULL): array {
    return [
      "name" => $name,
      "author" => $author,
      "year" => $year,
      "cssFile" => $cssFile,
    ];
  }

}