<?php

namespace Drupal\custom_movie;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining an award winning movie entity type.
 */
interface AwardWinningMovieInterface extends ConfigEntityInterface {

  /**
   * Method getYear.
   */
  public function getYear();

  /**
   * Method setYear.
   *
   * @param int $year
   *   The winning year.
   */
  public function setYear(int $year);

}
