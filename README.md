# Module 306 YBC

## Setup

### Dependencies

Install dependencies using composer:

```shell
composer install
```

### PDO Mysql

Make sure to have the "pdo\_mysql" extension installed and enabled.

```
# php.ini
extension=php_mysql
```

### Environment Variables

Set the `YBC_ROOT` environment variable to the project root of this project.

```shell
# example:
export YBC_ROOT="/home/user/code/YBCeBankingWebApp" # make sure there is no '/' at the end
```

On Windows with PowerShell the environment variable can be set using `$env:`:

```PowerShell
$env:YBC_ROOT='C:\Users\user\code\YBCeBankingWebApp'
```

### Database

MariaDb is required. After configuring the _username_ and _password_ in
`src/config/config.php`, `source` the `mariadb.sql` file located in the project
root.

```shell
$ pwd
> ./YBCBanking

$ mysql -h localhost -u root -ptoor
MariaDB []> source src/mariadb.sql
```

## Directory Structure

```
 ./YBCBanking/
├── src/ 
│  ├── config/  
│  ├── Modules/
│  ├── public/  
│  │  ├── assets/  
│  │  └── index.php  
│  └── Templates/
└── tests/
```

Folder | Description
------ | -----------
src    | contains the source code
config | application config
Modules | Application Logic
public | Public accessible files
Templates | Code that renders HTML
tests  | unit tests

## Unit Testing

PHPUnit is used for unit testing.

From the project root...

```shell
$ pwd
> ./YBCBanking
```

...run:

```shell
./vendor/bin/phpunit tests --colors always --verbose
```