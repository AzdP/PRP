-- phpMyAdmin SQL Dump
-- version 2.6.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Server version: 4.0.22
-- PHP Version: 4.3.10
-- 
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `attacks`
-- 

CREATE TABLE `attacks` (
  `id` mediumint(10) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `min_damage` varchar(10) NOT NULL default '',
  `max_damage` varchar(10) NOT NULL default '',
  `level` varchar(10) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `attacks`
-- 

INSERT INTO `attacks` VALUES (1, 'Punch', '1', '4', '1');
INSERT INTO `attacks` VALUES (2, 'Kick', '9', '14', '15');

-- --------------------------------------------------------

-- 
-- Table structure for table `buildings`
-- 

CREATE TABLE `buildings` (
  `id` mediumint(15) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `sector_id` mediumint(10) NOT NULL default '0',
  `x` varchar(30) NOT NULL default '',
  `y` varchar(30) NOT NULL default '',
  `image` varchar(30) NOT NULL default '',
  `interior` mediumint(10) NOT NULL default '0',
  `door_x` varchar(20) NOT NULL default '',
  `door_y` varchar(20) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `buildings`
-- 

INSERT INTO `buildings` VALUES (18, 'Ilithor''s Waystation', 1, '250', '100', 'npc_house01.gif', 2, '300', '100');
INSERT INTO `buildings` VALUES (20, 'Cave', 1, '200', '0', 'cave01.gif', 4, '200', '0');
INSERT INTO `buildings` VALUES (3, 'Bedroom', 2, '250', '0', 'door01', 5, '250', '0');
INSERT INTO `buildings` VALUES (12, 'Roland\\''s', 7, '50', '100', 'npc_house01.gif', 8, '100', '100');
INSERT INTO `buildings` VALUES (5, 'The Rat Hole Tavern', 7, '250', '100', 'npc_house01', 9, '300', '150');
INSERT INTO `buildings` VALUES (13, 'Beach', 10, '150', '100', 'npc_house01.gif', 11, '200', '100');

-- --------------------------------------------------------

-- 
-- Table structure for table `chat`
-- 

CREATE TABLE `chat` (
  `id` mediumint(20) NOT NULL auto_increment,
  `user` varchar(50) NOT NULL default '0',
  `time` varchar(60) NOT NULL default '',
  `message` varchar(255) NOT NULL default '',
  `public` smallint(1) NOT NULL default '0',
  `toid` text NOT NULL,
  KEY `id` (`id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `clans`
-- 

CREATE TABLE `clans` (
  `id` mediumint(10) NOT NULL auto_increment,
  `name` varchar(15) NOT NULL default '',
  `description` text NOT NULL,
  `members` text NOT NULL,
  `members_count` smallint(5) NOT NULL default '0',
  `admin` varchar(15) NOT NULL default '',
  `mods` text NOT NULL,
  `stocked_items` text NOT NULL,
  `member_tax` smallint(5) NOT NULL default '0',
  `paid_members` text NOT NULL,
  `members_taken` text NOT NULL,
  `global_news` text NOT NULL,
  `allow_new` smallint(1) NOT NULL default '0',
  `signup_fee` smallint(5) NOT NULL default '0',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `clans`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `clipping`
-- 

CREATE TABLE `clipping` (
  `id` mediumint(15) NOT NULL auto_increment,
  `sector_id` mediumint(10) NOT NULL default '0',
  `x` varchar(30) NOT NULL default '',
  `y` varchar(30) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `clipping`
-- 

INSERT INTO `clipping` VALUES (31, 1, '300', '100');
INSERT INTO `clipping` VALUES (4, 2, '150', '100');
INSERT INTO `clipping` VALUES (22, 1, '50', '0');
INSERT INTO `clipping` VALUES (20, 1, '0', '0');
INSERT INTO `clipping` VALUES (9, 10, '150', '100');
INSERT INTO `clipping` VALUES (13, 2, '350', '50');
INSERT INTO `clipping` VALUES (11, 10, '200', '100');
INSERT INTO `clipping` VALUES (23, 1, '100', '0');
INSERT INTO `clipping` VALUES (24, 1, '150', '0');
INSERT INTO `clipping` VALUES (25, 1, '250', '0');
INSERT INTO `clipping` VALUES (26, 1, '300', '0');
INSERT INTO `clipping` VALUES (27, 1, '350', '0');
INSERT INTO `clipping` VALUES (33, 12, '113', '300');
INSERT INTO `clipping` VALUES (30, 1, '250', '100');
INSERT INTO `clipping` VALUES (34, 12, '145', '300');
INSERT INTO `clipping` VALUES (35, 12, '145', '268');
INSERT INTO `clipping` VALUES (36, 12, '145', '236');
INSERT INTO `clipping` VALUES (37, 12, '145', '204');
INSERT INTO `clipping` VALUES (38, 12, '113', '204');
INSERT INTO `clipping` VALUES (39, 12, '81', '204');
INSERT INTO `clipping` VALUES (40, 12, '49', '204');
INSERT INTO `clipping` VALUES (41, 12, '49', '236');
INSERT INTO `clipping` VALUES (43, 12, '49', '268');
INSERT INTO `clipping` VALUES (44, 11, '50', '0');
INSERT INTO `clipping` VALUES (45, 11, '300', '0');

-- --------------------------------------------------------

-- 
-- Table structure for table `config`
-- 

CREATE TABLE `config` (
  `config_name` varchar(255) NOT NULL default '',
  `config_value` varchar(255) NOT NULL default ''
) TYPE=MyISAM;

-- 
-- Dumping data for table `config`
-- 

INSERT INTO `config` VALUES ('img_url', 'images');
INSERT INTO `config` VALUES ('template', 'grey');
INSERT INTO `config` VALUES ('language', 'english');
INSERT INTO `config` VALUES ('clan_fee', '5000');
INSERT INTO `config` VALUES ('default_sector', '1');

-- --------------------------------------------------------

-- 
-- Table structure for table `dialogue`
-- 

CREATE TABLE `dialogue` (
  `id` mediumint(20) NOT NULL auto_increment,
  `npc_id` mediumint(15) NOT NULL default '0',
  `dialogue` text NOT NULL,
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `dialogue`
-- 

INSERT INTO `dialogue` VALUES (1, 1, 'Hello, my name is Ilithor, the owner of this way station. May I offer you healing? Or can I interest you in some of my goods?\r\n\r\nspecial\nMeyin City:I have noticed that they are building a city over to the west east from here. Im hopeinf they open soon, I hear they will have shops with more items, and areas for gambiling and registering guilds. I will not be in a guild but hoping they build it fast. ;');
INSERT INTO `dialogue` VALUES (2, 2, 'I hear theres trouble away west on the path to Trig. The Gorgun have been waylaying travelers lately. They''ve all been stirred up by someone they''re calling Urrik. Probably some big green goon who''s grown to big for his own good.');
INSERT INTO `dialogue` VALUES (3, 3, 'The only reason I''ve stopped at this little rat hole is because the road west to Trig has been blocked by the Gorgun who''ve come down from the mountains. I was injured a bit on my way here by some Gorgun scum. Needless to say they aren''t exactly in possession of their heads about now. I dispatched most of them easily enough, but one snuck up behind me and nicked my shoulder. Until it''s healed I wont be able to get this message to General Ulaph who''s currently located in Trig. Say, would you mind taking the {questLink}message to the General{/questlink} for me?');
INSERT INTO `dialogue` VALUES (8, 9, 'Hello, I am a guard. I have been told I was weak So I am out training to get more strength for any upcomming turnaments.\r\n\r\nspecial\nTrig: Just keep heading west you are sure to find it.;');
INSERT INTO `dialogue` VALUES (10, 10, 'hi\n\nspecial\n');
INSERT INTO `dialogue` VALUES (9, 11, 'Hey, welcome to my beach house. What can I do for you?\n\nspecial\n');

-- --------------------------------------------------------

-- 
-- Table structure for table `inventory`
-- 

CREATE TABLE `inventory` (
  `pid` mediumint(15) NOT NULL default '0',
  `type` varchar(255) NOT NULL default '',
  `item_id` mediumint(10) NOT NULL default '0',
  `quantity` mediumint(5) NOT NULL default '0'
) TYPE=MyISAM;

-- 
-- Table structure for table `items`
-- 

CREATE TABLE `items` (
  `id` mediumint(10) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `image` varchar(15) NOT NULL default '',
  `effect_type` varchar(10) NOT NULL default '',
  `effect` varchar(10) NOT NULL default '',
  `effect_cap` varchar(40) NOT NULL default '',
  `effect_desc` varchar(50) NOT NULL default '',
  `value` varchar(5) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `items`
-- 

INSERT INTO `items` VALUES (1, 'Health Potion', 'healthPotion', 'hp', '+20', '$maxhp', 'Restores health up to 20 points.', '15');

-- --------------------------------------------------------

-- 
-- Table structure for table `monster_pos`
-- 

CREATE TABLE `monster_pos` (
  `id` mediumint(10) NOT NULL auto_increment,
  `monster` mediumint(10) NOT NULL default '0',
  `sector` mediumint(10) NOT NULL default '0',
  `x` varchar(20) NOT NULL default '',
  `y` varchar(20) NOT NULL default '',
  `killed` smallint(1) NOT NULL default '0',
  `time_killed` varchar(255) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `monster_pos`
-- 

INSERT INTO `monster_pos` VALUES (1, 0, 1, '200', '300', 0, '1111532286');
INSERT INTO `monster_pos` VALUES (2, 1, 1, '100', '50', 0, '1111346907');
INSERT INTO `monster_pos` VALUES (3, 2, 3, '50', '150', 0, '1111181499');

-- --------------------------------------------------------

-- 
-- Table structure for table `monsters`
-- 

CREATE TABLE `monsters` (
  `id` mediumint(10) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `image` varchar(20) NOT NULL default '',
  `hp` mediumint(5) NOT NULL default '0',
  `attacks` varchar(255) NOT NULL default '',
  `level` varchar(15) NOT NULL default '',
  `norand` smallint(1) NOT NULL default '0',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `monsters`
-- 

INSERT INTO `monsters` VALUES (1, 'Robo Bot', '9', 10, '1,2', '1', 0);
INSERT INTO `monsters` VALUES (2, 'Gorgun Scout', '18', 20, '1', '1', 0);
INSERT INTO `monsters` VALUES (3, 'Gorgun Warrior', '18', 25, '1,2', '13', 0);
INSERT INTO `monsters` VALUES (4, 'Scaled Monster', '18', -1, 'scaled', '-1', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `npc`
-- 

CREATE TABLE `npc` (
  `id` mediumint(10) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `image` varchar(30) NOT NULL default '',
  `sector_id` mediumint(10) NOT NULL default '0',
  `x` varchar(15) NOT NULL default '',
  `y` varchar(15) NOT NULL default '',
  `services` varchar(255) NOT NULL default '',
  `weapons` text NOT NULL,
  `items` varchar(255) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `npc`
-- 

INSERT INTO `npc` VALUES (1, 'Ilithor', '10', 2, '150', '100', 'heal,barter', '1,2,3,4,5', '1');
INSERT INTO `npc` VALUES (2, 'General Ulaph', '7', 2, '300', '150', '', '', '');
INSERT INTO `npc` VALUES (3, 'Sorrak', '12', 2, '100', '250', '', '', '');
INSERT INTO `npc` VALUES (9, 'Guard', '22', 6, '150', '100', '', '', '');
INSERT INTO `npc` VALUES (10, 'Lanayaa', '25', 12, '150', '100', 'heal', '', '');
INSERT INTO `npc` VALUES (11, 'Helos', '6', 11, '150', '100', 'heal', '', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `online`
-- 

CREATE TABLE `online` (
  `id` mediumint(10) NOT NULL auto_increment,
  `name` varchar(40) NOT NULL default '',
  `time` varchar(255) NOT NULL default '',
  `ip` varchar(25) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `online`
-- 

INSERT INTO `online` VALUES (357, 'Mathias', '1111613268', '81.83.223.246');

-- --------------------------------------------------------

-- 
-- Table structure for table `players`
-- 

CREATE TABLE `players` (
  `id` mediumint(30) NOT NULL auto_increment,
  `name` varchar(25) NOT NULL default '',
  `email` varchar(40) NOT NULL default '',
  `password` varchar(60) NOT NULL default '',
  `join_date` varchar(255) NOT NULL default '',
  `ip_address` varchar(30) NOT NULL default '',
  `char_img` varchar(50) NOT NULL default '',
  `sector` mediumint(15) NOT NULL default '0',
  `x` varchar(255) NOT NULL default '',
  `y` varchar(255) NOT NULL default '',
  `level` mediumint(4) NOT NULL default '0',
  `class` varchar(15) NOT NULL default '',
  `exp` mediumint(5) NOT NULL default '0',
  `hp` varchar(20) NOT NULL default '',
  `maxhp` varchar(20) NOT NULL default '',
  `mp` varchar(20) NOT NULL default '',
  `maxmp` varchar(20) NOT NULL default '',
  `gold` mediumint(5) NOT NULL default '0',
  `equip1` mediumint(10) NOT NULL default '0',
  `userlvl` enum('1','2','3','4') NOT NULL default '1',
  `music` smallint(1) NOT NULL default '0',
  `clan` mediumint(10) NOT NULL default '0',
  `accept_tax` smallint(1) NOT NULL default '0',
  `chatcolor` varchar(15) NOT NULL default '',
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) TYPE=MyISAM;

-- 
-- Table structure for table `pvp`
-- 

CREATE TABLE `pvp` (
  `id` mediumint(10) NOT NULL auto_increment,
  `challenger` mediumint(10) NOT NULL default '0',
  `defender` mediumint(10) NOT NULL default '0',
  `accepted` smallint(1) NOT NULL default '0',
  `lastmove_time` varchar(50) default NULL,
  `lastmove_player` mediumint(10) NOT NULL default '0',
  `won` smallint(1) NOT NULL default '0',
  `won_by` mediumint(10) NOT NULL default '0',
  `battle_time` varchar(255) default NULL,
  `messages` varchar(255) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Table structure for table `quest_status`
-- 

CREATE TABLE `quest_status` (
  `id` mediumint(20) NOT NULL auto_increment,
  `pid` mediumint(15) NOT NULL default '0',
  `qid` mediumint(10) NOT NULL default '0',
  `status` varchar(30) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Table structure for table `quests`
-- 

CREATE TABLE `quests` (
  `id` mediumint(10) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `description` text NOT NULL,
  `given_by` mediumint(10) NOT NULL default '0',
  `type` varchar(20) NOT NULL default '',
  `reward` varchar(255) NOT NULL default '',
  `reward_by_target` smallint(1) NOT NULL default '0',
  `item_to_find` mediumint(10) NOT NULL default '0',
  `give_item` smallint(1) NOT NULL default '0',
  `npc_target` mediumint(10) NOT NULL default '0',
  `give_dialogue` text NOT NULL,
  `complt_dialogue` text NOT NULL,
  `incompl_dialogue` text NOT NULL,
  `target_dialogue` text NOT NULL,
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `quests`
-- 

INSERT INTO `quests` VALUES (1, 'Message to General Ulaph', 'Deliver Sorrak''s message to General Ulaph in Trig. Sorrak has told you to check in the Rat Hole tavern for some of General Ulaph''s solders to find out where he is located.', 3, 'item', 'GOLD 200', 1, 4, 1, 2, 'Thanks a lot, I''m sure General Ulaph will be grateful when you deliever this. If you have trouble finding him in Trig, be sure to check the Rat Hole tavern for some of the Generals solders. They may be able to tell you where he is located. \r\n\r\n(Or you can just check with the hill-billy right over on the other side of the tavern!)', 'Thanks for delivering the message! Let me know if there is anything you need...', 'Have you delievered that message yet?', 'Hmmm... I see. Well thanks for delievering this message to me. I guess I should give you something in return for your troubles. Here, take 200G as a reward.');

-- --------------------------------------------------------

-- 
-- Table structure for table `sectors`
-- 

CREATE TABLE `sectors` (
  `id` mediumint(10) NOT NULL auto_increment,
  `name` varchar(40) NOT NULL default '',
  `bg` varchar(20) NOT NULL default '',
  `monsters` smallint(1) NOT NULL default '0',
  `sleep` smallint(1) NOT NULL default '0',
  `top_tele` mediumint(10) NOT NULL default '0',
  `bot_tele` mediumint(10) NOT NULL default '0',
  `left_tele` mediumint(10) NOT NULL default '0',
  `right_tele` mediumint(10) NOT NULL default '0',
  `music` varchar(50) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `sectors`
-- 

INSERT INTO `sectors` VALUES (1, 'Sector 01: A new beginning', 'grass', 0, 0, 0, 6, 3, 10, 'town1.mp3');
INSERT INTO `sectors` VALUES (2, 'Illithor''s Waystation', 'boards02', 0, 0, 0, 0, 0, 0, '');
INSERT INTO `sectors` VALUES (3, 'Test Sector 3: Hella Monsters', 'grass', 1, 0, 0, 7, 0, 1, '');
INSERT INTO `sectors` VALUES (4, 'Gresh Caverns', 'dirt', 1, 0, 0, 0, 0, 0, 'cave2.mp3');
INSERT INTO `sectors` VALUES (5, 'Ilithors Waystation, Beds', 'boards02', 0, 1, 0, 0, 0, 0, '');
INSERT INTO `sectors` VALUES (6, 'Sege Fields', 'grass', 1, 0, 1, 0, 7, 0, '');
INSERT INTO `sectors` VALUES (7, 'Trig', 'grass', 0, 0, 3, 0, 12, 6, '');
INSERT INTO `sectors` VALUES (8, 'Inside', 'boards', 0, 0, 0, 0, 0, 0, '');
INSERT INTO `sectors` VALUES (9, 'Inside 2', 'boards02', 0, 0, 0, 0, 0, 0, '');
INSERT INTO `sectors` VALUES (10, 'Water', 'sand', 0, 0, 0, 0, 1, 0, '');
INSERT INTO `sectors` VALUES (11, 'Beach House', 'boards03', 0, 0, 0, 0, 0, 0, '');
INSERT INTO `sectors` VALUES (12, 'Meyin City', 'whitebrick', 0, 0, 0, 0, 0, 7, '');
INSERT INTO `sectors` VALUES (13, 'Lake Sigess', 'water', 0, 0, 0, 0, 0, 0, '');

-- --------------------------------------------------------

-- 
-- Table structure for table `terrain`
-- 

CREATE TABLE `terrain` (
  `id` mediumint(20) NOT NULL auto_increment,
  `sector_id` mediumint(10) NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `image` varchar(25) NOT NULL default '',
  `ontop` smallint(1) NOT NULL default '0',
  `x` varchar(30) NOT NULL default '',
  `y` varchar(30) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `terrain`
-- 

INSERT INTO `terrain` VALUES (44, 1, 'Bush', 'bush.gif', 0, '0', '300');
INSERT INTO `terrain` VALUES (63, 1, 'cliff', 'cliff_face02.png', 0, '0', '0');
INSERT INTO `terrain` VALUES (3, 2, 'Desk', 'table01', 1, '135', '130');
INSERT INTO `terrain` VALUES (12, 3, '', 'cliff_face02.png', 0, '0', '0');
INSERT INTO `terrain` VALUES (45, 1, 'Bush', 'bush.gif', 0, '0', '150');
INSERT INTO `terrain` VALUES (7, 2, '', 'housewall.png', 0, '0', '0');
INSERT INTO `terrain` VALUES (8, 2, 'Bed', 'bed_sm', 0, '350', '50');
INSERT INTO `terrain` VALUES (64, 1, 'hemp', 'weed.gif', 0, '300', '50');
INSERT INTO `terrain` VALUES (9, 5, '', 'housewall.png', 0, '0', '0');
INSERT INTO `terrain` VALUES (10, 5, 'Large Bed', 'bed_lg', 0, '300', '30');
INSERT INTO `terrain` VALUES (11, 5, 'Potted Plant', 'pottedplant', 0, '265', '5');
INSERT INTO `terrain` VALUES (48, 12, 'Flowerbed', 'flowerbed.gif', 0, '200', '150');
INSERT INTO `terrain` VALUES (14, 6, 'A Tree', 'tree03', 1, '300', '50');
INSERT INTO `terrain` VALUES (15, 6, 'A Tree', 'tree03', 1, '150', '250');
INSERT INTO `terrain` VALUES (54, 7, 'Barrels', 'barrels.gif', 0, '50', '200');
INSERT INTO `terrain` VALUES (30, 8, 'Bed', 'bed_sm.gif', 0, '50', '50');
INSERT INTO `terrain` VALUES (20, 9, '', 'housewall.png', 0, '0', '0');
INSERT INTO `terrain` VALUES (28, 1, 'Tree', 'tree02.gif', 1, '200', '150');
INSERT INTO `terrain` VALUES (31, 8, 'Wall', 'housewall.png', 0, '0', '0');
INSERT INTO `terrain` VALUES (32, 10, 'Water', 'water01.gif', 0, '0', '0');
INSERT INTO `terrain` VALUES (35, 10, 'Palm', 'tree03.gif', 1, '50', '150');
INSERT INTO `terrain` VALUES (36, 10, 'Palm Tree', 'tree03.gif', 1, '300', '100');
INSERT INTO `terrain` VALUES (37, 10, 'Palm tree', 'tree03.gif', 1, '250', '300');
INSERT INTO `terrain` VALUES (70, 12, '', 'downcity_rightbottom.gif', 0, '49', '300');
INSERT INTO `terrain` VALUES (41, 4, 'Tree', 'tree_desert.gif', 0, '50', '100');
INSERT INTO `terrain` VALUES (42, 4, 'Another tree', 'tree_desert.gif', 0, '200', '250');
INSERT INTO `terrain` VALUES (43, 3, 'Dirt Patch', 'dirt.gif', 0, '100', '150');
INSERT INTO `terrain` VALUES (46, 4, 'Cracked Dirt', 'crack.gif', 0, '300', '50');
INSERT INTO `terrain` VALUES (47, 4, 'Rocks', 'rocks.gif', 0, '150', '150');
INSERT INTO `terrain` VALUES (49, 12, 'Well', 'well.gif', 0, '114', '242');
INSERT INTO `terrain` VALUES (50, 12, 'Crate', 'box_city.gif', 0, '300', '250');
INSERT INTO `terrain` VALUES (51, 12, 'Crate', 'box_city.gif', 0, '50', '50');
INSERT INTO `terrain` VALUES (52, 12, 'Tree', 'tree_city.gif', 0, '296', '300');
INSERT INTO `terrain` VALUES (53, 12, 'Tree', 'tree_city.gif', 0, '300', '50');
INSERT INTO `terrain` VALUES (55, 7, 'Bush', 'bush.gif', 0, '150', '150');
INSERT INTO `terrain` VALUES (58, 7, 'Bush', 'bush.gif', 0, '200', '100');
INSERT INTO `terrain` VALUES (59, 6, 'Weeds', 'weed.gif', 0, '50', '150');
INSERT INTO `terrain` VALUES (60, 6, 'Weeds', 'weed.gif', 0, '300', '300');
INSERT INTO `terrain` VALUES (61, 6, 'Flowers', 'flowers.gif', 0, '200', '150');
INSERT INTO `terrain` VALUES (68, 1, 'reefer', 'weed.gif', 0, '350', '100');
INSERT INTO `terrain` VALUES (66, 1, 'j', 'weed.gif', 0, '250', '50');
INSERT INTO `terrain` VALUES (67, 1, 'bud', 'weed.gif', 0, '350', '50');
INSERT INTO `terrain` VALUES (69, 1, '420', 'weed.gif', 0, '350', '150');
INSERT INTO `terrain` VALUES (71, 12, '', 'downcity_middlebottom.gif', 0, '81', '300');
INSERT INTO `terrain` VALUES (72, 12, '', 'downcity_rightmiddle.gif', 0, '49', '268');
INSERT INTO `terrain` VALUES (73, 12, '', 'downcity_righttop.gif', 0, '49', '204');
INSERT INTO `terrain` VALUES (74, 12, '', 'downcity_rightmiddle.gif', 0, '49', '236');
INSERT INTO `terrain` VALUES (75, 12, '', 'downcity_middletop.gif', 0, '81', '204');
INSERT INTO `terrain` VALUES (76, 12, '', 'downcity_middletop.gif', 0, '113', '204');
INSERT INTO `terrain` VALUES (77, 12, '', 'downcity_lefttop.gif', 0, '145', '204');
INSERT INTO `terrain` VALUES (78, 12, '', 'downcity_leftmiddle.gif', 0, '145', '236');
INSERT INTO `terrain` VALUES (79, 12, '', 'downcity_leftmiddle.gif', 0, '145', '268');
INSERT INTO `terrain` VALUES (80, 12, '', 'downcity_leftbottom.gif', 0, '145', '300');
INSERT INTO `terrain` VALUES (81, 12, '', 'downcity_leftbottom.gif', 0, '113', '300');
INSERT INTO `terrain` VALUES (87, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '128');
INSERT INTO `terrain` VALUES (86, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '160');
INSERT INTO `terrain` VALUES (88, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '96');
INSERT INTO `terrain` VALUES (89, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '64');
INSERT INTO `terrain` VALUES (90, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '32');
INSERT INTO `terrain` VALUES (91, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '0');
INSERT INTO `terrain` VALUES (92, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '192');
INSERT INTO `terrain` VALUES (93, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '224');
INSERT INTO `terrain` VALUES (94, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '256');
INSERT INTO `terrain` VALUES (95, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '288');
INSERT INTO `terrain` VALUES (96, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '320');
INSERT INTO `terrain` VALUES (97, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '352');
INSERT INTO `terrain` VALUES (98, 12, '', 'grasbrick_leftmiddle.gif', 0, '368', '368');
INSERT INTO `terrain` VALUES (100, 13, '', 'watertodirt_middletop.gif', 0, '0', '0');
INSERT INTO `terrain` VALUES (101, 13, '', 'watertodirt_middletop.gif', 0, '32', '0');
INSERT INTO `terrain` VALUES (102, 13, '', 'watertodirt_middletop.gif', 0, '64', '0');
INSERT INTO `terrain` VALUES (103, 13, '', 'watertodirt_outputtoprigh', 0, '96', '0');
INSERT INTO `terrain` VALUES (104, 13, '', 'watertodirt_rightmiddle.g', 0, '96', '32');
INSERT INTO `terrain` VALUES (105, 13, '', 'watertodirt_rightmiddle.g', 0, '96', '64');
INSERT INTO `terrain` VALUES (106, 13, '', 'watertodirt_rightmiddle.g', 0, '96', '96');
INSERT INTO `terrain` VALUES (107, 13, '', 'water_sticks.gif', 0, '192', '64');
INSERT INTO `terrain` VALUES (108, 12, '', 'grasbrick_middlebottom.gi', 0, '0', '350');
INSERT INTO `terrain` VALUES (113, 11, 'Plant', 'pottedplant.gif', 1, '50', '0');
INSERT INTO `terrain` VALUES (115, 11, 'Plant', 'pottedplant.gif', 1, '300', '0');
INSERT INTO `terrain` VALUES (112, 11, '', 'housewall.png', 0, '0', '0');

-- --------------------------------------------------------

-- 
-- Table structure for table `weapons`
-- 

CREATE TABLE `weapons` (
  `id` mediumint(10) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `min_damage` mediumint(3) NOT NULL default '0',
  `max_damage` mediumint(3) NOT NULL default '0',
  `image` varchar(40) NOT NULL default '',
  `level` mediumint(3) NOT NULL default '0',
  `value` mediumint(6) NOT NULL default '0',
  KEY `id` (`id`)
) TYPE=MyISAM;

-- 
-- Dumping data for table `weapons`
-- 

INSERT INTO `weapons` VALUES (1, 'Dull Long Sword', 5, 12, 'long_sword', 2, 35);
INSERT INTO `weapons` VALUES (2, 'Silver Long Sword', 11, 17, 'long_sword', 7, 650);
INSERT INTO `weapons` VALUES (3, 'Calibur', 16, 22, 'long_sword', 7, 1000);
INSERT INTO `weapons` VALUES (4, 'Excalibur', 21, 28, 'long_sword', 7, 1530);
INSERT INTO `weapons` VALUES (5, 'Enchanted Long Sword', 40, 55, 'en_long_sword', 50, 10000);
INSERT INTO `weapons` VALUES (6, 'Divine Blade', 50, 100, 'black_steel_long_sword', 150, 80000);
INSERT INTO `weapons` VALUES (9, 'Spiked Mace', 10, 25, 'iron_mace', 0, 6000);
