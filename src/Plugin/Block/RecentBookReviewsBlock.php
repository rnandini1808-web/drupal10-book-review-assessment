<?php

namespace Drupal\book_review\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\book_review\Service\BookReviewService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Recent Book Reviews' block.
 *
 * @Block(
 *   id = "recent_book_reviews_block",
 *   admin_label = @Translation("Recent Book Reviews"),
 * )
 */
class RecentBookReviewsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Book review service.
   *
   * @var \Drupal\book_review\Service\BookReviewService
   */
  protected $bookReviewService;

  /**
   * Constructor.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, BookReviewService $book_review_service) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->bookReviewService = $book_review_service;
  }

  /**
   * Dependency injection.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('book_review.review_service')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $reviews = $this->bookReviewService->getRecentReviews(3);

    $items = [];

    foreach ($reviews as $review) {
      $items[] = [
        '#theme' => 'book_review_card',
        '#review' => $this->bookReviewService->buildReviewData($review),
      ];
    }

    return [
      '#theme' => 'item_list',
      '#items' => $items,
      '#attached' => [
        'library' => [
          'book_review/book_review_styles',
        ],
      ],
      '#cache' => [
        'tags' => ['node_list'],
      ],
    ];
  }

}
