<?php

/**
 * Filter for redirecting to SSL for the pages that need it
 *
 * @author Sachin Makwana <sachin@avidindiainc.com>
 * @version 2
 */
class sslFilter extends sfFilter
{
  /**
   * Execute filter
   *
   * @param FilterChain $filterChain The symfony filter chain
   */
  public function execute ($filterChain)
  {
    // Only execute this filter once
//    if ($this->isFirstCall() && SF_ENVIRONMENT != 'dev') {
//      // Array of modules/actions that require move to SSL
//      $ssl_actions = sfConfig::get('app_ssl_secure_actions');
//
//
//      if (empty($_SERVER['HTTPS']) && count($_POST) < 1) {
//
//        // We're not using SSL and not POSTing data - check if we should be using SSL
//        foreach ($ssl_actions as $action) {
//          if ($this->getContext()->getModuleName() == $action['module'] && $this->getContext()->getActionName() == $action['action']) {
//            $new_url = sprintf('https://%s%s', sfConfig::get('app_ssl_secure_host'), $_SERVER['REQUEST_URI']);
//            header('Location: ' . $new_url);
//            exit;
//          }
//        }
//
//        // Using secure host when not required - not good
//        if ($_SERVER['HTTP_HOST'] == sfConfig::get('app_ssl_secure_host')) {
//          $new_url = sprintf('http://%s%s', sfConfig::get('app_ssl_insecure_host'), $_SERVER['REQUEST_URI']);
//          header('Location: ' . $new_url);
//          exit;
//        }
//      } elseif (!empty($_SERVER['HTTPS']) && count($_POST) < 1) {
//
//        // We're using SSL and not posting data
//        $dont_redirect = false;
//        foreach ($ssl_actions as $action) {
//          if ($this->getContext()->getModuleName() == $action['module'] && $this->getContext()->getActionName() == $action['action']) {
//            $dont_redirect = true;
//          }
//        }
//        if ($dont_redirect == false) {
          // Redirect
          $new_url = sprintf('http://%s%s', sfConfig::get('app_ssl_insecure_host'), $_SERVER['REQUEST_URI']);
          header('Location: ' . $new_url);
//          exit;
//        }
//      }
//    }
    // Next filter
    $filterChain->execute();
  }
}
