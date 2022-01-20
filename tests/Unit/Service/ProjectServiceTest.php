<?php
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

namespace OCA\ProjectBook\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;

use OCP\AppFramework\Db\DoesNotExistException;

use OCA\ProjectBook\Db\Project;
use OCA\ProjectBook\Service\ProjectService;

class ProjectServiceTest extends TestCase {

	private $service;
	private $mapper;
	private $userId = 'john';

	public function setUp(): void {
		$this->mapper = $this->getMockBuilder('OCA\ProjectBook\Db\ProjectMapper')
			->disableOriginalConstructor()
			->getMock();
		$this->service = new ProjectService($this->mapper);
	}

	public function testUpdate() {
		// the existing project
		$project = Project::fromRow([
			'id' => 3,
			'title' => 'title',
			'color' => '#ff5733',
			'description' => 'description'
		]);
		$this->mapper->expects($this->once())
			->method('find')
			->with($this->equalTo(3))
			->will($this->returnValue($project));

		// the project when updated
		$updatedProject = Project::fromRow(['id' => 3]);
		$updatedProject->setTitle('title');
		$updatedProject->setColor('color');
		$updatedProject->setDescription('description');
		$this->mapper->expects($this->once())
			->method('update')
			->with($this->equalTo($updatedProject))
			->will($this->returnValue($updatedProject));

		$result = $this->service->update(3, 
			'Projectname', 
			'#ff5733', 
			'description',
			$this->userId);

		$this->assertEquals($updatedProject, $result);
	}


	/**
	 * @expectedException OCA\ProjectBook\Service\NotFoundException
	 */
	public function testUpdateNotFound() {
		// test the correct status code if no project is found
		$this->mapper->expects($this->once())
			->method('find')
			->with($this->equalTo(3))
			->will($this->throwException(new DoesNotExistException('')));

		$this->service->update(3, 'title', 'color', 'description', $this->userId);
	}

}