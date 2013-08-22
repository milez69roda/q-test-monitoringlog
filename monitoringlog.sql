/*
SQLyog Enterprise - MySQL GUI v8.05 RC 
MySQL - 5.5.8-log : Database - monitoringlog
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`monitoringlog` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `monitoringlog`;

/*Table structure for table `calllog` */

DROP TABLE IF EXISTS `calllog`;

CREATE TABLE `calllog` (
  `call_id` int(11) NOT NULL AUTO_INCREMENT,
  `call_min` varchar(20) DEFAULT NULL,
  `call_esn` varchar(30) DEFAULT NULL,
  `call_type` varchar(30) DEFAULT NULL,
  `call_subtype` varchar(30) DEFAULT NULL,
  `call_details` text,
  `call_dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `call_ipaddress` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `avaya` varchar(6) DEFAULT NULL,
  `center` varchar(20) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `call_weekending` date DEFAULT NULL,
  `call_dateupdated` datetime DEFAULT NULL,
  `call_updatedby` int(11) DEFAULT NULL,
  PRIMARY KEY (`call_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8113 DEFAULT CHARSET=latin1;

/*Data for the table `calllog` */


/*Table structure for table `calllog_copy` */

DROP TABLE IF EXISTS `calllog_copy`;

CREATE TABLE `calllog_copy` (
  `call_id` int(11) NOT NULL AUTO_INCREMENT,
  `call_min` varchar(20) DEFAULT NULL,
  `call_esn` varchar(30) DEFAULT NULL,
  `call_type` varchar(30) DEFAULT NULL,
  `call_subtype` varchar(30) DEFAULT NULL,
  `call_details` text,
  `call_dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `call_ipaddress` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `avaya` varchar(6) DEFAULT NULL,
  `center` varchar(20) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `call_weekending` date DEFAULT NULL,
  `call_dateupdated` datetime DEFAULT NULL,
  PRIMARY KEY (`call_id`)
) ENGINE=MyISAM AUTO_INCREMENT=630 DEFAULT CHARSET=latin1;

/*Data for the table `calllog_copy` */


/*Table structure for table `calltype` */

DROP TABLE IF EXISTS `calltype`;

CREATE TABLE `calltype` (
  `ct_id` int(11) NOT NULL AUTO_INCREMENT,
  `ct_desc` varchar(60) DEFAULT NULL,
  `ct_dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ct_active` smallint(6) DEFAULT '1' COMMENT '0 inactive',
  PRIMARY KEY (`ct_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `calltype` */

insert  into `calltype`(`ct_id`,`ct_desc`,`ct_dateadded`,`ct_active`) values (1,'Activation','2013-01-28 09:41:36',1),(2,'Dead Air','2013-01-28 09:41:40',1),(3,'General Questions','2013-01-28 09:41:46',1),(4,'Port','2013-01-28 09:41:49',1),(5,'Reactivation','2013-01-28 09:41:53',1),(6,'Redemption - Credit Card','2013-01-28 09:42:02',1),(7,'Redemption - PIN','2013-01-28 09:42:07',1),(8,'Technical Issue','2013-01-28 09:42:29',1),(9,'Upgrade','2013-01-28 09:42:38',1),(10,'Other','2013-01-28 09:42:55',1),(12,'Enrollment','2013-02-08 11:27:11',1),(13,'Data','2013-02-19 10:57:39',1),(14,'SafeLink','2013-03-05 16:15:26',1);

/*Table structure for table `center` */

DROP TABLE IF EXISTS `center`;

CREATE TABLE `center` (
  `centerid` int(11) NOT NULL AUTO_INCREMENT,
  `centerdesc` varchar(100) DEFAULT NULL,
  `center_address` varchar(255) DEFAULT NULL,
  `center_active` tinyint(4) DEFAULT '1' COMMENT '0 inactive',
  `center_acronym` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`centerid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `center` */

insert  into `center`(`centerid`,`centerdesc`,`center_address`,`center_active`,`center_acronym`) values (2,'Belize City',NULL,1,'BEL'),(1,'Barranquilla',NULL,1,'BAR'),(3,'Bogota',NULL,1,'BOG'),(4,'Cebu',NULL,1,'CEB'),(5,'Guatemala City',NULL,1,'GUA'),(6,'Georgetown',NULL,1,'GEO'),(7,'Miami',NULL,1,'MIA'),(8,'Dumaguete',NULL,1,'DMG'),(11,'Bacolod',NULL,1,'BAC'),(12,'Honduras',NULL,1,'HON');

/*Table structure for table `center2` */

DROP TABLE IF EXISTS `center2`;

CREATE TABLE `center2` (
  `centerid` int(11) NOT NULL AUTO_INCREMENT,
  `centerdesc` varchar(100) DEFAULT NULL,
  `centeraddress` varchar(255) DEFAULT NULL,
  `center_active` tinyint(4) DEFAULT '1' COMMENT '0 inactive',
  `centeracronym` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`centerid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `center2` */

insert  into `center2`(`centerid`,`centerdesc`,`centeraddress`,`center_active`,`centeracronym`) values (1,'Belize City',NULL,1,'BEL'),(2,'Barranquilla',NULL,1,'BAR'),(3,'Bogota',NULL,1,'BOG'),(4,'Cebu',NULL,1,'CEB'),(5,'Guatemala City',NULL,1,'GUA'),(6,'Georgetown',NULL,1,'GEO');

/*Table structure for table `department` */

DROP TABLE IF EXISTS `department`;

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_desc` varchar(100) DEFAULT NULL,
  `dept_dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dept_active` smallint(6) DEFAULT '1' COMMENT '0 enactive',
  `dept_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `department` */

insert  into `department`(`dept_id`,`dept_desc`,`dept_dateadded`,`dept_active`,`dept_order`) values (1,'Operations/Randall','2013-01-25 16:02:14',1,2),(2,'Operations/Yaidy','2013-01-25 16:02:20',1,3),(3,'CCCM-WF/Angel','2013-01-25 16:02:24',1,4),(4,'Training/Ron','2013-01-25 16:02:26',1,5),(5,'Operations/Mark','2013-02-08 18:03:23',1,1);

/*Table structure for table `meeting` */

DROP TABLE IF EXISTS `meeting`;

CREATE TABLE `meeting` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_title` varchar(200) DEFAULT NULL,
  `m_date` date DEFAULT NULL,
  `m_attend` text,
  `m_no_attend` int(11) DEFAULT NULL,
  `m_notes` text,
  `m_action_items` text,
  `m_dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `m_ipaddress` varchar(20) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `m_type` varchar(30) DEFAULT NULL,
  `m_weekending` date DEFAULT NULL,
  `m_updated` datetime DEFAULT NULL,
  `m_updatedby` int(11) DEFAULT NULL,
  PRIMARY KEY (`m_id`)
) ENGINE=MyISAM AUTO_INCREMENT=303 DEFAULT CHARSET=latin1;

/*Data for the table `meeting` */


/*Table structure for table `meeting_copy` */

DROP TABLE IF EXISTS `meeting_copy`;

CREATE TABLE `meeting_copy` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_title` varchar(200) DEFAULT NULL,
  `m_date` date DEFAULT NULL,
  `m_attend` text,
  `m_no_attend` int(11) DEFAULT NULL,
  `m_notes` text,
  `m_action_items` text,
  `m_dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `m_ipaddress` varchar(20) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `m_type` varchar(30) DEFAULT NULL,
  `m_weekending` date DEFAULT NULL,
  `m_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`m_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

/*Data for the table `meeting_copy` */

insert  into `meeting_copy`(`m_id`,`m_title`,`m_date`,`m_attend`,`m_no_attend`,`m_notes`,`m_action_items`,`m_dateadded`,`user_id`,`m_ipaddress`,`dept_id`,`m_type`,`m_weekending`,`m_updated`) values (1,'Carl Limpahan (DMG)','2013-01-30','Carl Limpahan DMG 45117\r\nAngel Aleman\r\nMax Munoz\r\nMarietonie Alcorde',4,'I spoke to agent Carl Limpahan (DMG 45117) as I observed him going on break 14 times in Impact 360 on 1/25/13. Max and I met with the agent and he told me he kept hitting break to extend his ACW time without penalization. I advised this was not acceptable and must stop immediately. Agent understood.','Agent was adressed and was advise this is not correct procedure.','2013-01-30 12:07:30',9,'10.248.107.122',3,'Individual Meeting','2013-02-03',NULL),(2,'56751','2013-01-31','Joseph Daruca',1,'Customer could not use the internet. The previous agent she spoke with gave instructions for NET10 website to download the APN changer(per the customer) now her internet is working. She is calling back because she is not able to download from itunes. The error message that she is receiving is IOS needs to be updated. She mentioned she tried to download the updated IOS but it was not working for for her. Te Agent told her there was nothing he can do that she needs to contact the manufacuture for assistance.','Suggestion: Making the agent aware of the recourses we have to assist the customer. He should have used the Apple URL tool in AS to send the customer an article that would have fixed her issue. There are many articles on IOS updates for ITunes located in that tool.','2013-01-31 09:33:52',16,'10.248.3.30',4,'Individual Meeting','2013-02-03',NULL),(3,'BYOP Rep Meeting','2013-01-31','CZarlotte Faller Avaya 43255\r\nLaura Montecki',2,'Spoke to agent about the call I listened to she put together that she could search the wal-mart store list and the zoom list to find places where the customer can purchase the sim card sisnce it is not on the website.\r\nMost of the phone calls she is seeing is this issue and issues with browsing being turned off.  They would like to be abut to tell the customer how much data.  They would also like a script of why we don\'t have the sim card available and what to say to the customer.\r\nShe knew that as long as the phone was unlocked that they could use the TMO SIM card.','Update manual to make it more clear that if the phone is unlocked that they can use the TMO SIM card.','2013-01-31 14:03:39',15,'10.248.107.131',4,'Individual Meeting','2013-02-03',NULL),(6,'block caller ID','2013-02-05','Jessica Jamis\r\nHernan Cespedes\r\n',3,'Met with Jessica in charge of QA to discuss call 9116092902880010101. The agent had control of the call, but was completely lost when asked by the customer how to call someone and block the caller ID. I made sure to tell her how it works and to coach the agent and make sure to keep the information handy in case it ever comes up again in the future.','0','2013-02-05 10:41:05',12,'10.248.107.91',3,'Individual Meeting','2013-02-10',NULL),(7,'Idle Time at Shift Start','2013-02-05','Angel Aleman\r\nRichert Manjarres\r\nKarla Patricia Guillen\r\nJoan Escoto Castillo\r\nOlga Figueroa Ruiz\r\nCarlos Leon',6,'We met with several agents from Honduras as Rich noticed them sitting Idle before their shift while using Impact 360 to monitor Aux. Karla was IDLE 44 minutes into her shift. Joan was idle 31 minutes into her shift and Olga was Idle 10 minutis into her shift. We got on a conference call with all of the agents and proceded to ask them why the high idle time at the start of the shift. Karla said she was in the rest room for 2 minutes not 44. I checked CMS and in fact Impact was not recording the activity correctly. Joan denied staying on aux  for 31 minutes though CMS does show her on Aux for 31 minutes. She was advised that this is a one time break and that CMS showed she was on Aux for 31 minutes. She must be more carefull when starting her shift and make sure she hits auto-in correctly. Olga admitted to forgetting to auto in. CMS also showed her in Aux for 10 minutes.','0','2013-02-05 11:49:46',9,'10.248.107.122',3,'Group Meeting','2013-02-10',NULL),(5,'Review of iPhone conerns','2013-02-01','Monessa Trainer from Cebu\r\nLissette Specialty trainer from Cebu',2,'An email came from Donna Stubbs on a few concerns with the following areas of iPhone related calls:\r\nRequesting the Serial Number Instead of the MEID\r\nProviding Incomplete or Inaccurate Information\r\n• The customer wanted to know how to finance an iPhone through Walmart.  The agent did not explain the customer finance price of the iPhone 5 with which is located in Agent Support. \r\no 9116024693880000101 - Avaya : 43813\r\n• The agent told the customer that she can set up the iPhone trough a Satellite instead of Wi-FI or iTunes.\r\n• The agent told the customer that if the issue could not be resolved a replacement phone will be sent.\r\nDidn’t Follow Training Flash #13 iPhone Data Troubleshooting by contacting Verizon for assistance or resetting the iPhone:\r\nI provided the contact m=number specifically for Nemia which belongs to their center to review call as I did and review not only the Credit Card Walmart scenario but all other scenarios listed in the email from Donna.  Lissette will provide to me by Tuesday her feedback of not only the call but the review of the items listed above with the team. NL','0','2013-02-01 14:26:32',17,'10.248.106.53',4,'Group Meeting','2013-02-03',NULL),(8,'Excessive Idle State at Start of Shift','2013-02-05','Angel Aleman\r\nPablo Andrade (Honduras Shift Manager)\r\nCarlos DeLeon (Honduras Ops Manager)\r\nKarla Patricia Guillen (CSR)\r\nJoan Escoto Castillo (CSR)\r\nOlga Figueroa Ruiz (CSR)',6,'Agents were interviewed to find out reasons behind high Idle State at beginning of their shift.  \r\n\r\nKarla Guillen\'s idle time could not be confirmed by CMS. Juan Peraza advised that I360 had an outage at the time in question which might explain her high idle time.\r\n\r\nJoan Escoto was given a warning as both CMS and I360 coincide in that she had 31 min idle time.  \r\n\r\nOlga Figueroa advised that she logged in but failed to auto in. As soon as she noticed what had happened, she advised her supervisor.','0','2013-02-05 12:11:19',11,'10.248.3.73',3,'Group Meeting','2013-02-10',NULL),(9,'Simple Mobile','2013-02-05','Luis Garcia\r\nSergio Ramirez\r\nVelvet Hernandez\r\nStephine Dia',4,'Can combine new hire and technical together rather than having it separate.  This makes sense since the training is similar and the agents are already providing APN settings.  Better AHT and reduced transfer rates.\r\n\r\nMerge blackberry and supervisor group since the only additional training for sup group is the conflict resolution training.\r\n\r\nCustomers want the micro sim for Simple Mobile for the Iphone 5.\r\n\r\nWant an ERD department for Simple Mobile or for local ERD to be able to handle the call.','0','2013-02-05 14:59:36',15,'10.248.107.131',4,'Individual Meeting','2013-02-10',NULL),(10,'Quality One and Training Flash #15','2013-02-05','Natalie LaChance\r\nDe Jesus, KC Raquel rep-from Cebu',2,'Spoke with KC the representative belonging to this AVAYA.  This phone was actually purchased from the Third Party Website of Quality one-however the customer said it was a NET10 iPhone 4S.  Per the Training Flash #15 (2013)-for Exchanges, Refunds, or Technical Issues, the customer should be given the Quality One Customer Service Number.  I was unable to identify via WebCSR that this came from Quality One and since this agent is a BYOP agent-she too was unable to identify it was from Quality One therefore proceeded BAU to trouble shoot the phone and when the customer was unable to see if there was an APN setting available to manually update, the representative advised the customer to go back to the manufacturer.  Customer was upset said the phone was unlocked and that he would be leaving NET10 because of it.  I asked what could have been done to better assist the agent-she recommended that if WebCSR prompted her or there was some identifying factor in the profile then she would have directed the customer to Quality One.','0','2013-02-05 15:57:09',17,'10.248.106.53',4,'Individual Meeting','2013-02-10',NULL),(11,'Charlott Atienza','2013-02-06','AM ERD Shift Manager, Antoniete Marie Dellatan\r\nERD Supervisor, Marimil Cadavis\r\nERD Agent: Charlott Atienza\r\nOperations Manager Kara Dupio',4,'I spoke with the DMG ERD agent Charlott Atienza regarding her call where I feel she could have done a much better job in attempting to keep the customer.  Agent was nonchalant if the customer decided to leave the company.   Agent understood to make an effort to be more positive and strive to keep every customer. \r\n\r\n\r\nNotes from the call I monitored:\r\n\r\n8125726591\r\n268435459307089133\r\nST Customer called to get a refund for a double charge.\r\nThe customer had called from the cell phone.  The rep told the customer that in order to provide a refund for the double charge, she need the phone’s serial number.   The customer got upset and hung up.','0','2013-02-06 15:16:41',19,'10.248.107.143',1,'Individual Meeting','2013-02-10',NULL),(12,'Meeting with Agent','2013-02-06','Anna Arriola, Christian Casul',1,'During agents call the customer dropped off the line after about 1 minute.  Agent Christian Casul stayed on the line for an additional 3 minutes before releasing the line.  Anna had the agent listen to his call before our meeting so he would be prepared.  We discussed the proper procedures for when a customer\'s call drops.  The agent remained on the call for 3 minutes after the call dropped.  Christian now understands the proper procedure and states he will follow it.','0','2013-02-06 17:46:59',20,'10.248.107.223',1,'Individual Meeting','2013-02-10',NULL),(13,'AT&T SIM card','2013-02-07','Jane  Villaruel',1,'Hi Jane,\r\n\r\nI monitored a call yesterday and below you will see what I documented based on what I heard.\r\n\r\nSuggestion: She needs to probe for more info when the customer calls in. She automatically assumed the customer was calling to purchase a AT&T SIM. It did turn out that’s what the customer needed but after the customer pulled for more info from the agent.  Also make her aware that not only can the customer purchase the  AT&T SIM card on the website, they can also purchase at a retailer if they have them in stock.  She just need to be more confident when relaying information to the customers on the calls.\r\n\r\nThank you Jane.','0','2013-02-07 09:39:50',16,'10.248.107.137',4,'Individual Meeting','2013-02-10',NULL),(14,'Wrong Replacement','2013-02-06','Agent: ceb1cmarmamento\r\nOM: Faye Mutia',2,'We got word that this agent had sent the wrong replacement phone to a customer (a Samsung Galaxy phone that is significantly more expensive). However, it turns out after research and verifying through Tealeaf that the agent did in fact sent the correct phone. Case was closed.','0','2013-02-07 09:54:13',13,'10.248.107.186',3,'Individual Meeting','2013-02-10',NULL),(15,'Wasting Time on a Call','2013-02-07','Michelle Sanchez (CRD Cebu Manger)\r\nSusan Sam (CDR Manger)\r\nFransico Gonsalez  (Agent)\r\nChestnut (QA) \r\nAnna SME for CRD.\r\n\r\n',7,'Agent made an Outbound call to a customer.  Before the agent said the departments agreeding, the customer told him she was speaking to someone else on the other phone and hung up.  Agent didn\'t release the call and stayed on the line for a total on 3 minutes.  Agent should have released the line at that point.\r\nAgent claims he was so focus on adding the note to the case he didn\'t realized the customer had hung up.  I pointed out that the customer had hung up before he finished with his greeding.  Also advised the agent that if this happens again, we could remove him from the team.  Gave this agent a warning and advise him to learn from this mistake.  \r\nall agreed agents didn\'t release the call when he should have.  Agent aplogized and promised it wouldn\'t happen again.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\nhim if he does it again, we could remove him from the team.','0','2013-02-07 16:20:20',23,'10.248.107.113',1,'Individual Meeting','2013-02-10',NULL),(16,'Keva','2013-02-07','Dominique McCauley\r\nPearline Graham\r\nMaria King Carrington\r\nDelphine Bailey\r\nKeva Bygrave\r\nTraves Alexander',6,'We had a discussion with Miami agent (Traves) in reference to the excessive silence used while assisting an offshore agent. The offshore agent called for an ILD issue and the Miami agent did not obtain phone number or serial number during the beginning of the call, instead, he reviewed is payroll sheet.\r\nAgent needs to focus on the calls and have all the necessary tools on the screen to address the customer concerns.','0','2013-02-08 11:58:48',30,'10.248.3.81',1,'Group Meeting','2013-02-10',NULL),(17,'Phone Call Behavior','2013-02-07','Dominique McCauley\r\nPearline Graham\r\nMaria King Carrington\r\nDelphine Bailey\r\nKeva Bygrave\r\nTraves Alexander\r\n',7,'We had a discussion with Miami agent (Traves) in reference to the excessive silence used while assisting an offshore agent. The offshore agent called for an ILD issue and the Miami agent did not obtain phone number or serial number during the beginning of the call, instead, he reviewed is payroll sheet.\r\nAgent needs to focus on the calls and have all the necessary tools on the screen to address the customer concerns.','0','2013-02-08 13:55:35',27,'10.248.3.93',1,'Group Meeting','2013-02-10',NULL),(18,'Call Review','2013-02-07','Dominique McCauley, Pearline Graham, Maria King Carrington, Delphine Bailey, Keva Bygrave, Traves Alexander.',1,'We had a discussion with Miami agent (Traves) in reference to the excessive silence used while assisting an offshore agent. The offshore agent called for an ILD issue and the Miami agent did not obtain phone number or serial number during the beginning of the call, instead, he reviewed is payroll sheet.\r\nAgent needs to focus on the calls and have all the necessary tools on the screen to address the customer concerns.','0','2013-02-08 13:58:51',28,'10.248.107.209',1,'Group Meeting','2013-02-10',NULL),(20,'Cebu','2013-02-07','Agent Bajo Sobrino and  Manager Mary Jane.\r\n',2,'CSR was advicsed to place close attention to the rules in regards to giving customer minutes. If needed yes go above an dboyond however if cusotmer is not updet or has not had any issues with us do offer extra free services','0','2013-02-08 17:17:07',5,'10.248.106.147',2,'Individual Meeting','2013-02-10',NULL),(21,'Recomendation ','2013-02-07',' Correct recommnedation for week ending 2/10/13',1,'Please disregard the last recommendation (it was suppose to be the meeting notes) \r\nRecommendation: 2/8/13 the majority of the calls where for internet access. After the CSR activate the ( what I believe was) the rate plan the customers internet service worked. Maybe we can add this instruction on the web for the customer to follow if and when they come across this issue','0','2013-02-08 17:22:38',5,'10.248.106.147',2,'Group Meeting','2013-02-10',NULL),(22,'Group Meeting','2013-02-07','Group Meeting\r\nAttendees: \r\nDominique McCauley\r\nPearline Graham\r\nMaria King Carrington\r\nDelphine Bailey\r\nKeva Bygrave\r\nTraves Alexander\r\n\r\nWe had a discussion with Miami agent (Traves) in reference to the excessive silence used while assisting an offshore agent. The offshore agent called for an ILD issue and the Miami agent did not obtain phone number or serial number during the beginning of the call, instead, he reviewed is payroll sheet.\r\nAgent needs to focus on the calls and have all the necessary tools on the screen to address the customer concerns\r\n',12,'','0','2013-02-08 18:40:23',26,'10.248.3.53',1,'Group Meeting','2013-02-10',NULL),(23,'Home Phone','2013-02-08','56150 - Joan Lumbad',1,'Called Cebu to speak to a Home Phone agent.  Spoke with Joan and asked what is the biggest reason that customers call in.  She said - Unable/Unable.  \r\n\r\nThe two main issues with that is:\r\n\r\n#1 - The customer is calling from their Home Phone and they are unable to troubleshoot it.\r\n\r\n#2 - The customer has plugged in the Home Phone to the wall jack.  They will need to unplug it and do *22890.','0','2013-02-08 18:54:50',10,'10.248.3.117',3,'Individual Meeting','2013-02-10',NULL),(24,'Excessive Silent','2013-02-07','Group Meeting\r\nAttendees: \r\nDominique McCauley\r\nPearline Graham\r\nMaria King Carrington\r\nDelphine Bailey\r\nKeva Bygrave\r\nTraves Alexander\r\n\r\nWe had a discussion with Miami agent (Traves) in reference to the excessive silence used while assisting an offshore agent. The offshore agent called for an ILD issue and the Miami agent did not obtain phone number or serial number during the beginning of the call, instead, he reviewed is payroll sheet.\r\nAgent needs to focus on the calls and have all the necessary tools on the screen to address the customer concerns\r\n',0,'','0','2013-02-08 18:59:33',31,'10.248.3.77',1,'Group Meeting','2013-02-10',NULL),(25,'Weekly Meeting','2013-02-10','Myrldred Bardet\r\nShaynee Peterson',2,'I listened to this call and noticed the agent told the customer that we are having problems with customer\'s not being able to use mms. I advised the agent not to place blame on the company because mms issues are related to apn settings/phone is not unlocked to enable feature.','0','2013-02-10 14:18:32',25,'10.248.3.56',1,'Individual Meeting','2013-02-17','2013-02-10 14:20:37'),(26,'Weekly Review','2013-02-10','Akan Ikpe\r\nKalika Hardaway\r\nShaynee Peterson',3,'The customer called because his data stop working again on his BYOP Iphone. \r\n\r\nI had a discussion with the Miami agents in reference to the hold time used while assisting the customer, follow correct hold procedure and different troubleshooting techniques for data issues.\r\n\r\nAgent needed to use all necessary tools (check apn settings/contact carrier)to resolve issue.','0','2013-02-10 18:01:59',25,'10.248.3.56',1,'Group Meeting','2013-02-17',NULL),(27,'Meeting with Anna Arriola','2013-02-07','Anna Arriola and Randall Richards',1,'During a couple calls I noted poor call quality.  During one specific call the reception was very poor that the call was terminated by the customer. This was an outbound call and when it was discovered that the call quality was so bad, the agent should have offered right away to hang up and call again.  Anna Arriola and I discussed this option on Thursday afternoon and Anna will disseminate this information to both Local ERD and Corp ERD groups.','0','2013-02-10 22:10:59',1,'10.248.87.44',1,'Individual Meeting','2013-02-10',NULL);

/*Table structure for table `recommendation` */

DROP TABLE IF EXISTS `recommendation`;

CREATE TABLE `recommendation` (
  `rec_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_id` int(11) DEFAULT NULL,
  `rec_text` text,
  `rec_dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `rec_ipaddress` varchar(20) DEFAULT NULL,
  `rec_weekending` date DEFAULT NULL,
  `rec_updated` datetime DEFAULT NULL,
  `rec_updatedby` int(11) DEFAULT NULL,
  `isforwarded` smallint(6) DEFAULT '0',
  `forwardTo` int(11) DEFAULT NULL,
  `forwardName` varchar(35) DEFAULT NULL,
  `forwardDate` datetime DEFAULT NULL,
  `forwardBy` int(11) DEFAULT NULL,
  `forwardByName` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=MyISAM AUTO_INCREMENT=436 DEFAULT CHARSET=latin1;

/*Data for the table `recommendation` */


/*Table structure for table `subcalltype` */

DROP TABLE IF EXISTS `subcalltype`;

CREATE TABLE `subcalltype` (
  `sct_id` int(11) NOT NULL AUTO_INCREMENT,
  `ct_id` int(11) DEFAULT NULL,
  `sct_desc` varchar(100) DEFAULT NULL,
  `sct_active` smallint(6) DEFAULT '1' COMMENT '0 inactive',
  `sct_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sct_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

/*Data for the table `subcalltype` */

insert  into `subcalltype`(`sct_id`,`ct_id`,`sct_desc`,`sct_active`,`sct_added`) values (1,1,'Successful',1,'2013-01-28 09:40:33'),(2,1,'Accessories',1,'2013-01-28 09:40:33'),(3,1,'Airtime Issue',1,'2013-01-28 09:40:33'),(4,1,'Auto-Refill',1,'2013-01-28 09:40:33'),(5,1,'Call Dropped',1,'2013-01-28 09:40:33'),(6,1,'Call Transferred',1,'2013-01-28 09:40:33'),(7,1,'Coverage Issue',1,'2013-01-28 09:40:33'),(8,1,'Credit Card Declined',1,'2013-01-28 09:40:33'),(9,1,'Customer Hung Up',1,'2013-01-28 09:40:33'),(10,1,'Customer Will Call Back',1,'2013-01-28 09:40:33'),(11,1,'Dead Air',1,'2013-01-28 09:40:33'),(12,1,'Defective Phone',1,'2013-01-28 09:40:33'),(13,1,'Error Message',1,'2013-01-28 09:40:33'),(14,1,'Features',1,'2013-01-28 09:40:33'),(15,1,'General Questions',1,'2013-01-28 09:40:33'),(16,1,'Invalid PIN',1,'2013-01-28 09:40:33'),(17,1,'Long Distance',1,'2013-01-28 09:40:33'),(18,1,'Lost/Stolen Phone',1,'2013-01-28 09:40:33'),(19,1,'MIN Issue',1,'2013-01-28 09:40:33'),(20,1,'Needs New SIM Card',1,'2013-01-28 09:40:33'),(21,1,'Phone Locked',1,'2013-01-28 09:40:33'),(22,1,'Prepaid Disable',1,'2013-01-28 09:40:33'),(23,1,'Refund',1,'2013-01-28 09:40:33'),(24,1,'Replacement Phone',1,'2013-01-28 09:40:33'),(25,1,'Shipping',1,'2013-01-28 09:40:33'),(26,1,'SIM Issue',1,'2013-01-28 09:40:33'),(27,1,'Text Messaging',1,'2013-01-28 09:40:33'),(28,1,'Unable/Unable',1,'2013-01-28 09:40:33'),(29,1,'Voicemail',1,'2013-01-28 09:40:33'),(30,1,'WAP',1,'2013-01-28 09:40:33'),(31,1,'Web Browser',1,'2013-01-28 09:40:33'),(32,1,'Other',1,'2013-01-28 09:40:33'),(34,1,'De-enrolled',1,'2013-02-08 11:27:43'),(35,1,'Din’t Rcv Mins',1,'2013-02-08 11:27:54'),(36,1,'App Denied',1,'2013-02-08 11:28:08'),(37,1,'Reps needs to Callback Customer',1,'2013-02-20 11:54:42'),(39,1,'Re-enrollment',1,'2013-03-05 16:16:55'),(40,1,'Dealer unable to log in',1,'2013-05-15 12:44:48'),(41,1,'High Data usage ',1,'2013-05-15 12:45:16');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_fullname` varchar(60) DEFAULT NULL,
  `user_pass` varchar(100) DEFAULT NULL,
  `user_active` smallint(6) DEFAULT '1' COMMENT '0 inactive',
  `user_lastlogin` datetime DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `user_dateadded` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_access` int(11) DEFAULT NULL,
  `user_show` smallint(6) DEFAULT '1',
  `user_allowtorecievfor` smallint(6) DEFAULT '0',
  `user_email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`user_id`,`user_fullname`,`user_pass`,`user_active`,`user_lastlogin`,`dept_id`,`user_dateadded`,`user_access`,`user_show`,`user_allowtorecievfor`,`user_email`) values (1,'Randall Richards','QW1234**',1,NULL,1,NULL,3,1,1,'rrichards@tracfone.com'),(2,'Joy Belstock','fr1234**',1,NULL,1,NULL,3,1,0,NULL),(3,'Luis Reyes','ow1234**',0,NULL,1,NULL,3,1,0,NULL),(4,'Gerald Gutierrez','gg1234**',1,NULL,1,NULL,3,1,0,NULL),(5,'Yaidy Gomez','Ab321**',1,NULL,2,NULL,3,1,1,'ygomez@tracfone.com'),(6,'Elias Nortelus','xg3434**',1,NULL,2,NULL,3,1,1,'enortelus@tracfone.com'),(7,'Nicole Hall','nicole3434',1,NULL,2,NULL,3,1,0,NULL),(8,'Sandy Ellis','xe342**',1,NULL,2,NULL,3,1,0,NULL),(9,'Angel Aleman','xp3424**',1,NULL,3,NULL,3,1,1,'aaleman@tracfone.com'),(10,'Maria Romero','ye3684**',1,NULL,3,NULL,3,1,0,NULL),(11,'Richert Manjarres','noe327**',1,NULL,3,NULL,3,1,0,NULL),(12,'Hernan Cespedes','she2134**',1,NULL,3,NULL,3,1,0,NULL),(13,'Max Munoz','5761',1,NULL,3,NULL,3,1,0,NULL),(14,'Ron Garon','green',1,NULL,4,NULL,3,1,1,'rgaron@tracfone.com'),(15,'Laura Montecki','pos6564**',1,NULL,4,NULL,3,1,0,NULL),(16,'Michelle Bassett','coldice',1,NULL,4,NULL,3,1,0,NULL),(17,'Natalie LaChance','face2face',1,NULL,4,NULL,3,1,0,NULL),(18,'Kerla Beckford','element',1,NULL,1,NULL,3,1,0,NULL),(19,'Rommel Jay','round6',1,NULL,1,NULL,3,1,0,NULL),(20,'Kim Filardi','76ers',1,NULL,1,NULL,3,1,0,NULL),(21,'Jose Alvarez','8eight',1,NULL,1,NULL,3,1,0,NULL),(22,'Ariana Pintado','forty5',1,NULL,1,NULL,3,1,0,NULL),(23,'Susan Sam','susan123',1,NULL,1,NULL,3,1,0,NULL),(24,'Juan Carlos Penton','house3',1,NULL,1,NULL,3,1,0,NULL),(25,'Shaynee Peterson','caliber45',1,NULL,1,NULL,3,1,0,NULL),(26,'Delphine Bailey','macperson',1,NULL,1,NULL,3,1,0,NULL),(27,'Dominique McCauley','23drive',1,NULL,1,NULL,3,1,0,NULL),(28,'Maria King Carrington','6digits',1,NULL,1,NULL,3,1,0,NULL),(29,'Anne Sampeur','tears28',1,NULL,1,NULL,3,1,0,NULL),(30,'Keva Bygrave','hardrock2',1,NULL,1,NULL,3,1,0,NULL),(31,'Pearline Graham','again1',1,NULL,1,NULL,3,1,0,NULL),(32,'Robert Woodard ','range3',1,NULL,2,'2013-02-06 17:03:09',3,1,0,NULL),(33,'Mark Mahan','miamimark',1,NULL,5,'2013-02-08 16:39:50',3,1,0,NULL),(34,'Admin','t0ba',1,NULL,4,'2013-03-05 16:05:12',1,0,0,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;