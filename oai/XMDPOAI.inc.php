<?php

/**
 * @defgroup oai_format_xmdp XMetaDissPlus OAI format plugin
 */

/**
 * @file plugins/oaiMetadataFormats/xmdp/OAIMetadataFormat_XMDP.inc.php
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2003-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class OAIMetadataFormat_XMDP
 * @ingroup oai_format_xmdp
 * @see OAI
 *
 * @brief OAI metadata format class -- XMetaDissPlus.
 */

import('classes.oai.omp.PressOAI');

class XMDPOAI extends PressOAI {
	
	function XMDPOAI() {
		
	}
	
	/**
	 * Add publication format sets
	 */
	function sets($hookName, $params) {
		$pressOAI =& $params[0];
		$offset = $params[1];
		$limit = $params[2];
		$total = $params[3];
		$sets =& $params[4];
	
		$pressDAO =& DAORegistry::getDAO('PressDAO');
		$oaidao = DAORegistry::getDAO('OAIDAO');
		$publicationFormatDAO =& DAORegistry::getDAO('PublicationFormatDAO');
	
		$pressId = $pressOAI->pressId;
		if (isset($pressId)) {
			$presses = array($pressDAO->getById($pressId));
		} else {
			$presses =& $pressDAO->getAll();
			$presses =& $presses->toArray();
		}
	
		$sets = array();
		foreach ($presses as $press) {
			$pressId = $press->getId();
			
			// Default press and series sets
			$sets = array_merge($sets, $oaidao->getSets($pressId, $offset, $limit, $total));
			
			// Additional publication format sets
			$pubFormats =& $publicationFormatDAO->getByPressId($pressId);
			$pubFormatNames = array();
			foreach ($pubFormats->toArray() as $pubFormat) {
				if ( $pubFormat->getIsAvailable() ) {
					$name = strtolower($pubFormat->getLocalizedName());
					$pubFormatNames[$name] = "Publication Format " . strtoupper($name);
				}
			}
		
			foreach ( $pubFormatNames as $abbrev => $name ) {
				array_push($sets, new OAISet($press->getLocalizedAcronym() . ':pubf_' . urlencode($abbrev), $name, ''));
			}
		}
	
 		if ($offset != 0) {
			$sets = array_slice($sets, $offset);
		}
	
		return true;
	}
	
	/**
	 *  Add publication format sets to record, handle requests for records
	 */
	function records($hookName, $params) {
 		$pressOAI =& $params[0];
		$from = $params[1];
		$until = $params[2];
		$set = $params[3];
		$offset = $params[4];
		$limit = $params[5];
		$total = $params[6];
		$records =& $params[7];
		
		$oaidao = DAORegistry::getDAO('OAIDAO');
		$pressDAO =& DAORegistry::getDAO('PressDAO');
		
		$pressId = $pressOAI->pressId;
		$press = $pressDAO->getById($pressId);
		
		$records = array();
		// Handle publication format sets
		if ( isset($set) && strpos($set, ':pubf_') != False ) {
			// Identify publication format and press
			// TODO: Handle errors, if there is no press with the given acronym
			// TODO: Simply derive press from pressID? Do we need to add the press to the publication format? Check what happens, if we have more than one press ...
			$set_elements = explode(':pubf_', $set);
			if ( sizeof($set_elements) == 2 ) {
				list($pressAcronym, $pubFormatString) = $set_elements;
			}
			$pressRows = $pressDAO->getBySetting("acronym", $pressAcronym);
			if ( $pressRows->getCount() == 1 ) {
				$press = $pressRows->next();
			} else {
				// No way to handle multiple presses with the same acronym (pretty sure OMP does not allow this to happen)
				assert(false);
			}
			
			// Keep only records with the requested publication format
			// FIXME: This might be slow for a large number of records -- handle on database level?
			$allPressRecords = $oaidao->getRecords(array($pressOAI->pressId, null), $from, $until, $set, $offset, $limit, $total);
			foreach ( $allPressRecords as $record ) {
				$pubFormat =& $record->getData('publicationFormat');
				if ( !is_null($pubFormat) && strtolower($pubFormat->getLocalizedName())== $pubFormatString ) {
					array_push($records, $record);
				}
			}
		}
		// If no publication format set is specified, copy behaviour of PressOAI::records
		elseif ( isset($set) ) {
			$records = $oaidao->getRecords($pressOAI->setSpecToSeriesId($set), $from, $until, $set, $offset, $limit, $total);
		} else {
			$records = $oaidao->getRecords(array($pressOAI->pressId, null), $from, $until, $set, $offset, $limit, $total);
		}
		
		// Add publication format sets to record data
		foreach ($records as $record) {
			$pubFormat =& $record->getData('publicationFormat');
			if ( !is_null($pubFormat) && $pubFormat->getIsAvailable() ) {
				$record->sets[] = $press->getLocalizedAcronym() . ':pubf_' . strtolower($pubFormat->getLocalizedName());
			}
		}
		
		return True;
	}

