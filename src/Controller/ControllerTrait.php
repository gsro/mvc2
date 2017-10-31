<?php

namespace GSRO\DotKernel\MVC2\Controller;

use Zend_Filter_Alnum;

trait ControllerTrait
{
    protected $registry;
    
    protected $allowedActions;
    
    protected $siteUrl;
    
    protected $controllerUrl;
    
    protected $model = null;
    
    protected $view = null;
    
    protected $pageTitle = 'Overwrite $this->pageTitle';
    
    /**
     * @return null
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }
    
    /**
     * @param null $pageTitle
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }
    
    /**
     * @return mixed
     */
    public function getSiteUrl()
    {
        return $this->siteUrl;
    }
    
    /**
     * @param mixed $siteUrl
     */
    public function setSiteUrl($siteUrl)
    {
        $this->siteUrl = $siteUrl;
    }
    
    /**
     * @return null
     */
    public function getRegistry()
    {
        return $this->registry;
    }
    
    /**
     * @param null $registry
     */
    public function setRegistry($registry)
    {
        $this->registry = $registry;
    }
    
    /**
     * @return mixed
     */
    public function getAllowedActions()
    {
        return $this->allowedActions;
    }
    
    /**
     * @param mixed $allowedActions
     */
    public function setAllowedActions($allowedActions)
    {
        $this->allowedActions = $allowedActions;
    }
    
    public function checkAction($action)
    {
        return in_array($action, $this->allowedActions);
    }
    
    public function message($message = '', $messageType = 'info')
    {
        $this->registry->session->message['txt'] = $message;
        $this->registry->session->message['type'] = $messageType;
        return true;
    }
    
    public function redirect($target, $message = '', $messageType = 'info')
    {
        if ($message) {
            $this->message($message, $messageType);
        }
        header('Location: '. $target);
        exit;
    }
    
    public function bootstrap()
    {
        $this->siteUrl = $this->registry->configuration->website->params->url;
        $this->controllerUrl = $this->siteUrl . '/' . $this->registry->requestModule .
            '/' . $this->registry->requestController;
        
        if (!$this->checkAction($this->registry->requestAction)) {
            $this->redirect($this->registry->configuration->website->params->url);
        }
        return true;
    }
    
    public function __call($name, $arguments)
    {
        # $this->redirect($this->registry->website->params->url, 'invalid action', 'error');
        $this->redirect($this->controllerUrl, 'invalid action', 'error');
    }
    
    /**
     * Code injection protection
     * @param $action
     * @return mixed
     */
    public function filterAction($action)
    {
        return (new Zend_Filter_Alnum)->filter($action);
    }
    
    public function __invoke()
    {
        $this->bootstrap();
        $this->customBootstrap();
        $action = $this->filterAction($this->registry->requestAction);
        $method =  $action . 'Action';
        $this->$method();
        return $this;
    }
}
