<?php

/**
 * @defgroup oai_format_dc Dublin Core OAI format plugin
 */

/**
 * @file plugins/oaiMetadataFormats/dc/OAIMetadataFormat_DC.inc.php
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

import('plugins.metadata.xmdp22.schema.Xmdp22Schema');
import('plugins.metadata.xmdp22.filter.Xmdp22DescriptionXmlFilter');

class OAIMetadataFormat_XMDP extends OAIMetadataFormat {

	/**
	 * @copydoc OAIMetadataFormat::toXML
	 */
	function toXml(&$record, $format = null) {
		$publicationFormat =& $record->getData('publicationFormat');
		$description = $publicationFormat->extractMetadata(new Xmdp22Schema());
		
//		error_log(var_export($description, true));
		
/* 		$response = "<xMetaDiss:xMetaDiss\n" . 
			"\txmlns:xMetaDiss=\"http://www.d-nb.de/standards/xmetadissplus/\"\n" .
			"\txmlns:cc=\"http://www.d-nb.de/standards/cc/\"\n" .
			"\txmlns:dc=\"http://purl.org/dc/elements/1.1/\"\n" .
			"\txmlns:dcmitype=\"http://purl.org/dc/dcmitype\"\n" .
			"\txmlns:dcterms=\"http://purl.org/dc/terms/\"\n" .
			"\txmlns:ddb=\"http://www.d-nb.de/standards/ddb/\"\n" .
			"\txmlns:dini=\"http://www.d-nb.de/standards/xmetadissplus/type/\"\n" .
			"\txmlns:doi=\"http://www.d-nb.de/standards/doi/\"\n" .
			"\txmlns:hdl=\"http://www.d-nb.de/standards/hdl/\"\n" .
			"\txmlns:pc=\"http://www.d-nb.de/standards/pc/\"\n" .
			"\txmlns=\"http://www.d-nb.de/standards/subject/\"\n" .
			"\txmlns:thesis=\"http://www.ndltd.org/standards/metadata/etdms/1.0/\"\n" .
			"\txmlns:urn=\"http://www.d-nb.de/standards/urn/\"\n" .
			"\txsi:schemaLocation=\"http://www.d-nb.de/standards/xmetadissplus/ http://www.d-nb.de/standards/xmetadissplus/xmetadissplus.xsd\"\n" .
			"\txmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">\n";
		
		foreach($description->getProperties() as $propertyName => $property) {
			if ($description->hasStatement($propertyName)) {
				if ($property->getTranslated()) {
					$values = $description->getStatementTranslations($propertyName);
				} else {
					$values = $description->getStatement($propertyName);
				}
				$response .= $this->formatElement($propertyName, $values, $property->getTranslated());
			}
		}

		$response .= "</xMetaDiss:xMetaDiss>"; */
		
		
		//FIXME: Hack to remove the duplicate XML document declarations
		$xmlFilter = new Xmdp22DescriptionXmlFilter(PersistableFilter::tempGroup(
				'metadata::plugins.metadata.xmdp22.schema.Xmdp22Schema(*)',
				'xml::schema(plugins/metadata/xmdp22/filter/xmdp22.xsd)'));
		
		$response = substr($xmlFilter->process($description), 39);
		
		return $response;
	}

	/**
	 * Format XML for single DC element.
	 * @param $propertyName string
	 * @param $value array
	 * @param $multilingual boolean optional
	 */
	function formatElement($propertyName, $values, $multilingual = false) {
		if (!is_array($values)) $values = array($values);

		// Translate the property name to XML syntax.
		$openingElement = str_replace(array('[@', ']'), array(' ',''), $propertyName);
		$closingElement = String::regexp_replace('/\[@.*/', '', $propertyName);

		//error_log("o: " . var_export($propertyName, true) . var_export($values, true));

		// Create the actual XML entry.
		$response = '';
		foreach ($values as $key => $value) {
			if ($multilingual) {
				$key = str_replace('_', '-', $key);
				assert(is_array($value));
				foreach ($value as $subValue) {
					if ($key == METADATA_DESCRIPTION_UNKNOWN_LOCALE) {
						$response .= "\t<$openingElement>" . OAIUtils::prepOutput($subValue) . "</$closingElement>\n";
					} else {
						$response .= "\t<$openingElement xml:lang=\"$key\">" . OAIUtils::prepOutput($subValue) . "</$closingElement>\n";
					}
				}
			} else {
				assert(is_scalar($value));
				$response .= "\t<$openingElement>" . OAIUtils::prepOutput($value) . "</$closingElement>\n";
			}
		}
		return $response;
	}
}

?>
