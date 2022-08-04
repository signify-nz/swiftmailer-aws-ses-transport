# Swiftmailer AWS SES Transport

A simple Swiftmailer Transport to send mail over AWS SES.

## Install

Install via [composer](https://getcomposer.org):

```bash
composer require signify-nz/swiftmailer-aws-ses-transport
```

## Usage example

```php
$awsConfig = [
    'region' => 'ap-southeast-2',
    'version' => '2010-12-01',
    'credentials' => [
        'key' => 'YOURKEY',
        'secret' => 'YOURSECRET',
    ],
];
$transport = new AWSSESTransport($awsConfig);
$transport->send($message);
```

You can also force set the 'from' email address, which is useful if your SES account only has a single email address verified. The original 'from' address will be used as the 'reply-to' header if no 'reply-to' was set in the email.

```php
$awsConfig = [...];
$fromEmail = 'no-reply@example.com';
$transport = new AWSSESTransport($awsConfig, $fromEmail);
$transport->send($message);
```