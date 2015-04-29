Change Log
===================================

2.1.0
-----------------------------------
* Changed the format of the coveralls report

2.0.0
-----------------------------------
* PHP5.4 not support
* Rename CompositeEntityInterface.php -> CompositeEntity.php
* Rename EntityInterface.php -> Entity.php
* Rename CompositeEntityCollectionInterface.php -> CompositeEntityCollection
* Raname CoverageInterface -> CoverageEntity
* Raname Coverage -> CoverageResult
* Raname RepositoryInterface -> RepositoryEntity
* Raname Repository -> GitRepository
* Raname ServiceInterface -> ServiceEntity
* Raname Service -> CIService
* Raname ReportInterface -> ReportEntity
* Raname Report -> CoverallsReport
* Raname AdaptorInterface -> EnviromentAdaptor
* Raname RecordInterface -> FileRecord
* Raname ReportParserInterface -> ReportParser
* Raname ReportBuilder -> CoverallsReportBuilder
* Raname ReportBuilderInterface -> ReportBuilder
* Rename ReportTransfer -> CoverallsReportTransfer
* Rename ReportTransferInterface -> ReportTransfer
* Rename ReportTransferAwareInterface -> ReportTransferAware
* Rename Configuration -> BuilderConfiguration
* Rename ConfigurationInterface -> Configuration
* Rename RootConfigurationInterface -> RootConfiguration
* Rename ConfigurationLoaderInterface -> ConfigurationLoader
* Rename Registry -> ObjectRegistry
* Changed the dom parser from Zend\Dom to Symfony\DomCrawler
* Changed the interface of the report parser


1.4.0.3
-----------------------------------
* Upgrade peridot (1.9 > 1.8)

1.4.0.2
-----------------------------------
* Remove resource watcher

1.4.0.1
-----------------------------------
* Support codeship

1.4.0
-----------------------------------
* The format of the configuration file changed to **toml**
* Automatically detects the ci of execution environment
* Fixed a small bug

1.3.1
-----------------------------------
* Upgrade to guzzlehttp/guzzle

1.3.0
-----------------------------------
* add **ReportTransferAwareTrait**, **ReportTransferAwareInterface**
* changed to **setReportTransfer** / **getReportTransfer** and **setUploader** / **getUploader** method of **Report** class
* **ReportUploaderInterface** to **ReportTransferInterface**
* **ReportUploader** to **ReportTransfer**
* support **clover.xml** report file

1.2.1
-----------------------------------
* support a configuration file(.yml or .yaml)
* use **COVERALLS_REPO_TOKEN** by default

1.2.0
-----------------------------------
* Changed the name of the class, the interface.
	* *JSONFile* -> **Report**
	* *JSONFileBuilder* -> **ReportBuilder**
	* *JSONFileUpLoader* -> **ReportUpLoader**
	* *JSONFileUpLoaderInterface* -> **ReportUpLoaderInterface**
* When there is no specification of the report file,  use the default file name.
	* The default file name - **coverage.json**
