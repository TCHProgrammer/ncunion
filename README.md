Установка:
1) composer install
2) php init 
3) создаём и подключаемся к бд 
(изменяем подключение к базе дыннх в конфигах(common/config/main-colal) 
на 'dsn' => 'mysql:host=localhost;dbname=yii2-cms')
4) yii migrate (создаём пользователя)
5) yii create-roles