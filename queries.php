<?php
include ('config.php');
//include ('querys.php');
switch($sql)
{
   	case 'Bliss':
	//Index
		$stats_totalAlive = "SELECT COUNT(*) FROM survivor WHERE is_dead = 0";
		$stats_totalplayers = "SELECT COUNT(*) FROM profile";
		$stats_deaths = "SELECT COUNT(*) FROM survivor WHERE is_dead = 1";
		$stats_alivebandits = "SELECT COUNT(*) FROM survivor WHERE is_dead = 0 AND Model = 'Bandit1_DZ'";
		$stats_aliveheros = "SELECT COUNT(*) FROM survivor WHERE is_dead = 0 AND Model = 'Survivor3_DZ'";
		$stats_totalVehicles = "SELECT COUNT(*) FROM instance_vehicle WHERE instance_id =" .$iid;
		$stats_Played24h = "SELECT COUNT(*) FROM survivor WHERE last_updated > now() - INTERVAL 1 DAY";
		$stats_totalkills = "SELECT * FROM profile";
		$stats_totalkills_KillsZ = 'total_zombie_kills';
		$stats_totalkills_KillsB = 'total_bandit_kills';
		$stats_totalkills_KillsH = 'total_survivor_kills';
		$stats_totalkills_HeadshotsZ = 'total_headshots';
	//Info
		$info1 = array("SELECT s.*,p.* FROM survivor s JOIN profile p ON p.unique_id = s.unique_id WHERE s.unique_id = ? AND is_dead=0 AND world_id = ? LIMIT 1", array($_GET['id'], $world)); 
		$info4 = array("SELECT iv.*, v.class_name FROM instance_vehicle iv inner join  world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on wv.vehicle_id = v.id WHERE iv.id = ? and instance_id = ? LIMIT 1", array($_GET['id'], $iid));
		$info5 = array("select v.class_name as otype,wv.id as id,wv.worldspace as pos from world_vehicle wv join vehicle v on v.id = wv.vehicle_id where world_id = (select id from world where name = ?) and wv.id = ? LIMIT 1", array($map, $_GET['id']));
		$info6 = array("SELECT id.*,d.class_name,p.name,p.unique_id player_unique_id from instance_deployable id JOIN deployable d on d.id = id.deployable_id JOIN survivor s ON s.id = id.owner_id JOIN profile p on p.unique_id = s.unique_id WHERE id.id = ? and instance_id = ? LIMIT 1", array($_GET["id"], $iid) );
	//Maps
		$map0 = array("select s.id, p.*, 'Player' as type, s.worldspace as worldspace, s.survival_time as survival_time, s.model as model, s.survivor_kills as survivor_kills, s.zombie_kills as zombie_kills, s.bandit_kills as bandit_kills, s.is_dead as is_dead, s.unique_id as unique_id from profile p join survivor s on p.unique_id = s.unique_id where s.is_dead = 0 and s.world_id = ? and last_updated > now() - interval 1 minute", $world);
		$map4 = array("SELECT iv.*, v.class_name, oc.Type FROM instance_vehicle iv inner join  world_vehicle wv on iv.world_vehicle_id = wv.id inner join vehicle v on wv.vehicle_id = v.id inner join object_classes oc on oc.Classname = v.class_name WHERE iv.instance_id = ? AND wv.world_id = ?", array($iid, $world));
		$map6 = array("select id.id,id.unique_id as idid,id.worldspace,id.inventory,id.last_updated,instance_id,oc.Classname,oc.Type,p.name,p.unique_id from instance_deployable id inner join deployable d on id.deployable_id = d.id inner join object_classes oc on d.class_name = oc.classname join survivor s on s.id = id.owner_id join profile p on p.unique_id = s.unique_id where d.class_name = 'TentStorage' and id.instance_id = ?", $iid);
		$map7 = array("select id.id,id.unique_id as idid,id.worldspace,id.last_updated,oc.Classname,oc.Type,p.name from instance_deployable id inner join deployable d on id.deployable_id = d.id inner join object_classes oc on d.class_name = oc.classname join survivor s on s.id = id.owner_id join profile p on p.unique_id = s.unique_id where d.class_name in ('Sandbag1_DZ', 'TrapBear', 'Hedgehog_DZ', 'Wire_cat1') and id.instance_id = ?", $iid);
		$map8_players = array("select s.id, p.*, 'Player' as type, s.worldspace as worldspace, s.survival_time as survival_time, s.model as model, s.survivor_kills as survivor_kills, s.zombie_kills as zombie_kills, s.bandit_kills as bandit_kills, s.is_dead as is_dead, s.unique_id as unique_id from profile p join survivor s on p.unique_id = s.unique_id where s.is_dead = 0 and s.world_id = ? and last_updated > now() - interval 1 minute", $world);
		$map8_vehicles = array("SELECT world_vehicle.vehicle_id, vehicle.class_name, object_classes.Type, instance_vehicle.*, instance.world_id FROM `world_vehicle`, `vehicle`, `object_classes`, `instance_vehicle`, `instance` WHERE vehicle.id = world_vehicle.vehicle_id AND instance_vehicle.world_vehicle_id = world_vehicle.id AND instance_vehicle.instance_id = ? AND world_vehicle.world_id = instance.world_id AND object_classes.classname = vehicle.class_name", $iid);
		$map8_objects = array("select id.id,id.unique_id as idid,id.worldspace,id.inventory,id.last_updated,oc.Classname,oc.Type,p.name from instance_deployable id inner join deployable d on id.deployable_id = d.id inner join object_classes oc on d.class_name = oc.classname join survivor s on s.id = id.owner_id join profile p on p.unique_id = s.unique_id where d.class_name in ('Sandbag1_DZ', 'TrapBear', 'Hedgehog_DZ', 'Wire_cat1', 'TentStorage') and id.instance_id = ?", $iid);
		$check_player = "select p.name, s.* from profile p left join survivor s on p.unique_id = s.unique_id where s.is_dead = 0";
		$check_vehicles = "SELECT * FROM v_deployable";
		$check_objects = "SELECT * FROM v_vehicle";
	break;
	
    case 'DayZ':
	//Index
		$stats_totalAlive = "SELECT COUNT(*) FROM character_data WHERE Alive = 1";
		$stats_totalplayers = "SELECT COUNT(*) FROM player_data";
		$stats_deaths = "SELECT COUNT(*) FROM character_data WHERE Alive = 0";
		$stats_alivebandits = "SELECT COUNT(*) FROM character_data WHERE Alive = 1 AND Model = 'Bandit1_DZ'";
		$stats_aliveheros = "SELECT COUNT(*) FROM character_data WHERE Alive = 1 AND Model = 'Survivor3_DZ'";
		$stats_totalVehicles = "SELECT COUNT(*) FROM object_data WHERE Instance = '" . $iid . "' and CharacterID = '0'";
		$stats_Played24h = "select count(*) from (SELECT count(*) from character_data WHERE LastLogin > now() - INTERVAL 1 DAY group by PlayerUID) uniqueplayers";
		$stats_totalkills = "SELECT * FROM character_data";
		$stats_totalkills_KillsZ = 'KillsZ';
		$stats_totalkills_KillsB = 'KillsB';
		$stats_totalkills_KillsH = 'KillsH';
		$stats_totalkills_HeadshotsZ = 'HeadshotsZ';
	//Info	
		$info1 = array("select player_data.*, character_data.* from player_data, character_data  where character_data.playerUID = player_data.playerUID and character_data.Alive = '1' and player_data.PlayerUID like ?", array($_GET['id'])); 
		$info4 = array("SELECT * FROM object_data WHERE ObjectID = ? and Instance = ?", array($_GET["id"], $iid)); 
		$info5 = array("SELECT * FROM object_spawns WHERE ObjectUID = ".$_GET["id"]." LIMIT 1");
		$info6 = array(""); 
	//Map	
		$map0 = array("select player_data.playerName, player_data.playerUID, character_data.* from player_data, character_data where player_data.PlayerUID = character_data.PlayerUID and character_data.Alive = 1 and character_data.last_updated >= NOW() - INTERVAL 1 minute");
		$map4 = array("SELECT object_classes.*, object_data.*  FROM object_classes, object_data as object_data where object_data.Classname = object_classes.Classname and object_data.Instance =  '" . $iid . "' and CharacterID = '0'");
		$map6 = array("SELECT object_classes.*, object_data.* FROM object_classes, object_data as object_data where object_data.Classname = object_classes.Classname and object_data.Classname = 'TentStorage' and object_data.Instance = ?", array($iid));
		$map7 = array("SELECT object_classes.*, object_data.* FROM object_classes, object_data where object_data.Classname = object_classes.Classname and object_data.CharacterID > '0' and object_data.Classname = 'Wire_cat1' OR object_data.Classname = 'Hedgehog_DZ' OR object_data.Classname = 'Sandbag1_DZ' OR object_data.Classname = 'TrapBear' and object_data.Instance = '" . $iid . "'");
		$map8_players = array("select player_data.*, character_data.* from player_data, character_data where player_data.PlayerUID = character_data.PlayerUID and character_data.Alive = 1 and character_data.last_updated >= NOW() - INTERVAL 1 minute");
		$map8_vehicles = array("SELECT object_classes.*, object_data.* FROM object_classes, object_data as object_data where object_data.Classname = object_classes.Classname and object_data.Instance =  '" . $iid . "' and CharacterID = '0'");
		$map8_objects = array("SELECT object_classes.*, object_data.* FROM object_classes, object_data where object_data.Classname = object_classes.Classname and object_data.CharacterID > '0' and object_data.Instance = '" . $iid . "'");
		$check_players = "select player_data.playerName, character_data.* from player_data, character_data where player_data.PlayerUID = character_data.PlayerUID and character_data.Alive = '1'";
		$check_vehicles = "select * from object_data where CharacterID like '0'";
		$check_objects = "select * from object_data where Classname LIKE 'TentStorage'";
	break;
};
?>
