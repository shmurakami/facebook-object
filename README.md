# TakaakiMizuno/FacebookObject

Fancy Wrapper Of Facebook PHP SDK.

## How To Use

```php
$repository = new \TakaakiMizuno\FacebookObject\Repositories\UserRepository($session);
$me = $repository->me();
print $me->name;
```        

## License

This library is available under the MIT license. See the LICENSE file for more info.
