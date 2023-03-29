# MeeHou Social Network Project

Follow the steps below in order to run the project.
1. Clone project from Github. 
2. Run the following codes on the home directory.

`composer install`

`npm install`

`npm run watch`

## Creating JWT Certificates 

After completing steps above, you need to create jwt certificates. For this, run the command below;

`php bin/console lexik:jwt:generate-keypair`


If you are working in a test environment;
php bin/console doctrine:fixtures:load
run the command.

[MeeHou](https://www.meehou.app)


