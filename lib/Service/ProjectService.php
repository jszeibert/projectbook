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

use OCA\ProjectBook\Db\Project;
use OCA\ProjectBook\Db\ProjectMapper;


class ProjectService {

	private $mapper;

	public function __construct(ProjectMapper $mapper){
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

	public function create(string $title, string $color, string $description, string $userId) {
		$project = new Project();
		$project->setTitle($title);
		$project->setColor($color);
		$project->setDescription($description);
		$project->setUserId($userId);
		return $this->mapper->insert($project);
	}

	public function update(int $id, string $title, string $color, string $description,  string $userId) {
		try {
			$project = $this->mapper->find($id, $userId);
			$project->setTitle($title);
			$project->setColor($color);
			$project->setDescription($description);
			return $this->mapper->update($project);
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete(int $id, string $userId) {
		try {
			$project = $this->mapper->find($id, $userId);
			$this->mapper->delete($project);
			return $project;
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	// TODO: At the moment this function only edits a Database field, but should do a lot more at a later stage,
	// 		e.g. move dependent files and bundle them into a zip archive, compile a summary of special entries, etc.
	public function archive(int $id, string $userId) {
		try {
			$project = $this->mapper->find($id, $userId);
			$project->setArchived(true);
			return $this->mapper->update($project);
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}

	// TODO: This is the reverse of the archive function
	public function restore(int $id, string $userId) {
		try {
			$project = $this->mapper->find($id, $userId);
			$project->setArchived(false);
			return $this->mapper->update($project);
		} catch(Exception $e) {
			$this->handleException($e);
		}
	}
}
