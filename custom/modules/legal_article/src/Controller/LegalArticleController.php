<?php

namespace Drupal\legal_article\Controller;

use Dompdf\Dompdf;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Render\Renderer;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

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
    $html = $this->renderer->renderRoot($renderarray);

    // Get module path.
    $path = DRUPAL_ROOT . '/' . \Drupal::service('extension.list.module')->getPath("legal_article");

    // Set base path for CSS.
    $path .= "/css";
    $dompdf->setBasePath($path);

    // Load html into dompdf.
    $dompdf->loadHtml($html, "utf-8");

    // Render the HTML as PDF.
    $dompdf->render();

    // Name PDF file.
    $alias = $node->path->getValue()[0]['alias'] ?? NULL;
    $parts = $alias ? explode('/', $alias) : NULL;
    $name = $parts ? array_pop($parts) : NULL;
    $pdf_name = "$name-transcription" ?? $node->getTitle();

    // Return PDF file response.
    $response = new Response($dompdf->output());
    $response->headers->set('Content-Type', 'Content-type:application/pdf');
    $response->headers->set('Content-Disposition', "attachment; filename=\"{$pdf_name}.pdf\"");
    return $response;
  }

  /**
   * Redirect citation links.
   */
  public function citationLink($nid) {
    if (is_numeric($nid)) {
      return new RedirectResponse("/node/$nid");
    }
  }

  /**
   * Check if node is a legal article.
   */
  public function checkLegalArticle($nid) {
    $node = $this->entityTypeManager->getStorage('node')->load($nid);

    if ($node) {
      return AccessResult::allowedIf($node->bundle() === 'legal_article');
    }
    else {
      return FALSE;
    }
  }

}
