-- Create the database if it doesn't exist and select it
CREATE DATABASE IF NOT EXISTS `otokoe`;
USE `otokoe`;

-- --------------------------------------------------------
-- Table structure for table `category`
-- --------------------------------------------------------

CREATE TABLE `category` ( -- Menu categories
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `navigation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `image`
-- --------------------------------------------------------

CREATE TABLE `image` ( -- Product images
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `member`
-- --------------------------------------------------------

CREATE TABLE `member` ( -- Staff members
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forename` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `picture` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `article`
-- --------------------------------------------------------

CREATE TABLE `article` ( -- Coffee shop menu items
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `category_id` (`category_id`),
  KEY `member_id` (`member_id`),
  KEY `image_id` (`image_id`),
  CONSTRAINT `category_exists` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `image_exists` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`),
  CONSTRAINT `member_exists` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping data for table `category`
-- --------------------------------------------------------

INSERT INTO `category` (`id`, `name`, `description`, `navigation`) VALUES
(1, 'Hot Coffee', 'Freshly brewed hot coffee drinks', 1),
(2, 'Cold Coffee', 'Refreshing iced coffee beverages', 1),
(3, 'Pastries', 'Baked goods and sweet treats', 1),
(4, 'Specialty Drinks', 'Signature drinks of the coffee shop', 1);

-- --------------------------------------------------------
-- Dumping data for table `image`
-- --------------------------------------------------------

INSERT INTO `image` (`id`, `file`, `alt`) VALUES
(1, 'espresso.jpg', 'Hot espresso coffee'),
(2, 'latte.jpg', 'Creamy latte coffee'),
(3, 'americano.jpg', 'Classic americano coffee'),
(4, 'cappuccino.jpg', 'Espresso with steamed milk foam'),
(5, 'macchiato.jpg', 'Espresso with a dash of milk'),
(6, 'mocha.jpg', 'Espresso with chocolate and milk'),
(7, 'iced-latte.jpg', 'Cold iced latte'),
(8, 'cold-brew.jpg', 'Smooth cold brew coffee'),
(9, 'iced-coffee.jpg', 'Classic iced coffee'),
(10, 'iced-caramel-latte.jpg', 'Iced caramel latte'),
(11, 'frappe.jpg', 'Blended iced coffee'),
(12, 'iced-mocha.jpg', 'Iced mocha coffee'),
(13, 'croissant.jpg', 'Fresh butter croissant'),
(14, 'blueberry-muffin.jpg', 'Blueberry muffin pastry'),
(15, 'chocolate-cake.jpg', 'Slice of chocolate cake'),
(16, 'cheesecake.jpg', 'Classic cheesecake'),
(17, 'donut.jpg', 'Glazed donut'),
(18, 'banana-bread.jpg', 'Banana bread'),
(19, 'caramel-frappe.jpg', 'Caramel frappe drink'),
(20, 'matcha-latte.jpg', 'Matcha green tea latte'),
(21, 'turmeric-latte.jpg', 'Turmeric latte'),
(22, 'lavender-latte.jpg', 'Lavender infused latte'),
(23, 'chai-latte.jpg', 'Spiced chai latte'),
(24, 'pumpkin-spice-latte.jpg', 'Pumpkin spice latte');

-- --------------------------------------------------------
-- Dumping data for table `member`
-- --------------------------------------------------------

INSERT INTO `member` (`id`, `forename`, `surname`, `email`, `password`, `joined`, `picture`) VALUES
(1, 'Carlos', 'Reyes', 'carlos@brewcorner.com', 'pass-1234', '2024-01-10 08:12:20', 'carlos.jpg'),
(2, 'Anna', 'Lopez', 'anna@brewcorner.com', 'pass-5678', '2024-02-05 09:33:10', 'anna.jpg'),
(3, 'Miguel', 'Santos', 'miguel@brewcorner.com', 'pass-9012', '2024-03-01 10:21:15', 'ivy.jpg');

-- --------------------------------------------------------
-- Dumping data for table `article`
-- --------------------------------------------------------

INSERT INTO `article` (`id`, `title`, `summary`, `content`, `created`, `category_id`, `member_id`, `image_id`, `published`) VALUES
(1, 'Espresso', 'Strong and rich espresso shot', 'Our signature espresso is brewed using premium Arabica beans for a bold and intense flavor.', '2024-04-01 08:00:00', 1, 1, 1, 1),
(2, 'Cafe Latte', 'Smooth espresso with steamed milk', 'The cafe latte combines rich espresso with silky steamed milk to create a creamy and balanced drink.', '2024-04-02 09:10:00', 1, 2, 2, 1),
(3, 'Americano', 'Espresso diluted with hot water', 'A classic americano offering a lighter yet rich coffee experience.', '2024-04-03 10:30:00', 1, 3, 3, 1),
(4, 'Cappuccino', 'Espresso with steamed milk foam', 'A cappuccino features a strong espresso base with creamy foam on top.', '2024-04-04 11:45:00', 1, 1, 4, 1),
(5, 'Macchiato', 'Espresso with a dash of milk', 'Our macchiato adds a small amount of milk foam to our rich espresso.', '2024-04-05 13:00:00', 1, 2, 5, 1),
(6, 'Mocha', 'Espresso with chocolate and milk', 'The mocha combines espresso, milk, and chocolate syrup for a sweet, rich taste.', '2024-04-06 14:10:00', 1, 3, 6, 1),
(7, 'Iced Latte', 'Chilled latte served over ice', 'A refreshing version of the classic latte, perfect for hot days.', '2024-04-07 09:50:00', 2, 2, 7, 1),
(8, 'Cold Brew', 'Slow brewed cold coffee', 'Our cold brew is steeped for 16 hours to produce a smooth and less acidic coffee.', '2024-04-08 11:10:00', 2, 3, 8, 1),
(9, 'Iced Coffee', 'Classic cold brewed iced coffee', 'Classic iced coffee with a refreshing twist of coolness.', '2024-04-09 12:25:00', 2, 1, 9, 1),
(10, 'Iced Caramel Latte', 'Iced latte with caramel syrup', 'The iced caramel latte features espresso and milk with a sweet caramel twist.', '2024-04-10 14:00:00', 2, 2, 10, 1),
(11, 'Frappe', 'Blended iced coffee', 'Our frappe is a blended iced coffee with creamy texture.', '2024-04-11 15:30:00', 2, 3, 11, 1),
(12, 'Iced Mocha', 'Iced coffee with chocolate syrup', 'A delicious iced mocha with rich chocolate syrup and whipped cream.', '2024-04-12 16:40:00', 2, 1, 12, 1),
(13, 'Butter Croissant', 'Flaky French pastry', 'Freshly baked croissants with buttery layers and a golden crisp crust.', '2024-04-13 07:30:00', 3, 1, 13, 1),
(14, 'Blueberry Muffin', 'Sweet muffin with blueberries', 'Soft muffin filled with juicy blueberries and topped with sugar crumble.', '2024-04-14 08:45:00', 3, 2, 14, 1),
(15, 'Chocolate Cake', 'Rich chocolate dessert', 'Moist chocolate cake layered with creamy chocolate frosting.', '2024-04-15 10:15:00', 3, 3, 15, 1),
(16, 'Cheesecake', 'Classic cheesecake', 'Rich and creamy cheesecake with a buttery biscuit base.', '2024-04-16 12:20:00', 3, 1, 16, 1),
(17, 'Donut', 'Glazed donut', 'Our soft, melt-in-your-mouth glazed donuts are freshly baked daily.', '2024-04-17 14:10:00', 3, 2, 17, 1),
(18, 'Banana Bread', 'Banana bread with walnuts', 'Fresh banana bread with crunchy walnut bits for added flavor.', '2024-04-18 16:05:00', 3, 3, 18, 1),
(19, 'Caramel Frappe', 'Blended iced coffee with caramel', 'A delicious iced coffee blended with caramel syrup and topped with whipped cream.', '2024-04-19 08:00:00', 4, 3, 19, 1),
(20, 'Matcha Latte', 'Green tea latte with milk', 'Premium Japanese matcha blended with steamed milk for a smooth earthy flavor.', '2024-04-20 09:10:00', 4, 2, 20, 1),
(21, 'Turmeric Latte', 'Golden turmeric latte', 'Turmeric, cinnamon, and black pepper blended with steamed milk for a healthy, spiced drink.', '2024-04-21 10:20:00', 4, 1, 21, 1),
(22, 'Lavender Latte', 'Lavender infused latte', 'Smooth steamed milk with the subtle floral taste of lavender for a relaxing beverage.', '2024-04-22 11:25:00', 4, 2, 22, 1),
(23, 'Chai Latte', 'Spiced chai latte', 'Spicy and aromatic chai tea combined with steamed milk for a cozy treat.', '2024-04-23 12:30:00', 4, 3, 23, 1),
(24, 'Pumpkin Spice Latte', 'Seasonal pumpkin spice latte', 'Warm spices and pumpkin flavor combined with espresso and steamed milk, perfect for fall.', '2024-04-24 13:40:00', 4, 3, 24, 1);