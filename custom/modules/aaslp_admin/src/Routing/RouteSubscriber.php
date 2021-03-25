<?php

namespace Drupal\aaslp_admin\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\user\Entity\User;
use Drupal\Core\Session\AccountProxy;
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
   * Constructs a new RouteSubscriber object.
   *
   * @param Drupal\Core\Session\AccountProxy $currentUserSession
   *   The current user session.
   */
  public function __construct(AccountProxy $currentUserSession) {
    $this->currentUserSession = $currentUserSession;
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
    $account = User::load($this->currentUserSession->id());

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
