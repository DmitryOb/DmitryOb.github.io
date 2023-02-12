<?php

// DB connect
$mysql = @new mysqli('localhost', 'root', 'pass', 'dbName');
if (mysqli_connect_errno()){die(mysqli_connect_error());};
$sql = "set names 'utf8'";
$result = $mysql->query($sql);
if (!$result) die($mysql->error);

$mysql->query("drop table `users`"); // удалить таблицу users `` , еще есть - drop database

// СОЗАДНИЕ ТАБЛИЦЫ
$sql = "
CREATE TABLE `users` (
	`id` int(11) NOT NULL,
	`surname` tinytext,
	`phone` varchar(12) DEFAULT NULL,
	`email` tinytext,
	`status` enum('active','passive','lock','gold') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

$sql2 = "ALTER TABLE `users` ADD PRIMARY KEY (`id`);";
$sql3 = "ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";

// ДОБАВЛЕНИЕ ЗАПИСИ В ТАБЛИЦУ
$sql = "
insert into `users` (`surname`, `patronymic`, `name`, `phone`, `email`, `url`, `status`) values ('Иванов', 'Валерьевич', 'Александр', '58-98-78', 'ivanov@email.ru', NULL, 'active'), ('Лосев', 'Иванович', 'Сергей', '9057777777', 'losev@email.ru', NULL, 'passive'), ('Симдянов', 'Вячеславович', 'Игорь', '9056666100', 'simdyanov@softtime.ru', 'http://www.softtime.ru/', 'active'), ('Кузнецов', 'Валерьевич', 'Максим', NULL, 'kuznetsov@softtime.ru', 'http://www.softtime.ru', 'active'), ('Нехорошев', 'Юрьевич', 'Анатолий', NULL, NULL, NULL, 'lock'), ('Корнеев', 'Александрович', 'Александр', '89-78-36', 'korneev@domen.ru', NULL, 'gold');
";

// /* ОТОБРАЖЕНИЕ ЗАПИСЕЙ SELECT*/
$sql = "select * from `users`"; // выбирает все данные из таблицы users
$data = $result->fetch_all(MYSQLI_NUM); // вернется индексный массив 0-значение,1-значение,2-значение
if (count($data)) {
	echo '<pre>'.print_r($data, true).'</pre>'; // возвращает данные в виде массива ключ:значение
	echo drawTable($data);
} else {
	echo 'Таблица пустая!';
}

// ОТОБРАЖЕНИЕ ЗАПИСЕЙ ЧЕРЕЗ ОБЪЕДИНЕНИЕ
/* u. - псевдоним таблицы*/
$sql = "
select u.*, s.statusname as status from users as u
left join statusname s
on s.status = u.status
";
$result = $mysql->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC); // вернет ассоциативный массив

// УДАЛЕНИЕ ЗАПИСЕЙ
$sql = "delete from `users` where `id`='2' ";
$result = $mysql->query($sql); if (!$result) die($mysql->error);

/* УДАЛЕНИЕ ВСЕХ ЗАПИСЕЙ */
$sql = "truncate table `users`";
$result = $mysql->query($sql); if (!$result) die($mysql->error);
// ОТОБРАЖАЕМ РЕЗУЛЬТАТ
echo '<p>Результат удаления ВСЕХ пользователей</p>';
$sql = "select * from `users`";
$result = $mysql->query($sql); if (!$result) die($mysql->error);
$data = $result->fetch_all(MYSQLI_ASSOC); if (count($data)) { echo drawTable($data); } else { echo 'Таблица пустая!'; }

print_r(PDO::getAvailableDrivers()); // вывести список PDO драйверов

echo '<pre>'.print_r($data, true).'</pre>'; // возвращает данные в виде массива ключ:значение