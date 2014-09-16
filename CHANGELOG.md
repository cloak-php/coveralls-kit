Change Log
===================================

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
