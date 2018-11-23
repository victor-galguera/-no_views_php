<?php

namespace Drupal\no_views_php\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Random;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\content_moderation\ModerationInformationInterface;

/**
 * A handler to provide a field that is completely custom by the administrator.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("phpviews_field")
 */
class PHPViewsField extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function usesGroupBy() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Do nothing -- to override the parent query.
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['hide_alter_empty'] = ['default' => FALSE];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    // Return a random text, here you can include your custom logic.
    // Include any namespace required to call the method required to generate
    // the desired output.
    $entity = $values->_entity;
    $eid = $entity->id();
    $etid = $entity->getEntityTypeId();
    $moderation_info = \Drupal::service('content_moderation.moderation_information');
    $latest = $moderation_info->getLatestRevisionId($etid, $eid);
    $vids = \Drupal::entityManager()->getStorage('node')->revisionIds($entity);

    $query = \Drupal::entityQuery('node')->condition('nid', $eid)->currentRevision();
    $result = $query->execute();
    $live = key($result);
    if (count($vids) <= 1){
        return [
            '#type' => 'markup',
            '#markup' => t("<a href='/node/$eid/revisions/$latest/view' target='_blank'>Review Draft</a>"),
        ];
    }
    else {
        $latest = array_pop($vids);
        return [
            '#type' => 'markup',
            '#markup' => t("<a href='/node/$eid/revisions/view/$live/$latest/split_fields' target='_blank'>Review Changes</a>")
       ];
    }
  }

}
