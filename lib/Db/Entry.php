<?php

declare(strict_types=1);
/**
 * @copyright Copyright (c) 2022 Johannes Szeibert <johannes@szeibert.de>
 *
 * @author Johannes Szeibert <johannes@szeibert.de>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\ProjectBook\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Entry extends Entity implements JsonSerializable {
	protected $title;
	protected $type;
	protected $content;
	protected $projectId;
	protected $archived = false;
	protected $userId;

	public function __construct() {
		$this->addType('title', 'string');
		$this->addType('type', 'string');
		$this->addType('projectId', 'integer');
		$this->addType('archived', 'boolean');
	}

	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'title' => $this->title,
			'color' => $this->color,
			'content' => $this->content,
			'projectId' => $this->projectId,
			'archived' => $this->archived
		];
	}
}