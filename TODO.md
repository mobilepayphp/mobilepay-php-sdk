# TODO

- add filter query parameters to list requests
- add idempotencyKey as Uuid: https://mobilepaydev.github.io/MobilePay-Payments-API/docs/app-payments/build-basics#idempotency
- add header for correlationId: https://mobilepaydev.github.io/MobilePay-Payments-API/docs/app-payments/build-basics#correlation-ids
- make sure only valid characters are used in string type fields
- add integration tests for Gateways and Client
- add retry functionality for 500 responses: https://mobilepaydev.github.io/MobilePay-Payments-API/docs/app-payments/build-basics#retry-policy
- collect all response payload validation errors and show them together
- check for PHP 8.1 features
- set up github actions tests for php 8.1, 8.2, etc.
- make sure that every request and response field are following documentation standard
- using Github secrets in workflow for

- handle exceptions in Gateways
- https://mobilepaydev.github.io/MobilePay-Payments-API/api/app-payments#tag/Refunds/operation/get-refunds-list
- https://mobilepaydev.github.io/MobilePay-Payments-API/api/app-payments#tag/Refunds/operation/get-refunds-list now supports filters (createdBefore, createdAfter)
- https://mobilepaydev.github.io/MobilePay-Payments-API/api/app-payments#tag/Payments/operation/get-payments-list supports more filters

## Documentation

- app payments: https://mobilepaydev.github.io/MobilePay-Payments-API/api/app-payments
- webhooks https://mobilepaydev.github.io/MobilePay-Payments-API/api/wehooks
- reporting https://mobilepaydev.github.io/MobilePay-Payments-API/api/reporting

## Setup documentation page

- https://www.mkdocs.org/

- add MobilePay logo: 
  - https://www.mobilepaygroup.com/design/logo/mobilepay-logo-png
  - https://www.php.net/download-logos.php

## Subtree split

- mobilepay-app-payments-php-sdk
- mobilepay-webhooks-php-sdk
- mobilepay-reporting-php-sdk

## Downgrade repositories

- https://tomasvotruba.com/blog/how-to-develop-sole-package-in-php81-and-downgrade-to-php72/

## PHPStan

- https://tomasvotruba.com/blog/2018/05/21/is-your-code-readable-by-humans-cognitive-complexity-tells-you/

## github project structure

-- mobilepay-php
---- mobilepay-php-sdk-src
---- mobilepay-php-sdk
---- mobilepay-bundle
---- mobilepay-recipe
---- omnipay-mobilepay
