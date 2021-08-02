<?php

declare(strict_types=1);

namespace shoghicp\BigBrother\utils;

use muqsit\invmenu\inventory\InvMenuInventory;
use pocketmine\inventory\ChestInventory;
use pocketmine\inventory\DoubleChestInventory;
use pocketmine\tile\Chest;
use pocketmine\tile\Tile;
use shoghicp\BigBrother\DesktopPlayer;

class JavaUtils
{
	public const CHEST = 0;
	public const DOUBLE_CHEST = 1;

	/**
	 * @param DesktopPlayer $player - The java player instance you are sending the inventory to
	 * @param InvMenuInventory $inv - The InvMenu you would like to be translated to java
	 * @param int $type - The type of InvMenu you are translating
	 */
	public static function sendTranslatedInvMenu(DesktopPlayer $player, InvMenuInventory $inv, int $type = 0): void
	{
		if ($type === self::CHEST) {
			$chest = Tile::createTile(Tile::CHEST, $player->getLevelNonNull(), Chest::createNBT($player));
			if ($chest instanceof Chest) {
				$inventory = new ChestInventory($chest);
				$inventory->setContents($inv->getContents());

				$player->addWindow($inventory);
			}
		} else if ($type === self::DOUBLE_CHEST) {
			$left = Tile::createTile(Tile::CHEST, $player->getLevelNonNull(), Chest::createNBT($player));
			$right = Tile::createTile(Tile::CHEST, $player->getLevelNonNull(), Chest::createNBT($player->add(1)));
			if ($left instanceof Chest && $right instanceof Chest) {
				$left->pairWith($right);

				$inventory = new DoubleChestInventory($left, $right);
				$inventory->setContents($inv->getContents());

				$player->addWindow($inventory);
			}
		}
	}
}
