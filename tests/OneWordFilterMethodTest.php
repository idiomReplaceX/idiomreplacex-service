<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class OneWordFilterMethodTest extends TestCase
{
  public function testBasic(): void
  {
    
    $input =  "Tiere sind vielzellige Lebensformen, die eine Form des heterotrophen Stoff- und Energiewechsels betreiben."; 
    $results = [
        ["Lebensformen","Lebenswormen"],
        ["heterotrophen","hederodrophen"],
        ["Stoff-","Sdoff-"],
        ["Energiewechsels","Energiewecbsels"],
        ["betreiben","bedreiben"],
    ];  
      
    $filter = new OneWordFilterMethod('',FilterMethods::WEICHSPUELER);
    $rpTokens = $filter->getReplaceTokens();
    
    $this->assertEquals(count($results), count($rpTokens));
    foreach ($results as $key => $value) {
        $this->assertEquals($value[0], $rpTokens[0]["token"]);
        $this->assertEquals($value[1], $rpTokens[0]["replacement"]);
    }

  }

  

}






