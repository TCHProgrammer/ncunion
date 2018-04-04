Установка:
1) composer install
2) php init 
3) создаём и подключаемся к бд 
(изменяем подключение к базе дыннх в конфигах(common/config/main-colal) 
на 'dsn' => 'mysql:host=localhost;dbname=yii2-db')
4) yii migrate 
5) php yii migrate --migrationPath=@yii/rbac/migrations
6) yii start
7) yii zalog-zalog
8) yii migrate --migrationPath=frontend\migrations