<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class KackspechtFilterMethodTest extends TestCase
{
  public function testBasic(): void
  {
    $kackspecht = '<span style="color: red">' . "Kackspecht" . '</span>';
    $filter = new KackspechtFilterMethod('IdiomReplaceX ist ein <strong>Kunstprojekt</strong> zur <em>literarischen Bearbeitung</em> von Webseiten.');
    $rpTokens = $filter->getReplaceTokens();
    $this->assertEquals(4, count($rpTokens));

    $this->assertEquals("ist", $rpTokens[0]["token"]);
    $this->assertEquals($kackspecht, $rpTokens[0]["replacement"]);

    $this->assertEquals("Kunstprojekt", $rpTokens[1]["token"]);
    $this->assertEquals($kackspecht, $rpTokens[1]["replacement"]);

    $this->assertEquals("literarischen", $rpTokens[2]["token"]);
    $this->assertEquals($kackspecht, $rpTokens[2]["replacement"]);

    $this->assertEquals("von", $rpTokens[3]["token"]);
    $this->assertEquals($kackspecht, $rpTokens[3]["replacement"]);
  }

  public function testSatzzeichen(): void
  {
    $kackspecht = '<span style="color: red">' . "Kackspecht" . '</span>';
    $filter = new KackspechtFilterMethod('IdiomReplaceX Komma, ein <strong>Kunstprojekt,</strong> zur <em>literarischen Bearbeitung</em> von Webseiten.');
    $rpTokens = $filter->getReplaceTokens();
    $this->assertEquals(4, count($rpTokens));

    $this->assertEquals("Komma", $rpTokens[0]->getToken());
    $this->assertEquals($kackspecht, $rpTokens[0]->getReplacement());

    $this->assertEquals("Kunstprojekt", $rpTokens[1]->getToken());
    $this->assertEquals($kackspecht, $rpTokens[1]->getReplacement());
  }

}






