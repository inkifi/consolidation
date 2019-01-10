A customer consolidation module for [inkifi.com](https://inkifi.com).  
- [upwork.com/ab/f/contracts/21344553](https://www.upwork.com/ab/f/contracts/21344553)
- [upwork.com/messages/rooms/room_f518ada88c89e3d7de30e4fd8922bbdf/story_579929cf1ed21577d3dbe99db0a476e0](https://www.upwork.com/messages/rooms/room_f518ada88c89e3d7de30e4fd8922bbdf/story_579929cf1ed21577d3dbe99db0a476e0)

## How to install
```
bin/magento maintenance:enable
composer require inkifi/consolidation:*
bin/magento setup:upgrade
rm -rf var/di var/generation generated/code && bin/magento setup:di:compile
rm -rf pub/static/* && bin/magento setup:static-content:deploy -f en_US en_GB --area adminhtml --theme Magento/backend && bin/magento setup:static-content:deploy -f en_US en_GB --area frontend --theme Infortis/ultimo
bin/magento maintenance:disable
```

## How to upgrade
```
bin/magento maintenance:enable
composer update inkifi/consolidation
bin/magento setup:upgrade
rm -rf var/di var/generation generated/code && bin/magento setup:di:compile
rm -rf pub/static/* && bin/magento setup:static-content:deploy -f en_US en_GB --area adminhtml --theme Magento/backend && bin/magento setup:static-content:deploy -f en_US en_GB --area frontend --theme Infortis/ultimo
bin/magento maintenance:disable
```

If you have problems with these commands, please check the [detailed instruction](https://mage2.pro/t/263).