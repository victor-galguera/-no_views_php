<?php

/**
 * @file
 * Contains no_views_php\no_views_php.views.inc..
 * Provide a custom views field data that isn't tied to any other module. */

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Render\Markup;
use Drupal\field\FieldConfigInterface;
use Drupal\field\FieldStorageConfigInterface;
use Drupal\system\ActionConfigEntityInterface;

/**
* Implements hook_views_data().
*/
function no_views_php_views_data() {

    $data['views']['table']['group'] = t('Custom Global');
    $data['views']['table']['join'] = [
      // #global is a special flag which allows a table to appear all the time.
      '#global' => [],
    ];


    $data['views']['phpviews_field'] = [
        'title' => t('PHP Field'),
        'help' => t('Enable to include and run PHP code in your modules as part of a view'),
        'field' => [
            'id' => 'phpviews_field',
        ],
    ];

    return $data;
}
