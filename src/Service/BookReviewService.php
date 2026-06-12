<?php

namespace Drupal\book_review\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\node\NodeInterface;

/**
 * Service for loading book reviews.
 */
class BookReviewService {

  /**
   * Entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * File URL generator.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * Constructor.
   */
  public function __construct(
    EntityTypeManagerInterface $entity_type_manager,
    FileUrlGeneratorInterface $file_url_generator,
  ) {
    $this->entityTypeManager = $entity_type_manager;
    $this->fileUrlGenerator = $file_url_generator;
  }

  /**
   * Get all published book reviews (newest first).
   */
  public function getPublishedReviews() {

    $nids = $this->getQuery()
      ->execute();

    return $nids
      ? $this->entityTypeManager->getStorage('node')->loadMultiple($nids)
      : [];
  }

  /**
   * Get latest N reviews.
   */
  public function getRecentReviews($limit = 3) {

    $nids = $this->getQuery()
      ->range(0, $limit)
      ->execute();

    return $nids
      ? $this->entityTypeManager->getStorage('node')->loadMultiple($nids)
      : [];
  }

  /**
   * Shared query builder.
   */
  private function getQuery() {
    return $this->entityTypeManager
      ->getStorage('node')
      ->getQuery()
      ->accessCheck(TRUE)
      ->condition('type', 'book_review')
      ->condition('status', 1)
      ->sort('created', 'DESC');
  }

  /**
   * Get book cover image URL safely.
   */
  public function getBookCoverUrl(NodeInterface $node) {

    if (
      !$node->hasField('field_book_cover') ||
      $node->get('field_book_cover')->isEmpty()
    ) {
      return NULL;
    }

    $file = $node->get('field_book_cover')->entity;

    if (!$file) {
      return NULL;
    }

    return $this->fileUrlGenerator->generateAbsoluteString(
      $file->getFileUri()
    );
  }

  /**
   * Build review data array for Twig templates.
   */
  public function buildReviewData(NodeInterface $node): array {

    return [
      'title' => $node->getTitle(),
      'author' => $node->get('field_author_name')->value ?? '',
      'rating' => $node->get('field_star_rating')->value ?? '',
      'body' => $node->get('field_review_body')->value ?? '',
      'image' => $this->getBookCoverUrl($node),
      'url' => $node->toUrl()->toString(),
    ];
  }

}
