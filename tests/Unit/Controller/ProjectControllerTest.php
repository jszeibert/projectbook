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

namespace OCA\ProjectBook\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;

use OCA\ProjectBook\Service\NotFoundException;
use OCA\ProjectBook\Service\ProjectService;
use OCA\ProjectBook\Controller\ProjectController;

class ProjectControllerTest extends TestCase {

	protected $controller;
	protected $service;
	protected $userId = 'john';
	protected $request;

	public function setUp(): void {
		$this->request = $this->getMockBuilder('OCP\IRequest')->getMock();
		$this->service = $this->getMockBuilder('OCA\ProjectBook\Service\ProjectService')
			->disableOriginalConstructor()
			->getMock();
		$this->controller = new ProjectController(
			'projectbook', $this->request, $this->service, $this->userId
		);
	}

	public function testUpdate() {
		$project = 'just check if this value is returned correctly';
		$this->service->expects($this->once())
			->method('update')
			->with($this->equalTo(3),
					$this->equalTo('title'),
					$this->equalTo('color'),
					$this->equalTo('description'),
				   $this->equalTo($this->userId))
			->will($this->returnValue($project));

		$result = $this->controller->update(3, 'title', 'color', 'content');

		$this->assertEquals($project, $result->getData());
	}


	public function testUpdateNotFound() {
		// test the correct status code if no project is found
		$this->service->expects($this->once())
			->method('update')
			->will($this->throwException(new NotFoundException()));

		$result = $this->controller->update(3, 'title', 'color', 'description');

		$this->assertEquals(Http::STATUS_NOT_FOUND, $result->getStatus());
	}

}