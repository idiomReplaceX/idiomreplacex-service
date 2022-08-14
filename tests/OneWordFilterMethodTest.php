<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class OneWordFilterMethodTest extends TestCase
{
  public function testBasic(): void
  {
    
    $filter = new OneWordFilterMethod('Tiere sind vielzellige Lebensformen, die eine Form des heterotrophen Stoff- und Energiewechsels betreiben.');
    $rpTokens = $filter->getReplaceTokens();
    $this->assertEquals(5, count($rpTokens));

    $this->assertEquals("Lebensformen", $rpTokens[0]["token"]);
    $this->assertEquals("Lebenswormen", $rpTokens[0]["replacement"]);

    $this->assertEquals("heterotrophen", $rpTokens[1]["token"]);
    $this->assertEquals("hederodrophen", $rpTokens[1]["replacement"]);

    $this->assertEquals("Stoff-", $rpTokens[2]["token"]);
    $this->assertEquals("Sdoff-", $rpTokens[2]["replacement"]);

    $this->assertEquals("Energiewechsels", $rpTokens[3]["token"]);
    $this->assertEquals("Energiewecbsels", $rpTokens[3]["replacement"]);
    
    $this->assertEquals("betreiben", $rpTokens[4]["token"]);
    $this->assertEquals("bedreiben", $rpTokens[4]["replacement"]);
  }

  

}






