<?php

namespace Drupal\legal_article\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Render\Renderer;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;

/**
 * Controller definition.
 */
class LegalArticleController extends ControllerBase {
  /**
   * For services dependency injection.
   *
   * @var Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * For services dependency injection.
   *
   * @var Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * Class constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entity_type_manager
   *   For services dependency injection.
   * @param \Drupal\Core\Render\Renderer $renderer
   *   For services dependency injection.
   */
  public function __construct(
    EntityTypeManager $entity_type_manager,
    Renderer $renderer) {
    $this->entityTypeManager = $entity_type_manager;
    $this->renderer = $renderer;
  }

  /**
   * Object create method.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Container interface.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('renderer'),
    );
  }

  /**
   * Creates and serves PDF file.
   */
  public function legalArticlePdf($nid) {
    // Instantiate and use the dompdf class.
    $dompdf = new Dompdf();

    // Render node view html to string.
    $node =
      $this->entityTypeManager->getStorage('node')->load($nid);
    $view_builder = $this->entityTypeManager->getViewBuilder('node');
    $renderarray = $view_builder->view($node, 'pdf');
    $html =
      $this->renderer->renderRoot($renderarray);

    // Get module path.
    $path = DRUPAL_ROOT . '/' . drupal_get_path("module", "legal_article");

    // Set base path for CSS.
    $path .= "/css";
    $dompdf->setBasePath($path);

    // Load html into dompdf.
    $dompdf->loadHtml($html, "utf-8");

    // Render the HTML as PDF.
    $dompdf->render();

    // Name PDF file.
    $pdf_name = $node->getTitle();

    $response = new Response($dompdf->output());
    $response->headers->set('Content-Type', 'Content-type:application/pdf');
    $response->headers->set('Content-Disposition', "attachment; filename=\"{$pdf_name}.pdf\"");
    return $response;
  }

  /**
   * Check if node is a legal article.
   */
  public function checkLegalArticle($nid) {
    $node =
      $this->entityTypeManager->getStorage('node')->load($nid);
    return AccessResult::allowedIf($node->bundle() === 'legal_article');
  }

}
