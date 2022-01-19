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
	<div class="header">
		<div class="project-title">
			<div class="project-bullet icon-star-dark" />
			<h2>Project Title</h2>
			<h3 class="active">
				Journal
			</h3>
			<h3>Activities</h3>
		</div>
		<div class="project-actions">
			<div class="project-search">
				<input type="search"
					class="icon-search">
			</div>
			<div class="project-action-buttons">
				<Actions slot="trigger" :title="t('deck', 'Apply filter')">
					<ActionButton icon="icon-filter" />
				</Actions>
			</div>
		</div>
	</div>
</template>

<script>
import { Actions, ActionButton } from '@nextcloud/vue'
export default {
	components: {
		Actions,
		ActionButton,
	},
	data() {
	},
	computed: {

	},
	methods: {

	},
}
</script>

<style lang="scss" scoped>
$breakpoint-mobile: 1024px;

.header {
	display: flex;
	padding: 3px;
	height: 44px;
	padding-left: 44px;
	background-color: var(--color-background-dark);
	z-index: 1000;

	.project-title {
		display: flex;
		align-items: center;

		h2 {
			margin: 0;
			margin-right: 10px;
		}

		h3 {
			margin: 0;
			margin-right: 15px;
			margin-left: 15px;

			.active {
				border-bottom: 2px solid;
			}
		}

		.project-bullet {
			display: inline-block;
			width: 20px;
			height: 20px;
			border: none;
			border-radius: 50%;
			background-color: transparent;
			margin: 12px;
			margin-left: -4px;
		}
	}

	.project-actions {
		flex-grow: 1;
		order: 100;
		display: flex;
		justify-content: flex-end;
	}

	.project-action-buttons {
		display: flex;
		button {
			border: 0;
			width: 44px;
			margin: 0 0 0 -1px;
			background-color: transparent;
		}
	}

	.project-search {
		input[type=search] {
			background-position: 5px;
			padding-left: 24px;
		}
	}

	.sortorder {
		margin-left: auto;
	}
}
</style>
