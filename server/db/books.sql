CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(96) NOT NULL,
  `age` int(11) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `authors` (`id`, `name`, `age`, `country_id`) VALUES
(1, 'Arthur Clarke', 90, 1),
(2, 'J. R. R. Tolkien', 120, 2),
(3, 'Иван Вазов', 100, 359);

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `pages` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `books` (`id`, `title`, `pages`, `year`, `author_id`) VALUES
(1, 'Lord of the Rings', 1200, 1961, 2),
(2, 'Childhood\'s End', 200, 1971, 1),
(3, 'Под Игото', 900, 1892, 3);

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'US'),
(2, 'England'),
(359, 'България');

ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=360;
