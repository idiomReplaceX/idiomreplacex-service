<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class OneWordFilterMethodTest extends TestCase
{
    
    
  public function testBasic(): void
  {
      
    $input =  "Tiere sind vielzellige Lebensformen, die eine Form des heterotrophen Stoff- und Energiewechsels betreiben."; 
    
    //Filter Weichspüler
    $results = [
        ["Lebensformen","Lebenswormen"],
        ["heterotrophen","hederodrophen"],
        ["Stoff-","Sdoff-"],
        ["Energiewechsels","Energiewecbsels"],
        ["betreiben","bedreiben"],
    ];  
    $this->filtertest(FilterMethods::WEICHSPUELER,$input,$results);
    
    //Filter Klarspüler
    $results = [
        ["sind","sint"],
        ["Lebensformen","Lephensformen"],
        ["und","unt"],
        ["Energiewechsels","Energiefechsels"],
    ];
    $this->filtertest(FilterMethods::KLARSPUELER,$input,$results);
    
    //Filter Vernis
    $results = [
        ["Tiere","Tyere"],
        ["sind","synd"],
        ["vielzellige","vyelzellyge"],
        ["die","dye"],
        ["eine","eyne"],
        ["Energiewechsels","Energyewechsels"],
        ["betreiben","betreyben"],
    ];
    $this->filtertest(FilterMethods::VERNIS,$input,$results);
    
    //Filter Polynesien
    $results = [
        ["heterotrophen","hekerokrophen"],
        ["Stoff-","Skoff-"],
        ["betreiben","bekreiben"],
    ];
    $this->filtertest(FilterMethods::POLYNESIEN,$input,$results);
    

  }
  
  public function filtertest($subfilter,$input,$results) {
      
    $filter = new OneWordFilterMethod($input,$subfilter);
    $rpTokens = $filter->getReplaceTokens();

    $this->assertEquals(count($results), count($rpTokens));
    foreach ($results as $key => $value) {
        $this->assertEquals($value[0], $rpTokens[$key]["token"]);
        $this->assertEquals($value[1], $rpTokens[$key]["replacement"]);
    }
    
  }

  

}






