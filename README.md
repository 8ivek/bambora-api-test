# Bambora Api Test
Test your Bambora custom checkout api

# Bambora terminology
 ## Checkout vs Custom Checkout in Bambora
 * Checkout involves redirecting the user to a payment form on bambora.com. Custom Checkout embeds Bambora hosted input fields in your webpage and we pay through Bambora api.

# make config.php file in root
## content of config.php file
```
<?php
$bambora_merchant_id    =   '***your merchant id***';
$bambora_passcode       =   '***your pass code***';
const BAMBORA_ROOT_URL  =   'https://api.na.bambora.com/';
const BAMBORA_LOG_FILE  =   'bambora_events.log';
```
## Further more: config file location and config file content
![Config File Location](https://raw.githubusercontent.com/8ivek/bambora-api-test/master/images/config_file_location.jpg)
![Config File Content](https://raw.githubusercontent.com/8ivek/bambora-api-test/master/images/config_file_content.jpg)
