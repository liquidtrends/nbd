<?php

namespace Drupal\layout_builder_view_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\views\ResultRow;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\EntityDisplayRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\views\Views;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\layout_builder\Plugin\SectionStorage\OverridesSectionStorage;

/**
 * Provides a Custom block.
 *
 * @Block(
 *   id = "layout_builder_view_block",
 *   admin_label = @Translation("View block"),
 *   category = @Translation("View Block"),
 *   deriver = "Drupal\layout_builder_view_block\Plugin\Derivative\ViewBlock"
 * )
 */
class ViewBlock extends BlockBase implements ContainerFactoryPluginInterface, BlockPluginInterface {

  /**
   * Storage interface for views.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $manager;

  /**
   * Entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Display repository.
   *
   * @var \Drupal\Core\Entity\EntityDisplayRepositoryInterface
   */
  protected $displayRepository;

  /**
   * Renderer for display.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Count for all results.
   *
   * @var int
   */
  protected $resultCount = 0;

  /**
   * View to display.
   *
   * @var \Drupal\Core\Entity\EntityInterface|null
   */
  protected $view;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityTypeManagerInterface $manager,
    EntityDisplayRepositoryInterface $display_repository,
    RendererInterface $renderer
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->manager = $manager->getStorage('view');
    $this->entityTypeManager = $manager;
    $this->displayRepository = $display_repository;
    $this->renderer = $renderer;
    $this->view = $this->manager->load($this->getViewId());
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('entity_display.repository'),
      $container->get('renderer')
    );
  }

  /**
   * Set if this block is in preview.
   */
  public function inPreview($in_preview) {
    $this->inPreview = $in_preview;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $view = $this->getView();
    $config = $this->getConfiguration();

    if (!$view && $this->inPreview) {
      return [
        '#markup' => $this->t('View @config do not exist anymore', [
          '@config' => $this->getDerivativeId(),
        ]),
      ];
    }
    if (!$view) {
      return [];
    }

    $view->setItemsPerPage(1);
    $resultToShow = $config['offset'] - 1;
    $view->setOffset($resultToShow);
    $view->execute();
    $rows = count($view->result);
    $build = [
      '#cache' => [
        'tags' => [],
      ],
    ];
    $view->getDisplay()->getCacheMetaData()->applyTo($build);
    $this->renderer->addCacheableDependency($build, $this->view);
    $build['#cache']['tags'] = Cache::mergeTags($build['#cache']['tags'], $view->getCacheTags());
    if (count($view->result) == 0) {
      return $build;
    }

    $entity = $this->getRowEntity($view->result[0]);
    $build['result'] = $this->entityTypeManager->getViewBuilder($entity->getEntityTypeId())
      ->view($entity, isset($this->configuration['view_mode']) ? $this->configuration['view_mode'] : 'default');
    return $build;
  }

  /**
   * Extracts the entity from a views Row.
   *
   * @param \Drupal\views\ResultRow $row
   *   View result row.
   *
   * @return \Drupal\Core\Entity\EntityInterface|null
   *   Entity interface to display.
   */
  protected function getRowEntity(ResultRow $row) {
    if (is_a($row, '\Drupal\search_api\Plugin\views\ResultRow')) {
      $adapter = $row->_item->getOriginalObject();
      if (!$adapter) {
        return NULL;
      }
      return $adapter->getEntity();
    }
    return $row->_entity ?? NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'label_display' => FALSE,
      'view_mode' => 'default',
      'offset' => 1,
    ];
  }

  /**
   * Get a view.
   */
  public function getView() {
    $block_id = $this->getDerivativeId();
    $viewId = explode(':', $block_id)[0];
    $displayId = explode(':', $block_id)[1];
    $view = Views::getView($viewId);
    if (!$view) {
      return NULL;
    }
    $routes = [
      'layout_builder.add_block',
      'layout_builder.move_block',
      'layout_builder.update_block',
      'layout_builder.update_block',
      'layout_builder.remove_block',
    ];
    if (in_array(\Drupal::routeMatch()->getRouteName(), $routes)) {
      /**
       * @var \Drupal\layout_builder\Plugin\SectionStorage\OverridesSectionStorage
       */
      $storage = \Drupal::routeMatch()->getParameter('section_storage');
      /**
       * @var \Drupal\Core\Entity\ContentEntityBase $entity
       */
      if ($storage instanceof OverridesSectionStorage && $entity = $storage->getContextValue('entity')) {
        if ($entity) {
          $view->setArguments([$entity->id()]);
        }
      }
    }
    $view->setDisplay($displayId);
    return $view;
  }

  /**
   * Get display id.
   */
  public function getDisplayId() {
    $block_id = $this->getDerivativeId();
    return explode(':', $block_id)[1];
  }

  /**
   * Get view id.
   */
  public function getViewId() {
    $block_id = $this->getDerivativeId();
    return explode(':', $block_id)[0];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $view = $this->getView();
    if (!$view) {
      return ['#markup' => $this->t('View does not exist')];
    }

    if (is_a($view->getQuery(), '\Drupal\search_api\Plugin\views\query\SearchApiQuery')) {
      /**
       * @var Drupal\search_api\Plugin\views\query\SearchApiQuery $view
       */
      $target_type = $view->getQuery()->getEntityTypes();
      foreach ($target_type as $type) {
        $form['view_mode'][$type] = [
          '#type' => 'select',
          '#options' => $this->displayRepository->getViewModeOptions($type),
          '#tree' => TRUE,
          '#title' => $this->t('View mode for @type', ['@type' => $type]),
          '#description' => $this->t('Who do you want to say hello to?'),
          '#default_value' => isset($config['view_mode']) ? $config['view_mode'] : '',
        ];
      }
    }
    else {
      $form['view_mode'][$view->getBaseEntityType()->id()] = [
        '#type' => 'select',
        '#options' => $this->displayRepository->getViewModeOptions($view->getBaseEntityType()->id()),
        '#tree' => TRUE,
        '#title' => $this->t('View mode'),
        '#description' => $this->t('Who do you want to say hello to?'),
        '#default_value' => isset($config['view_mode']) ? $config['view_mode'] : '',
      ];
    }

    $form['offset'] = [
      '#type' => 'number',
      '#min' => 1,
      '#title' => $this->t('Offset to display'),
      '#default_value' => isset($config['offset']) ? $config['offset'] : '',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();

    $this->configuration['view_mode'] = array_values($values['view_mode'])[0];
    $this->configuration['offset'] = $values['offset'];
  }

}
