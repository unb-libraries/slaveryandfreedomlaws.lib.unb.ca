<?php

namespace Drupal\aaslp_admin\Routing;

use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events and restrict access to user.pass route.
 */
class RouteSubscriber extends RouteSubscriberBase {
  /**
   * Current user session.
   *
   * @var Drupal\Core\Session\AccountProxy
   */
  protected $currentUserSession;

  /**
   * User entity.
   *
   * @var Drupal\Core\Entity\EntityTypeManager
   */
  protected $currentUserEntity;

  /**
   * Constructs a new RouteSubscriber object.
   *
   * @param Drupal\Core\Session\AccountProxy $currentUserSession
   *   The current user session.
   * @param Drupal\Core\Entity\EntityTypeManager $currentUserEntity
   *   The current user entity.
   */
  public function __construct(AccountProxy $currentUserSession, EntityTypeManager $currentUserEntity) {
    $this->currentUserSession = $currentUserSession;
    $this->currentUserEntity = $currentUserEntity->getStorage('user');
  }

  /**
   * {@inheritdoc}
   */
  public function alterRoutes(RouteCollection $collection) {
    // Restrict user admin routes.
    $deny_routes = [
      'user.pass',
      'user.register',
      'user.reset',
      'entity.user.edit_form',
    ];

    // Get current user account object.
    // $account = User::load(\Drupal::currentUser()->id());
    $account = $this->currentUserEntity->load($this->currentUserSession->id());

    // Only restrict for non-admin users.
    if (!$account->hasRole('administrator')) {

      // Deny access to non-admins.
      foreach ($deny_routes as $deny_route) {
        if ($route = $collection->get($deny_route)) {
          $route->setRequirement('_access', 'FALSE');
        }
      }
    }
  }

}
