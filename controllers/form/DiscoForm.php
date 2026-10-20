<?php

/**
 * @file controllers/grid/form/StaticPageForm.inc.php
 *
 * Copyright (c) 2014-2020 Simon Fraser University
 * Copyright (c) 2003-2020 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class StaticPageForm
 * @ingroup controllers_grid_staticPages
 *
 * Form for press managers to create and modify sidebar blocks
 *
 */

namespace APP\plugins\generic\disco\controllers\form;

use APP\plugins\generic\disco\DiscoPlugin;
use APP\template\TemplateManager;
use PKP\db\DAORegistry;

class DiscoForm extends \PKP\form\Form {

    /** @var int Context (press / journal) ID */
    var $_contextId;

    /** @var int disco setting ID */
    var $_discoId;

    /** @var DiscoPlugin Disco plugin */
    var $_plugin;

    /** @var string Requirement category being saved */
    var $_category;

    /**
     * Constructor
     * @param $discoPlugin DiscoPlugin The disco plugin
     * @param $contextId int Context ID
     * @param $discoPluginId int disco Setting ID (if any)
     */
    function __construct($discoPlugin, $contextId, $discoPluginId = null, $category = null) {
        parent::__construct($discoPlugin->getTemplateResource('discoTab.tpl'));

        $this->_contextId = $contextId;
        $this->_discoId = $discoPluginId;
        $this->_plugin = $discoPlugin;
        $this->_category = $category;
        // Add form checks
        $this->addCheck(new \PKP\form\validation\FormValidatorCSRF($this));
    }

    /**
     * Initialize form data from current group.
     */
    function initData() {
        $templateMgr = TemplateManager::getManager();
        $this->setData('contextId', $this->_contextId);
        
        if ($this->_discoId) {        
            $discoDao = DAORegistry::getDAO('DiscoDAO');
            $disco = $discoDao->getById($this->_discoId, $this->_contextId);
            $this->setData('discoId', $this->_discoId);
            $this->setData('scholarlyJournal', (bool) $disco->getScholarlyJournal());
            $this->setData('openLicence', (bool) $disco->getOpenLicence());
            $this->setData('noCharges', (bool) $disco->getNoCharges());
            $this->setData('openAuthorship', (bool) $disco->getOpenAuthorship());
            $this->setData('ownershipScience', (bool) $disco->getOwnershipScience());
            $this->setData('fullContentAvailable', (bool) $disco->getFullContentAvailable());
            $this->setData('functionalWebsite', (bool) $disco->getFunctionalWebsite());
            $this->setData('journalUrl', (bool) $disco->getJournalUrl());
            $this->setData('qualityEnHomepage', (bool) $disco->getQualityEnHomepage());
            $this->setData('aimsAndScopeDescribed', (bool) $disco->getAimsAndScopeDescribed());
            $this->setData('authorGuidelinesDescribed', (bool) $disco->getAuthorGuidelinesDescribed());
            $this->setData('bibliographicInformation', (bool) $disco->getBibliographicInformation());
            $this->setData('editorialBoardPage', (bool) $disco->getEditorialBoardPage());
            $this->setData('contactDetailsAvailable', (bool) $disco->getContactDetailsAvailable());
            $this->setData('journalPublisherNameAvailable', $disco->getJournalPublisherNameAvailable());
            $this->setData('peerReviewDescribed', (bool) $disco->getPeerReviewDescribed());
            $this->setData('publicationEthicsDescribed', (bool) $disco->getPublicationEthicsDescribed());
            $this->setData('scholarlyArticles', (bool) $disco->getScholarlyArticles());
            $this->setData('fullBio', (bool) $disco->getFullBio());
            $this->setData('linkToFulltext', (bool) $disco->getLinkToFulltext());
            $this->setData('lpDoi', (bool) $disco->getLpDoi());
            $this->setData('references', (bool) $disco->getReferences());
            $this->setData('uniqueUrlArticles', (bool) $disco->getUniqueUrlArticles());
            $this->setData('authorsAffiliations', (bool) $disco->getAuthorsAffiliations());
            $this->setData('titlesAbstractsInEnglish', (bool) $disco->getTitlesAbstractsInEnglish());
            $this->setData('markingReferences', (bool) $disco->getMarkingReferences());
            $this->setData('noAPC', (bool) $disco->getNoAPC());
            $this->setData('apcDescribed', (bool) $disco->getApcDescribed());
            $this->setData('oaPolicyDescribed', (bool) $disco->getOaPolicyDescribed());
            $this->setData('copyrightTerms', (bool) $disco->getCopyrightTerms());
            $this->setData('periodicity', (bool) $disco->getPeriodicity());
            $this->setData('publishingHistory', (bool) $disco->getPublishingHistory());
            $this->setData('timeliness', (bool) $disco->getTimeliness());
            $this->setData('eIssn', $disco->getEIssn());
            $this->setData('journalTitle', $disco->getJournalTitle());
            $this->setData('machineReadableMetadataFormat', $disco->getMachineReadableMetadataFormat());
            $this->setData('oaiPMHEnabled', $disco->getOaiPMHEnabled());
            $this->setData('usingDOIs', $disco->getUsingDOIs());
            $this->setData('metadataFormatOpenAIRE', $disco->getMetadataFormatOpenAIRE());
            $this->setData('noRegistrationNeed', $disco->getNoRegistrationNeed());
            $this->setData('noEmbargoPeriod', $disco->getNoEmbargoPeriod());
            $this->setData('badgesAvailable', $disco->getBadgesAvailable());
            $this->setData('organisationType', $disco->getOrganisationType());
        }
    }

