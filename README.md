## Laravel package for Tah Moe Hnye` SMS and One-Time Password (OTP) Integration
## Installation
```shel
composer require aungmyokyaw/tmh
```
## Configuration
You will need to publish the configuration file to your application. You can do this using the following command:
```shel
php artisan vendor:publish --tag="tmh-config"
```
After publishing the package's configuration file, you will find the file at `config/tmh.php`. You will need to fill out the necessary data in this file to use the package.
## Usage samples
To use the package in your application, you will need to import the TMH class:
```shel
use TMH;
```
#### SMS
You can then call `SMS` methods on the TMH class to work with TMH data. For example:
```
$response = TMH::sms('This is test SMS.')->send('959xxxxxxxxx'); 
```
#### One-Time Password (OTP)
You can then call `OTP` methods. For example: 
```
$response = TMH::otp()->send('959xxxxxxxxx');
```
This will send an OTP to the phone number 959xxxxxxxxx. Make sure to replace this phone number with the actual phone number you want to send the OTP to. 
The default OTP `type is numberic` and the `length is 6`.

If you want a custom OTP, you can change the following code:
```
$response = TMH::otp('alphabet',8)->send('959xxxxxxxxx');
dd($response);
```
It means that the OTP will consist of random alphabetic characters and will be 8 characters long.

#### OTP Arguments
```
TMH::otp($type, $length)->send('959xxxxxxxxx');
```
The `otp()` method accepts two optional arguments:

- `$type`: the type of OTP to send, such as `numeric`, `alphabet` or `alphanumeric`. If not specified, the default is `numeric`.
- `$length`: the length of the OTP to send, such as 4 or 6. If not specified, `the default is 6`.

#### Custom OTP SMS Message
The default OTP message is `Your OTP is :otp .`
If you want to change custom message,you need to publish `translation` file.
```
php artisan vendor:publish --tag="tmh-translation"
```
After publishing the package's translation file, you can find the file at `resources/lang/vendor/tmh`.
