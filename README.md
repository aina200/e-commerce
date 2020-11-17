# Framewa

## Summary

- [Short presentation](#short-presentation)
- [How to add a route](#how-to-add-a-route)
- [How to generate a link](#how-to-generate-a-link)
- [How to connect to the database](#how-to-connect-to-the-database)
- [How to add a Model](#how-to-add-a-model)
- [How to authenticate](#how-to-authenticate)
- [How to add a service](#how-to-add-a-service)
- [How to add a parameter](#how-to-add-a-parameter)

## Short presentation

Framewa is a very minimalistic framework created for pedagogic purpose.

As it respects the MVC pattern, it separates Models from Views from Controllers.

The framework itself is contained in the `lib` directory (`Framewa` namespace),
while your own application code will belong in the `src` directory
(`App` namespace).

Some advanced OOP and PHP concepts are used here:
- Polymorphism through inheritance and interfaces
- Namespaces
- Autoloading
- Strong types

> **/!\\** As already said, this framework exists for pedagogic purpose.
> It tends to keep things very simple and therefore is not meant for
> production. You would use it in the real world at your own risk.

> **/!\\** While using a third party framework is not strictly forbidden,
> 3WA students should be trying to prove themselves and to accomplish
> their graduation projects from scratch. (:

## How to add a route

Let's suppose we need some "/admin" route. Then we are going to need
two bricks:
- An action in a Controller
- The route's definition
 
First add an action to an existing Controller, or create a new Controller:

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Framewa\Controller\Controller;

class AdminController extends Controller
{
    public function index(): void
    {
        $this->displayView('views/homepage.phtml', [
            'user_id' => 4,
            'some_text' => 'Lalala'
        ]);
    }
}
```

Do whatever you need to do in this action, then call the
`Controller::displayView` method. First argument is the template's
file path. Second argument is the data to be passed to the template and
retrieved in the `$data` variable.

Now we must add the definition for this route into the `config/routes.php` file:

> Note that you could technically put your template files anywhere you want,
> but you really should be keeping all of them in the `views` directory.
> This being said, you can of course create subdirectories in the `views`
> directory.

```php
return [
    '/admin' => [
        'name' => 'admin',
        'action' => [App\Controller\AdminController::class, 'index']
    ],
];
```
To understand this simply, we say to our application
"When someone tries to access to the /admin path, then execute the `index`
method in the `App\Controller\AdminController` class".

## How to generate a link

In any template, you can simply write this:

```html
<a href="<?= $this->generateUri('register') ?>">Sign up</a>
```

In order to add GET parameters, `generateUri` can also take an optional
associative array as second argument:

```html
 <a href="<?= $this->generateUri('topic', ['id' => 634, 'page' => 4]) ?>">Sign up</a>
```

## How to connect to the database

First you must create a `config/database.php` file based upon
`config/database.dist.php`.

```bash
$ cp ./config/database.dist.php ./config/database.php
```

Then change the settings this new file to make them match your database
address and credentials.

> **Why do we need an extra database file and don't simply use the `dist` one?**
>
> Because the `dist` one is a versioned dummy file never used in the application,
> while the real database file you just created will be ignored by Git
> (see the `.gitignore` file). You don't want to push your database password
> to Git, right? (:

Once your database is correctly configured, you can get your PDO object
this way:

```php
public function someMethod(): void
{
    $container = \Framewa\Service\Container::createOnce();
    $pdo = $container->get('framewa.database')->getConnection();
}
```

## How to add a Model

Models belong in the `src/Model` directory, under the `App\Model` namespace.

A Model needs two classes:
- The Model itself (or DTO, for Data Transfert Object)
- Its ModelManager 

The DTO is here to strictly represent its corresponding table in the database.

```php
<?php

declare(strict_types=1);

namespace App\Model;

use Framewa\Model\Model;
use Framewa\Model\ModelInterface;

/**
 * Class User
 * @package App\Model
 */
class User extends Model
{
    /** @var int|null $id */
    private ?int $id;

    /** @var string|null $email */
    private ?string $email;

    /** @var string|null $password */
    private ?string $password;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function createFromArray(array $data): self
    {
        $user = new User();

        $user->setEmail((string) $data['email']);
        $user->setPassword((string) $data['password']);

        return $user;
    }

    /**
     * @return array
     */
    public function getValidationErrors(): array
    {
        $err = [];

        if ($this->email === '' || $this->email === null) {
            $err[] = 'Email address cannot be empty.';
        }

        $emailLen = strlen($this->email);
        if ($emailLen < 3 || $emailLen > 127) {
            $err[] = 'Email address\' length cannot be less than 3 or greater than 127.';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $err[] = 'Invalid email format';
        }

        if ($this->password === '' || $this->password === null) {
            $err[] = 'Password cannot be empty';
        }

        return $err;
    }
}
```

This is a very basic Model for a User representation. Its properties are
private and can only be accessed through accessors (getters, issers, hassers)
and mutators (setters, adders).

A Model **must** extend the `Framewa\Model\Model` class. It **must** define
a `getValidationErrors` method, and it **must** define a static
`createFromArray` method.

Now let's see a simple ModelManager:

```php
<?php

declare(strict_types=1);

namespace App\Model;

use Framewa\Connection\Database;
use Framewa\Model\Manager;

/**
 * Class UserManager
 * @package App\Model
 */
class UserManager extends Manager
{
    public function insert(User $user): void
    {
        $sql = 'INSERT INTO `user` (`email`, `password`) VALUES (:email, :password)';
        $q = $this->connection->prepare($sql);

        $q->bindValue(':email', $user->getEmail(), \PDO::PARAM_STR);
        $q->bindValue(':password', $user->getPassword(), \PDO::PARAM_STR);

        $q->execute();
    }
}
```

Very simple. As we can see, the ModelManager's role is to build the bridge
between the database and the PHP representation of the data. It handles
all SQL queries: `SELECT`, `INSERT`, etc.

> Don't forget to create the corresponding table in the database.
> In our example it would be `user`, with the following columns:
> `id` (PK), `email` (UNIQUE), `password`
>
> Oh and... NEVER forget to hash the passwords with a strong algorithm. (:
> It can be done in the Controller.

## How to authenticate

First you must define the `user_provider` configuration in the
`config/authentication.php` file. It takes a array callable, which must lead
to a method that will retrieve your User from its id, or return null if none
is found.

```php
// config/authentication.php

<?php

return [
    'user_provider' => [\App\Model\UserManager::class, 'find']
];
```

Then you must declare this method:

```php
<?php

declare(strict_types=1);

namespace App\Model;

use Framewa\Model\Manager;

class UserManager extends Manager
{
    public function find(int $id): ?User
    {
        $sql = 'SELECT * FROM `user` WHERE user.id = :id';
        $q = $this->connection->prepare($sql);

        $q->bindValue(':id', $id, \PDO::PARAM_INT);

        $q->execute();

        $userArray = $q->fetch(\PDO::FETCH_ASSOC);
        if (!$userArray || empty($userArray)) {
            return null;
        }

        return User::createFromArray($userArray);
    }
}
```

Now, in your Controller actions, you can use the `login` method from the
`Authenticator` service:

```php
public function login(): void
{
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $manager = new UserManager();
        $user = $manager->findByEmail($_POST['email']);
        if ($user && password_verify($_POST['password'], $user->getPassword())) {
            $this->auth->login($user->getId());
            $this->router->redirectToRoute('homepage');
        }
    }

    $this->displayView('views/login.phtml');
}
```

Note that there is also a `logout` method to stop the session. (:

You can retrieve the current logged user in any template with the
`currentUser` property:

```html
<?php if($this->currentUser !== null): ?>
  <p>You are logged and your name is <?= <?php $this->currentUser->getUsername() ?></p>
<?php else: ?>
  <p>You are not logged in. ):</p>
<?php endif; ?>
```

## How to add a service

Services are classes used to handle current tasks. These objects are
not meant to carry data but to act like stateful toolboxes. You could
imagine a service to parse CSV, a service to format money, etc.

To add a service, you must first create its class:

```php
<?php

namespace App\Util;

class MoneyFormatter
{
    private string $currency;

    public function __construct(string $currency = '€')
    {
        $this->currency = $currency;    
    }

    public function format(float $amount): string
    {
        return $amount . ' ' . $this->currency;
    }
}
```

Then you must define its config in the `config/services.php`:

```php
<?php

return [
    'app.money_formatter' => [
        'class' => App\Util\MoneyFormatter::class,
        'arguments' => [
            'currency' => '$'
        ]
    ]
];
```

Now you can use this service in your controllers:

```php
// ...
public function index(): void
{
    // ...
    $moneyFormatter = $this->container->get('app.money_formatter');
    $price = $moneyFormatter->format(6.55);  // '6.55 $'
    // ...
}
// ...
```

## How to add a parameter

Parameters are arbitrary defined key=>value pairs that can be accessed
in your whole application through the Config service.

Parameters belong in the `config/parameters.php` file. Example:

```php
<?php

return [
    'default_locale' => 'fr_FR'
];
```

To retrieve this one, you can do the following in your controllers:
```php
// ...
public function index(): void
{
    // ...
    $parameters = $this->container->get('framewa.config_reader')->getParameters();
    $defaultLocale = $parameters->get('default_locale');  // 'fr_FR'
    // ...
}
// ...
```
