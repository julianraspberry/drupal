<?php

/**
 * @file
 * Definition of views_handler_sort_search_score.
 */

namespace Views\search\Plugin\views\sort;

use Drupal\views\Plugin\views\sort\SortPluginBase;
use Drupal\Core\Annotation\Plugin;

/**
 * Field handler to provide simple renderer that allows linking to a node.
 *
 * @ingroup views_sort_handlers
 */

/**
 * @Plugin(
 *   id = "search_score",
 *   module = "search"
 * )
 */
class Score extends SortPluginBase {
  function query() {
    // Check to see if the search filter/argument added 'score' to the table.
    // Our filter stores it as $handler->search_score -- and we also
    // need to check its relationship to make sure that we're using the same
    // one or obviously this won't work.
    foreach (array('filter', 'argument') as $type) {
      foreach ($this->view->{$type} as $handler) {
        if (isset($handler->search_score) && $handler->relationship == $this->relationship) {
          $this->query->add_orderby(NULL, NULL, $this->options['order'], $handler->search_score);
          $this->table_alias = $handler->table_alias;
          return;
        }
      }
    }

    // Do absolutely nothing if there is no filter/argument in place; there is no reason to
    // sort on the raw scores with this handler.
  }
}
