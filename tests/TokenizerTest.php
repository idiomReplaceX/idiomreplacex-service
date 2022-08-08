<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class TokenizerTest  extends TestCase {

  public function testHtmlEntities() {
    $tokenizer  = new \tokenizer\HtmlTextTokenizer('Literat&uuml;r <strong>f&ouml;rdert</strong> hei&szlig;e Sonderzeichen wie&gt;und&lt;oder&amp;was noch');
    $text_tokens = $tokenizer->getTextTokens();
    $this->assertEquals('Literat&uuml;r', $text_tokens[0]->getToken());
    $this->assertEquals('Literatür', $text_tokens[0]->tokenDecoded());

    $this->assertEquals('f&ouml;rdert', $text_tokens[1]->getToken());
    $this->assertEquals('fördert', $text_tokens[1]->tokenDecoded());

    $this->assertEquals('wie&gt;und&lt;oder&amp;was', $text_tokens[4]->getToken());
    $this->assertEquals('wie>und<oder&was', $text_tokens[4]->tokenDecoded());
  }

}