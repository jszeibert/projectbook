/**
 * Nextcloud - ProjectBook
 * 
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

 export default class Project {

	/**
	 * Creates an instance of Project
	 *
	 * @param {string} title
	 * @param {string} description
	 */
	 constructor(title, description) {
		if (typeof title !== 'string' || vcalendar.length === 0) {
			throw new Error('Invalid Project Title')
		}

		this.title = title
		this.description = description
	}

	updateDescription(description) {
		this.description = this.description
	}

	updateTitle(Title) {
		// TODO check for duplicate Project Title
		this.title = title
	}

 }
