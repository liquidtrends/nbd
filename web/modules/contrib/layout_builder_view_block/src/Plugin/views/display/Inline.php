<?php

namespace Drupal\layout_builder_view_block\Plugin\views\display;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\views\Plugin\views\display\Embed;

/**
 * The plugin that handles an embed display.
 *
 * @ViewsDisplay(
 *   id = "inline",
 *   title = @Translation("Inline block (Layout builder)"),
 *   help = @Translation("Provide a display which can be embedded in layout builder."),
 *   theme = "views_view",
 *   uses_menu_links = FALSE
 * )
 */
class Inline extends Embed {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['category'] = [
      'contains' => [
        'title' => ['default' => ''],
      ],
    ];

    $options['icon'] = [
      'contains' => [
        'image' => [
          'default' => '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-list-ul" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>',
        ],
      ],
    ];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function optionsSummary(&$categories, &$options) {
    parent::optionsSummary($categories, $options);

    $categories['category'] = [
      'title' => $this->t('Inline view settings'),
      'column' => 'second',
      'build' => [
        '#weight' => -10,
      ],
    ];

    $category = $this->getOption('category');
    switch ($category['title']) {
      default:
        $str = $category['title'];
        break;

      case '':
        $str = $this->t('No category');
        break;
    }

    $icon = $this->getOption('icon');
    $options['category'] = [
      'category' => 'category',
      'title' => $this->t('Category'),
      'value' => views_ui_truncate($str, 24),
    ];

    $options['icon'] = [
      'category' => 'category',
      'title' => $this->t('Icon'),
      'value' => !empty($icon['image']) ? Markup::create($icon['image']) : $this->t('No icon set'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    switch ($form_state->get('section')) {
      case 'category':
        $form['category'] = [
          '#prefix' => '<div class="clearfix">',
          '#suffix' => '</div>',
          '#tree' => TRUE,
        ];
        $options = $this->getOption('category');
        $form['category']['title'] = [
          '#prefix' => '<div class="views-left-75">',
          '#suffix' => '</div>',
          '#title' => $this->t('Title'),
          '#type' => 'textfield',
          '#default_value' => $options['title'],
          '#description' => $this->t('Set a category for this display.'),
        ];
        break;

      case 'icon':
        $options = $this->getOption('icon');
        $form['icon'] = [
          '#prefix' => '<div class="clearfix">',
          '#suffix' => '</div>',
          '#tree' => TRUE,
        ];
        $form['icon']['image'] = [
          '#prefix' => '<div class="views-left-75">',
          '#suffix' => '</div>',
          '#title' => $this->t('Icon'),
          '#type' => 'textarea',
          '#default_value' => $options['image'],
          '#description' => $this->t('You can add your svg image here'),
        ];
        break;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitOptionsForm(&$form, FormStateInterface $form_state) {
    parent::submitOptionsForm($form, $form_state);

    switch ($form_state->get('section')) {
      case 'category':
        $category = $form_state->getValue('category');
        $this->setOption('category', $category);
        break;

      case 'icon':
        $icon = $form_state->getValue('icon');
        $this->setOption('icon', $icon);
        break;
    }
  }

}
