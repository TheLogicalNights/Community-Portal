-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 22, 2021 at 06:27 PM
-- Server version: 10.2.36-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `febinaevents18_community`
--

-- --------------------------------------------------------

--
-- Table structure for table `adharno`
--

CREATE TABLE `adharno` (
  `adhar` bigint(20) NOT NULL,
  `valid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adharno`
--

INSERT INTO `adharno` (`adhar`, `valid`) VALUES
(222222222222, 1),
(111111111111, 1);

-- --------------------------------------------------------

--
-- Table structure for table `favourit`
--

CREATE TABLE `favourit` (
  `sr_no` bigint(20) NOT NULL,
  `name` varchar(120) NOT NULL,
  `username` varchar(80) NOT NULL,
  `uname` varchar(80) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `favourit`
--

INSERT INTO `favourit` (`sr_no`, `name`, `username`, `uname`) VALUES
(26, 'Aniket Chandrakant Dhole', 'swapnil_', 'aniket_dhole_');

-- --------------------------------------------------------

--
-- Table structure for table `postlikes`
--

CREATE TABLE `postlikes` (
  `srno` int(11) NOT NULL,
  `likedby` text DEFAULT NULL,
  `postid` bigint(20) DEFAULT NULL,
  `count` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postlikes`
--

INSERT INTO `postlikes` (`srno`, `likedby`, `postid`, `count`) VALUES
(47, '2', 2, 1),
(46, '1,2', 1, 2),
(45, ',,,,,2', 3, 1),
(44, ',,,,,', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `name` varchar(30) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `posttitle` longtext DEFAULT NULL,
  `post` longtext DEFAULT NULL,
  `postid` bigint(20) NOT NULL,
  `posted_at` datetime DEFAULT NULL,
  `img_path` varchar(500) DEFAULT 'https://images.pexels.com/photos/1680172/pexels-photo-1680172.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`name`, `username`, `posttitle`, `post`, `postid`, `posted_at`, `img_path`) VALUES
('Aniket Chandrakant Dhole', 'aniket_dhole_', 'Explore new perspectives', '<h3>Read and share ideas from independent voices, world-class publications, and experts from around the globe. Everyone&#39;s welcome. <a class=\"fr fs ft fu fv fw fx fy fz ga gd ge gf jh\" href=\"https://medium.com/about?autoplay=1\" rel=\"noopener\">Learn more.</a></h3>\r\n', 1, '2021-02-19 17:08:36', 'https://images.pexels.com/photos/1680172/pexels-photo-1680172.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260'),
('Aniket Chandrakant Dhole', 'aniket_dhole_', 'The Stan Lee Story That Tore Apart Marvel Comics Jack Kirby and Steve Ditko were heroes in â€œthe House of Ideas.â€ But a 1966 profile gave all the credit to one superman.', '<p><em>This excerpt is adapted with permission from </em><a href=\"https://bookshop.org/a/2181/9780593135716\">True Believer: The Rise and Fall of Stan Lee</a><em> by Abraham Riesman, published by Crown Publishing, a division of Penguin Random House, copyright 2021 by Abraham Riesman.</em></p>\r\n\r\n<p>Stan Lee was good at projecting an air of hipness. Nowhere was that more apparent than in his dealings with a reporter named Nat Freedland (n&eacute; Friedland; he changed it for his byline because he &ldquo;thought <em>Friedland</em> was a stupid-looking name&rdquo;), who was working on assignment for the New York Herald Tribune in the mid-1960s. Freedland had been working for a small paper called the Long Island Press and was trying to do some freelance magazine writing on the side. &ldquo;I wanted to be the next Tom Wolfe; I wanted fame; I wanted to be a first-call for big stories,&rdquo; Freedland recalls. &ldquo;I was waiting for little niches that Tom Wolfe hadn&rsquo;t covered yet.&rdquo; He landed on a topic idea: &ldquo;Spider-Man, Marvel, and Stan Lee were the really big thing in New York at the time,&rdquo; he says, citing a <a href=\"https://www.villagevoice.com/2020/05/19/spider-man-super-anti-hero-in-forest-hills/\">contemporaneous Village Voice column</a> as something that had sparked interest in the comics among &ldquo;pop-culture snobs.&rdquo;</p>\r\n\r\n<div>\r\n<div>Advertisement</div>\r\n\r\n<div>\r\n<div>&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<p>He pitched a feature on Marvel to the editor of the Herald Tribune&rsquo;s magazine section, James Bellows, and got it approved. &ldquo;I called Marvel, I got Stan Lee on the phone, I said what assignment I had, and he was excited,&rdquo; Freedland says. The journalist came to the Marvel offices for only one afternoon in late 1965. One component of the visit was an interview with Lee, who turned on the charm. &ldquo;There are little touches I can see now, in retrospect&mdash;little touches of being an egomaniac and taking all the credit,&rdquo; Freedland says. &ldquo;But he told me about all the stuff, and I thought it was cute and tremendous. I saw artists coming around, but I didn&rsquo;t talk to them much.&rdquo;</p>\r\n\r\n<p>The one quasi-interaction he did have with an artist came when Lee contrived to have a story conference between him and Jack Kirby to discuss an upcoming issue of <em>The Fantastic Four</em>, one of the many smash comic book series that were co-written by the two men and drawn by Kirby (others had included <em>The X-Men, The Avengers, </em>and <em>The Incredible Hulk</em>). &ldquo;And Lee is talking to Kirby in very general terms and Kirby&rsquo;s going, &lsquo;Uh-huh&rsquo;&mdash;he&rsquo;s not very verbal,&rdquo; Freedland recalls. Lee started doing his trademark storytelling acrobatics, leaping around and throwing mock punches. &ldquo;Great, great,&rdquo; was all Kirby said when Lee was done. Kirby maintained that the whole thing was a staged stunt&mdash;and, for Lee, a successful one. &ldquo;Jack said that there was not a plotting session for a real issue,&rdquo; recalls Kirby&rsquo;s assistant and biographer, Mark Evanier. &ldquo;They had already plotted that issue beforehand, and they were basically recreating it for the reporter. And one of the reasons Jack didn&rsquo;t say more in the meeting was he wasn&rsquo;t thinking about a story. He wasn&rsquo;t gonna take anything home and draw that story. The story was done for him.&rdquo; Indeed, according to Kirby, he was by that point primarily just dictating to Lee what he was going to do in a given story, and those meager plot conversations weren&rsquo;t even happening in person; they were all over the phone. Freedland knew none of this and didn&rsquo;t bother to find it out. &ldquo;I was so enchanted by the whole thing,&rdquo; he says. The staged scene wound up as the central sequence in the Herald Tribune story.</p>\r\n\r\n<div>&ldquo;I feel sad that I was one of the things that made Kirby feel he was being shortchanged, which, in retrospect, decades later, I can see, yeah, he was. [&hellip;] What the hell was I&nbsp;thinking?&rdquo; &mdash; Nat Freedland</div>\r\n\r\n<p>While chatting with Freedland that day, Lee also tore into Marvel writer/artist Steve Ditko, the co-creator of Spider-Man, with his signature passive aggression. &ldquo;I don&rsquo;t plot Spider-Man anymore,&rdquo; Lee told the reporter. &ldquo;Steve Ditko, the artist, has been doing the stories. I guess I&rsquo;ll leave him alone until sales start to slip. Since Spidey got so popular, Ditko thinks he&rsquo;s the genius of the world. We were arguing so much over plotlines I told him to start making up his own stories.&rdquo; These digs wound up in the profile, too.</p>\r\n\r\n<p>The Herald Tribune article hit stands a few weeks after Freedland&rsquo;s interviews, on Jan. 9, 1966. It was classic New Journalism, its language simultaneously flip and hip, and it fawned over Lee. Freedland wrote that Lee was &ldquo;an ultra&ndash;Madison Avenue, rangy lookalike of Rex Harrison&rdquo; with &ldquo;humorous eyes, thinning but&nbsp;tasteful gray hair, the brightest-colored Ivy wardrobe in captivity and a deep suntan&rdquo; who &ldquo;dreamed up the &lsquo;Marvel Age of Comics&rsquo; in 1961.&rsquo; &rdquo; It recounted legendary Italian film director Federico Fellini&rsquo;s fascinated and worshipful visit with Lee from a few months prior, his recent appearance at Bard College, the bombastic magic of the Fantastic Four, the neurotic charm of Spidey, and claimed that &ldquo;practically every costumed hero in Lee&rsquo;s new Marvel Comics mythology displaces enough symbolic weight to become grist for an English Lit. Ph.D. thesis.&rdquo; Freedland even parroted Lee&rsquo;s claim about winning a Herald Tribune essay contest as a kid. (He did not.) By contrast, in the published piece, Kirby went uninterviewed, appeared passive, and was described in the following terms: &ldquo;If you stood next to him on the subway you would peg him for the assistant foreman in a girdle factory.&rdquo;</p>\r\n\r\n<div>\r\n<div>Advertisement</div>\r\n\r\n<div>\r\n<div>&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<p>The story was published after decades of intermittent tension between the two men over credit for creation of the characters they wrote and various other interpersonal conflicts. The New York Herald Tribune piece, it turned out, was something like the last straw.</p>\r\n\r\n<p>Mark Evanier recalled, &ldquo;Jack&rsquo;s wife, Roz, read the article early the Sunday morning it came out, woke Jack up to read it,&rdquo; then &ldquo;Jack phoned Stan at home to wake him up and complain. Both men later recalled that the collaboration was never the same after that day, and it was more than just an injured ego at work.&rdquo;</p>\r\n\r\n<p>Freedland has lived to regret what he wrote. &ldquo;I feel sad that I was one of the things that made Kirby feel he was being shortchanged, which, in retrospect, decades later, I can see, yeah, he was,&rdquo; he tells me. &ldquo; &lsquo;Girdle factory.&rsquo; Oh, God. Oh, poor Kirby. What the hell was I thinking?&rdquo;</p>\r\n\r\n<h1>Recently in <a class=\"in-article-recirc__topic\" href=\"https://slate.com/culture/books\"> Books </a></h1>\r\n\r\n<ol>\r\n	<li><a class=\"in-article-recirc__link\" href=\"https://slate.com/culture/2021/02/vanessa-springora-memoir-consent-gabriel-matzneff.html\">The French #MeToo Memoir That Ensnares the Abuser in His Own Trap </a></li>\r\n	<li><a class=\"in-article-recirc__link\" href=\"https://slate.com/culture/2021/02/dress-codes-fashion-law-history-book-review.html\">When Wearing the Wrong Pants Could Land You in Prison </a></li>\r\n	<li><a class=\"in-article-recirc__link\" href=\"https://slate.com/culture/2021/02/patricia-lockwood-interview-debut-novel-no-one-is-talking-about-this.html\">Patricia Lockwood on the Terrors of the Internet, the Power of Novels, and Her Famous Cat </a></li>\r\n	<li><a class=\"in-article-recirc__link\" href=\"https://slate.com/culture/2021/02/patricia-lockwood-novel-review-no-one-is-talking-about-this.html\">Extremely Online: The Novel </a></li>\r\n</ol>\r\n\r\n<p>Freedland says that when the article came out, he promoted it by appearing on Jean Shepherd&rsquo;s popular radio show and repeating his pro-Stan account of Marvel&rsquo;s popularity. As the weeks went on, Freedland was surprised to find that Lee didn&rsquo;t mention all this publicity in the back matter of any of the comics. He was perplexed&mdash;after all, Lee was usually eager to boast about any and all mentions the company received. &ldquo;I called Marvel and talked to Stan Lee and said, &lsquo;How come you didn&rsquo;t put me in your column, now that the thing is out?&rsquo; &rdquo; Freedland recalls. &ldquo;And he told me about Kirby being upset&mdash;I think he put it as, &lsquo;upset about having his feelings hurt&rsquo;&mdash;and I thought, gee, I can see why he would.&rdquo;</p>\r\n\r\n<div>\r\n<div>Advertisement</div>\r\n\r\n<div>\r\n<div>&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<p>Kirby stayed at Marvel for a few more years out of necessity&mdash;steady work was hard to find in the fly-by-night comics industry of the day&mdash;but left for rival publisher DC in 1970. With the exception of an ill-fated graphic novel in 1978, Lee and Kirby never directly collaborated again, and Kirby and his family would often note that the Herald Tribune article had been a decisive factor in severing that relationship. Ditko didn&rsquo;t wait nearly as long: By the time the article was published, he&rsquo;d already flown the coop. He never worked with Lee again and went to his grave furious about the way Lee had treated him.</p>\r\n\r\n<p>Nevertheless, after spending so much time with Lee, Freedland remained enchanted and landed on a new idea: &ldquo;I wanted to be a Marvel writer,&rdquo; he says. &ldquo;There was a writing test, and I took it and turned it in, and I got the word back&nbsp;from someone, saying I didn&rsquo;t have the style or quality&mdash;by which I mean characteristics&mdash;of writing stuff that would work with Marvel Comics.&rdquo; Freedland was one of countless admirers who were now dreaming of working for what was known as the House of Ideas. To all appearances, the tide was high for Marvel, and Lee was the glorious captain of the ship. But with Ditko&rsquo;s departure and Kirby&rsquo;s grim resignation to the fact that he would never be fully appreciated, the Marvel Age of Comics was, in a way, already over.</p>\r\n', 2, '2021-02-19 17:37:03', 'https://compote.slate.com/images/988d6263-8235-4fa6-ba8a-ff2c8c6cf0f4.jpeg?width=840&rect=1560x1040&offset=0x0'),
('Swapnil Ramesh Adhav', 'swapnil_', 'Swapnil demo', '<p>dsfdsfsdfdsfdsfzd</p>\r\n', 3, '2021-02-22 11:04:15', './postuploads/3/ren-ran-Jy6luiLBsrk-unsplash.jpg'),
('Aniket Chandrakant Dhole', 'aniket_dhole_', '7 things people who are good with money never buy', '<p>You don&rsquo;t have to be wealthy to be good with money.</p>\r\n\r\n<p>However, a lot of wealthy people are good with money &mdash; and it&rsquo;s how they got to be that way. Millionaires often aren&rsquo;t living the lifestyle you might think they are. Instead, they&rsquo;re frugal, and tend to <a class=\"fr ke\" href=\"https://www.businessinsider.com/personal-finance/millionaire-spending-habits-millionaire-next-door-2020-11\" rel=\"noopener nofollow\">spend only what they can afford</a>. They&rsquo;re always looking for ways to make their money grow, rather than spend it.</p>\r\n\r\n<p>Millionaires or not, there are some purchases that just don&rsquo;t make sense to anyone who&rsquo;s good with money. Here are the top seven things they aren&rsquo;t likely to buy or spend on.</p>\r\n', 4, '2021-02-22 12:43:58', 'https://images.pexels.com/photos/1680172/pexels-photo-1680172.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `name` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `about` varchar(200) DEFAULT NULL,
  `dppath` varchar(200) DEFAULT NULL,
  `instalink` varchar(200) DEFAULT NULL,
  `fblink` varchar(200) DEFAULT NULL,
  `isset` int(11) DEFAULT NULL,
  `birthdate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`name`, `username`, `about`, `dppath`, `instalink`, `fblink`, `isset`, `birthdate`) VALUES
('Aniket Chandrakant Dhole', 'aniket_dhole_', 'Web Developer...', './profilepictures/aniket_dhole_/boris-baldinger-VEkIsvDviSs-unsplash.jpg', 'https://instagram.com/aniket_dhole_', 'https://instagram.com/aniket_dhole_', 1, '2000-04-10'),
('Swapnil Ramesh Adhav', 'swapnil_', 'Web Developer intern', './profilepictures/swapnil_/Wallpape-of-Joker.jpg', 'https://leetcode.com/TheLogicalNights/', 'https://github.com/TheLogicalNights', 1, '1999-08-17');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `postid` bigint(20) DEFAULT NULL,
  `posttitle` varchar(150) DEFAULT NULL,
  `post` varchar(500) DEFAULT NULL,
  `reportcount` int(11) DEFAULT NULL,
  `reportedby` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reportuser`
--

CREATE TABLE `reportuser` (
  `username` varchar(50) DEFAULT NULL,
  `postid` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `sr_no` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `contact_number` bigint(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(12) DEFAULT NULL,
  `seckey` bigint(20) DEFAULT NULL,
  `otp` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`sr_no`, `name`, `contact_number`, `email`, `address`, `username`, `password`, `seckey`, `otp`) VALUES
(1, 'Aniket Chandrakant Dhole', 9284770231, 'aniketd.febina@gmail.com', 'Alandi, Pune', 'aniket_dhole_', 'aniket1004', 111111111111, NULL),
(2, 'Swapnil Ramesh Adhav', 8446736267, 'swapnil.febina1@gmail.com', '66,Somwar peth,Near Nageshwar Mandir,Pune-411011', 'swapnil_', '12345678', 222222222222, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adharno`
--
ALTER TABLE `adharno`
  ADD PRIMARY KEY (`adhar`);

--
-- Indexes for table `favourit`
--
ALTER TABLE `favourit`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `postlikes`
--
ALTER TABLE `postlikes`
  ADD PRIMARY KEY (`srno`),
  ADD KEY `likedby` (`likedby`(1000)),
  ADD KEY `postid` (`postid`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postid`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD KEY `username` (`username`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD KEY `postid` (`postid`),
  ADD KEY `reportedby` (`reportedby`);

--
-- Indexes for table `reportuser`
--
ALTER TABLE `reportuser`
  ADD KEY `username` (`username`),
  ADD KEY `postid` (`postid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favourit`
--
ALTER TABLE `favourit`
  MODIFY `sr_no` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `postlikes`
--
ALTER TABLE `postlikes`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
