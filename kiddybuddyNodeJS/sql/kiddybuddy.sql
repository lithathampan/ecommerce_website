
CREATE DATABASE kiddybuddy;

-- CREATE USER AND GRANT PERMISSIONS

CREATE USER 'kiddybuddy_appuser'@'%' IDENTIFIED BY 'kiddybuddy_password';

GRANT SELECT, INSERT, DELETE,EXECUTE, UPDATE ON kiddybuddy.* TO kiddybuddy_appuser@'%';

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `kiddybuddy`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
   primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`name`) VALUES
('Plush Toys'),
('Barbie'),
('Disney Princess'),
('Arts and Crafts');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `content` longtext NOT NULL,
   primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`url`, `title`, `content`) VALUES
('/about', 'About Us', '<p> <strong>Kiddy Buddy</strong> is an E-commerce company designed to become the market leader of indoor toys.  The company is located in Montclair, New Jersey. With more and more parents realizing the harmful nature of electronic screens, the demand for indoor educational toys is on the rise.</p> <p><i>Kiddy Buddy</i> will provide an easy to access the web interface to help parents or grandparents to find their favorite toys for their loved ones..</p>'),
('/contact', 'Contact Us', '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12069.752969882164!2d-74.1978088!3d40.8622558!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xeece028744cfc9ae!2sMontclair%20State%20University!5e0!3m2!1sen!2sus!4v1575058836878!5m2!1sen!2sus" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe><br><address><strong>Montclair University</strong><br>Montclair, New Jersey ,USA<br>Pin: 07043<br><abbr title="Phone">Phone:</abbr> (973) 655-4000<br><abbr title="Email">Email:</abbr> thampanl1@montclair.edu</address>');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pid` int NOT NULL AUTO_INCREMENT,
  `category` int NOT NULL,
  `title` varchar(1000) NOT NULL,
  `details` longtext NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `picture` longtext NOT NULL,
   primary key (pid)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`category`, `title`, `details`, `price`, `picture`) VALUES
(1, 'PoohBear', ' Bear to cuddle ,Life Size', 40.00, 'img20.jpg'),
(1, 'Teddy Bear', 'mall soft brown toy', 13.95, 'img19.jpg'),
(1, 'Tiger', 'Small soft plush tiger', 16.95, 'img18.jpg'),
(1, 'Bunny', 'Small soft washable stuffed toy', 19.95, 'img27.jpg'),
(2, 'Barbie Bride', 'Barbie bride with Bouquet', 20.00, 'img21.jpg'),
(3, 'Aurora Doll', 'Disney Aurora Toddler Doll', 29.95, 'img26.jpg'),
(3, 'Belle Doll', 'Disney Belle Doll', 29.95, 'img22.jpg'),
(4, 'Kaleidoscope', 'Kaleidoscope making kit', 9.95, 'img40.jpg');


CREATE TABLE `order` (
  `orderid` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `totalprice` decimal(11,2) NOT NULL,
   primary key (orderid)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `orderdetail` (  
  `odid` int NOT NULL AUTO_INCREMENT,
  `orderid` int NOT NULL,
  `pid` int NOT NULL,
  `qty` int NOT NULL,
   primary key (odid)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
--
-- Indexes for dumped tables
--

