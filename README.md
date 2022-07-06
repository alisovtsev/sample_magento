This test is to evaluate their Magento 2 technical approach to a common functionality involving backend and frontend development.

The goal of this test is to create a Magento module that will show a small bar at the top of the page. 

    The content of this bar must be associated with a customer group when the current visitor is logged in or not.
    The module must have an admin option to enable or disable the new feature, it must work with FPC enabled (e.g. Varnish). 
    It must work in a Luma installation without extra theme customization out of the module, which means that all the files must be inside a folder app/code/LeSite/CustomBar.


After it is completed, please put in a Repository on GitHub so we can perform testing on:

- Enable and disable functionality
- Change customer groups and check the result in the frontend
- Enabling Varnish and log in as another customer
- Magento Code Standards analysis
- Review the technical approach taken to complete this task.




--------------------------------------------


# LeSite_CustomBar

**Custom Bar Notification** is a Magento 2 extension to display a Custom notification at the top of Magento store pages.

## Installation

### 1) with Composer

Run the following command in Magento 2 root folder

```
clone repository at the root of the project
next step add to project composer.json
"repositories": {
...
    "custombar": {
       "type": "path",
       "url": "custom_bar"
            }
}
composer require lesite/custombar
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

### 2) or manually to app/code
```
Create manually LeSite/CustomBar directories at app/code directory
clone repository at the CustomBar directory
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## User Guide

### Configuration

Go to Stores > Settings > Configuration > LeSite > Custom Top Bar Notification.

# About developer

The extension is developed by Andrey Lisovtsev (https://wdevs.com/)
