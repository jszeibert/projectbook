<!--
Nextcloud - ProjectBook

@copyright Copyright (c) 2022 Johannes Szeibert <johannes@szeibert.de>

@author Johannes Szeibert <johannes@szeibert.de>

@license GNU AGPL version 3 or any later version

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->

<template>
	<Content app-name="projectbook">
		<AppNavigation>
			<div>AppNavigation</div>
		</AppNavigation>
		<AppContent>
			<div>AppContent</div>
		</AppContent>
	</Content>
</template>

<script>
import { Content, AppNavigation, AppContent } from '@nextcloud/vue'

export default {
	name: 'App',
	components: {
		Content,
		AppNavigation,
		AppContent,
	},
	data() {
	},
	methods: {
		log() {
			console.debug(arguments)
		},
	},
}
</script>
<style scoped>
	#app-content > div {
		width: 100%;
		height: 100%;
		padding: 20px;
		display: flex;
		flex-direction: column;
		flex-grow: 1;
	}
</style>
