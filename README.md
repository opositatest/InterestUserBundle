# INSTALLATION

## Connect with User

### Trait for your User Entity

```php
# src/AppBundle/Entity/User
    ...
    // Add trait
    use \Opositatest\InterestUserBundle\Model\UserTrait {
        __construct as _traitconstructor;
    }
    ...
    // Add construct
    public function __construct()
    {
        $this->_traitconstructor();
        parent::__construct();
    }
```

### Configuration config.yml

```yaml
# app/config/config.yml
orm:
   resolve_target_entities:
      Opositatest\InterestUserBundle\Model\UserInterface: AppBundle\Entity\User
```