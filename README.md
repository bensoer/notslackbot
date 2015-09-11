# notslackbot
notslackbot is a fun slapped together php api that mimicks the simple functionality of slackbot through the slack
integrations interface. notslackbot stores responses to specific 'request' words. This can be hooked up to work in slack
by using outbound and inbound webhooks in slack. This allows you to narrow down where notslackbot will listen for
trigger words and where it will respond with reactions

# Quick Setup
To setup you will need to create a `config.inc` file containing constant definitions for `SERVER`, `USERNAME`, `PASSWORD`,
`DB`, `SLACKINBOUNDHOOK`

It should look something like this

```php

<?php

if(!defined('SERVER')){
    define('SERVER', '###.###.###.###');
}
if(!defined('USERNAME')){
    define('USERNAME', 'myusername');
}
if(!defined('PASSWORD')){
    define('PASSWORD', 'supersecret');
}
if(!defined('DB')){
    define('DB', 'notslackdb');
}
if(!defined('SLACKINBOUNDHOOK')){
    define('SLACKINBOUNDHOOK', 'https://hooks.slack.com/services/ccccc/bbbbbb/aaaaaaaaaaaaaaaaaaaaa');
}

```

Then all you need to do is run the script to setup the database!




#Notes
notslack uses the php://input route which can cause issues depending on your php configuration. To avoid potential
issue make sure outbound buffering is enabled in your php.ini and the `always_populate_raw_post_data` setting in the
php.ini is set to -1