	function identifiers($hookName, $params) {
 		$pressOAI =& $params[0];
		$from = $params[1];
		$until = $params[2];
		$set = $params[3];
		$offset = $params[4];
		$limit = $params[5];
		$total = $params[6];
		$records =& $params[7];
		
		$oaidao = DAORegistry::getDAO('OAIDAO');
		$pressDAO =& DAORegistry::getDAO('PressDAO');
		$publicationFormatDAO =& DAORegistry::getDAO('PublicationFormatDAO');
		
		$pressId = $pressOAI->pressId;
		$press = $pressDAO->getById($pressId);
		
		$records = array();
		error_log("Hi there");
		// Handle publication format sets
		if ( isset($set) && strpos($set, ':pubf_') != False ) {
			// Identify publication format and press
			// TODO: Handle errors, if there is no press with the given acronym
			// TODO: Simply derive press from pressID? Do we need to add the press to the publication format? Check what happens, if we have more than one press ...
			$set_elements = explode(':pubf_', $set);
			if ( sizeof($set_elements) == 2 ) {
				list($pressAcronym, $pubFormatString) = $set_elements;
			}
			$pressRows = $pressDAO->getBySetting("acronym", $pressAcronym);
			if ( $pressRows->getCount() == 1 ) {
				$press = $pressRows->next();
			} else {
				// No way to handle multiple presses with the same acronym (pretty sure OMP does not allow this to happen)
				assert(false);
			}
				
			// Keep only records with the requested publication format
			// FIXME: This might be slow for a large number of records -- handle on database level?
			$allPressRecords = $oaidao->getIdentifiers(array($pressOAI->pressId, null), $from, $until, $set, $offset, $limit, $total);
			foreach ( $allPressRecords as $record ) {
				$pubFormatId = explode("publicationFormat/", $record->identifier)[1];
				$pubFormat = $publicationFormatDAO->getById($pubFormatId);
				error_log($pubFormatId);
				if ( !is_null($pubFormat) && strtolower($pubFormat->getLocalizedName())== $pubFormatString ) {
					array_push($records, $record);
				}
			}
		}
		// If no publication format set is specified, copy behaviour of PressOAI::records
		elseif ( isset($set) ) {
			$records = $oaidao->getIdentifiers($pressOAI->setSpecToSeriesId($set), $from, $until, $set, $offset, $limit, $total);
		} else {
			$records = $oaidao->getIdentifiers(array($pressOAI->pressId, null), $from, $until, $set, $offset, $limit, $total);
		}
		
		// Add publication format sets to record data
		foreach ($records as $record) {
			$pubFormatId = explode("publicationFormat/", $record->identifier)[1];
			$pubFormat = $publicationFormatDAO->getById($pubFormatId);
			if ( !is_null($pubFormat) && $pubFormat->getIsAvailable() ) {
				$record->sets[] = $press->getLocalizedAcronym() . ':pubf_' . strtolower($pubFormat->getLocalizedName());
			}
		}
		
		return True;
	}
}

?>
