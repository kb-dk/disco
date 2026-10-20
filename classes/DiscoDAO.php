<?php

/**
 * @file classes/DiscoDAO.inc.php
 *
 * Copyright (c) 2014-2020 Simon Fraser University
 * Copyright (c) 2003-2020 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @package plugins.generic.disco
 * @class DiscoDAO
 * Operations for retrieving and modifying Disco objects.
 */


namespace APP\plugins\generic\disco\classes;

use PKP\db\DAOResultFactory;
use APP\plugins\generic\disco\classes\Disco;


class DiscoDAO extends \PKP\db\DAO {

           
    /**
	 * Get a disco by ID
	 * @param $discoId int Disco ID
	 * @param $contextId int (optional) Context ID
	 */
	function getById($discoId, $contextId = null) {
		$params = [(int) $discoId];
		if ($contextId) $params[] = (int) $contextId;

		$result = $this->retrieve(
			'SELECT * FROM disco_plugin WHERE disco_id = ?'
			. ($contextId?' AND context_id = ?':''),
			$params
		);

		$row = $result->current();
		return $row ? $this->_fromRow((array) $row) : null;
	}
        
	/**
	 * Get a set of disco criteria by context ID
	 * @param $contextId int
	 * @param $rangeInfo Object optional
	 * @return DAOResultFactory
	 */
	function getByContextId($contextId) {
                $params = [(int) $contextId];
		$result = $this->retrieve(
			'SELECT * FROM disco_plugin WHERE context_id = ?',
                        $params
		);

		return new DAOResultFactory($result, $this, '_fromRow');
	}

        /**
	 * Insert a disco object.
	 * @param $disco disco
	 * @return int Inserted disco ID
	 */
	function insertObject($disco) {
		$this->update(
			'INSERT INTO disco_plugin (context_id) VALUES (?)',
			array(
				(int) $disco->getContextId()
			)
		);

		$disco->setId($this->getInsertId());
		$this->updateLocaleFields($disco);
		return $disco->getId();
	}

        /**
	 * Update the database with a disco object
	 * @param $disco Disco
	 */
	function updateObject($disco) {
		$this->update(
			'UPDATE	disco_plugin
			SET	context_id = ?
			WHERE disco_id = ?',
			array(
				(int) $disco->getContextId(),
				(int) $disco->getId()
			)
		);
		$this->updateLocaleFields($disco);
	}
	
        /**
	 * Delete a disco by ID.
	 * @param $discoId int
	 */
	function deleteById($discoId) {
		$this->update(
			'DELETE FROM disco_plugin WHERE disco_id = ?',
			[(int) $discoId]
		);

		$this->update(
			'DELETE FROM disco_plugin_settings WHERE disco_id = ?',
			[(int) $discoId]		
                );
	}
        
        /**
	 * Delete a disco object.
	 * @param $disco Disco
	 */
	function deleteObject($disco) {
		$this->deleteById($disco->getId());
	}

        /**
	 * Generate a new disco object.
	 * @return Disco
	 */
	function newDataObject() {
		return new Disco();
	}
        
        /**
	 * Return a new disco object from a given row.
	 * @return disco
	 */
	function _fromRow($row) {
		$disco = $this->newDataObject();
		$disco->setId($row['disco_id']);
		$disco->setContextId($row['context_id']);

		$this->getDataObjectSettings('disco_plugin_settings', 'disco_id', $row['disco_id'], $disco);

		return $disco;
	}
        

	/**
	 * Get the additional field names.
	 * @return array
	 */
	function getAdditionalFieldNames(): array {
		return array('scholarlyJournal', 'noCharges', 'openAuthorship', 'ownershipScience', 'openLicence', 'fullContentAvailable', 'functionalWebsite', 'journalUrl', 'qualityEnHomepage', 'aimsAndScopeDescribed', 'authorGuidelinesDescribed', 'bibliographicInformation', 'editorialBoardPage', 'contactDetailsAvailable', 'peerReviewDescribed', 'publicationEthicsDescribed', 'scholarlyArticles', 'fullBio', 'linkToFulltext', 'lpDoi', 'references', 'uniqueUrlArticles', 'authorsAffiliations', 'titlesAbstractsInEnglish', 'markingReferences', 'noAPC', 'apcDescribed', 'oaPolicyDescribed', 'copyrightTerms', 'periodicity', 'publishingHistory', 'timeliness', 'eIssn', 'journalTitle', 'machineReadableMetadataFormat', 'oaiPMHEnabled', 'usingDOIs', 'metadataFormatOpenAIRE', 'noRegistrationNeed', 'noEmbargoPeriod', 'journalPublisherNameAvailable', 'badgesAvailable','organisationType');
	}

	/**
	 * Update the settings for this object
	 * @param $disco object
	 */
	function updateLocaleFields($disco) {
		$this->updateDataObjectSettings('disco_plugin_settings', $disco, array('disco_id' => (int) $disco->getId()));
	}
}

