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
