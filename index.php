<?php

/**
 * @file plugins/oaiMetadataFormats/dc/index.php
 *
 * Copyright (c) 2015 Heidelberg University
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_oaiMetadataFormats
 * @brief Wrapper for the OAI DC format plugin.
 *
 */

require_once('OAIMetadataFormatPlugin_XMDP.inc.php');
require_once('OAIMetadataFormat_XMDP.inc.php');

return new OAIMetadataFormatPlugin_XMDP();

?>
