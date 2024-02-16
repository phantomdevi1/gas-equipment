-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Фев 16 2024 г., 17:24
-- Версия сервера: 8.0.30
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gas_equipment`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `cart_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `ID` int NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`ID`, `category_name`) VALUES
(1, 'Газовые плиты и печи'),
(2, 'Газовые котлы'),
(3, 'Газовые колонки'),
(4, 'Газовые баллоны и баллончики'),
(5, 'Газовые горелки'),
(6, 'Газовые регуляторы и счетчики'),
(7, 'Газовые трубы и фитинги'),
(8, 'Газовые обогреватели'),
(9, 'Газовые грили и барбекю'),
(10, 'Газовые компрессоры'),
(11, 'Газовые сигнализации и детекторы утечки газа'),
(12, 'Газовые резаки и сварочные аппараты'),
(13, 'Газовые насосы и насосные станции'),
(14, 'Газовые фонари и светильники'),
(15, 'Газовые аксессуары и расходные материалы');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) DEFAULT NULL,
  `full_price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `ID` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` int DEFAULT NULL,
  `quantity_warehouse` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`ID`, `name`, `description`, `price`, `image`, `category`, `quantity_warehouse`) VALUES
(58, 'Газовая плита Hansa FHGCW51025', '4 конфорки, газовая духовка, стеклокерамика, белый', '21500.00', 'img/product/gazovaya_plita.jpg', 1, 20),
(59, 'Газовая плита Electrolux EKG6330AOK', '3 конфорки, газовая духовка, автоподжиг, черный', '18990.00', 'img/product/gazovaya_plita2.jpg', 1, 15),
(60, 'Газовая плита Gorenje K5111AW', '4 конфорки, газовая духовка, эмалированная поверхность, белый', '17990.00', 'img/product/gazovaya_plita3.jpg', 1, 25),
(61, 'Газовый котел BAXI ECO 3 1.240Fi', 'Котел с закрытой камерой сгорания, мощность 24 кВт, модулирующий', '46790.00', 'img/product/gazovyy_kotel.jpg', 2, 12),
(62, 'Газовый котел Protherm Panther 25 KTZ', 'Компактный настенный котел, мощность 25 кВт, электронная плата', '39900.00', 'img/product/gazovyy_kotel2.jpg', 2, 18),
(63, 'Газовый котел Vaillant ecoTEC plus VU INT 306/5-5', 'Высокоэффективный котел, мощность 30 кВт, модулирующий', '56990.00', 'img/product/gazovyy_kotel3.jpg', 2, 25),
(64, 'Газовая колонка Bosch W 125 K 1 E 23', 'Проточная газовая колонка, надежная и компактная, 12 л/мин', '10990.00', 'img/product/gazovaya_kolonka.jpg', 3, 8),
(65, 'Газовая колонка Baxi WGB 20 E', 'Электронно-проточная газовая колонка, автоматическая регулировка мощности, 16 л/мин', '13490.00', 'img/product/gazovaya_kolonka2.jpg', 3, 10),
(66, 'Газовая колонка Mora Top Flow', 'Модель с электронным поджигом, эффективной системой безопасности, 12 л/мин', '12500.00', 'img/product/gazovaya_kolonka3.jpg', 3, 15),
(67, 'Газовый баллон Campingaz R 904', 'Баллон смешанного газа для газовых горелок и ламп, объем 1,8 кг', '2300.00', 'img/product/gazovyy_ballon.jpg', 4, 30),
(68, 'Газовый баллончик Coleman C500', 'Баллончик с пропан-бутановой смесью, объем 440 г', '750.00', 'img/product/gazovyy_ballonchik.jpg', 4, 40),
(69, 'Газовый баллон Primus PowerGas 100g', 'Баллон смешанного газа с пропан-бутановой смесью, объем 100 г', '290.00', 'img/product/gazovyy_ballonchik2.jpg', 4, 50),
(70, 'Газовая горелка Campingaz Twister Plus', 'Портативная газовая горелка с регулируемой мощностью, 2900 Вт', '1890.00', 'img/product/gazovaya_gorilka.jpg', 5, 20),
(71, 'Газовая горелка MSR PocketRocket Deluxe', 'Компактная газовая горелка, вес 83 г, мощность 2800 Вт', '3990.00', 'img/product/gazovaya_gorilka2.jpg', 5, 15),
(72, 'Газовая горелка Primus Express', 'Прочная газовая горелка с регулируемым пламенем, вес 82 г', '2590.00', 'img/product/gazovaya_gorilka3.jpg', 5, 25),
(73, 'Газовый регулятор DAEWOO DRP-0725', 'Манометр для газовых баллонов, рабочее давление 0,5-7 бар', '690.00', 'img/product/gazovyy_regulyator.jpg', 6, 30),
(74, 'Газовый регулятор GOK 21 мбар', 'Редуктор газового давления, применяется для баллонных газовых установок', '1290.00', 'img/product/gazovyy_regulyator2.jpg', 6, 20),
(75, 'Газовый счетчик ГБУ-4М', 'Мембранный газовый счетчик, пропускная способность 4 м³/час', '2890.00', 'img/product/gazovyy_schetchik.jpg', 6, 25),
(76, 'Газовая труба металлопластиковая Rehau RAUTITAN', 'Гибкая труба для газоснабжения, диаметр 20 мм, длина 4 м', '850.00', 'img/product/gazovaya_truba.jpg', 7, 30),
(77, 'Газовый фитинг Uponor Uni Pipe Plus', 'Фитинг для металлопластиковых труб, переходник диаметром 20 мм', '350.00', 'img/product/gazovyy_fiting.jpg', 7, 40),
(78, 'Газовый переходник Uponor Uni Pipe Plus', 'Переходник для металлопластиковых труб, диаметр 20 мм', '220.00', 'img/product/gazovyy_perehodnik.jpg', 7, 50),
(79, 'Мобильный газовый обогреватель EINHELL GH-GH4202P', 'Мощность 4200 Вт, пьезоподжиг, автоматическое отключение при опрокидывании', '3190.00', 'img/product/gazovyy_obogrevatel.jpg', 8, 20),
(80, 'Газовый обогреватель Feron HG 115 M', 'Мощность 11500 ккал/час, автоматический регулятор пламени', '6490.00', 'img/product/gazovyy_obogrevatel2.jpg', 8, 15),
(81, 'Газовый тепловентилятор Energy Eco 4200', 'Мощность 4200 Вт, автоматическое отключение при опрокидывании, защита от перегрева', '4190.00', 'img/product/gazovyy_obogrevatel3.jpg', 8, 25),
(82, 'Газовый гриль Char-Broil Convective 210 B', '2 горелки, площадь гриля 35x41 см, портативный', '9990.00', 'img/product/gazovyy_gril.jpg', 9, 10),
(83, 'Газовый гриль Campingaz 3 Series Classic LS', '3 горелки, площадь гриля 61x45 см, боковая конфорка', '18990.00', 'img/product/gazovyy_gril2.jpg', 9, 20),
(84, 'Газовый барбекю Broil King Crown 420', '4 горелки, площадь гриля 65x42 см, эмалированный корпус', '31990.00', 'img/product/gazovyy_barbekyu.jpg', 9, 15),
(85, 'Газовый компрессор Einhell TH-AC 190/6 OF', 'Мощность 1100 Вт, производительность 185 л/мин, емкость ресивера 6 л', '6690.00', 'img/product/gazovyy_kompressor.jpg', 10, 20),
(86, 'Газовый компрессор Sturm! AC1050G', 'Мощность 750 Вт, производительность 180 л/мин, емкость ресивера 24 л', '4490.00', 'img/product/gazovyy_kompressor2.jpg', 10, 15),
(87, 'Газовый компрессор Hyundai HAC 1020', 'Мощность 1100 Вт, производительность 180 л/мин, емкость ресивера 20 л', '5390.00', 'img/product/gazovyy_kompressor3.jpg', 10, 25),
(88, 'Детектор утечки газа Xiaomi Mijia Honeywell Gas Alarm', 'Оповещает о наличии газа в воздухе, работает от батареек', '1790.00', 'img/product/detektor_utechki_gaza.jpg', 11, 30),
(89, 'Сигнализация для дома Securiton GD-4', 'Система контроля газа в доме, сигнализирует об утечке газа', '3490.00', 'img/product/signalizatsiya_utechki_gaza.jpg', 11, 40),
(90, 'Датчик утечки газа Cavius Gas Alarm 220-0011', 'Самопроверяющийся датчик газа, работает от батареек', '2990.00', 'img/product/datchik_utechki_gaza.jpg', 11, 50),
(91, 'Газовый резак GCE Oxy-Fuel 3000', 'Ручной газовый резак с регулируемым пламенем, набор сопел включен', '4990.00', 'img/product/gazovyy_rezak.jpg', 12, 20),
(92, 'Газовый резак KOVEA LPG Adapter KA-0101', 'Компактный газовый резак для кемпинга, подходит для различных баллонов', '1190.00', 'img/product/gazovyy_rezak2.jpg', 12, 15),
(93, 'Газовый сварочный аппарат DEKO DKA-180Y', 'Сварочный аппарат на газе, мощность 180 А, компактный и мобильный', '5690.00', 'img/product/gazovyy_svarochnyy_apparat.jpg', 12, 25),
(94, 'Газовый насос Karcher G 7.10 M', 'Мощный насос для перекачивания газа, производительность до 400 л/мин', '10990.00', 'img/product/gazovyy_nasos.jpg', 13, 20),
(95, 'Газовая насосная станция Grundfos Unilift KP', 'Автоматическая насосная станция для газа, производительность 240 л/мин', '23990.00', 'img/product/gazovaya_nasosnaya_stantsiya.jpg', 13, 15),
(96, 'Газовый насос Makita PF1110', 'Компактный и мощный насос, производительность 650 л/мин', '5690.00', 'img/product/gazovyy_nasos2.jpg', 13, 25),
(97, 'Газовый фонарь Ferei BL200', 'Мощный газовый фонарь для активного отдыха, 2000 люмен, вес 360 г', '4990.00', 'img/product/gazovyy_fonar.jpg', 14, 30),
(98, 'Газовый фонарь Primus EasyLight Lantern', 'Компактный газовый фонарь, съемный рефлектор, вес 490 г', '2590.00', 'img/product/gazovyy_fonar2.jpg', 14, 40),
(99, 'Газовый фонарь Coleman F1 Lite', 'Легкий и компактный газовый фонарь, мощность 480 люмен', '1890.00', 'img/product/gazovyy_fonar3.jpg', 14, 50),
(100, 'Газовая гильза газовой горелки MSF-1a', 'Запасная гильза для газовой горелки, производство Швейцария', '150.00', 'img/product/gazovaya_gilza.jpg', 15, 20),
(101, 'Газовый фильтр для газовых плит BOSCH', 'Запасной фильтр для газовых плит, улучшает качество сгорания газа', '250.00', 'img/product/gazovyy_filter.jpg', 15, 15),
(102, 'Газовая трубка для газовой колонки 1/2\"', 'Гибкая металлическая трубка, устойчивая к высокому давлению', '350.00', 'img/product/gazovaya_trubka.jpg', 15, 25);

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `review_text` text,
  `submission_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`review_id`, `username`, `rating`, `review_text`, `submission_date`) VALUES
(7, 'admin', 5, 'qwfqfqwf', '2024-02-16 13:31:08'),
(8, 'admin', 5, 'qwdfqwfqwf', '2024-02-16 13:31:13'),
(9, 'admin', 5, 'qwdfqwfqwf', '2024-02-16 13:31:18'),
(10, 'admin', 5, 'qwdfqwfqwf', '2024-02-16 13:32:10'),
(11, 'admin', 5, 'qwdfqwfqwf', '2024-02-16 13:32:28'),
(12, 'admin', 5, 'qwdfqwfqwf', '2024-02-16 13:32:42'),
(13, 'admin', 5, '', '2024-02-16 13:34:00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID` int NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `access_status` int NOT NULL,
  `discount_card` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `user_email`, `user_phone`, `user_name`, `user_password`, `access_status`, `discount_card`) VALUES
(1, 'admin@gazprom.ru', '89451672356', 'admin', 'admin', 1, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `category` (`category`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`ID`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`);

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`ID`);

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
