=== Plugin Name ===
Contributors: lagally
Donate link: http://www.ghtech.org/tools/plugins.html
Tags: charities, charity, donate, donate goals, donate meter, donations, fundraise, fundraising, fundraising goal, goal, nonprofit
Requires at least: 2.7.0
Tested up to: 3.3
Stable tag: 1.0

Plugin used to generate XML editor within Administration menus, useful for fundraising or other purposes.  

== Description ==

This plugin loads an XML file specifying different "bricks" used to comprise a fundraising image map in Flash or other means, and allows editing and re-saving of the file.

Features:

* Loads XML file and displays it as a form within the Administrator panel for editing
* Saves edited XML file 

For support and further information about the XML Editor plugin see the plugins homepage at [http://www.ghtech.org/tools/plugins.html](http://www.gthech.org/tools/plugins.html).


== Installation ==

1.  Install and activate the XML Editor plugin as normal.  

2.  Upload an XML file with the correct format and content to the site.

3.  Select the "XML Editor Options" under the Plugins admin menu and fill out the form with the correct path to your XML file.  


== Frequently Asked Questions ==

= What is the format of the XML file? =

`<?xml version="1.0" encoding="utf-8"?> 

 <bricks> 

<item id="item-id-1" product_name="message-that-appears-in-popup-1" link_brick="url-that-popup-links-to" bricks="url-that-points-to-brick-image" raised="total-raised-so-far-first-item-only" />

</bricks>`


An example XML file:


`<?xml version="1.0" encoding="utf-8"?> 

<bricks> 
<item id="mc1" product_name="Purchase your Brick now $5000" link_brick="http://localhost/test/purchase/bricks6" bricks="http://localhost/wp/wp-content/uploads/2011/08/2.png" raised="$3,700.00"/>
<item id="mc2" product_name="Purchase your Brick now $5000" link_brick="http://localhost/test/purchase/bricks6" bricks="http://localhost/wp/wp-content/uploads/2011/08/2.png"/>
<item id="mc3" product_name="Purchase your Brick now $5000" link_brick="http://localhost/test/purchase/bricks" bricks="http://localhost/wp/wp-content/uploads/2011/08/2.png"/>
<item id="mc4" product_name="Purchase your Brick now $5000" link_brick="http://localhost/test/purchase/bricks" bricks="http://localhost/wp/wp-content/uploads/2011/08/2.png"/>

</bricks>`

== Screenshots ==

1. Plugin settings page

2. XML Editor screen

== Changelog ==

= 1.0 =
* First stable version

== Upgrade Notice ==

= 1.0 =
* First stable version

== Other Notes ==

**Plugin Official Site**
If you have questions about installation or use of this plugin, please visit the [official plugin site](http://www.ghtech.org/tools/plugins.html).


