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
}