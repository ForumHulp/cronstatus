Cron status
===========

Cron status shows a notification on main page of acp panel when a cron job is locked. It shows the time when the cron started and which cron was the problem. 

## Requirements
* phpBB 3.1-dev or higher
* PHP 5.3 or higher

## Installation
You can install this on the latest copy of the develop branch ([phpBB 3.1-dev](https://github.com/phpbb/phpbb3)) by doing the following:

1. Copy the entire contents of this repo to to `FORUM_DIRECTORY/ext/forumhulp/cron_status/`
2. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
3. Click Cron status => `Enable`.

Note: This extension is in development. Installation is only recommended for testing purposes and is not supported on live boards. This extension will be officially released following phpBB 3.1.0. Extension depends on two core changes.

## Uninstallation
Navigate in the ACP to `Customise -> Extension Management -> Extensions` and click Cron status => `Disable`.

To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/cron_status/` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2014 - John Peskens (ForumHulp.com)