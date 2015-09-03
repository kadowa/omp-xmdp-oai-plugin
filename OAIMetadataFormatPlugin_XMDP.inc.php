<?php

/**
 * @file plugins/oaiMetadataFormats/dc/OAIMetadataFormatPlugin_DC.inc.php
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2003-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class OAIMetadataFormatPlugin_DC
 * @ingroup oai_format
 * @see OAI
 *
 * @brief dc metadata format plugin for OAI.
 */

import('lib.pkp.classes.plugins.OAIMetadataFormatPlugin');

class OAIMetadataFormatPlugin_XMDP extends OAIMetadataFormatPlugin {
	/**
	 * Constructor
	 */
	function OAIMetadataFormatPlugin_XMDP() {
		parent::OAIMetadataFormatPlugin();
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
		return 'oai_xmdp';
	}
	
	static function getSchema() {
		return 'http://www.openarchives.org/OAI/2.0/oai_dc.xsd';
	}
	
	static function getNamespace() {
		return 'http://www.openarchives.org/OAI/2.0/oai_dc/';
	}
}

?>
