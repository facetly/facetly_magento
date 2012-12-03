Facetly Magento
===============

Install Magento Extension
-------------

How to install Facetly Module in Magento

1. Before Installing Facetly Module, make sure you already have these requirements:

       a. Any FTP program, such as WinSCP, FileZilla, etc.

       b. Magento 1.5.0 or higher (we are not guarantee facetly plugin would be work properly in previous version)
       
       c. Enable curl in php, please follow our guide here (https://www.facetly.com/doc/howto/curl)

2. Download Facetly Module from our site (https://github.com/facetly/facetly_magento) and rename folder into facetly then upload it to your module folder using FTP program.

3. Extract Facetly Module in your Magento root.

4. After Facetly Module successfully installed in your Magento, you will find Facetly Configuration in admin menu.

Configure Facetly Module
-------------

Now we are going to configure Facetly Module. There are several steps that you are need to do:

1. Input your Consumer Key, Consumer Secret, Server Name, Search Limit, and Additional Variable in Facetly Configuration.

2. Configure your facetly fields. Go to Field Tab and we will see field mapping here. Please follow instruction in (https://www.facetly.com/doc/field) to set field mapping

3. Configure your template. Go to Template tab to set up template for your search page. You will see search template and facet template settings which will be displayed in your search page. You can find more details about template settings in (https://www.facetly.com/doc/template)

4. Reindex data in Reindex tab. This configuration is used to save all data in your store to our server, which will be used as your search data. Input size push data to edit how many data will be send to facetly server per process.

5. Click Reindex button to start the process. Please note: you should wait until process is complete and not move to other page, otherwise your data reindex will not completed and you must start from the beginning.

6. Facetly search ready


