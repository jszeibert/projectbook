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

namespace OCA\ProjectBook\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\ProjectBook\Db\Entry;
use OCA\ProjectBook\Db\EntryMapper;


class EntryService {

	private $mapper;

	public function __construct(EntryMapper $mapper){
		$this->mapper = $mapper;
	}

	public function findAll(string $userId) {
		return $this->mapper->findAll($userId);
	}

	private function handleException ($e) {
		if ($e instanceof DoesNotExistException ||
			$e instanceof MultipleObjectsReturnedException) {
			throw new NotFoundException($e->getMessage());
		} else {
			throw $e;
		}
	}

	public function find(int $id, string $userId) {
		try {
			return $this->mapper->find($id, $userId);

		// in order to be able to plug in different storage backends like files
		// for instance it is a good idea to turn storage related exceptions
		// into service related exceptions so controllers and service users
		// have to deal with only one type of exception
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	public function create(string $title, string $type, string $content, int $projectId, string $userId) {
		$entry = new Project();
		$entry->setTitle($title);
		$entry->setType($type);
		$entry->setContent($content);
		$entry->setProjectId($projectId);
		$entry->setUserId($userId);
		return $this->mapper->insert($entry);
	}

	public function update(int $id, string $type, string $content, int $projectId,  string $userId) {
		try {
			$entry = $this->mapper->find($id, $userId);
			$entry->setTitle($title);
			$entry->setType($type);
			$entry->setContent($content);
			$entry->setProjectId($projectId);
			return $this->mapper->update($entry);
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	public function archive(int $id, string $userId) {
		try {
			$entry = $this->mapper->find($id, $userId);
			$entry->setArchived(true);
			return $this->mapper->update($entry);
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete(int $id, string $userId) {
		try {
			$entry = $this->mapper->find($id, $userId);
			$this->mapper->delete($entry);
			return $entry;
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

}
