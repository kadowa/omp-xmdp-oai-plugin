<?php

/**
 * @file plugins/oaiMetadataFormats/xmdp/index.php
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2003-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_oaiMetadataFormats
 * @brief Wrapper for the OAI XMetaDissPlus format plugin.
 *
 */

require_once('OAIMetadataFormatPlugin_XMDP.inc.php');
require_once('OAIMetadataFormat_XMDP.inc.php');

return new OAIMetadataFormatPlugin_XMDP();

?>
