<?php

/**
 * @file plugins/oaiMetadataFormats/xmdp/OAIMetadataFormatPlugin_XMDP.inc.php
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2003-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class OAIMetadataFormatPlugin_XMDP
 * @ingroup oai_format
 * @see OAI
 *
 * @brief XMetaDissPlus metadata format plugin for OAI.
 */

import('plugins.oaiMetadataFormats.xmdp.oai.XMDPOAI');
import('lib.pkp.classes.plugins.OAIMetadataFormatPlugin');

class OAIMetadataFormatPlugin_XMDP extends OAIMetadataFormatPlugin {
	
	/**
	 * Constructor
	 */
	function OAIMetadataFormatPlugin_XMDP() {
		parent::OAIMetadataFormatPlugin();

		$oai = new XMDPOAI();
		HookRegistry::register('PressOAI::sets', array(&$oai, 'sets'));
		HookRegistry::register('PressOAI::records', array(&$oai, 'records'));
		HookRegistry::register('PressOAI::identifiers', array(&$oai, 'identifiers'));
		HookRegistry::register('OAIDAO::_returnRecordFromRow', array(&$oai, '_addPublicationFormatSets'));
		HookRegistry::register('OAIDAO::_returnIdentifierFromRow', array(&$oai, '_addPublicationFormatSets'));
	}
	
	/**
	 * Get the name of this plugin. The name must be unique within
	 * its category.
	 * @return String name of plugin
	 */
	function getName() {
		return 'OAIMetadataFormatPlugin_XMDP';
	}

	function getDisplayName() {
		return __('plugins.oaiMetadata.xmdp.displayName');
	}

	function getDescription() {
		return __('plugins.oaiMetadata.xmdp.description');
	}

	function getFormatClass() {
		return 'OAIMetadataFormat_XMDP';
	}

	static function getMetadataPrefix() {
		return 'XMetaDissPlus';
	}
	
	static function getSchema() {
		return 'http://files.dnb.de/standards/xmetadissplus/xmetadissplus.xsd';
	}

	static function getNamespace() {
		return 'http://www.d-nb.de/standards/xmetadissplus/';
	}
}

?>
