<?xml version="1.0" encoding="UTF-8"?>
<package packagerversion="1.4.2" version="2.0" xmlns="http://pear.php.net/dtd/package-2.0" xmlns:tasks="http://pear.php.net/dtd/tasks-1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://pear.php.net/dtd/tasks-1.0 http://pear.php.net/dtd/tasks-1.0.xsd http://pear.php.net/dtd/package-2.0 http://pear.php.net/dtd/package-2.0.xsd">
 <name>Chiara_PEAR_Server</name>
 <channel>pear.chiaraquartet.net</channel>
 <summary>A lightweight pearweb-compatible channel server for hosting a PEAR channel</summary>
 <description>Chiara_PEAR_Server provides a modular
approach to implementing the channel protocol.
By default, a lightweight database is used,
accessed by a DB_DataObject backend,
with an administrative frontend using HTML_QuickForm and
REST-based static frontend
Chiara_PEAR_Server replaces PEAR_Server</description>
 <lead>
  <name>Greg Beaver</name>
  <user>cellog</user>
  <email>cellog@php.net</email>
  <active>yes</active>
 </lead>
 <lead>
  <name>Davey Shafik</name>
  <user>davey</user>
  <email>davey@php.net</email>
  <active>yes</active>
 </lead>
 <lead>
  <name>Clay Loveless</name>
  <user>clay</user>
  <email>clay@killersoft.com</email>
  <active>yes</active>
 </lead>
 <date>2005-10-04</date>
 <time>23:31:05</time>
 <version>
  <release>0.18.3</release>
  <api>0.18.0</api>
 </version>
 <stability>
  <release>alpha</release>
  <api>alpha</api>
 </stability>
 <license uri="http://www.php.net/license">PHP License</license>
 <notes>* Fix fatal error in post-install script.</notes>
 <contents>
  <dir baseinstalldir="Chiara/PEAR" name="/">
   <file name="Server.php" role="php" />
  </dir> <!-- / -->
 </contents>
 <dependencies>
  <required>
   <php>
    <min>5.0.0</min>
   </php>
   <pearinstaller>
    <min>1.4.2</min>
   </pearinstaller>
   <package>
    <name>DB_DataObject</name>
    <channel>pear.php.net</channel>
    <min>1.7.12</min>
   </package>
   <package>
    <name>HTML_QuickForm</name>
    <channel>pear.php.net</channel>
    <min>3.2.2</min>
   </package>
  </required>
  <group hint="Public frontend for users to browse channel packages" name="pearweb">
   <package>
    <name>Crtx_PEAR_Channel_Frontend</name>
    <channel>pear.crtx.org</channel>
    <min>0.1.1</min>
   </package>
  </group>
 </dependencies>
 <phprelease />
 <changelog>
  <release>
   <version>
    <release>0.1</release>
    <api>0.1</api>
   </version>
   <stability>
    <release>devel</release>
    <api>devel</api>
   </stability>
   <date>2004-07-30</date>
   <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
   <notes>Initial development release for testing purposes only</notes>
  </release>
  <release>
   <version>
    <release>0.2</release>
    <api>0.2</api>
   </version>
   <stability>
    <release>devel</release>
    <api>devel</api>
   </stability>
   <date>2004-08-02</date>
   <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
   <notes>Add new channel.listAll and channel.update methods</notes>
  </release>
  <release>
   <version>
    <release>0.3.0</release>
    <api>0.3.0</api>
   </version>
   <stability>
    <release>devel</release>
    <api>devel</api>
   </stability>
   <date>2004-08-03</date>
   <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
   <notes>Add xmlrpc dep</notes>
  </release>
  <release>
   <version>
    <release>0.4.0</release>
    <api>0.4.0</api>
   </version>
   <stability>
    <release>devel</release>
    <api>devel</api>
   </stability>
   <date>2004-08-12</date>
   <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
   <notes>Fix package.listAll to make up for pearweb kludge, fix package.getDownloadURL,
fix package.info</notes>
  </release>
  <release>
   <version>
    <release>0.5.0</release>
    <api>0.5.0</api>
   </version>
   <stability>
    <release>devel</release>
    <api>devel</api>
   </stability>
   <date>2004-08-13</date>
   <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
   <notes>Fix issue with xml-rpc that borks XML_RPC package on client-side</notes>
  </release>
  <release>
   <version>
    <release>0.6.0</release>
    <api>0.6.0</api>
   </version>
   <stability>
    <release>devel</release>
    <api>devel</api>
   </stability>
   <date>2004-08-17</date>
   <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
   <notes>update for new version of PEAR</notes>
  </release>
  <release>
   <version>
    <release>0.7.0</release>
    <api>0.7.0</api>
   </version>
   <stability>
    <release>devel</release>
    <api>devel</api>
   </stability>
   <date>2004-10-01</date>
   <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
   <notes>update for new version of PEAR - complete rewrite, must be installed from scratch</notes>
  </release>
  <release>
   <version>
    <release>0.8.0</release>
    <api>0.8.0</api>
   </version>
   <stability>
    <release>devel</release>
    <api>devel</api>
   </stability>
   <date>2005-02-14</date>
   <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
   <notes>rewrite to work with PEAR 1.4.0a1, must be installed from scratch</notes>
  </release>
  <release>
   <version>
    <release>0.9.0</release>
    <api>0.9.0</api>
   </version>
   <stability>
    <release>devel</release>
    <api>devel</api>
   </stability>
   <date>2005-02-14</date>
   <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
   <notes>Add new XMLRPC5 frontend for those without xmlrpc extension</notes>
  </release>
  <release>
   <version>
    <release>0.10.0</release>
    <api>0.10.0</api>
   </version>
   <stability>
    <release>devel</release>
    <api>devel</api>
   </stability>
   <date>2005-02-17</date>
   <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
   <notes>Fix problems in mysqlinstall.php post-install script</notes>
  </release>
  <release>
   <version>
    <release>0.11.0</release>
    <api>0.11.0</api>
   </version>
   <stability>
    <release>devel</release>
    <api>devel</api>
   </stability>
   <date>2005-02-17</date>
   <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
   <notes>Fix package.info</notes>
  </release>
  <release>
   <version>
    <release>0.12.0</release>
    <api>0.12.0</api>
   </version>
   <stability>
    <release>alpha</release>
    <api>alpha</api>
   </stability>
   <date>2005-02-17</date>
   <license uri="http://www.php.net/license/3_0.txt">PHP License</license>
   <notes>Fix package.listLatestReleases</notes>
  </release>
  <release>
   <version>
    <release>0.13.0</release>
    <api>0.13.0</api>
   </version>
   <stability>
    <release>alpha</release>
    <api>alpha</api>
   </stability>
   <date>2005-03-12</date>
   <license uri="http://www.php.net/license">PHP License</license>
   <notes>* Added Category support
