# CHANGELOG

## v0.7.1 - 2020.04.10

### Added
- Usage warnings in documentation

## v0.7.0 - 2020.04.10

### Added
- Error page on exception
- Symfony VarDumper in dev depencencies

### Removed
- Try-catch around routing on index

### Changed
- Request now handled through a Kernel

### Fixed
- Routing was broken on Apache
- Service arguments
- Error in documentation

## v0.6.0 - 2020.04.07

### Added
- Authentication workflow
- `keyExists` method on `Config`
- `final` statement in all lib classes
- License docblock in all lib files

### Fixed
- Typo in license file name

## v0.5.0 - 2020.04.07

### Added
- `redirectToRoute` method in Router
- Static analysis tools (PHPStan and PHPInsights)
- Init Composer (composer.json and PSR-2 autoloading)

### Fixed
- Outdated documentation about database connection
- Bug on password encoding during registration example
- Bug on `getValidationErrors` method in User example
- Bug on `UserManager` example
- Multiple properties and annotations were wrongly or insufficiently typed

## v0.4.0 - 2020.04.06

### Added
- CSS assets

### Fixed
- Trailing slash in URI generation

## v0.3.0 - 2020.04.06

### Added
- Application parameters
- Service container
- Config reading service
- Property `scriptName` on Request instance
- `generateUri` method can now handle GET parameters

### Changed
- Controller and Manager are now instantiated with PDO connection 
- Make Framewa internal services using Container
- Better view handling
- Better message on autoload error 

## v0.2.0 - 2020.04.04

### Added
- `generateUri` method in Controller
- Properties `host` and `protocol` on Request instance

### Fixed
- Homepage example template was embedding a whole HTML layout

## v0.1.1 - 2020.04.03

### Changed
- Slight optimization in the autoload.php

### Fixed
- Debug code in the index.php was creating a new user on each page load (:

## v0.1.0 - 2020.04.02

### Added
- Autoload
- Routing
- Database
- Docker Compose
- Documentation
- Licence (GPL-3.0)
