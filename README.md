# XMetaDissPlus OAI Plugin

> The XMetaDissPlus OAI plugin for OMP has been developed at UB Heidelberg. It enables the OAI transfer of metadata that is consistent with the [XMetaDissPlus][xmetadissplus] format defined by the [Deutsche Nationalbibliothek][dnb] (DNB).

## Requirements

* The XMetaDissPlus **OAI** Plugin relies on the [XMetaDissPlus **Metadata** plugin][xmdp22] for OMP to format the metadata. See its [README][xmdp22-readme] for information on how to install and configure this plugin.

* To generate a valid record, XMetaDissPlus requires the existence of a public identifier. You can either enable the OMP DOI plugin (`Management > Settings > Website > Plugins > Public Identifier Plugins > DOI`) that is included in OMP or install and enable the [URN DNB plugin][urn_dnb] for OMP.

## Installation

	git clone https://github.com/kadowa/omp-xmdp-oai-plugin omp/plugins/oaiMetadataFormats/xmdp
	php omp/tools/upgrade.php upgrade

## Bugs / Issues

You can report issues here: <https://github.com/kadowa/omp-xmdp-oai-plugin/issues>

## License

This software is released under the the [GNU General Public License][gpl-licence].

See the [COPYING][gpl-licence] included with OMP for the terms of this license.

[pkp]: http://pkp.sfu.ca/
[xmdp22]: https://github.com/kadowa/omp-xmdp-metadata-plugin
[xmdp22-readme]: https://github.com/kadowa/omp-xmdp-metadata-plugin/blob/master/README.md
[xmetadissplus]: http://www.dnb.de/DE/Standardisierung/Metadaten/xMetadissPlus.html
[urn_dnb]: https://github.com/kadowa/omp-dnb-urn-plugin
[dnb]: http://www.dnb.de
[gpl-licence]: https://github.com/pkp/omp/blob/master/docs/COPYING