    /**
     * Assign form data to user-submitted data.
     */
    function readInputData() {
        $this->readUserVars(array('scholarlyJournal', 'noCharges', 'openAuthorship', 'ownershipScience', 'openLicence', 'fullContentAvailable', 'functionalWebsite', 'journalUrl', 'qualityEnHomepage', 'aimsAndScopeDescribed', 'authorGuidelinesDescribed', 'bibliographicInformation', 'editorialBoardPage', 'contactDetailsAvailable', 'peerReviewDescribed', 'publicationEthicsDescribed', 'scholarlyArticles', 'fullBio', 'linkToFulltext', 'lpDoi', 'references', 'uniqueUrlArticles', 'authorsAffiliations', 'titlesAbstractsInEnglish', 'markingReferences', 'noAPC', 'apcDescribed', 'oaPolicyDescribed', 'copyrightTerms', 'periodicity', 'publishingHistory', 'timeliness', 'eIssn', 'journalTitle', 'machineReadableMetadataFormat', 'oaiPMHEnabled', 'usingDOIs', 'metadataFormatOpenAIRE', 'noRegistrationNeed', 'noEmbargoPeriod', 'journalPublisherNameAvailable', 'badgesAvailable','organisationType'));
    }

    /**
     * @copydoc Form::fetch
     */
    function fetch($request, $template = null, $display = false) {
        $templateMgr = TemplateManager::getManager();
        $templateMgr->assign(array(
            'discoId' => $this->_discoId,
            'contextId' => $this->_contextId,
        ));
        return parent::fetch($request);
    }

