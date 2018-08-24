# INSTALLATION

## Basic Installation...

### Composer install

composer require opositatest/interest-user-bundle

### Add bundle to AppKernel:

```php
# app/AppKernel.php
new Opositatest\InterestUserBundle\OpositatestInterestUserBundle(),
```

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

### Add fields in UserAdmin Class

You need add followInterests and unfollowInterests to UserAdmin Class, so:
```php
# src/AppBundle/Admin/UserAdmin
    protected function configureFormFields(FormMapper $formMapper)
    {
        ...
            ->add('followInterests', 'sonata_type_model', array('multiple' => true, 'by_reference' => false))
            ->add('unfollowInterests', 'sonata_type_model', array('multiple' => true, 'by_reference' => false))
        ...
    }
```

Add validate function, so:
```php
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var SyliusUser $user */
        $user = $object;
        foreach($user->getFollowInterests() as $followInterest) {
            if ($user->exitUnfollowInterest($followInterest)) {
                $custom_error = "Interest ".$followInterest." used in follow and unfollow";
                $errorElement->with( 'enabled' )->addViolation( $custom_error )->end();
            }
        }
    }
```

### Configuration config.yml

```yaml
# app/config/config.yml
orm:
   resolve_target_entities:
      Opositatest\InterestUserBundle\Model\UserInterface: AppBundle\Entity\User
```

## Add routes

Add routes to your project. It should be compatible with nelmio api doc

```yaml
# app/config/routing.yml
opositatest_interestuser_api:
    resource: "@OpositatestInterestUserBundle/Resources/config/routing.yml"
    prefix:   /api/ # Prefix is customizable
```

## API

Enable annotations for group feature

```yaml
# app/config/config.yml
framework:
    # ...
    serializer:
        enable_annotations: true

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

# USAGE

We have three functions, "/api/" is customizable prefix url:

## Add interest

It add interest to logged user

```
POST
/api/interest/{interestId}
```
## Remove interest

It remove interest to logged user 

```
DELETE
/api/interest/{interestId}
```

## View interests

It return interests global and for logged user

```
GET
/api//interests
```

# Test

You can try unit test with:
```
./vendor/bin/phpunit vendor/opositatest/interest-user-bundle/Opositatest/InterestUserBundle
```

# Información adicional

El bundle gestiona los intereses de un usuario, permite añadir y eliminar followInterest y unfollowInterest.

Tiene dos lógicas importantes implementadas:
1. Cuando añades un nuevo interés en followInterest o unfollowInterest el sistema añade los intereses hijo automáticamente. 
Este proceso se hace a través de la Entidad Interest en el caso de que se use SonataAdmin y en el servicio InterestService en el caso de que
se use la API. Esta diferenciación es así porque a través de la API necesitamos comprobar el punto 2, mientras que a través de Sonata el punto 2
ya se comprueba con una función especial en el propio Sonata.

2. No puede haber un mismo interés en followInterest y unfollowInterest, por tanto, en Sonata se comprueba a través de una función de validación, y en 
la API se hace cada vez que se incorpora un nuevo interés.