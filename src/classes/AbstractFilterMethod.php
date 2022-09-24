<?php

abstract class AbstractFilterMethod implements IFilterMethod {

    protected $tokenizer;
    protected $rpTokens = [];
    protected $subfilter;
    protected $documentUrlId;

    /**
     * @param null $text
     */
    public function __construct($text,$subfilter='',$documentUrlId='') {
        $this->tokenizer = new \tokenizer\HtmlTextTokenizer($text);
        $this->subfilter = $subfilter;
        $this->documentUrlId = $documentUrlId;
    }

    /**
     * @return null
     */
    public function getText() {
        return $this->tokenizer->getText();
    }

    /**
     * @return \tokenizer\HtmlTextTokenizer
     */
    public function getTokenizer(): \tokenizer\HtmlTextTokenizer {
        return $this->tokenizer;
    }
    
    /**
     * @return \tokenizer\HtmlTextTokenizer
     */
    public function getSubfilter() {
        return $this->subfilter;
    }
    
    /**
     * @return \tokenizer\HtmlTextTokenizer
     */
    public function getDocumentId() {
        return $this->documentUrlId;
    }

    /**
     * @return array
     */
    public function getReplaceTokens(): array {
        if (!$this->rpTokens) {
            $this->makeReplacementTokens();
        }
        $data = [];
        foreach($this->rpTokens as $token) {
            $arr = [];
            $arr["replacement"] = $token->getReplacement();
            $arr["start"] = $token->getStart();
            $arr["token"] = $token->getToken();
            $data[] = $arr;
        }
        return $data;
    }

    abstract public function makeReplacementTokens();
}
