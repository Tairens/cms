php app/console doctrine:mapping:import --force AppFrontendBundle xml
php app/console doctrine:mapping:convert annotation ./src
php app/console doctrine:generate:entities AppFrontendBundle