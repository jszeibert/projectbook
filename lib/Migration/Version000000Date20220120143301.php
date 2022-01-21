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


  namespace OCA\ProjectBook\Migration;

  use Closure;
  use OCP\DB\ISchemaWrapper;
  use OCP\Migration\SimpleMigrationStep;
  use OCP\Migration\IOutput;
  use OCA\ProjectBook\AppInfo\Application;

  class Version000000Date20220120143301 extends SimpleMigrationStep {

	/**
	* @param IOutput $output
	* @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	* @param array $options
	* @return null|ISchemaWrapper
	*/
	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		if (!$schema->hasTable(Application::APP_ID.'_projects')) {
			$table = $schema->createTable(Application::APP_ID.'_projects');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('title', 'string', [
				'notnull' => true,
				'length' => 200
			]);
			$table->addColumn('color', 'string', [
				'notnull' => true,
				'length' => 200
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);
			$table->addColumn('description', 'text', [
				'notnull' => false,
				'default' => ''
			]);
			$table->addColumn('archived', 'boolean', [
				'notnull' => false,
				'default' => false,
			]);

			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'puid_index');
		}

		if (!$schema->hasTable(Application::APP_ID.'_entries')) {
			$table = $schema->createTable(Application::APP_ID.'_entries');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('title', 'string', [
				'notnull' => true,
				'length' => 200
			]);
			$table->addColumn('type', 'string', [
				'notnull' => true,
				'length' => 200
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);
			$table->addColumn('project_id', 'bigint', [
				'notnull' => true,
				'length' => 8,
			]);
			$table->addColumn('content', 'text', [
				'notnull' => false,
				'default' => ''
			]);
			$table->addColumn('archived', 'boolean', [
				'notnull' => false,
				'default' => false,
			]);

			$table->setPrimaryKey(['id']);
			$table->addIndex(['project_id'], 'pid_index');
			$table->addIndex(['user_id'], 'euid_index');
		}
		return $schema;
	}
}
