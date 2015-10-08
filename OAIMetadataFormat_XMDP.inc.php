<?php

/**
 * @defgroup oai_format_xmdp XMetaDissPlus OAI format plugin
 */

/**
 * @file plugins/oaiMetadataFormats/xmdp/OAIMetadataFormat_XMDP.inc.php
 *
 * Copyright (c) 2015 Heidelberg University
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class OAIMetadataFormat_XMDP
 * @ingroup oai_format_xmdp
 * @see OAI
 *
 * @brief OAI metadata format class -- XMetaDissPlus.
 */

import('plugins.metadata.xmdp22.schema.Xmdp22Schema');
import('plugins.metadata.xmdp22.filter.Xmdp22DescriptionXmlFilter');

class OAIMetadataFormat_XMDP extends OAIMetadataFormat {

	/**
	 * @copydoc OAIMetadataFormat::toXML
	 */
	function toXml(&$record, $format = null) {
		$publicationFormat =& $record->getData('publicationFormat');
		$description = $publicationFormat->extractMetadata(new Xmdp22Schema());
		
		$xmlFilter = new Xmdp22DescriptionXmlFilter(PersistableFilter::tempGroup(
				'metadata::plugins.metadata.xmdp22.schema.Xmdp22Schema(*)',
				'xml::schema(plugins/metadata/xmdp22/filter/xmdp22.xsd)'));
		
		//FIXME: Hack to remove the duplicate XML document declarations
		$response = substr($xmlFilter->process($description), 39);
		
		return $response;
	}
}

?>
