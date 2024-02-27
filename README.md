# auto_parts1

## Установка

У вас должен быть установлен и настроен OpenServer, в качестве СУБД phpMyAdmin

1. Клонирование репозитория

Перейдите в папку внутри директории OpenServerPanel по следущему пути `\domains\localhost`

Используйте команду для клонирования репозитория

`git clone https://github.com/phantomdevi1/gas-equipment`

2. Импорт базы данных

Переходим к директории bd, внутри которой лежит файл `gas_equipments.sql`

Запускаем OSPanel и переходим через вкладку "Дополнительно" в СУБД PhpMyAdmin

Авторизуемся по данным, которые были использованы при установке OSPanel

Создаём новую БД с названием gas_equipment

Переходим в эту бд

Выбираем вкладку "Импорт"

Выбираем файл `gas_equipments.sql`

Нажимаем кнопку "Импорт"

3. Запуск веб-платформы

Нажимаем на зелёный флажок OSPanel

Выбираем вкладку "Мои проекты" -> "localhost"

Выбираем проект с названием "gas-equipment"
