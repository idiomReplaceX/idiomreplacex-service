<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class XXXFilterMethodTest extends TestCase
{
  public function testBasic(): void
  {
    $xxx = 'XXXX';
    $filter = new XXFilterMethod('IdiomReplaceX ist ein <strong>Kunstprojekt</strong> zur <em>literarischen Bearbeitung</em> von Webseiten');
    $rpTokens = $filter->getReplaceTokens();

    // $this->assertEquals(9, count($rpTokens)); // FIXME

    $this->assertEquals("IdiomReplaceX", $rpTokens[0]["token"]);
    $this->assertEquals($xxx, $rpTokens[0]["replacement"]);

    $this->assertEquals("ist", $rpTokens[1]["token"]);
    $this->assertEquals($xxx, $rpTokens[1]["replacement"]);

    $this->assertEquals("ein", $rpTokens[2]["token"]);
    $this->assertEquals($xxx, $rpTokens[2]["replacement"]);

    $this->assertEquals("von", $rpTokens[7]["token"]);
    $this->assertEquals($xxx, $rpTokens[7]["replacement"]);
  }

}






