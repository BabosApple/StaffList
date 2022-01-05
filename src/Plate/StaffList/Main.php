<?php

namespace Plate\StaffList;

use pocketmine\Plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\utils\TextFormat as TF;

class Main extends PluginBase {
	
	public function onEnable() : void {
		@mkdir($this->getDataFolder() . "staff/");
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool {
		
		switch($cmd->getName()){
			case "stafflist":
			 $dir = glob($this->getDataFolder() . "staff/*.txt");
			 if(empty($dir)){
				$sender->sendMessage("There's no staff is setup!");
				return true;
			 }
			 $sender->sendMessage(TF::GREEN . "Stafflist in this server!");
			 $sender->sendMessage(TF::YELLOW . "=========");
			 foreach($dir as $file){
				 $sender->sendMessage(TF::RED . file_get_contents($file) . "\n");
			 }
			 $sender->sendMessage(TF::YELLOW . "=========");
			break;
			
			case "addstaff":
			 $dir = glob($this->getDataFolder() . "staff/*.txt");
			 $name = substr(implode(" ", $args), 0);
			 $staffname = $this->getDataFolder() . "staff/" . $name;
			 if(!isset($args[0])){
				 $sender->sendMessage(TF::RED . "Please type the staff name to add!");
				 return true;
			 }
			 if(file_exists($this->getDataFolder() . "staff/" . $name . ".txt")){
				 $sender->sendMessage(TF::RED . "That player is already in the list!");
				 return true;
			 }
			 $newstaff = fopen($staffname . ".txt", "w");
			 $txt = $name;
			 fwrite($newstaff, $txt);
			 fclose($newstaff);
			 $sender->sendMessage(TF::GOLD . "Player " . $name . " has been" . TF::GREEN . " added " . TF::GOLD . " to the staff list!");
			break;
			
			case "delstaff":
			 $dir = glob($this->getDataFolder() . "staff/*.txt");
			 $name = substr(implode(" ", $args), 0);
			 $staffname = $this->getDataFolder() . "staff/" . $name . ".txt";
			 if(!isset($args[0])){
				 $sender->sendMessage(TF:: RED . "Please type the staff name to remove!");
				 return true;
			 }
			 if(file_exists($staffname)){
				 unlink($staffname);
				 $sender->sendMessage(TF::GOLD . "Player " . $name . " has been" . TF::RED . " removed" . TF::GOLD . " from stafflist");
			 } else {
				 $sender->sendMessage(TF:: RED . "Cannot find player " . $name . " on the list!");
			 }
			break;
		}
		
		return true;
	}
	
}