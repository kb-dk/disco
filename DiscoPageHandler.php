<?php

/**
 * @file /disco/DiscoPageHandler.inc.php
 *
 * Copyright (c) 2014-2020 Simon Fraser University
 * Copyright (c) 2003-2020 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class DiscoPageHandler
 * @ingroup pages_disco
 *
 * @brief 
 */
 
namespace APP\plugins\generic\disco; 

use APP\template\TemplateManager;

class DiscoPageHandler extends \APP\handler\Handler {

    /** @var DiscoPlugin The disco plugin */
    protected $plugin;

    public function __construct(DiscoPlugin $plugin)
    {
        parent::__construct();
        $this->plugin = $plugin;
    }

    /**
     * Generate an XML sitemap for webcrawlers
     * Creates a sitemap index if in site context, else creates a sitemap
     * @param $args array
     * @param $request Request
     */
    function index($args, $request) {
        $path = array_shift($args);
                                                            
        // Assign the template vars needed and display
        $templateMgr = TemplateManager::getManager($request);
        $this->setupTemplate($request);
        $templateMgr->assign('title', __("plugin.generic.disco.page.title"));
        $this->plugin->assignBadges();
        $templateMgr->display($this->plugin->getTemplateResource('discoDescription.tpl'));
    }

}
