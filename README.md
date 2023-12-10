## To Install

### For Magento Version >= 2.4.4

```
composer require moses/magento-log
php bin/magento module:enable Hikmadh_DocUploader
php bin/magento setup:upgrade
```

### For Magento Version < 2.4.4

```
composer require moses/magento-log 1.1.0
php bin/magento module:enable Hikmadh_DocUploader
php bin/magento setup:upgrade

### Configuration

Frontend website  -> checkout -> DocUploader -> PlaceOrder