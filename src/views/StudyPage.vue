<script setup>
import { storeToRefs } from 'pinia';
import { useStudyStore } from '@/stores/study';

const studyStore = useStudyStore();
const { hUniversity, hFaculty, tableHead, tableBody, cellClasses } = storeToRefs(studyStore);
</script>

<template>
	<main class="flex flex-col items-center">
		<h2 class="text-center text-xl font-bold not-md:text-lg">{{ hUniversity }}</h2>
		<h3 class="mb-5 text-center text-lg not-md:text-base">{{ hFaculty }}</h3>
		<table class="m-1 table-auto border-collapse not-md:text-sm">
			<thead>
				<div v-if="tableHead !== undefined" class="contents">
					<tr v-for="(row, ind) in tableHead" :key="ind">
						<th
							v-for="(elem, el_ind) in row"
							:key="el_ind"
							:rowspan="elem.rowspan"
							:colspan="elem.colspan"
							:class="cellClasses"
							class="align-middle"
						>
							{{ elem.text }}
						</th>
					</tr>
				</div>
			</thead>
			<tbody v-if="tableBody !== undefined">
				<tr v-for="(elem, el_ind) in tableBody" :key="el_ind">
					<td :class="cellClasses" class="text-center">{{ el_ind + 1 }}</td>
					<td :class="cellClasses">
						{{ elem.discipline }}
						<RouterLink
							class="mx-1 rounded-md bg-amber-500"
							v-if="elem.anchor !== undefined"
							:to="elem.anchor.route"
						>
							{{ elem.anchor.text }}
						</RouterLink>
					</td>
					<td :class="cellClasses" class="text-center">{{ elem.faculty }}</td>
					<td
						v-for="(hour, hour_ind) in elem.hours"
						:key="hour_ind"
						:class="cellClasses"
						class="text-right"
					>
						{{ hour }}
					</td>
				</tr>
			</tbody>
		</table>
	</main>
</template>
