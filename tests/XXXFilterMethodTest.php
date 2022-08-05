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

    $this->assertEquals("IdiomReplaceX", $rpTokens[0]->getToken());
    $this->assertEquals($xxx, $rpTokens[0]->getReplacement());

    $this->assertEquals("ist", $rpTokens[1]->getToken());
    $this->assertEquals($xxx, $rpTokens[1]->getReplacement());

    $this->assertEquals("ein", $rpTokens[2]->getToken());
    $this->assertEquals($xxx, $rpTokens[2]->getReplacement());

    $this->assertEquals("von", $rpTokens[7]->getToken());
    $this->assertEquals($xxx, $rpTokens[7]->getReplacement());
  }

}






