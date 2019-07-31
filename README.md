# QuackNet

QuackNet is a symfony 4 project i made for learning the framework.

# Installing

- clone or download the repository
- cd into the directory and run : composer install
- create .env file and connect to your database
- if not already done, create a database by runnig : php bin/console doctrine:database:create
- then update the schema by running : php bin/console doctrine:schema:update --force
- you must create a directory named "uploads" in /public
