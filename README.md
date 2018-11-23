# Wyszukiwarka książek

## Treść zadania

Zadanie polega na napisaniu metody wyświetlającej wyniki wyszukiwania tytułu książki
na podstawie danych z bazy danych MySQL, w oparciu o dane wejściowe.

Dane wejściowe będą miały postać jak na listingu poniżej:

Listening 1:
```php
ZieLoNa MiLa|age>30
```

Listening 2:
```php
ZiElonA Droga|age<30
```

Dane te określały będą dolny bądź górny zakres wieku czytelników, których należy
uwzględnić w raporcie, oraz wyszukiwany tytuł książki, które należy uwzględnić w raporcie.

Przykład z Listingu 1. określa, że w raporcie ma być uwzględnia książka zawierającą tytuł
Zielona Mila oraz jej czytelnicy o wieku wyższym niż 30 lat.

Wielkość wprowadzonych liter nie powinna mieć znaczenia na wyniki wyszukiwania.
Należy przyjąć, że podany tytuł może nie występować w bazie danych. Wówczas należy
wyświetlić książki spełniające warunek wiekowy czytelników z podanym procentem
podobieństwa wyszukiwanego tytułu.

Po uruchomieniu, program powinien wywoływać stworzoną metodę z parametrami z
Listing 1 oraz Listing 2.

Listening 3:
```php
Stats::showStatistics(‘ZieLoNa MiLa|age>30’);
Stats::showStatistics(‘ZiElonA Droga|age<30’);
```

Wynik działania programu powinien mieć format podobny do tego poniżej:

Obrazek 1. ( wynik działania Listing 1 ):

| Book          | Compatibility | Book Date  | Female AVG age | Male AVG age |
| ------------- |:-------------:| ----------:| --------------:| -----------: |
| Zielona Mila  | 100 %         | 2012-01-03 | 38             | 57           |

Obrazek 2. ( wynik działania Listing 2 ):

| Book           | Compatibility | Book Date  | Female AVG age | Male AVG age |
| -------------  |:-------------:| ----------:| --------------:| -----------: |
| Zielona żabka  | 69.23 %       | 2011-07-05 | 15             | 0            |
| Co nam zostało | 44.44 %       | 2011-11-16 | 29             | 12           |
| Na szafocie    | 25 %          | 2011-12-28 | 0              | 19           |
| Harry Potter   | 24 %          | 2011-05-18 | 29             | 14.67        |
| Tajemnica      | 18.18 %       | 2011-09-30 | 15.5           | 16           |

Struktura bazy danych:
```sql
CREATE TABLE `books` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(56) NOT NULL,
`book_date` date NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `books` (`id`, `name`, `book_date`) VALUES
(1, 'Zielona Mila', '2012-01-03'),
(2, 'Harry Potter', '2011-05-18'),
(3, 'Zielona Żabka', '2011-07-05'),
(4, 'Tajemnica', '2011-09-30'),
(5, 'Policja', '2011-12-06'),
(6, 'Na szafocie', '2011-12-28'),
(7, 'Co nam zostało', '2011-11-16');

CREATE TABLE `reviews` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`book_id` int(11) NOT NULL,
`age` int(11) NOT NULL,
`sex` enum('m','f') NOT NULL,
PRIMARY KEY (`id`),
KEY `book_id` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `reviews` (`id`, `book_id`, `age`, `sex`) VALUES
(1, 2, 16, 'm'),
(2, 2, 29, 'f'),
(3, 4, 14, 'f'),
(4, 4, 16, 'm'),
(5, 1, 56, 'm'),
(6, 1, 58, 'm'),
(7, 3, 15, 'f'),
(8, 2, 15, 'm'),
(9, 2, 13, 'm'),
(10, 7, 29, 'f'),
(11, 7, 12, 'm'),
(12, 1, 38, 'f'),
(13, 6, 19, 'm'),
(14, 4, 17, 'f'),
(15, 3, 54, 'm'),
(16, 2, 52, 'f'),
(17, 1, 58, 'f');

ALTER TABLE `reviews`
ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books`
(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

```