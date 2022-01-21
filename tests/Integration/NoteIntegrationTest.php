<?php

namespace OCA\ProjectBook\Tests\Integration\Controller;

use OCP\AppFramework\App;
use OCP\IRequest;
use PHPUnit\Framework\TestCase;


use OCA\ProjectBook\Db\Project;
use OCA\ProjectBook\Db\ProjectMapper;
use OCA\ProjectBook\Controller\ProjectController;

class ProjectIntegrationTest extends TestCase {
	private $controller;
	private $mapper;
	private $userId = 'john';

	public function setUp(): void {
		$app = new App('projectbook');
		$container = $app->getContainer();

		// only replace the user id
		$container->registerService('userId', function () {
			return $this->userId;
		});

		// we do not care about the request but the controller needs it
		$container->registerService(IRequest::class, function () {
			return $this->createMock(IRequest::class);
		});

		$this->controller = $container->query(ProjectController::class);
		$this->mapper = $container->query(ProjectMapper::class);
	}

	public function testUpdate() {
		// create a new project that should be updated
		$project = new Project();
		$project->setTitle('old_title');
		$project->setColor('old_color');
		$project->setDescription('old_description');
		$project->setUserId($this->userId);

		$id = $this->mapper->insert($project)->getId();

		// fromRow does not set the fields as updated
		$updatedproject = project::fromRow([
			'id' => $id,
			'user_id' => $this->userId
		]);
		$updatedproject->setDescription('description');
		$updatedproject->setColor('color');
		$updatedproject->setTitle('title');

		$result = $this->controller->update($id, 'title', 'color', 'content');

		$this->assertEquals($updatedproject, $result->getData());

		// clean up
		$this->mapper->delete($result->getData());
	}
}
