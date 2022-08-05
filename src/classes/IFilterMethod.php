<?php

interface IFilterMethod {

  /**
   * @return null
   */
  public function getText();

  /**
   * @return array
   */
  public function getReplaceTokens(): array;

  /**
   * @param array $chrArray
   * @param int $startPos
   * @param int $endPos
   *
   * @return boolean
   *  TRUE if a new token has been created and added to the rpTokens list, otherwise FALSE
   */
  public function makeReplacementToken(array $chrArray, int $startPos, int $endPos): bool;
}