    /**
     * Save form values into the database
     */
    function execute(...$functionParams) {
        parent::execute(...$functionParams);
        
        $discoDao = DAORegistry::getDAO('DiscoDAO');
        
        if ($this->_discoId) {
            // Load and update an existing disco
            $disco = $discoDao->getById($this->_discoId, $this->_contextId);
        } else {
            // Create a new discos object
            $disco = $discoDao->newDataObject();
            $disco->setContextId($this->_contextId);
        }       
        switch($this->_category){
            case "diamond":
                $disco->setEIssn((bool) $this->getData('eIssn'));
                $disco->setScholarlyJournal((bool) $this->getData('scholarlyJournal'));
                $disco->setOpenLicence((bool) $this->getData('openLicence'));
                $disco->setNoCharges((bool) $this->getData('noCharges'));
                $disco->setOpenAuthorship((bool) $this->getData('openAuthorship'));
                $disco->setOwnershipScience((bool) $this->getData('ownershipScience'));  
                $disco->setOrganisationType($this->getData('organisationType'));  
                break;
            case "appearance":
                $disco->setFullContentAvailable((bool) $this->getData('fullContentAvailable'));
                $disco->setFunctionalWebsite((bool) $this->getData('functionalWebsite'));
                $disco->setJournalUrl((bool) $this->getData('journalUrl'));                
                $disco->setJournalTitle((bool) $this->getData('journalTitle'));
                $disco->setQualityEnHomepage((bool) $this->getData('qualityEnHomepage'));
                break;
            case "journalDescription":
                $disco->setAimsAndScopeDescribed((bool) $this->getData('aimsAndScopeDescribed'));
                $disco->setAuthorGuidelinesDescribed((bool) $this->getData('authorGuidelinesDescribed'));
                $disco->setBibliographicInformation((bool) $this->getData('bibliographicInformation'));
                $disco->setEditorialBoardPage((bool) $this->getData('editorialBoardPage'));
                $disco->setContactDetailsAvailable((bool) $this->getData('contactDetailsAvailable'));
                $disco->setJournalPublisherNameAvailable((bool) $this->getData('journalPublisherNameAvailable'));
                $disco->setPeerReviewDescribed((bool) $this->getData('peerReviewDescribed'));
                $disco->setPublicationEthicsDescribed((bool) $this->getData('publicationEthicsDescribed'));
                $disco->setScholarlyArticles((bool) $this->getData('scholarlyArticles'));
                break;
            case "lpGalleys":
                $disco->setFullBio((bool) $this->getData('fullBio'));
                $disco->setLinkToFulltext((bool) $this->getData('linkToFulltext'));
                $disco->setLpDoi((bool) $this->getData('lpDoi'));
                $disco->setReferences((bool) $this->getData('references'));
                $disco->setUniqueUrlArticles((bool) $this->getData('uniqueUrlArticles'));
                break;
            case "metadataRequirements":
                $disco->setAuthorsAffiliations((bool) $this->getData('authorsAffiliations'));
                $disco->setTitlesAbstractsInEnglish((bool) $this->getData('titlesAbstractsInEnglish'));
                $disco->setMarkingReferences((bool) $this->getData('markingReferences'));
                $disco->setMachineReadableMetadataFormat((bool) $this->getData('machineReadableMetadataFormat'));
                $disco->setOaiPMHEnabled((bool) $this->getData('oaiPMHEnabled'));
                $disco->setUsingDOIs((bool) $this->getData('usingDOIs'));
                $disco->setMetadataFormatOpenAIRE((bool) $this->getData('metadataFormatOpenAIRE'));
                break;
            case "journalPolicy":
                $disco->setNoAPC((bool) $this->getData('noAPC'));
                $disco->setApcDescribed((bool) $this->getData('apcDescribed'));
                $disco->setOaPolicyDescribed((bool) $this->getData('oaPolicyDescribed'));
                $disco->setCopyrightTerms((bool) $this->getData('copyrightTerms'));
                $disco->setNoRegistrationNeed((bool) $this->getData('noRegistrationNeed'));
                $disco->setNoEmbargoPeriod((bool) $this->getData('noEmbargoPeriod'));
                break;
            case "regularity":
                $disco->setPeriodicity((bool) $this->getData('periodicity'));
                $disco->setPublishingHistory((bool) $this->getData('publishingHistory'));
                $disco->setTimeliness((bool) $this->getData('timeliness'));
                break;   
             case "badges":
                $disco->setBadgesAvailable((bool) $this->getData('badgesAvailable'));
                break; 
            default:
                break;
        }
        
        if ($this->_discoId) {
            $discoDao->updateObject($disco);
        } else {
            $discoDao->insertObject($disco);
        }
    }
}
