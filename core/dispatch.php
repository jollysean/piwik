<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * @package Piwik
 */

use Piwik\ErrorHandler;
use Piwik\ExceptionHandler;
use Piwik\FrontController;
use Piwik\Plugin\ControllerAdmin as PluginControllerAdmin;

PluginControllerAdmin::disableEacceleratorIfEnabled();

if (!defined('PIWIK_ENABLE_ERROR_HANDLER') || PIWIK_ENABLE_ERROR_HANDLER) {
    ErrorHandler::registerErrorHandler();
    ExceptionHandler::setUp();
}

FrontController::setUpSafeMode();

if (!defined('PIWIK_ENABLE_DISPATCH')) {
    define('PIWIK_ENABLE_DISPATCH', true);
}

if (PIWIK_ENABLE_DISPATCH) {
    $controller = FrontController::getInstance();

    try {
        $controller->init();
        $response = $controller->dispatch();

        if (!is_null($response)) {
            echo $response;
        }
    } catch (Exception $ex) {
        ExceptionHandler::dieWithHtmlErrorPage($ex);
    }
}