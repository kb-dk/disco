<?php

/**
 * @file controllers/DiscoHandler.php
 *
 * Copyright (c) 2014-2020 Simon Fraser University
 * Copyright (c) 2003-2020 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class DiscoHandler
 * @ingroup controllers_disco
 *
 *
 */

namespace APP\plugins\generic\disco\controllers;


use APP\core\Application;
use PKP\security\authorization\ContextAccessPolicy;
use PKP\security\Role;
use APP\plugins\generic\disco\controllers\form\DiscoForm;
use APP\plugins\generic\disco\DiscoPlugin;

class DiscoHandler extends \APP\handler\Handler 
{

    protected $plugin;
    /**
     * Constructor
     */
    public function __construct(DiscoPlugin $plugin) {
        parent::__construct();
        $this->addRoleAssignment(
                array(Role::ROLE_ID_MANAGER, Role::ROLE_ID_SITE_ADMIN),
                array('updateDisco')
        );
        $this->plugin = $plugin;
    }

    //
    // Overridden template methods
    //

    /**
     * @copydoc PKPHandler::authorize()
     */
    public function authorize($request, &$args, $roleAssignments) {
        $this->addPolicy(new ContextAccessPolicy($request, $roleAssignments));
        return parent::authorize($request, $args, $roleAssignments);
    }

    /**
     * Update a disco
     * @param $args array
     * @param $request PKPRequest
     * @return string Serialized JSON object
     */
    public function updateDisco($args, $request) {
        
        $discoId = $request->getUserVar('discoId');
        $category = $request->getUserVar('category');
        $context = $request->getContext();
        $this->setupTemplate($request);
        // Create and populate the form
        
        $discoForm = new DiscoForm($this->plugin, $context->getId(), $discoId, $category);
        $discoForm->readInputData();

        // Check the results
        if ($discoForm->validate()) {
            // Save the results
            $discoForm->execute();
            
            $redirectUrl = $request->getDispatcher()->url($request, Application::ROUTE_PAGE, null, 'management', 'settings', array('website'), null, 'disco');
            return $request->redirectUrl($redirectUrl);

        } else {
            // Present any errors
            $redirectUrl = $request->getDispatcher()->url($request, Application::ROUTE_PAGE, null, 'management', 'settings', array('website'), null, 'disco');
            return $request->redirectUrl($redirectUrl);;
        }
    }
}

if (!PKP_STRICT_MODE) {
    class_alias('\APP\plugins\generic\disco\controllers\DiscoHandler', '\DiscoHandler');
}
