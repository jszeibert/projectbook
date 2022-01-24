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

use OCA\ProjectBook\Service\NotFoundException;
use OCP\AppFramework\Db\DoesNotExistException;

use OCA\ProjectBook\Db\Project;
use OCA\ProjectBook\Service\ProjectService;
use OCA\ProjectBook\Db\ProjectprojectMapper;

class ProjectServiceTest extends TestCase {

	private $service;
	private $projectMapper;
	private $userId = 'jones';

	public function setUp(): void {
		$this->projectMapper = $this->getMockBuilder('OCA\ProjectBook\Db\ProjectMapper')
			->disableOriginalConstructor()
			->getMock();
		$this->service = new ProjectService($this->projectMapper);
	}

	public function testFind() {
		$p = new Project();
		$p->setId(1);
		$this->projectMapper->expects($this->once())
			->method('find')
			->with(1)
			->willReturn($p);
		$this->assertEquals($p, $this->service->find(1,$this->userId));
	}

	public function testFindAll() {
		$p1 = new Project();
		$p1->setId(1);
		$p2 = new Project();
		$p2->setId(2);
		$p3 = new Project();
		$p3->setId(3);
		$this->projectMapper->expects($this->once())
			->method('findAll')
			->with($this->userId)
			->willReturn([$p1, $p2, $p3]);

		$result = $this->service->findAll($this->userId);
		sort($result);
		$this->assertEquals([$p1, $p2, $p3], $result);
	}

	public function testCreate() {
		$project = Project::fromRow([
			'id' => 3,
			'title' => 'My project',
			'color' => '00ff00',
			'description' => 'some description',
			'user_id' => $this->userId
		]);
		$this->projectMapper->expects($this->once())
			->method('insert')
			->willReturn($project);
		$p = $this->service->create('My project', '00ff00', 'some description', $this->userId);

		$this->assertEquals($p->getTitle(), 'My project');
		$this->assertEquals($p->getColor(), '00ff00');
		$this->assertEquals($p->getDescription(), 'some description');
		$this->assertEquals($p->getUserId(), $this->userId);
	}

	public function testUpdate() {
		// the existing project
		$project = Project::fromRow([
			'id' => 3,
			'title' => 'title',
			'color' => 'color',
			'description' => 'description'
		]);
		$this->projectMapper->expects($this->once())
			->method('find')
			->with($this->equalTo(3))
			->will($this->returnValue($project));

		// the project when updated
		$updatedProject = Project::fromRow(['id' => 3]);
		$updatedProject->setTitle('Projectname');
		$updatedProject->setColor('#ff5733');
		$updatedProject->setDescription('ProjectDescription');
		$this->projectMapper->expects($this->once())
			->method('update')
			->with($this->equalTo($updatedProject))
			->will($this->returnValue($updatedProject));

		$result = $this->service->update(3, 
			'Projectname', 
			'#ff5733', 
			'ProjectDescription',
			$this->userId);

		$this->assertEquals($updatedProject, $result);
	}

	public function testUpdateNotFound() {
		$this->expectException(NotFoundException::class);
		// test the correct status code if no project is found
		$this->projectMapper->expects($this->once())
			->method('find')
			->with($this->equalTo(3))
			->will($this->throwException(new DoesNotExistException('')));

		$this->service->update(3, 'title', 'color', 'description', $this->userId);
	}
}
