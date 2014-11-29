ajax-shoutbox-ext
=================
[![Build Status](https://travis-ci.org/paul999/ajax-shoutbox-ext.svg)](https://travis-ci.org/paul999/ajax-shoutbox-ext)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/paul999/ajax-shoutbox-ext/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/paul999/ajax-shoutbox-ext/?branch=master)

# Support
Support is only provide at [http://www.ajax-shoutbox.com](http://www.ajax-shoutbox.com). Support requested at other places will be ignored or redirected.

# Installation

## From release
Download the release file, and extract it to phpBB/ext/

After that enable it in ACP -> Customise -> Extensions and enable the ajax shoutbox extension.

## From git:
Clone the repository into your ext/ directory for phpBB:
git clone https://github.com/paul999/profile-guestbook-ext.git phpBB3/ext/paul999/ajaxshoutbox

After that enable it in ACP -> Customise -> Extensions and enable the ajax shoutbox extension.

If you want to use the Push functionality, please make sure to run composer.phar install prior to using it.

# Translations
Only complete translations of the extension will be accepted. 
Please submit your translation as pull request in github. Make sure to use a proper commit message and PR name.

PRs with incomplete translations or without proper commit message will be closed.

# License

[GPLv2](license.txt)

# Known issues
 - The time is not updated when the shoutbox refreshes, causing issues when using relative time.

