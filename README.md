# Book Review Module

## Overview

The Book Review module is a custom Drupal 10 module that enables content editors to create, manage, and display book reviews on a website.

The module provides a dedicated Book Review content type, a public review listing page, and a reusable sidebar block for displaying recent reviews. It is designed following Drupal 10 best practices and demonstrates key Drupal development concepts, including custom content types, routing, controllers, services, dependency injection, entity queries, block plugins, hooks, Twig templating, and asset libraries.

---

## Assumptions

- The Book Review content type is created automatically when the module is installed.
- An optional Book Cover field was added as an enhancement beyond the assessment requirements.
- The `/book-reviews` page displays all published Book Reviews sorted by newest first.
- The Recent Reviews block displays the latest three published Book Reviews.
- The block can be placed through Drupal's Block Layout UI.

---

## Features

### Book Review Content Type

Upon installation, the module automatically creates a custom content type named Book Review.

The content type includes the following fields:

| Field       | Description                      |
| ----------- | -------------------------------- |
| Book Title  | Title of the book being reviewed |
| Author Name | Name of the book's author        |
| Review Body | Detailed review content          |
| Star Rating | Rating from 1 to 5 stars         |
| Book Cover  | Optional cover image             |

---

## Public Review Listing Page

The module provides a custom route:

/book-reviews

The page displays:

* All published Book Reviews
* Reviews sorted by newest first
* Book cover image
* Book title
* Author name
* Star rating
* Review summary
* "Read More" link to the 

---

## Recent Reviews Sidebar Block

The module includes a custom block named:

Recent Book Reviews

This block can be placed through Drupal's Block Layout interface.

The block displays:

* Three most recent published reviews
* Book cover image
* Book title
* Author name
* Star rating
* Review excerpt
* "Read More" link

---

## Installation

Enable the module:

bash
drush en book_review -y


Clear Drupal caches:

bash
drush cr


---

## Content Type Configuration

After enabling the module, configure the title field label:

Navigate to:

Structure → Content Types → Book Review → Edit

Under Submission Form Settings, change the Title field label to:

Book Title

---

## Creating Book Reviews

Navigate to:

Content → Add Content → Book Review

Complete the following fields:

* Book Title
* Author Name
* Review Body
* Star Rating
* Book Cover Image

Click Save.

---

## Viewing Reviews

Visit:

/book-reviews

to view all published book reviews.

---

## Placing the Recent Reviews Block

Navigate to:

Structure → Block Layout

Locate:

Recent Book Reviews

Place the block in the desired region (for example, Sidebar First) and save the configuration.

---

## Architecture

### Controller

File:
src/Controller/BookReviewController.php

Responsibilities:

* Loads published book reviews
* Builds listing page data
* Renders the review listing page

---

### Service

File:
src/Service/BookReviewService.php

Responsibilities:

* Retrieves published reviews
* Retrieves recent reviews
* Generates book cover image URLs
* Provides reusable review data structures
* Centralizes business logic

The service is shared by both the controller and block plugin to eliminate duplicate code and maintain consistency.

---

### Block Plugin

File:
src/Plugin/Block/RecentBookReviewsBlock.php

Responsibilities:

* Displays recent reviews
* Uses dependency injection
* Reuses service methods
* Renders review cards using Twig templates

---

## Twig Templates

### Listing Template

File:
templates/book-review-listing.html.twig

Used to render the main review listing page.

### Review Card Template

File:
templates/book-review-card.html.twig

Used to render individual review cards consistently across both the listing page and the sidebar block.

---

## CSS Library

File:
css/book-review.css

Provides:

* Responsive review grid layout
* Review card styling
* Image presentation and scaling
* Mobile-friendly responsiveness

---

## Hook Implementation

The module implements:

php
hook_entity_view_alter()


### Purpose

When a Book Review node is displayed, the hook evaluates the review's star rating and applies rating-specific CSS classes.

Examples:

* book-review--high
* book-review--medium
* book-review--low

This demonstrates the use of Drupal hooks as part of the assessment requirements.

---

## Dependency Injection

The module follows Drupal best practices by using dependency injection throughout the codebase.

Injected services include:

* EntityTypeManagerInterface
* FileUrlGeneratorInterface
* BookReviewService

Dependency injection is implemented in:

* BookReviewController
* RecentBookReviewsBlock

No business logic relies on static service calls.

---

## Entity Query Usage

The module uses Drupal EntityQuery APIs to retrieve Book Review content.

Typical use cases include:

* Loading all published reviews
* Loading the three most recent reviews
* Sorting reviews by creation date
* Respecting Drupal access checks

---

## Coding Standards

The module has been validated against Drupal coding standards using:

bash
vendor/bin/phpcs --standard=Drupal modules/custom/book_review


bash
vendor/bin/phpcs --standard=DrupalPractice modules/custom/book_review


### Result

* No Drupal coding standard violations
* No Drupal best-practice violations

---

## Module Structure

text
book_review/
├── book_review.info.yml
├── book_review.install
├── book_review.libraries.yml
├── book_review.module
├── book_review.routing.yml
├── book_review.services.yml
├── css/
│   └── book-review.css
├── src/
│   ├── Controller/
│   │   └── BookReviewController.php
│   ├── Plugin/
│   │   └── Block/
│   │       └── RecentBookReviewsBlock.php
│   └── Service/
│       └── BookReviewService.php
└── templates/
    ├── book-review-listing.html.twig
    └── book-review-card.html.twig


---

## Conclusion

The Book Review module demonstrates core Drupal 10 development concepts, including custom content types, field management, routing, controllers, services, dependency injection, entity queries, block plugins, hooks, Twig templating, and coding standards compliance.

The solution follows Drupal best practices, promotes code reusability through services and dependency injection, and successfully fulfills all requirements outlined in the assessment.
