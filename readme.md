# Služba číselníků pro Nette Framework

Nastavení v **config.neon**
```neon
extensions:
    references: NAttreid\ReferenceService\DI\ReferenceServiceExtension
```

dostupné nastavení
```neon
references:
    classes:
        - App\Services\ReferenceService
```

## Příklad
```php
class ReferenceService extends Service {

    /**
     * @return array[key => class]
     */
    public static function getEntities()
    {
        return [
            1 => Test::class,
            2 => Test2::class,
            3 => Test3::class,
            4 => Test4::class,
        ];
    }
}
```

```php
class Test extends Entity {

}
```