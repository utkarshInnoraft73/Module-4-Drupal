<?php

namespace Drupal\custom_movie\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\custom_movie\AwardWinningMovieInterface;

/**
 * Defines the award winning movie entity type.
 *
 * @ConfigEntityType(
 *   id = "award_winning_movie",
 *   label = @Translation("Award winning Movie"),
 *   label_collection = @Translation("Award winning Movies"),
 *   label_singular = @Translation("award winning movie"),
 *   label_plural = @Translation("award winning movies"),
 *   label_count = @PluralTranslation(
 *     singular = "@count award winning movie",
 *     plural = "@count award winning movies",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\custom_movie\AwardWinningMovieListBuilder",
 *     "form" = {
 *       "add" = "Drupal\custom_movie\Form\AwardWinningMovieForm",
 *       "edit" = "Drupal\custom_movie\Form\AwardWinningMovieForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *   },
 *   config_prefix = "award_winning_movie",
 *   admin_permission = "administer award_winning_movie",
 *   links = {
 *     "collection" = "/admin/structure/award-winning-movie",
 *     "add-form" = "/admin/structure/award-winning-movie/add",
 *     "edit-form" = "/admin/structure/award-winning-movie/{award_winning_movie}",
 *     "delete-form" = "/admin/structure/award-winning-movie/{award_winning_movie}/delete",
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "year" = "year",
 *     "uuid" = "uuid",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "year",
 *   },
 * )
 */
class AwardWinningMovie extends ConfigEntityBase implements AwardWinningMovieInterface {

  /**
   * The example ID.
   */
  protected string $id;

  /**
   * The example label.
   */
  protected string $label;

  /**
   * The example year.
   */
  protected int $year;

  /**
   * Method setYear to set the award winning year of the movie.
   *
   * @param int $year
   *   The year of the award winning.
   */
  public function setYear(int $year) {
    $this->year = $year;
  }

  /**
   * Method getYear to get the award winning year of the movie.
   *
   * @return int
   *   Return the year of award winning.
   */
  public function getYear() : int {
    if (empty($this->year)) {
      return 0;
    }
    return $this->year;
  }

}
