<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\entity\Entity;
use pocketmine\entity\Living;

final class Slime extends Transparent{

	private float $speedMultiplier = 0.4;

	public function getFrictionFactor() : float{
		return 0.8; //???
	}

	public function onEntityLand(Entity $entity) : ?float{
		if($entity instanceof Living && $entity->isSneaking()){
			return null;
		}
		$entity->resetFallDistance();
		return -$entity->getMotion()->y;
	}

	public function onEntityWalking(Entity $entity) : void{
        $motion = $entity->getMotion();
        $entity->setMotion($motion->multiply($this->speedMultiplier));
    }

    public function setSpeedMultiplier(float $multiplier) : void{
        if ($multiplier < 0) {
            throw new \InvalidArgumentException("Speed multiplier cannot be negative: $multiplier");
        }
        $this->speedMultiplier = $multiplier;
    }

    public function getSpeedMultiplier() : float {
        return $this->speedMultiplier;
    }
}
