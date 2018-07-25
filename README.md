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

## Connect with SonataAdmin (optional)

Add OpositatestInterestUserBundle group:
```
# app/config/config.yml
sonata_admin:
    ...
    dashboard:
        ...
        groups:
            OpositatestInterestUserBundle:
                label: "Intereses de Usuario"
        blocks:
            - { position: right, type: sonata.admin.block.admin_list, settings: { groups: [OpositatestInterestUserBundle] } }
```            