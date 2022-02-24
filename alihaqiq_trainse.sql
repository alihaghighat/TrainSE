-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 24, 2022 at 09:16 AM
-- Server version: 5.7.36-cll-lve
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alihaqiq_trainse`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `adminID` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`adminID`, `username`) VALUES
(2, 'rayan'),
(3, 'testAdmin123'),
(1, 'TrainSE5462Owner');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark_tbl`
--

CREATE TABLE `bookmark_tbl` (
  `bookmarkID` int(11) NOT NULL,
  `resourceID` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookmark_tbl`
--

INSERT INTO `bookmark_tbl` (`bookmarkID`, `resourceID`, `username`) VALUES
(6, 10, 'Mohammad'),
(9, 27, 'Navid98'),
(10, 55, 'Navid98');

-- --------------------------------------------------------

--
-- Table structure for table `comment_tbl`
--

CREATE TABLE `comment_tbl` (
  `commentID` int(11) NOT NULL,
  `commentText` text,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(255) DEFAULT NULL,
  `resourceID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment_tbl`
--

INSERT INTO `comment_tbl` (`commentID`, `commentText`, `date`, `username`, `resourceID`) VALUES
(17, 'ok!!', '2022-01-02 16:29:27', 'ali5381', 28),
(18, 'something', '2022-01-25 09:58:16', 'zeinab', 23),
(19, 'New Comment', '2022-01-25 10:52:33', 'Navid98', 56),
(20, 'Very good content', '2022-02-09 16:53:53', 'TrainSE5462Owner', 53);

-- --------------------------------------------------------

--
-- Table structure for table `course_coordinator_tbl`
--

CREATE TABLE `course_coordinator_tbl` (
  `ccID` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_coordinator_tbl`
--

INSERT INTO `course_coordinator_tbl` (`ccID`, `username`) VALUES
(1, 'Mohammad');

-- --------------------------------------------------------

--
-- Table structure for table `example_tbl`
--

CREATE TABLE `example_tbl` (
  `exampleID` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `resourceID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `example_tbl`
--

INSERT INTO `example_tbl` (`exampleID`, `title`, `link`, `resourceID`) VALUES
(2, 'UML Class Diagram Examples', 'https://www.edrawsoft.com/example-uml-class-diagram.html', 18),
(4, 'FullstackTodo', 'https://github.com/gmu-swe432/FullstackTodo', 57),
(5, 'sandbox', 'https://github.com/gmu-swe432/sandbox', 57),
(6, 'lecture7demos', 'https://github.com/gmu-swe432/lecture7demos', 57),
(7, 'lecture8demos', 'https://github.com/gmu-swe432/lecture8demos', 57),
(8, 'lecture10demos', 'https://github.com/gmu-swe432/lecture10demos', 57),
(9, 'See other examples here', 'https://github.com/gmu-swe432', 57),
(10, 'Object Role Modeling', 'http://www.orm.net/', 62),
(11, 'Training and consulting in data modeling', 'https://davidhaertzen.com/', 62),
(13, 'data modeling guru', 'https://www.essentialstrategies.com/', 62),
(14, 'software practitioners & architecture', 'https://www.slideshare.net/NeilErnst', 35),
(15, 'testing project', 'https://www.jku.at/en/institute-of-software-systems-engineering/teaching/project-and-thesis-topics/', 51),
(17, 'type of uml', 'https://developer.ibm.com/articles/an-introduction-to-uml/', 18);

-- --------------------------------------------------------

--
-- Table structure for table `field_tbl`
--

CREATE TABLE `field_tbl` (
  `fieldID` int(11) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(255) DEFAULT NULL,
  `imgName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `field_tbl`
--

INSERT INTO `field_tbl` (`fieldID`, `date`, `title`, `imgName`) VALUES
(1, '2021-12-25 00:00:00', 'Software Engineering', 'VG7op0Uw2k_TrainSE5462Owner_software-engineering.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `like_tbl`
--

CREATE TABLE `like_tbl` (
  `likeID` int(11) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `commentID` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `like_tbl`
--

INSERT INTO `like_tbl` (`likeID`, `date`, `commentID`, `username`) VALUES
(7, '2022-01-02 16:29:49', 17, 'ali5381'),
(8, '2022-01-02 16:30:27', 17, 'rayan'),
(9, '2022-01-02 16:30:41', 17, 'TrainSE5462Owner');

-- --------------------------------------------------------

--
-- Table structure for table `rate_tbl`
--

CREATE TABLE `rate_tbl` (
  `rateID` int(11) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `rateLevel` enum('5star','4star','3star','2star','1star','0star') DEFAULT NULL,
  `resourceID` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rate_tbl`
--

INSERT INTO `rate_tbl` (`rateID`, `date`, `rateLevel`, `resourceID`, `username`) VALUES
(16, '2022-01-02 16:29:18', '4star', 28, 'ali5381'),
(17, '2022-01-02 16:29:27', '4star', 28, 'ali5381'),
(18, '2022-01-25 09:58:26', '5star', 23, 'zeinab'),
(19, '2022-01-25 09:58:38', '5star', 23, 'zeinab'),
(20, '2022-01-25 10:52:25', '5star', 56, 'Navid98'),
(21, '2022-01-25 10:52:33', '5star', 56, 'Navid98'),
(22, '2022-01-25 10:54:18', '5star', 54, 'Navid98'),
(23, '2022-02-09 16:53:06', '4star', 53, 'TrainSE5462Owner'),
(24, '2022-02-09 16:53:53', '4star', 53, 'TrainSE5462Owner');

-- --------------------------------------------------------

--
-- Table structure for table `report_tbl`
--

CREATE TABLE `report_tbl` (
  `reportID` int(11) NOT NULL,
  `sentDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `checkoutDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `type` enum('Inappropriate Content','Inappropriate Content') DEFAULT NULL,
  `status` enum('Checked','Inappropriate Content') DEFAULT NULL,
  `resourceID` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `checker` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_tbl`
--

INSERT INTO `report_tbl` (`reportID`, `sentDate`, `checkoutDate`, `type`, `status`, `resourceID`, `username`, `checker`) VALUES
(7, '2022-01-02 16:24:20', '2022-01-02 16:38:28', '', 'Checked', 25, 'ali5381', 'rayan'),
(8, '2022-01-02 16:24:20', '2022-01-02 16:24:20', '', '', 25, 'ali5381', NULL),
(9, '2022-01-02 17:02:14', '2022-01-02 17:02:14', '', '', 25, 'TrainSE5462Owner', NULL),
(10, '2022-01-25 10:55:44', '2022-01-26 15:08:16', 'Inappropriate Content', 'Checked', 18, 'Navid98', 'TrainSE5462Owner');

-- --------------------------------------------------------

--
-- Table structure for table `resource_creator_tbl`
--

CREATE TABLE `resource_creator_tbl` (
  `creatorID` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resource_creator_tbl`
--

INSERT INTO `resource_creator_tbl` (`creatorID`, `username`) VALUES
(4, 'Mohammad'),
(6, 'rayan'),
(63, 'testAdmin123'),
(1, 'TrainSE5462Owner');

-- --------------------------------------------------------

--
-- Table structure for table `resource_tag_tbl`
--

CREATE TABLE `resource_tag_tbl` (
  `rtID` int(11) NOT NULL,
  `tagID` int(11) NOT NULL,
  `resourceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `resource_tag_tbl`
--

INSERT INTO `resource_tag_tbl` (`rtID`, `tagID`, `resourceID`) VALUES
(9, 6, 17),
(10, 7, 17),
(11, 8, 17),
(12, 9, 18),
(13, 10, 18),
(18, 15, 18),
(19, 16, 22),
(20, 17, 22),
(21, 18, 23),
(33, 9, 24),
(34, 17, 24),
(35, 16, 24),
(36, 24, 28),
(37, 25, 28),
(38, 26, 25),
(39, 9, 25),
(40, 16, 25),
(41, 27, 33),
(42, 28, 33),
(43, 29, 36),
(44, 30, 36),
(45, 7, 10),
(46, 31, 10),
(47, 32, 10),
(48, 33, 29),
(49, 34, 29),
(50, 35, 30),
(51, 34, 30),
(52, 36, 43),
(53, 37, 43),
(54, 38, 18),
(55, 39, 38),
(56, 40, 38),
(57, 41, 38),
(58, 42, 32),
(59, 43, 32),
(60, 44, 26),
(61, 26, 23),
(62, 45, 36),
(63, 46, 39),
(64, 47, 39),
(65, 48, 39),
(66, 49, 18),
(67, 50, 51),
(68, 51, 51),
(69, 52, 51),
(70, 51, 52),
(71, 53, 52),
(72, 52, 52),
(73, 54, 53),
(74, 55, 53),
(75, 56, 53),
(76, 57, 53),
(77, 58, 53),
(78, 3, 53),
(79, 51, 54),
(80, 40, 54),
(81, 41, 54),
(82, 59, 54),
(83, 60, 55),
(84, 61, 55),
(85, 62, 55),
(86, 63, 56),
(87, 64, 56),
(88, 59, 56),
(89, 62, 57),
(90, 65, 57),
(91, 66, 57),
(92, 67, 57),
(93, 62, 58),
(94, 68, 58),
(95, 3, 58),
(96, 64, 58),
(97, 69, 59),
(98, 70, 59),
(99, 71, 59),
(100, 69, 60),
(101, 9, 60),
(102, 72, 60),
(103, 73, 60),
(104, 74, 61),
(105, 75, 61),
(106, 76, 61),
(107, 77, 61),
(108, 71, 61),
(109, 78, 61),
(110, 79, 62),
(111, 80, 62),
(112, 81, 62);

-- --------------------------------------------------------

--
-- Table structure for table `resource_tbl`
--

CREATE TABLE `resource_tbl` (
  `resourceID` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `link` varchar(255) DEFAULT NULL,
  `imgName` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `creatorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resource_tbl`
--

INSERT INTO `resource_tbl` (`resourceID`, `title`, `description`, `link`, `imgName`, `duration`, `date`, `creatorID`) VALUES
(10, 'Udemy – Design Patterns in C# and .NET 2021-9', 'This course provides a comprehensive overview of Design Patterns in C# and .NET from a practical perspective. This course in particular covers patterns with the use of:', 'https://downloadly.ir/elearning/video-tutorials/design-patterns-in-csharp-and-dotnet-4/', 'P4FT587xSf_rayan_Design-Patterns-in-Csharp-and-dotnet-new.jpg', 1200, '2021-12-25 00:00:00', 6),
(17, 'Udemy – Design Patterns in TypeScript 2021-6', 'Learn All of the 23 GoF (Gang of Four) Design Patterns and Implemented them in TypeScript.\r\n\r\nDesign Patterns are descriptions or templates that can be repeatedly applied to commonly recurring problems during in software design.\r\n\r\nA familiarity of Design Patterns is very useful when planning, discussing, managing and documenting your applications from now and into the future.', 'https://downloadly.ir/elearning/video-tutorials/design-patterns-in-typescript/', '3KCQZca6mU_Mohammad_Design-Patterns-in-TypeScript.jpg', 304, '2021-12-25 00:00:00', 4),
(18, 'Udemy – Software Development From A to Z – OOP, UML, Agile, Python 2021-9', 'Are you interested in learning about software development?\r\nSoftware Development From A to Z is an informative course that provides insights into the software development industry. It covers topics such as Object-Oriented Programming, UML, Agile, SCRUM, and Python. You’ll learn about all of these things from a developer with decades of experience in the field.', 'https://downloadly.ir/elearning/video-tutorials/software-development-from-a-to-z-oop-uml-agile-and-more/', 'pcYX6k2ujW_Mohammad_Software-Development-From-A-to-Z-OOP-UML-Agile-and-more.jpg', 330, '2021-12-25 00:00:00', 4),
(20, 'Udemy – Design Patterns in JavaScript 2019-6', 'This course provides a comprehensive overview of Design Patterns in JavaScript from a practical perspective. This course in particular covers patterns with the use of:\r\n\r\nThe latest versions of the JavaScript programming language\r\n\r\nUse of modern programming libraries and frameworks\r\n\r\nUse of modern developer tools such as JetBrains WebStorm', 'https://downloadly.ir/elearning/video-tutorials/design-patterns-in-javascript/', 'Qjs3fAHJlB_TrainSE5462Owner_Design-Patterns-in-JavaScript.jpg', 603, '2021-12-25 00:00:00', 1),
(21, 'Security Engineering on AWS', 'This course demonstrates how to efficiently use AWS security services to stay secure in the AWS Cloud. The course focuses on the security practices that AWS recommends for enhancing the security of your data and systems in the cloud. The course highlights the security features of AWS key services including compute, storage, networking, and database services. You will also learn how to leverage AWS services and tools for automation, continuous monitoring and logging, and responding to security incidents.', 'https://aws.amazon.com/training/classroom/security-engineering-on-aws/', 'kFxyoCMqxt_TrainSE5462Owner_download (1).png', 1000, '2021-12-25 00:00:00', 1),
(22, 'Agile Software Development and the Three Faces of Simplicity', 'Simplicity should be simple, shouldnâ€™t it? Unfortunately, sometimes itâ€™s downright difficult. Most of the agile approaches to project management and software development espouse a principle of minimalism: do less, do better, and do swarms. In this article, Jim Highsmith of the Cutter Consortium discusses these three dimensions of simplicity.', 'https://www.informit.com/articles/article.aspx?p=25944', 'zp0YK0F1Za_Mohammad_what-is-agile.png', 17, '2022-01-01 00:00:00', 4),
(23, 'Ten tips on agile software development', 'Think you\'re organization is ready to transition to an agile software development process? Wondering how to make the move without breaking anything? Not sure how to make the transition stick? Joshua Kerievsky is the man to see.', 'https://www.theregister.com/2007/11/22/ten_agile_tips/', 'aW3U5HI5xb_Mohammad_10.png', 27, '2022-01-01 00:00:00', 4),
(24, 'Extreme Programming Roadmap', 'ExtremeProgramming system is a discipline of software development based on values of Simplicity, Communication, Feedback, and Aggressiveness.\r\nExtremeProgramming is expressed as a system of practices which balance each other to help keep projects on track.\r\nDelegating priority setting to the customer, if done blindly, could lead to a choice of features, and an order of those features, that might leave some key product capability too late. If the system is supposed to be a distributed database, but the priorities didn\'t call for any work on distribution until the last week, something bad might happen.', 'http://wiki.c2.com/?ExtremeProgrammingSystem', '8ZVaK84RPZ_Mohammad_Banner-image-Top-10-Agile-Strengths-Key-for-Enterprise-Performance.jpg', 15, '2022-01-01 00:00:00', 4),
(25, 'Scrum', 'Scrum is an agile way to manage a project, usually software development. Agile software development with Scrum is often perceived as a methodology; but rather than viewing Scrum as methodology, think of it as a framework for managing a process.', 'https://www.mountaingoatsoftware.com/agile/scrum', 'DLXcleEPHB_Mohammad_Thumbnail-_why-agile-software-factory-approach-best-to-rpa-development.png', 20, '2022-01-01 00:00:00', 4),
(26, 'software engineering ethics', 'JOHN EVELAND JOHN HOFFSTATTER SOFTWARE ENGINEERING CODE OF ETHICS', 'https://www.slideshare.net/inam12/software-engineering-ethics-48094822', 'tejRcyZz5f_rayan_ethic1.png', 20, '2022-01-01 00:00:00', 6),
(27, 'Waterfall Model', 'The Waterfall Model was the first Process Model to be introduced. It is also referred to as a linear-sequential life cycle model. It is very simple to understand and use. In a waterfall model, each phase must be completed before the next phase can begin and there is no overlapping in the phases.', 'https://www.tutorialspoint.com/sdlc/sdlc_waterfall_model.htm', 'bfsp9yTGnq_rayan_jira-waterfall-model.png', 12, '2022-01-01 00:00:00', 6),
(28, 'Requirements Engineering Key Practices', 'The software industry is exhibiting an increasing interest in requirements engineering â€” that is, understanding what you intend to build before youâ€™re done building it. Despite the hype of â€œInternet time,â€ companies across many business domains realize that time spent understanding the business problem is an excellent investment. Clients have told me theyâ€™re getting serious about requirements because the pain of having built poor products has simply become too great.', 'http://www.processimpact.com/articles/telepathy.html', '7psHVfHyli_Mohammad_1_QrlF0Iltcg6ZABW9D5QYyg.png', 35, '2022-01-01 00:00:00', 4),
(29, 'Users Involvement In The Requirements Engineering Process', 'Software requirements elicitation is the process where the customers\' needs in a software project are identified. This process is regarded as one of the most important parts of building a software system because during this stage it is decided precisely what will be built. However, requirements gathering needs close interaction between developers and end-users of the system. If developers and end-users are in different organizations or different cities, meetings can be costly, inconvenient and infrequent. This leads to problems of communication, which can greatly impact the quality of the elicited requirements. Well known requirements engineering methodologies are presented in this paper and the degree of the user involvement in the process of requirements negotiation is discussed. The system called TeamRooms integrates the rich applications and interfaces found in the existing real-time groupware applications, providing a persistent work space suitable for synchronous and asynchronous collaboration. TeamRooms may be used as a method of distance collaboration between the knowledge engineer, the developer who elicits the information, and the domain expert, the knowledgeable end-user. It encapsulates both structured and unstructured work through its applications and also takes into account individual and group work.', 'http://ksi.cpsc.ucalgary.ca/KAW/KAW96/herlea/FINAL.html', 'UMH3BjZcoK_Mohammad_software-requirement-specifications.jpg', 94, '2022-01-01 00:00:00', 4),
(30, 'Requirements Engineering Patterns', 'Requirements engineeringâ€“the elicitation, documentation and validation of requirementsâ€“is a fundamental aspect of software development. Unfortunately, and to the detriment of everyone involved, requirements engineering efforts are often shortchanged or even completely forgone in favor of \"getting the code out as soon as possible, at all cost.\" This month I share my experiences and observations regarding requirements engineering, present several requirements engineering patterns that you should find valuable to your software development efforts, and suggest several good books that describe how to successfully engineer requirements.', 'https://www.drdobbs.com/requirements-engineering-patterns/184414612', 'ivLnkOYazC_Mohammad_training-requirements-engineering-495x400.jpg', 100, '2022-01-01 00:00:00', 4),
(31, 'Requirements management', 'A couple of weeks ago, I was peer reviewing some work by a colleague. I was struggling to communicate what was and what was not covered by the popular agile processes  - what I call the scope of the process. For example, Scrum and eXtreme Programming essentially focus on a single small, cross-functional, development team. At a fundamental level, they do not cover larger teams or projects or organizations consisting of many small dependent teams. They say little about how customers or product owners decide on the business value and priority of the user stories or backlog items they create. Neither do they say much about working with a formal testing organization.', 'https://borland.typepad.com/agile_transformation/requirements_management/', 'knXJ0wkVEu_Mohammad_Stages-in-the-requirements-management-process-cycle_Q640.jpg', 55, '2022-01-01 00:00:00', 4),
(32, 'Software Engineerig | Classical Waterfall Model', 'Classical waterfall model is the basic software development life cycle model. It is very simple but idealistic. Earlier this model was very popular but nowadays it is not used. But it is very important because all the other software development life cycle models are based on the classical waterfall model.', 'https://www.geeksforgeeks.org/software-engineering-classical-waterfall-model/', '4slqYFZIwU_rayan_waterfall-model-featured.jpg', 15, '2022-01-01 00:00:00', 6),
(33, 'Software Architecture Quality Attributes', 'Following on to my previous blog-entry about Software Architecture Views and Perspectives, the book \"Software Architecture in Practice\" also describes a method called Attribute-Driven Design or ADD. This is not yet-another-design-method like BDD or TDD. ADD is concerned software architectural design (so it\'s at the \"architecture-level\" rather than what we might normally think of as the \"design-level\").', 'http://bradapp.blogspot.com/2008/02/software-architecture-quality.html', 'OvhFibNlaz_Mohammad_Screenshot-2021-06-15-at-12.49.07.png', 15, '2022-01-01 00:00:00', 4),
(34, 'Incremental development', 'Incremental Model is a process of software development where requirements divided into multiple standalone modules of the software development cycle. In this model, each module goes through the requirements, design, implementation and testing phases. Every subsequent release of the module adds function to the previous release. The process continues until the complete system achieved.', 'https://www.javatpoint.com/software-engineering-incremental-model', 'vwCNMByboa_rayan_incremental.jpg', 20, '2022-01-01 00:00:00', 6),
(35, 'An Introduction to Software Architecture', 'As the size of software systems increases, the algorithms and data structures of the computation no longer constitute the major design problems.  When systems are constructed from many components, the organization of the overall systemâ€”the software architectureâ€”presents a new set of design problems.  This level of design has been addressed in a number of ways including informal diagrams and descriptive terms, module interconnection languages, templates and frameworks for systems that serve the needs of specific domains, and formal models of component integration mechanisms. In this paper we provide an introduction to the emerging field of software architecture.  We begin by considering a number of common architectural styles upon which many systems are currently based and show how different styles can be combined in a single design.  Then we present six case studies to illustrate how architectural representations can improve our understanding of complex software systems.  Finally, we survey some of the outstanding problems in the field, and consider a few of the promising research directions.', 'http://www.cs.cmu.edu/afs/cs/project/vit/ftp/pdf/intro_softarch.pdf', '5PTq0ocn1Y_Mohammad_An-Introduction-to-Software-Architecture-OpenLibra1.jpg', 220, '2022-01-01 00:00:00', 4),
(36, 'Architectural  Blueprintsâ€”The  â€œ4+1â€ View Model of  Software Architecture', 'This  article presents  a model for describing  the architecture of  software-intensive  systems,  based on  the use of  multiple, concurrent  views. This use of  multiple views allows  to  address separately  the concerns  of  the various  â€˜stakeholdersâ€™  of  the architecture: end-user, developers, systems  engineers,  project managers, etc., and  to  handle separately  the functional and  non  functional requirements. Each  of  the five  views is described, together with  a notation  to capture it. The views  are designed using  an  architecture-centered, scenariodriven, iterative development process. Keywords: software architecture, view, object-oriented design,  software development process', 'http://www.cs.ubc.ca/~gregor/teaching/papers/4+1view-architecture.pdf', 's3mStVQegF_Mohammad_4+1_Architectural_View_Model.svg.png', 150, '2022-01-01 00:00:00', 4),
(37, 'Software Requirement Specification (SRS) Format', 'Software Requirement Specification (SRS) Format as name suggests, is complete specification and description of requirements of software that needs to be fulfilled for successful development of software system. These requirements can be functional as well as non-functional depending upon type of requirement. The interaction between different customers and contractor is done because its necessary to fully understand needs of customers.', 'https://www.geeksforgeeks.org/software-requirement-specification-srs-format/', 'VZWVIP6x9I_rayan_software_requirement_specification.jpg', 25, '2022-01-01 00:00:00', 6),
(38, 'Verification and Validation Testing', 'Verification testing includes different activities such as business requirements, system requirements, design review, and code walkthrough while developing a product.\r\n\r\nIt is also known as static testing, where we are ensuring that \"we are developing the right product or not\". And it also checks that the developed application fulfilling all the requirements given by the client.', 'https://www.javatpoint.com/verification-and-validation-testing', 'A1Z4BEZ9ur_rayan_Annotation 2022-01-01 214806.jpg', 15, '2022-01-01 00:00:00', 6),
(39, 'Software Engineering | Software Evolution', 'Software Evolution is a term which refers to the process of developing software initially, then timely updating it for various reasons, i.e., to add new features or to remove obsolete functionalities etc. The evolution process includes fundamental activities of change analysis, release planning, system implementation and releasing a system to customers. ', 'https://www.geeksforgeeks.org/software-engineering-software-evolution/', 'XKCWo8onso_rayan_evolution-1200x494.jpg', 25, '2022-01-01 00:00:00', 6),
(40, 'Agile Software Development', 'MIT CMS.611J Creating Video Games, Fall 2014\r\nInstructor: Sara Verrilli', 'https://www.youtube.com/watch?v=UxMpn92vGXs', 'qkUg2kPthx_TrainSE5462Owner_1__2b6wH3mJ8RkW9BMvY-ydw.png', 77, '2022-01-01 00:00:00', 1),
(41, 'Coursera â€“ Software Design and Architecture Specialization 2021-2', 'In the Software Design and Architecture Specialization, you will learn how to apply design principles, patterns, and architectures to create reusable and flexible software applications and systems. You will learn how to express and document the design and architecture of a software system using a visual notation.\r\n\r\nPractical examples and opportunities to apply your knowledge will help you develop employable skills and relevant expertise in the software industry.', 'https://downloadly.ir/elearning/video-tutorials/software-design-and-architecture-specialization/', 'RW35HtOVke_TrainSE5462Owner_Software-Design-and-Architecture-Specialization.png', 640, '2022-01-01 00:00:00', 1),
(42, 'MySQL Tutorial for Beginners', 'I uploaded a 3-hour tutorial on SQL with MySQL to my YouTube channel. Enjoy!', 'https://www.youtube.com/watch?v=7S_tz1z_5bA', 'NfkWaxW8ZA_TrainSE5462Owner_mysql_mosh_yt.jpg', 190, '2021-12-31 00:00:00', 1),
(43, 'Introduction to Software Testing or Software QA', 'Learn what is ahead in Software Testing or Software QA.\r\nLearn what to expect form Software Testing career.\r\nLearn how to get started in Software Testing or Software QA field.', 'https://www.udemy.com/course/introduction-to-software-testing-or-software-qa/', '8D9B7Lz2hg_TrainSE5462Owner_QA-2.jpeg', 60, '2022-01-02 00:00:00', 1),
(51, 'Design for Testability in Software Systems', 'Building reliable software is becoming more and more important considering that\r\nsoftware applications are becoming pervasive in our daily lives. The need for more\r\nreliable software requires that, amongst others, it is adequately tested to give greater\r\nconfidence in its ability to perform as expected. However, testing software becomes a\r\ntedious task as the size and complexity of software increases, therefore, the next logical\r\nstep is to make the task of testing easier and more effective. In other words, improving\r\non the testability of the software. Improvement of testability can be achieved through\r\napplying certain tactics in practice that improve on a testerâ€™s ability to manipulate the\r\nsoftware and to observe and interpret the results from the execution of tests.', 'https://azaidman.github.io/MScThesis/MuloEmmanuel.pdf', 'i9pMk9jCAn_rayan_software_test.jpg', 180, '2022-01-24 00:00:00', 6),
(52, 'Automatic Unit Test Generation', 'While test generators have the potential to significantly reduce the costs of software testing and have the ability to increase the quality of the software tests (and thus,\r\nthe software itself), they unfortunately have only limited support for testing objectoriented software and their underlying test generation techniques fail to scale up to\r\nsoftware of industrial size and complexity. In this context, we developed JTestCraft,\r\na state-of-the-art test generator for the Java programming that deals effectively with\r\nall object-oriented programming concepts, such as object array types, inheritance and\r\npolymorfism. Furthermore, JTestCraft can locate all relevant test cases due to the use\r\nof the novel Candidate Sequence Search algorithm. Other novel concepts introduced\r\nin this thesis include the Constraint Tree data-structure to improve scalability and the\r\nHeap Simulation Representation to simplify the implementation of the test generator.\r\nWe evaluated JTestCraft by looking at its ability to generate tests that obtain high code\r\ncoverage and compare the results to human crafted tests. In addition, the performance\r\nof JTestCraft is compared against similar tools. Finally, we give pointers for further\r\nresearch to improve the performance and usability of future test generators.', 'https://azaidman.github.io/MScThesis/MennoDenHollander.pdf', 'WYnM6mG76m_rayan_automate_test.jpg', 210, '2022-01-24 00:00:00', 6),
(53, 'Automated Testing with Targeted Event Sequence Generation', 'Automated software testing aims to detect errors by producing test inputs that cover as much of the application source code as possible. Applications for mobile devices are typically event-driven, which raises the challenge of automatically producing event sequences that result in high coverage. Some existing approaches use random or model-based testing that largely treats the application as a black box. Other approaches use symbolic execution, either starting from the entry points of the applications or on specific event sequences. A common limitation of the existing approaches is that they often fail to reach the parts of the application code that require more complex event sequences. We propose a two-phase technique for automatically finding event sequences that reach a given target line in the application code. The first phase performs concolic execution to build summaries of the individual event handlers of the application. The second phase builds event sequences backward from the target, using the summaries together with a UI model of the application. Our experiments on a collection of open source Android applications show that this technique can successfully produce event sequences that reach challenging targets.', 'https://cs.au.dk/~amoeller/papers/collider/paper.pdf', 'hLwjkkzrOv_TrainSE5462Owner_Automation_Testing.jpg', 85, '2022-01-25 00:00:00', 1),
(54, 'Software Testing Verification Validation and Quality Assurance', 'This course will use The Fuzzing Book as the main textbook, and students can refer to following books for other background knowledge.\r\nStatic Program Analysis\r\nThe Debugging Book\r\nComputer Security and the Internet: Tools and Jewels\r\nThe Art and Science of Analyzing Software Data (using UTD email to access)\r\nDive into Deep Learning\r\nBuilding Intelligent Systems: A Guide to Machine Learning Engineering (using UTD email to access)\r\nHands-On Machine Learning with Scikit-Learn, Keras, and TensorFlow (using UTD email to access)', 'http://youngwei.com/page/CS4367-001-22S/index.html', 'field_topic_default.png', 240, '2022-01-25 00:00:00', 6),
(55, 'Concurrent & Distributed Systems', 'Learning Outcomes:\r\nDemonstrate an ability to design and implement concurrent programs\r\nDemonstrate an understanding of the fundamental concepts in synchronizing concurrent processes and threads by using locks, semaphores and monitors\r\nDemonstrate an ability to design and implement distributed programs using current middleware technologies\r\nDemonstrate an understanding of the fundamental concepts underlying distributed programming including message passing and remote procedure calls', 'https://www.jonbell.net/gmu-cs-475-fall-2019/', '9QrTT90Gt5_TrainSE5462Owner_h3p8zdhgw38ev4une3ev.png', 1800, '2022-01-25 00:00:00', 1),
(56, 'Software Analysis & Security', 'you can refering to following books for background knowledge.\r\nStatic Program Analysis\r\nThe Fuzzing Book\r\nThe Debugging Book\r\nComputer Security and the Internet: Tools and Jewels\r\nThe Art and Science of Analyzing Software Data (using UTD email to access)\r\nSecurity in Computing (using UTD email to access)\r\nDive into Deep Learning\r\nBuilding Intelligent Systems: A Guide to Machine Learning Engineering (using UTD email to access)\r\nHands-On Machine Learning with Scikit-Learn, Keras, and TensorFlow (using UTD email to access)', 'http://youngwei.com/page/CS7301-007-21F/index.html', 'field_topic_default.png', 260, '2022-01-25 00:00:00', 6),
(57, 'Web Application Development', 'Learning Outcomes\r\nKnowledge of quantitative engineering principles for how to build software user interfaces, especially web-based user interfaces, that are usable\r\nUnderstanding the client-server and message-passing computing models in the context of web applications\r\nKnowledge for how to build usable, secure and effective web applications\r\nTheoretical and practical knowledge about how data are stored and shared in web applications\r\nComponent software development using specific technologies including Javascript, NodeJS, JSON, React and Firebase\r\nUnderstanding that usability is more important than efficiency for almost all modern software projects, and often the primary factor that leads to product success', 'https://www.jonbell.net/swe-432-fall-2018-web-programming/', 'LJyyEQgteX_TrainSE5462Owner_term1.png', 1800, '2022-01-25 00:00:00', 1),
(58, 'Program Analysis for Software Testing', 'Learn different methods for analyzing software, with several applications in software engineering, particularly testing. We will study different analysis techniques, learn how they work by studying specific algorithms and tools, and discuss applications of the techniques. Our goal will be to explore the current research issues in this cutting edge area, to learn how to build software analysis tools, and to understand how these techniques can be applied to software development activities.\r\n\r\nWe will primarily focus on applications for testing software, including automatic test data generation. We will also consider using analysis techniques for other software related activities such as maintenance, reuse, metrics, and optimization. Some of the specific analysis techniques to be studied are parsing, software representation methods (control flow graphs, data flow graphs, program dependency graphs), symbolic evaluation, constraints, program slicing, software coupling, and testability.\r\n\r\nWhile we will consider analyses in various languages (e.g. applying to native x86 binaries, Java and JavaScript), there will be a particular emphasis towards Java analysis. Students will complete a research project involving dynamic analysis of Java applications.', 'https://www.jonbell.net/swe-795-fall-17-program-analysis-for-software-testing/', 'nwWHuye0GD_TrainSE5462Owner_download (1).png', 1500, '2022-01-25 00:00:00', 1),
(59, 'Challenges and Strategies for Managing Requirements Selection in Software Ecosystems', 'The last decade, deemed the age of the platform [1], saw a major shift in how software organizations operate and leverage platforms as a flavor of open innovation to extend their markets or â€œgrow the pieâ€ [2]. These platforms are used to underpin and form Software Ecosystems (SECOs) through which the platform provider, also known as the keystone organization, can partner and innovate together with other organizations [3]. Examples include the popular tool suite Atlassian1 or the communication hub Slack2, which maintain thriving Marketplaces comprised of add-ons or third-party software integrations that extend the functionality of their own oâ†µerings.', 'https://kblincoe.github.io/publications/2020_IEEESW_Ecosystems.pdf', 'rjlW5ozwZa_TrainSE5462Owner_requirements-engineering-4-graph1.jpg', 115, '2022-01-25 00:00:00', 1),
(60, 'What Drives and Sustains Self-Assignment in Agile Teams', 'â€”Self-assignment, where software developers choose their own tasks, is a common practice in agile teams. However, it is not known why developers select certain tasks. It is important for managers to be aware of these reasons to ensure sustainable selfassignment practices. We investigated developersâ€™ preferences while they are choosing tasks for themselves. We collected data from 42 participants working in 25 different software companies. We applied Grounded Theory procedures to study and analyse factors for self-assigning tasks, which we grouped into three categories: task-based, developer-based, and opinion-based. We found that developers have individual preferences and not all factors are important to every developer. Managers share some common and varying perspectives around the identified factors. Most managers want developers to give higher priority to certain factors. Developers often need to balance between task priority and their own individual preferences, and managers facilitate this through a variety of strategies. More risk-averse managers encourage expertise-based self-assignment to ensure tasks are completed quickly. Managers who are riskbalancing encourage developers to choose tasks that provide learning opportunities only when there is little risk of delays or reduced quality. Finally, growth-seeking managers regularly encourage team members to pick tasks outside their comfort zone to encourage growth opportunities. Our findings will help managers to understand what developers consider when self-assigning tasks and help them empower their teams to practice self-assignment in a sustainable manner.', 'https://kblincoe.github.io/publications/2021_TSE_Self_Assignment.pdf', 'uTW199IMMK_TrainSE5462Owner_Agile business cover 1.png', 100, '2022-01-25 00:00:00', 1),
(61, 'A method for analyzing stakeholdersâ€™ influence on an open source software ecosystemâ€™s requirements engineering process', 'For a firm in an open source software (OSS) ecosystem, the requirements engineering (RE) process is rather multifaceted. Apart from its typical RE process, there is a competing process, external to the firm and inherent to the firmâ€™s ecosystem. When trying to impose an agenda in competition with other firms, and aiming to align internal product planning with the ecosystemâ€™s RE process, firms need to consider who and how influential the other stakeholders are, and what their agendas are. The aim of the presented research is to help firms identify and analyze stakeholders in OSS ecosystems, in terms of their influence and interactions, to create awareness of their agendas, their collaborators, and how they invest their resources. To arrive at a solution artifact, we applied a design science research approach where we base artifact design on the literature and earlier work. A stakeholder influence analysis (SIA) method is proposed and demonstrated in terms of applicability and utility through a case study on the Apache Hadoop OSS ecosystem. SIA uses social network constructs to measure the stakeholdersâ€™ influence and interactions and considers the special characteristics of OSS RE to help firms structure their stakeholder analysis processes in relation to an OSS ecosystem. SIA adds a strategic aspect to the stakeholder analysis process by addressing the concepts of influence and interactions, which are important to consider while acting in collaborative and meritocratic RE cultures of OSS ecosystems.', 'https://link.springer.com/article/10.1007%2Fs00766-019-00310-3', '0jqcYJDndf_TrainSE5462Owner_Stages-in-the-requirements-management-process-cycle_Q640.jpg', 135, '2022-01-25 00:00:00', 1),
(62, 'Data Modeling Resource Center', 'Data modeling is a critical skill for IT professionals including: database administrators (DBAs), data modelers, business analysts and software developers. It is an essential ingredient of nearly all IT projects. Without a data model there is no blueprint for the design of the database\r\nWhat is Data Modeling?\r\nData modeling is the process of creating and extending data models which are visual representations of data and its organization. The ERD Diagram (Entity Relationship Diagram) is the most popular type of data model. Data models exist at multiple levels including:\r\n\r\nThe Conceptual Data Model describes data from a high level. It defines the problem rather than the solution from the business point of view. It includes entities and their relationships. Typically the conceptual data model is developed first.\r\nThe Logical Data Model describes a logical solution to a data project. It provides more details than the conceptual data model and is nearly ready for the creation of a database. These details include attributes, the individual pieces of information that will be included. Typically the logical data model is developed second.\r\nThe Physical Data Model describes the implementation of data in a physical database. It is the blueprint for the database. Typically the physical data model is developed third.', 'http://infogoal.com/dmc/dmcdmd.htm', 'MvC5YHD9Qm_TrainSE5462Owner_home_pic.png', 0, '2022-01-25 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `status_tbl`
--

CREATE TABLE `status_tbl` (
  `session` char(100) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_tbl`
--

INSERT INTO `status_tbl` (`session`, `time`) VALUES
('cbvavr9j8j855mu7jhod8vtot0', 1645681326);

-- --------------------------------------------------------

--
-- Table structure for table `student_tbl`
--

CREATE TABLE `student_tbl` (
  `studentID` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_tbl`
--

INSERT INTO `student_tbl` (`studentID`, `username`) VALUES
(3, 'ali'),
(4, 'ali5381'),
(7, 'hanie'),
(5, 'mina'),
(1, 'Mohammad'),
(8, 'Navid98'),
(2, 'rayan'),
(6, 'zeinab');

-- --------------------------------------------------------

--
-- Table structure for table `suggest_resource_tbl`
--

CREATE TABLE `suggest_resource_tbl` (
  `suggestID` int(11) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `studentID` int(11) DEFAULT NULL,
  `ccID` int(11) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `description` text,
  `status` enum('checked','unchecked','','') NOT NULL DEFAULT 'unchecked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suggest_resource_tbl`
--

INSERT INTO `suggest_resource_tbl` (`suggestID`, `date`, `studentID`, `ccID`, `link`, `description`, `status`) VALUES
(31, '2022-01-02 17:17:05', 3, NULL, 'https://quera.ir/blog/how-react-hooks-work-in-simple-words/', 'react Hooks work in simple words', 'checked'),
(32, '2022-01-25 10:57:45', 8, NULL, 'https://templink.com/tempdir', 'Test', 'checked');

-- --------------------------------------------------------

--
-- Table structure for table `suggest_topic_tbl`
--

CREATE TABLE `suggest_topic_tbl` (
  `suggestID` int(11) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `adminID` int(11) DEFAULT NULL,
  `ccID` int(11) DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `field` varchar(255) NOT NULL,
  `status` enum('checked','unchecked','','') NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suggest_topic_tbl`
--

INSERT INTO `suggest_topic_tbl` (`suggestID`, `date`, `adminID`, `ccID`, `topic`, `field`, `status`, `description`) VALUES
(2, '2022-01-02 00:00:00', 1, 1, 'Javascript', 'Software Engineering', 'unchecked', 'Ino add kon khaheshan');

-- --------------------------------------------------------

--
-- Table structure for table `tag_tbl`
--

CREATE TABLE `tag_tbl` (
  `tagID` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` char(200) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tag_tbl`
--

INSERT INTO `tag_tbl` (`tagID`, `date`, `title`) VALUES
(3, '2022-01-19 12:26:44', 'software_testing'),
(4, '2022-01-19 12:26:44', 'test_first_developement'),
(5, '2022-01-19 12:26:44', 'test'),
(6, '2022-01-24 08:58:09', 'design'),
(7, '2022-01-24 08:58:09', 'design_pattern'),
(8, '2022-01-24 08:58:09', 'design_system'),
(9, '2022-01-24 12:21:05', 'agile'),
(10, '2022-01-24 12:21:05', 'uml'),
(15, '2022-01-24 12:42:35', 'uml_diagram'),
(16, '2022-01-24 12:43:58', 'agile_development'),
(17, '2022-01-24 12:45:06', 'agile_methodologies'),
(18, '2022-01-24 12:49:18', 'agile_methodologie'),
(21, '2022-01-24 13:03:45', 'uml_design'),
(22, '2022-01-24 13:03:45', 'uml_development'),
(23, '2022-01-24 13:24:07', 'uml_example'),
(24, '2022-01-24 13:27:18', 'requirements'),
(25, '2022-01-24 13:27:18', 'requirement_management'),
(26, '2022-01-24 13:29:01', 'scrum'),
(27, '2022-01-24 13:59:30', 'architecture'),
(28, '2022-01-24 13:59:30', 'architecture_visualization'),
(29, '2022-01-24 16:59:28', 'architecture_diagram'),
(30, '2022-01-24 16:59:28', 'architecture_component'),
(31, '2022-01-24 17:00:41', 'c_sharp'),
(32, '2022-01-24 17:00:41', 'mosh_hamedani'),
(33, '2022-01-24 17:02:44', 'requierment_management'),
(34, '2022-01-24 17:02:44', 'requirement_specification'),
(35, '2022-01-24 17:02:56', 'pattern'),
(36, '2022-01-24 17:04:19', 'test_driven'),
(37, '2022-01-24 17:04:19', 'test_automation'),
(38, '2022-01-24 22:31:09', 'agile_methodology'),
(39, '2022-01-24 22:32:53', 'testing'),
(40, '2022-01-24 22:32:53', 'validation'),
(41, '2022-01-24 22:32:53', 'Verification'),
(42, '2022-01-24 22:33:46', 'waterfall'),
(43, '2022-01-24 22:33:46', 'process_model'),
(44, '2022-01-24 22:34:50', 'ethics'),
(45, '2022-01-24 22:36:43', 'process_view'),
(46, '2022-01-24 22:38:13', 'evolution'),
(47, '2022-01-24 22:38:13', 'system_implementation'),
(48, '2022-01-24 22:38:13', 'planning'),
(49, '2022-01-24 22:51:57', 'class_diagram'),
(50, '2022-01-25 07:17:25', 'software_design'),
(51, '2022-01-25 07:17:25', 'software_test'),
(52, '2022-01-25 07:17:25', 'Andy_Zaidman'),
(53, '2022-01-25 07:25:24', 'unit_testing'),
(54, '2022-01-25 07:30:52', 'anders_moller'),
(55, '2022-01-25 07:30:52', 'automated_testing'),
(56, '2022-01-25 07:30:52', 'aarhus_university'),
(57, '2022-01-25 07:30:52', 'casper_s_jensen'),
(58, '2022-01-25 07:30:52', 'mukul_r_prasad'),
(59, '2022-01-25 07:37:09', 'Wei_Yang'),
(60, '2022-01-25 07:38:36', 'concurrent_systems'),
(61, '2022-01-25 07:38:36', 'distributed_systems'),
(62, '2022-01-25 07:38:36', 'jonathan_bell'),
(63, '2022-01-25 07:42:45', 'software_security'),
(64, '2022-01-25 07:42:45', 'software_analysis'),
(65, '2022-01-25 07:51:12', 'quantitative_engineering'),
(66, '2022-01-25 07:51:12', 'client_server'),
(67, '2022-01-25 07:51:12', 'message_passing'),
(68, '2022-01-25 07:57:53', 'program_analysis'),
(69, '2022-01-25 08:02:08', 'kelly_blincoe'),
(70, '2022-01-25 08:02:08', 'requirements_selection'),
(71, '2022-01-25 08:02:08', 'requirement_engineering'),
(72, '2022-01-25 08:05:24', 'self_assignment'),
(73, '2022-01-25 08:05:24', 'aglie_methodology'),
(74, '2022-01-25 08:11:31', 'johan_linaker'),
(75, '2022-01-25 08:11:31', 'daniela_damian'),
(76, '2022-01-25 08:11:31', 'bjorn_regnell'),
(77, '2022-01-25 08:11:31', 'open_source'),
(78, '2022-01-25 08:11:31', 'stakeholder_influence'),
(79, '2022-01-25 10:29:58', 'data_modeling'),
(80, '2022-01-25 10:29:58', 'process_mode'),
(81, '2022-01-25 10:29:58', 'Object_Role_Modeling');

-- --------------------------------------------------------

--
-- Table structure for table `topic_resource_tbl`
--

CREATE TABLE `topic_resource_tbl` (
  `trID` int(11) NOT NULL,
  `topicID` int(11) DEFAULT NULL,
  `resourceID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topic_resource_tbl`
--

INSERT INTO `topic_resource_tbl` (`trID`, `topicID`, `resourceID`) VALUES
(10, 6, 10),
(17, 6, 17),
(18, 1, 18),
(19, 4, 18),
(21, 6, 20),
(22, 2, 21),
(23, 1, 22),
(24, 1, 23),
(25, 1, 24),
(26, 1, 25),
(27, 7, 26),
(28, 8, 27),
(29, 10, 28),
(30, 10, 29),
(31, 10, 30),
(32, 10, 31),
(33, 8, 32),
(34, 3, 33),
(35, 8, 34),
(36, 3, 35),
(37, 3, 36),
(38, 9, 37),
(39, 9, 38),
(40, 9, 39),
(41, 1, 40),
(42, 6, 41),
(43, 2, 42),
(44, 10, 42),
(45, 5, 43),
(95, 3, 51),
(96, 5, 51),
(97, 6, 51),
(98, 5, 52),
(99, 5, 53),
(100, 5, 54),
(101, 12, 54),
(102, 13, 54),
(103, 14, 55),
(104, 15, 56),
(105, 5, 57),
(106, 14, 57),
(107, 5, 58),
(108, 10, 59),
(109, 1, 60),
(110, 10, 61),
(111, 8, 62);

-- --------------------------------------------------------

--
-- Table structure for table `topic_tbl`
--

CREATE TABLE `topic_tbl` (
  `topicID` int(11) NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `fieldID` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `imgName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topic_tbl`
--

INSERT INTO `topic_tbl` (`topicID`, `date`, `fieldID`, `title`, `imgName`) VALUES
(1, '2021-12-25 00:00:00', 1, 'Agile Software Development', 'BVRcnHilma_TrainSE5462Owner_Agile.jpg'),
(2, '2021-12-25 00:00:00', 1, 'Safety Engineering', 'jBKLj4xwhN_TrainSE5462Owner_safety engineering.png'),
(3, '2021-12-25 00:00:00', 1, 'Software Architecture', '1R9qL6txa0_TrainSE5462Owner_Software Architecture.png'),
(4, '2021-12-25 00:00:00', 1, 'UML Design', 'zeOdm1Vy5l_rayan_images.png'),
(5, '2021-12-25 00:00:00', 1, 'Software Testing', 'vsdI1J0nTs_rayan_images (1).png'),
(6, '2021-12-25 00:00:00', 1, 'Design Pattern', 'IfS3BDYfsx_rayan_software-design-pattern.jpg'),
(7, '2022-01-01 00:00:00', 1, 'Ethic', 'field_topic_default.png'),
(8, '2022-01-01 00:00:00', 1, 'Software process model', 'field_topic_default.png'),
(9, '2022-01-01 00:00:00', 1, 'Process activities', 'field_topic_default.png'),
(10, '2022-01-01 00:00:00', 1, 'Requirements Engineering', 'field_topic_default.png'),
(12, '2022-01-25 00:00:00', 1, 'Software Verification', 'field_topic_default.png'),
(13, '2022-01-25 00:00:00', 1, 'Software Validation', 'field_topic_default.png'),
(14, '2022-01-25 00:00:00', 1, 'Distributed Systems', 'kxReFn6R9O_TrainSE5462Owner_h3p8zdhgw38ev4une3ev.png'),
(15, '2022-01-25 00:00:00', 1, 'Software Security', 'field_topic_default.png'),
(16, '2022-01-13 00:00:00', 1, 'TEST Category', 'field_topic_default.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `username` varchar(255) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `imgName` varchar(255) DEFAULT NULL,
  `role` enum('student','cc','admin','owner') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`username`, `firstName`, `lastName`, `email`, `password`, `imgName`, `role`) VALUES
('ali', 'alii', 'Haghighat', 'ali12@yahoo.com', '6c71dffdab29ca4d91d0cf293dc82c61', 'LLYh1Xyk04_ali_photo_2021-12-25_13-57-44.jpg', 'student'),
('ali5381', 'ali', 'hghighat1', 'hamoodhaqiqat@gmail.com', '6c71dffdab29ca4d91d0cf293dc82c61', 'fOO0dtFPSv_ali5381_Azad_University_logo.png', 'student'),
('hanie', 'hanie', 'veysian', 'hanie.veysian@gmail.com', '40f7966f1cef3195cc60e9a64b004a31', NULL, 'student'),
('mina', 'mina', 'nayernia', 'mina.nayernia@gmail.com', '01907aff5d356d5b0e03a963ff673745', NULL, 'student'),
('Mohammad', 'Mohammad', 'Eshrati', 'mohammad1379@gmail.com', '01907aff5d356d5b0e03a963ff673745', 'THPag3U1YS_Mohammad_nneyk3zq4ix21.jpg', 'cc'),
('Navid98', 'Navid', 'Fayezi', 'navidfayezi.98@gmail.com', 'cb7d76c7608bbc3856cc219b85db05bc', NULL, 'student'),
('newCC', 'newCC', 'newCC', '1224@gmail.com', '9d34e0dde4a54b10d6e61915961633ba', NULL, 'student'),
('rayan', 'amir', 'heidari', 'rayan79@yahoo.com', '547090c6604e42f87054cfd316d81c6f', 'OBfNCS0pdR_rayan_photo_2021-12-25_13-55-03.jpg', 'admin'),
('testAdmin123', 'Test', 'Admin', 'yasin2017me@gmail.com', 'f254d05e3b099df1d2cc7054d939de5b', NULL, 'student'),
('TrainSE5462Owner', 'Ali', 'Asnaashari', 'Ali.asnaashari2000@gmail.com', '6c71dffdab29ca4d91d0cf293dc82c61', 'DqQTjHUZ0v_TrainSE5462Owner_photo.jpg.jpg', 'owner'),
('zeinab', 'zeinab', 'kamkar', 'zeinab.kamkar@gmail.com', 'c6c2612495028fae0c7bc3de981abc07', 'b03bqJthB5_zeinab_Screenshot (9).png', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD PRIMARY KEY (`adminID`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `bookmark_tbl`
--
ALTER TABLE `bookmark_tbl`
  ADD PRIMARY KEY (`bookmarkID`),
  ADD KEY `username` (`username`),
  ADD KEY `resourceID` (`resourceID`);

--
-- Indexes for table `comment_tbl`
--
ALTER TABLE `comment_tbl`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `resourceID` (`resourceID`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `course_coordinator_tbl`
--
ALTER TABLE `course_coordinator_tbl`
  ADD PRIMARY KEY (`ccID`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `example_tbl`
--
ALTER TABLE `example_tbl`
  ADD PRIMARY KEY (`exampleID`),
  ADD KEY `resourceID` (`resourceID`);

--
-- Indexes for table `field_tbl`
--
ALTER TABLE `field_tbl`
  ADD PRIMARY KEY (`fieldID`);

--
-- Indexes for table `like_tbl`
--
ALTER TABLE `like_tbl`
  ADD PRIMARY KEY (`likeID`),
  ADD KEY `commentID` (`commentID`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `rate_tbl`
--
ALTER TABLE `rate_tbl`
  ADD PRIMARY KEY (`rateID`),
  ADD KEY `resourceID` (`resourceID`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `report_tbl`
--
ALTER TABLE `report_tbl`
  ADD PRIMARY KEY (`reportID`),
  ADD KEY `resourceID` (`resourceID`),
  ADD KEY `username` (`username`),
  ADD KEY `checker` (`checker`);

--
-- Indexes for table `resource_creator_tbl`
--
ALTER TABLE `resource_creator_tbl`
  ADD PRIMARY KEY (`creatorID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `resource_tag_tbl`
--
ALTER TABLE `resource_tag_tbl`
  ADD PRIMARY KEY (`rtID`),
  ADD KEY `resourceID` (`resourceID`),
  ADD KEY `tagID` (`tagID`);

--
-- Indexes for table `resource_tbl`
--
ALTER TABLE `resource_tbl`
  ADD PRIMARY KEY (`resourceID`),
  ADD KEY `creatorID` (`creatorID`);

--
-- Indexes for table `student_tbl`
--
ALTER TABLE `student_tbl`
  ADD PRIMARY KEY (`studentID`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `suggest_resource_tbl`
--
ALTER TABLE `suggest_resource_tbl`
  ADD PRIMARY KEY (`suggestID`),
  ADD KEY `studentID` (`studentID`),
  ADD KEY `ccID` (`ccID`);

--
-- Indexes for table `suggest_topic_tbl`
--
ALTER TABLE `suggest_topic_tbl`
  ADD PRIMARY KEY (`suggestID`),
  ADD KEY `adminID` (`adminID`),
  ADD KEY `ccID` (`ccID`);

--
-- Indexes for table `tag_tbl`
--
ALTER TABLE `tag_tbl`
  ADD PRIMARY KEY (`tagID`);

--
-- Indexes for table `topic_resource_tbl`
--
ALTER TABLE `topic_resource_tbl`
  ADD PRIMARY KEY (`trID`),
  ADD KEY `topicID` (`topicID`),
  ADD KEY `resourceID` (`resourceID`);

--
-- Indexes for table `topic_tbl`
--
ALTER TABLE `topic_tbl`
  ADD PRIMARY KEY (`topicID`),
  ADD KEY `fieldID` (`fieldID`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookmark_tbl`
--
ALTER TABLE `bookmark_tbl`
  MODIFY `bookmarkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comment_tbl`
--
ALTER TABLE `comment_tbl`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `course_coordinator_tbl`
--
ALTER TABLE `course_coordinator_tbl`
  MODIFY `ccID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `example_tbl`
--
ALTER TABLE `example_tbl`
  MODIFY `exampleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `field_tbl`
--
ALTER TABLE `field_tbl`
  MODIFY `fieldID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `like_tbl`
--
ALTER TABLE `like_tbl`
  MODIFY `likeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rate_tbl`
--
ALTER TABLE `rate_tbl`
  MODIFY `rateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `report_tbl`
--
ALTER TABLE `report_tbl`
  MODIFY `reportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `resource_creator_tbl`
--
ALTER TABLE `resource_creator_tbl`
  MODIFY `creatorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `resource_tag_tbl`
--
ALTER TABLE `resource_tag_tbl`
  MODIFY `rtID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `resource_tbl`
--
ALTER TABLE `resource_tbl`
  MODIFY `resourceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `student_tbl`
--
ALTER TABLE `student_tbl`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `suggest_resource_tbl`
--
ALTER TABLE `suggest_resource_tbl`
  MODIFY `suggestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `suggest_topic_tbl`
--
ALTER TABLE `suggest_topic_tbl`
  MODIFY `suggestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tag_tbl`
--
ALTER TABLE `tag_tbl`
  MODIFY `tagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `topic_resource_tbl`
--
ALTER TABLE `topic_resource_tbl`
  MODIFY `trID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `topic_tbl`
--
ALTER TABLE `topic_tbl`
  MODIFY `topicID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD CONSTRAINT `admin_tbl_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user_tbl` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bookmark_tbl`
--
ALTER TABLE `bookmark_tbl`
  ADD CONSTRAINT `bookmark_tbl_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user_tbl` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookmark_tbl_ibfk_2` FOREIGN KEY (`resourceID`) REFERENCES `resource_tbl` (`resourceID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment_tbl`
--
ALTER TABLE `comment_tbl`
  ADD CONSTRAINT `comment_tbl_ibfk_1` FOREIGN KEY (`resourceID`) REFERENCES `resource_tbl` (`resourceID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_tbl_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user_tbl` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_coordinator_tbl`
--
ALTER TABLE `course_coordinator_tbl`
  ADD CONSTRAINT `course_coordinator_tbl_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user_tbl` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `like_tbl`
--
ALTER TABLE `like_tbl`
  ADD CONSTRAINT `like_tbl_ibfk_1` FOREIGN KEY (`commentID`) REFERENCES `comment_tbl` (`commentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_tbl_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user_tbl` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rate_tbl`
--
ALTER TABLE `rate_tbl`
  ADD CONSTRAINT `rate_tbl_ibfk_1` FOREIGN KEY (`resourceID`) REFERENCES `resource_tbl` (`resourceID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rate_tbl_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user_tbl` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report_tbl`
--
ALTER TABLE `report_tbl`
  ADD CONSTRAINT `report_tbl_ibfk_1` FOREIGN KEY (`resourceID`) REFERENCES `resource_tbl` (`resourceID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_tbl_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user_tbl` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_tbl_ibfk_3` FOREIGN KEY (`checker`) REFERENCES `user_tbl` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `resource_creator_tbl`
--
ALTER TABLE `resource_creator_tbl`
  ADD CONSTRAINT `resource_creator_tbl_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user_tbl` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `resource_tag_tbl`
--
ALTER TABLE `resource_tag_tbl`
  ADD CONSTRAINT `resource_tag_tbl_ibfk_1` FOREIGN KEY (`resourceID`) REFERENCES `resource_tbl` (`resourceID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resource_tag_tbl_ibfk_2` FOREIGN KEY (`tagID`) REFERENCES `tag_tbl` (`tagID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `resource_tbl`
--
ALTER TABLE `resource_tbl`
  ADD CONSTRAINT `resource_tbl_ibfk_1` FOREIGN KEY (`creatorID`) REFERENCES `resource_creator_tbl` (`creatorID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_tbl`
--
ALTER TABLE `student_tbl`
  ADD CONSTRAINT `student_tbl_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user_tbl` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suggest_resource_tbl`
--
ALTER TABLE `suggest_resource_tbl`
  ADD CONSTRAINT `suggest_resource_tbl_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student_tbl` (`studentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `suggest_resource_tbl_ibfk_2` FOREIGN KEY (`ccID`) REFERENCES `course_coordinator_tbl` (`ccID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suggest_topic_tbl`
--
ALTER TABLE `suggest_topic_tbl`
  ADD CONSTRAINT `suggest_topic_tbl_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `admin_tbl` (`adminID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `suggest_topic_tbl_ibfk_2` FOREIGN KEY (`ccID`) REFERENCES `course_coordinator_tbl` (`ccID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topic_resource_tbl`
--
ALTER TABLE `topic_resource_tbl`
  ADD CONSTRAINT `topic_resource_tbl_ibfk_1` FOREIGN KEY (`topicID`) REFERENCES `topic_tbl` (`topicID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topic_resource_tbl_ibfk_2` FOREIGN KEY (`resourceID`) REFERENCES `resource_tbl` (`resourceID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topic_tbl`
--
ALTER TABLE `topic_tbl`
  ADD CONSTRAINT `topic_tbl_ibfk_1` FOREIGN KEY (`fieldID`) REFERENCES `field_tbl` (`fieldID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
