

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";


-- Database: `room_reservation`


CREATE TABLE `reservations` (

  `id` int(11) NOT NULL,

  `name` varchar(100) NOT NULL,

  `email` varchar(100) NOT NULL,

  `room` varchar(100) NOT NULL,

  `date_in` varchar(100) NOT NULL,

  `date_out` varchar(100) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `reservations`

  ADD PRIMARY KEY (`id`);



ALTER TABLE `reservations`

  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;