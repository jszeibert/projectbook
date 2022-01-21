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
	<AppNavigationVue :class="{'icon-loading': loading}">
		<template #list>
			<AppNavigationItem
				:title="t('projectbook', 'Dashboard')"
				icon="icon-star-dark"
				:exact="true"
				to="/" />
			<AppNavigationItem
				:title="t('projectbook', 'Pinned Projects')"
				icon="icon-star-dark"
				:exact="true"
				to="/" />
			<AppNavigationItem
				:title="t('projectbook', 'Open Projects')"
				icon="icon-star-dark"
				:exact="true"
				to="/" />
			<AppNavigationItem
				:title="t('projectbook', 'Archived Projects')"
				icon="icon-star-dark"
				:exact="true"
				to="/" />
			<AppNavigationNew v-if="!loading"
				:text="t('projectbook', 'New Project')"
				:disabled="false"
				button-id="new-projectbook-button"
				button-class="icon-add"
				@click="newButtonAction" />
		</template>
		<template #footer>
			<AppNavigationSettings>
				<div>There is nothing here yet</div>
			</AppNavigationSettings>
		</template>
	</AppNavigationVue>
</template>

<script>
import { AppNavigation as AppNavigationVue, AppNavigationItem, AppNavigationNew, AppNavigationSettings } from '@nextcloud/vue'
export default {
	name: 'AppNavigation',
	components: {
		AppNavigationVue,
		AppNavigationSettings,
		AppNavigationItem,
		AppNavigationNew,
	},
	props: {
		loading: {
			type: Boolean,
			default: false,
		},
	},
	data() {
		return {
			opened: false,
			groups: [],
			groupLimit: [],
			groupLimitDisabled: true,
		}
	},
	methods: {
		newButtonAction() {
			console.debug(arguments)
		},
	},
}
</script>
