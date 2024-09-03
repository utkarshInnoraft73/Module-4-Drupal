<?php

namespace Drupal\custom_movie;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining an award winning movie entity type.
 */
interface AwardWinningMovieInterface extends ConfigEntityInterface {

  /**
   * Method getYear to get the award winning year of the movie.
   *
   * @return int
   *   Return the year of award winning.
   */
  public function getYear();

  /**
   * Method setYear to set the award winning year of the movie.
   *
   * @param int $year
   *   The year of the award winning.
   */
  public function setYear(int $year);

}
