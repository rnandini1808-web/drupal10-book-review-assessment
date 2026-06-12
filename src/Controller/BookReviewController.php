<?php

namespace Drupal\book_review\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\book_review\Service\BookReviewService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns listing page for book reviews.
 */
class BookReviewController extends ControllerBase {

  /**
   * Book review service.
   *
   * @var \Drupal\book_review\Service\BookReviewService
   */
  protected $bookReviewService;

  /**
   * Constructor.
   */
  public function __construct(BookReviewService $book_review_service) {
    $this->bookReviewService = $book_review_service;
  }

  /**
   * Dependency injection.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('book_review.review_service')
    );
  }

  /**
   * Listing page callback.
   */
  public function listing() {

    $nodes = $this->bookReviewService->getPublishedReviews();

    $reviews = [];

    foreach ($nodes as $node) {
      $reviews[] = $this->bookReviewService->buildReviewData($node);
    }

    return [
      '#theme' => 'book_review_listing',
      '#reviews' => $reviews,
      '#cache' => [
        'tags' => ['node_list'],
      ],
    ];
  }

}
