# Module 306 YBC

## Setup

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

### Database

MariaDb is required. After configuring the _username_ and _password_ in
`src/config/config.php`, `source` the `mariadb.sql` file located in the project
root.

## Directory Structure

```
 .  
├── Projectdescription  
└── src  
   ├── config  
   ├── Modules  
   ├── public  
   │  ├── assets  
   │  └── index.php  
   ├── Templates  
   └── tests
```

Folder | Description
------ | -----------
src    | contains the source code
config | application config
Modules | Application Logic
public | Public accessible files
Templates | Code that renders HTML
tests  | unit tests
