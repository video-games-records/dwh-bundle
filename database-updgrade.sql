SET NAMES 'utf8';
SET CHARACTER SET utf8;

RENAME TABLE membre TO dwh_player;
RENAME TABLE jeu TO dwh_game;
RENAME TABLE team TO dwh_team;


ALTER TABLE `dwh_player` DROP `nbForumMessage`;
ALTER TABLE `dwh_player` DROP `connect`;
ALTER TABLE `dwh_player` DROP `pointVGR`;
ALTER TABLE `dwh_player` CHANGE `idMembre` `id` INT(13) NOT NULL;
ALTER TABLE `dwh_player` CHANGE `rankMedals` `rankMedal` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `pointRecord` `pointChart` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `pointJeu` `pointGame` INT(11) NOT NULL;
ALTER TABLE `dwh_player` CHANGE `rankPointJeu` `rankPointGame` INT(11) NOT NULL;
ALTER TABLE `dwh_player` CHANGE `rankPoint` `rankPointChart` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `nbPostJour` `nbPostDay` INT(11 NOT NULL;
ALTER TABLE `dwh_player` CHANGE `nbPost` `nbChart` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank0` `chartRank0` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank1` `chartRank1` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank2` `chartRank2` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank3` `chartRank3` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank4` `chartRank4` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank5` `chartRank5` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank6` `chartRank6` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank7` `chartRank7` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank8` `chartRank8` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank9` `chartRank9` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank10` `chartRank10` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank11` `chartRank11` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank12` `chartRank12` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank13` `chartRank13` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank14` `chartRank14` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank15` `chartRank15` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank16` `chartRank16` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank17` `chartRank17` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank18` `chartRank18` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank19` `chartRank19` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank20` `chartRank20` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank21` `chartRank21` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank22` `chartRank22` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank23` `chartRank23` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank24` `chartRank24` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank25` `chartRank25` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank26` `chartRank26` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank27` `chartRank27` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank28` `chartRank28` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank29` `chartRank29` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_player` CHANGE `rank30` `chartRank30` INT(11) NOT NULL DEFAULT '0';

ALTER TABLE dwh_player DROP INDEX pointJeu;
ALTER TABLE dwh_player DROP INDEX rankPointJeu;

ALTER TABLE `dwh_player` ADD INDEX `idxPlayer` (`id`);
ALTER TABLE `dwh_player` ADD INDEX `idxDate` (`date`);


ALTER TABLE `dwh_game` CHANGE `idJeu` `id` INT(13) NOT NULL;
ALTER TABLE `dwh_game` CHANGE `nbPostJour` `nbPostDay` INT(13) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_game` DROP `nbRecord`;


ALTER TABLE `dwh_team` CHANGE `vgr_pointRecord` `pointChart` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_team` CHANGE `vgr_pointBadge` `pointBadge` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_team` CHANGE `vgr_rank0` `chartRank0` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_team` CHANGE `vgr_rank1` `chartRank1` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_team` CHANGE `vgr_rank2` `chartRank2` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_team` CHANGE `vgr_rank3` `chartRank3` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_team` CHANGE `vgr_rank_point` `rankPointChart` INT(11) NULL DEFAULT '0';
ALTER TABLE `dwh_team` CHANGE `vgr_rank_medal` `rankMedal` INT(11) NULL DEFAULT '0';
ALTER TABLE `dwh_team` CHANGE `vgr_rank_badge` `rankBadge` INT(11) NULL DEFAULT '0';
ALTER TABLE `dwh_team` CHANGE `vgr_nbMasterBadge` `nbMasterBadge` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `dwh_team` CHANGE `vgr_nbPostJour` `nbPostDay` INT(11) NOT NULL;
ALTER TABLE `dwh_team` CHANGE `vgr_pointJeu` `pointGame` INT(11) NOT NULL;
ALTER TABLE `dwh_team` CHANGE `vgr_rank_pointJeu` `rankPointGame` INT(11) NOT NULL;
ALTER TABLE `dwh_team` DROP `vgr_nbPost`;

ALTER TABLE `dwh_team` DROP INDEX `vgr_pointJeu`;
ALTER TABLE `dwh_team` DROP INDEX `vgr_rank_pointJeu`;
ALTER TABLE `dwh_team` ADD INDEX `idxTeam` (`idTeam`);
ALTER TABLE `dwh_team` ADD INDEX `idxDate` (`date`);