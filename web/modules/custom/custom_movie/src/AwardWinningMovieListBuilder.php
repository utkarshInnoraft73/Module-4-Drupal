<?php

namespace Drupal\custom_movie;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of award winning movies.
 */
class AwardWinningMovieListBuilder extends ConfigEntityListBuilder {

  /**
   * Method buildHeader to build the header of the table.
   *
   * @return array
   *   Headings of the table.
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Movie Name');
    $header['year'] = $this->t('Year');
    return $header + parent::buildHeader();
  }

  /**
   * Method buildRow build the row.
   *
   * @param Drupal\Core\Entity\EntityInterface $entity
   *   Entities.
   *
   * @return array
   *   Row.
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\custom_movie\AwardWinningMovieInterface $entity */
    $row['label'] = $entity->label();
    $row['year'] = $entity->getYear();
    return $row + parent::buildRow($entity);
  }

}
