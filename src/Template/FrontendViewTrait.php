<?php

namespace GSRO\DotKernel\MVC2\Template;

use Zend_Registry;
use Dot_Auth;

trait FrontendViewTrait
{
    /**
     * Display the menus
     * @access public
     * @return void
     */
    public function setFrontendViewMenu()
    {
        $dotAuth = Dot_Auth::getInstance();
        $registry = Zend_Registry::getInstance();
        
        // this template variable will be replaced with "selected"
        $selectedItem = "SEL_" . strtoupper($registry->requestController . "_" . $registry->requestAction);
        
        // top menu
        $this->setFile('tpl_menu_top', 'blocks/menu_top.tpl');
        $this->setBlock('tpl_menu_top', 'top_menu_not_logged', 'top_menu_not_logged_block');
        $this->setBlock('tpl_menu_top', 'top_menu_logged', 'top_menu_logged_block');
        
        // add selected to the correct menu item
        $this->setVar($selectedItem, 'selected');
        
        if ($dotAuth->hasIdentity('user'))
        {
            $this->parse('top_menu_logged_block', 'top_menu_logged', true);
            $this->parse('top_menu_not_logged_block', '');
        }
        else
        {
            $this->parse('top_menu_not_logged_block', 'top_menu_not_logged', true);
            $this->parse('top_menu_logged_block', '');
        }
        $this->parse('MENU_TOP', 'tpl_menu_top');
        
        // sidebar menu
        $this->setFile('tpl_menu_sidebar', 'blocks/menu_sidebar.tpl');
        $this->setBlock('tpl_menu_sidebar', 'sidebar_menu_logged', 'sidebar_menu_logged_block');
        $this->setBlock('tpl_menu_sidebar', 'sidebar_menu_not_logged', 'sidebar_menu_not_logged_block');
        
        // add selected to the correct menu item
        $this->setVar($selectedItem, 'selected');
        
        if ($dotAuth->hasIdentity('user'))
        {
            $this->parse('sidebar_menu_logged_block', 'sidebar_menu_logged', true);
            $this->parse('sidebar_menu_not_logged_block', '');
        }
        else
        {
            $this->parse('sidebar_menu_not_logged_block', 'sidebar_menu_not_logged', true);
            $this->parse('sidebar_menu_logged_block', '');
        }
        
        $this->parse('MENU_SIDEBAR', 'tpl_menu_sidebar');
        
        // footer menu
        $this->setFile('tpl_menu_footer', 'blocks/menu_footer.tpl');
        
        // add selected to the correct menu item
        $this->setVar($selectedItem, 'selected');
        
        $this->parse('MENU_FOOTER', 'tpl_menu_footer');
    }
    
    /**
     * Add the user's token to the template
     * @access public
     * @return array
     */
    public function addFrontendUserToken()
    {
        $dotAuth = Dot_Auth::getInstance();
        $user = $dotAuth->getIdentity('user');
        $this->setVar('USERTOKEN', Dot_Auth::generateUserToken($user->password));
    }
    /**
     * Get captcha display box using Zend_Service_ReCaptcha api
     * @access public
     * @return Zend_Service_ReCaptcha
     */
    public function getRecaptcha()
    {
        $option = Zend_Registry::get('option');
        // add secure image using ReCaptcha
        $recaptcha = new Zend_Service_ReCaptcha($option->captchaOptions->recaptchaPublicKey, $option->captchaOptions->recaptchaPrivateKey);
        $recaptcha->setOptions($option->captchaOptions->toArray());
        return $recaptcha;
    }
}
