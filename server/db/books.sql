/*

Примерни задачи:

1. Да се създаде базата данни. Да се покажат всички автори в таблицата горе вляво. 
   За целта:
    - Да се промени рутера на сървъра така че да връща авторите в JSON. 
      Нека държавата на автора да се получава чрез JOIN на countries и authors
      Примерно URL: (GET) /authors
    - Промени клиента да визуализира в HTML таблицата с автори.

2. При клик върху името на автор от горната задача да се визуализира таблица с книги долу вляво. 
   Над таблицата да се покаже името на автора и броя на книгите.
   За целта:
    - Да се промени рутера на сървъра  така че да връща книги по зададен автор, както и самия автор по зададено ID на автора
      Примерно URL: (GET) /authors/3/books
    - Да се промени клиента така че да визуализира таблица с книгите, а над нея името на автора и броя на книгите.
     
3. Да се поставят линкове за изтриване на автор и книга съответно в горната и долната таблици от задачи 1 и 2.
   За целта:
    - Да се промени рутера на сървъра така че да може да изтрива книга по ID и автор по ID.
      примерно URL: (DELETE) /authors/3   (DELETE) /books/2
    - Да се промени клиента така че при изобразяване на книги и автори до тях да има линк за изтриване 
      и при натискане на този линк да се изпълнява HTTP DELETE върху URL на книгата или автора.
      
4. Да се реализира редактиране на автор чрез HTML форма (тага <form>) и проверки за валидност на сървъра.
   За целта:
   - Да се имплементира в рутера на сървъра четене и запис на автор по зададено ID.
     Примерно URL: (GET) /authors/3 (POST) /authors/3
   - Да се имплементира в клиента рендериране на HTML форма с подходящи контроли за редактиране на полетата на автора, 
     както и логика, която да изпраща данните към сървъра.
*/

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
