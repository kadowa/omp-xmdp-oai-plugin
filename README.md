# XMetaDissPlus OAI Plugin

> The XMetaDissPlus OAI plugin for OMP has been developed by UB Heidelberg. It enables the OAI transfer of metadata that is consistent with the [XMetaDissPlus][xmetadissplus] format defined by the [Deutsche Nationalbibliothek (DNB)][dnb].

## Requirements

The XMetaDissPlus OAI Plugin relies on the [XMetaDissPlus Metadata plugin][xmdp22] for OMP to format the metadata.

	git clone https://github.com/kadowa/omp-xmdp-metadata-plugin.git omp/plugins/metadata/xmdp22

XMetaDissPlus required a public identifier. You can either enable the OMP OAI plugin (in Management -> Settings -> Website -> Plugins -> Public Identifier Plugins -> DOI) or install and enable the [URN DNB plugin][urn_dnb]:

	git clone https://github.com/kadowa/omp-xmdp-oai-plugin.git omp/plugins/oaiMetadataFormats/xmdp

## Installation

	git clone https://github.com/kadowa/omp-dnb-urn-plugin.git omp/plugins/pubIds/urn_dnb
	php omp/tools/upgrade.php upgrade

## Bugs / Issues

See https://github.com/kadowa/omp-xmdp-oai-plugin#issues for information on reporting issues.

## License

This software is released under the the [GNU General Public License][gpl-licence].

See the [COPYING][gpl-licence] included with OMP for the terms of this license.

[pkp]: http://pkp.sfu.ca/
[xmdp22]: https://github.com/kadowa/omp-xmdp-metadata-plugin
[xmetadissplus]: http://www.dnb.de/DE/Standardisierung/Metadaten/xMetadissPlus.html
[dnb]: http://www.dnb.de
[gpl-licence]: https://github.com/pkp/omp/blob/master/docs/COPYING