- Added Table categories
- Added Server\Backend\DBDataObject\Categories.php
- Added necessary exceptions
- Modified Server\Frontend\HTML_QuickForm.php (added forms for above)

* Added support for external CVS/Bugs/Documentation
- Added Table package_extras
- Added Server\Backend\DBDataObject\Package_extras.php

* Added a real layout
- Added data\pear_server.css

* Now allows input of license_uri
* Now allows input of new maintainer password
* Fixed bug with Parent Packages
* Added URI field for Maintainers</notes>
  </release>
  <release>
   <version>
    <release>0.14.0</release>
    <api>0.13.0</api>
   </version>
   <stability>
    <release>alpha</release>
    <api>alpha</api>
   </stability>
   <date>2005-03-17</date>
   <license uri="http://www.php.net/license">PHP License</license>
   <notes>add check for weird addslashes/stripslashes behavior that seems to vary from system to system
add exception for invalid release upload
API is unchanged in this release</notes>
  </release>
  <release>
   <version>
    <release>0.15.0</release>
    <api>0.13.0</api>
   </version>
   <stability>
    <release>alpha</release>
    <api>alpha</api>
   </stability>
   <date>2005-03-21</date>
   <license uri="http://www.php.net/license">PHP License</license>
   <notes>* fix package.getDownloadURL and package.getDepDownloadURL when a different case is
  passed in (smarty as opposed to Smarty)
* fix duplicate names listing for multiple leads in DBDataObject-&gt;listPackageMaintainers()
API is unchanged in this release</notes>
  </release>
  <release>
   <version>
    <release>0.16.0</release>
    <api>0.16.0</api>
   </version>
   <stability>
    <release>alpha</release>
    <api>alpha</api>
   </stability>
   <date>2005-03-24</date>
   <license uri="http://www.php.net/license">PHP License</license>
   <notes>* implement package.getDownloadURL and package.getDepDownloadURL 1.1</notes>
  </release>
  <release>
   <version>
    <release>0.17.0</release>
    <api>0.17.0</api>
   </version>
   <stability>
    <release>alpha</release>
    <api>alpha</api>
   </stability>
   <date>2005-04-18</date>
   <license uri="http://www.php.net/license">PHP License</license>
   <notes>Implement ssl, port, path options for channel server connection and xmlrpc.php file name
rename to Chiara_PEAR_Server
add ability to deprecate a package in favor of another</notes>
  </release>
  <release>
   <version>
    <release>0.18.0</release>
    <api>0.18.0</api>
   </version>
   <stability>
    <release>alpha</release>
    <api>alpha</api>
   </stability>
   <date>2005-04-18</date>
   <license uri="http://www.php.net/license">PHP License</license>
   <notes>Implement REST support
fix subpackage support
fix package.info
fix PHP5 issue with visibility of Xmlrpc5 server contructor
add the ability to delete a package</notes>
  </release>
  <release>
   <version>
    <release>0.18.1</release>
    <api>0.18.0</api>
   </version>
   <stability>
    <release>alpha</release>
    <api>alpha</api>
   </stability>
   <date>2005-05-31</date>
   <license uri="http://www.php.net/license">PHP License</license>
   <notes>Consolidate post-install scripts
fix invalid release exception error message</notes>
  </release>
  <release>
   <version>
    <release>0.18.2</release>
    <api>0.18.0</api>
   </version>
   <stability>
    <release>alpha</release>
    <api>alpha</api>
   </stability>
   <date>2005-10-04</date>
   <license>PHP License</license>
   <notes>* Fixes bug which prevented non-admin leads from releasing.
* Adds support for groupings of user handles by channel
* Fixes bug relating to DB_DataObject configuration when channel database 
  name is not the default.
* Minor revisions for clarity in install/update messages
* Check to see if specified database exists before attempting to create it
  on first-time installations.</notes>
  </release>
  <release>
   <version>
    <release>0.18.3</release>
    <api>0.18.0</api>
   </version>
   <stability>
    <release>alpha</release>
    <api>alpha</api>
   </stability>
   <date>2005-10-04</date>
   <license>PHP License</license>
   <notes>* Fix fatal error in post-install script.</notes>
  </release>
 </changelog>
</package>