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


#API
To use notslackbot you'll need to add data. notlsackbot API has only a few simple routes you need to be aware of. And you
only post to one file for configuring, and one other file for getting reactions

##index.php
To do any configuring you'll be making your POST calls to the `index.php` file. It is recommended to use POSTman
to configure this. All POST requests follow this body
content functionality:
```json
{
    "head":{
        "command": <command>
    },
    "data":{
        "request": <request/trigger keyword>,
        "response": <response>
    }
}
```
The `command` tag in the `head` section is the command value for what you want to do in this request. The available commands are:
* add - adds a request and response trigger to the DB
* delete - deletes a request and response trigger from the DB
* listAll - list all of the request and response reactions stored in the DB

###add
To add a request and response set the `command` value to `add` and then pass a `request` with the trigger word and a `response` with
the desired response in the `data` section
###delete
To delete a request and response set the `command` value to `delete` and then in the `data` object set the `request` and `response` values to the
values of the request and response you are wanting to delete. Note you may need to use the listAll command to view all previously set requests and responses
###listAll
listAll is a helper command to view all set requests and responses. Simply set the `command` value to `listAll` and pass an empty `data` object in the
POST and all the set values will be returned

Additionaly you can add multiple reactions to the same request. Simply `add` a response with the same request value
and a random value will be selected when you trigger a reaction

##react.php
`react.php` is the trigger file for getting a random response you set for a specified request. All you have to do here
is setup slack's outbound webhooks to point to this route and have configured a trigger word in slack that is also a `request`
word you set in the database. `react.php` will then call your inbound webhook passing it the response it fetched from the request

#Notes
notslack uses the php://input route which can cause issues depending on your php configuration. To avoid potential
issue make sure outbound buffering is enabled in your php.ini and the `always_populate_raw_post_data` setting in the
php.ini is set to -1