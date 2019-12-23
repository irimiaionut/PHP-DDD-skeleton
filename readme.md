# Domain Driven Design Skeleton

A generic structure for DDD implementation.

Objectives:
- decouple business logic from components
- Infrastructure will keep components implementation

Components:
- Container - PHP-DI
- Framework - Slim
- ORM - Doctrine
- Console - Symfony Console Component
- Config - Dotenv


##Useful commands
Start server application
```
php -S localhost:8888
```

Run console application
```
php console.php list
```

Run Doctrine console
```
php vendor/bin/doctrine list
```