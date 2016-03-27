bigflannel Archive

bigflannel Archive is a quick and easy way to display your SlideShowPro Director galleries in archive format on your own website. It displays galleries, albums and the images and video in them. The code is HTML5/PHP/JS.

bigflannel Archive Demo
DELETED


Getting Started

1. Open 'conf.php' and add your SlideShowPro Director 'API Key' and 'API Path'. These can be found in 'System Settings' (self-hosted SSP Director) or in 'Account Info' (hosted SSP Director).

2. Upload all the files to a folder on your web host and visit that folder in a web browser.


Options

1. You can choose to omit galleries from your archive. Open 'conf.php' and set 'hasUnwantedGalleries' as true, and make a comma separated list of galleries you would like to omit by ID.

'hasUnwantedGalleries' => true,
'siteUnwantedGalleries' => '1,2,4',

2. You can choose to only include specific galleries in your archive. Open 'conf.php' and set 'hasWantedGalleries' as true, and make a comma separated list of galleries you would like to include by ID.

'hasWantedGalleries' => true,
'siteWantedGalleries' => '1,2,4',

3. You can order your galleries by ID or by Title. Open 'conf.php' and set 'galleryOrder' as either 'byID' or 'byTitle'.

'galleryOrder' => 'byID',
'galleryOrder' => 'byTitle',

4. You can add logo text or a graphic (replacing the home button) using 'logoType' as follows:

'logoType' => none,
'logoType' => text,
'logoType' => graphic,

then set the logo text using 'logoText':

'logoText' => 'bigflannel Archive',

or set the logo file's address using 'logoFile':

'logoFile' => 'bigflannel-archive/bigflannel-archive-logo.png',

5. You can add an additional link using 'hasLink':

'hasLink' => true,

and the text and address of the link using 'siteLinkText' and 'siteLinkAddress':

'siteLinkText' => 'bigflannel Portfolio',
'siteLinkAddress' => 'http://example.com'


License

(c) 2013 bigflannel
This code is licensed under MIT license (see license.txt for details)


Changelog

1.0
Initial release.
April 2013

