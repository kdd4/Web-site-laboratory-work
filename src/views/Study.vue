<script setup>
import { ref } from 'vue';

const cellClasses = ref('border md:p-0.5 border-gray-600');

const hUniversity = ref('ФГАОУ Севастопольский государственный университет');
const hFaculty = ref('ВШИ "СПИ". Факультет информационных технологий');

const tableHead = ref([
	[{ text: 'ПЛАН УЧЕБНОГО ПРОЦЕССА', colspan: 9 }],
	[
		{ text: '№', rowspan: 2 },
		{ text: 'Дисциплина', rowspan: 2 },
		{ text: 'Кафедра', rowspan: 2 },
		{ text: 'Всего часов', colspan: 6 },
	],
	[
		{ text: 'Всего' },
		{ text: 'Ауд' },
		{ text: 'Лк' },
		{ text: 'Лб' },
		{ text: 'Пр' },
		{ text: 'СРС' },
	],
]);

const tableBody = ref([
	{
		discipline: 'Экология',
		faculty: 'БЖ',
		hours: [54, 27, 18, 0, 9, 27],
	},
	{
		discipline: 'Высшая математика',
		anchor: {
			text: 'Тест',
			route: '/test',
		},
		faculty: 'ВМ',
		hours: [540, 282, 141, 0, 141, 258],
	},
	{
		discipline: 'Русский язык и культура речи',
		faculty: 'НГиГ',
		hours: [108, 54, 18, 0, 36, 54],
	},
	{
		discipline: 'Основы дискретной математики',
		faculty: 'ИС',
		hours: [216, 139, 87, 0, 52, 77],
	},
	{
		discipline: 'Основы программирования и алгоритмические языки',
		faculty: 'ИС',
		hours: [405, 210, 105, 87, 18, 195],
	},
	{
		discipline: 'Основы экологии',
		faculty: 'ПЭОП',
		hours: [54, 27, 18, 0, 9, 27],
	},
	{
		discipline: 'Теория вероятностей и математическая статистика',
		faculty: 'ИС',
		hours: [162, 72, 54, 18, 0, 90],
	},
	{
		discipline: 'Физика',
		faculty: 'Физики',
		hours: [324, 194, 106, 88, 0, 130],
	},
	{
		discipline: 'Основы электротехники и электроники',
		faculty: 'ИС',
		hours: [108, 72, 36, 18, 18, 36],
	},
	{
		discipline: 'Численные методы в информатике',
		faculty: 'ИС',
		hours: [189, 89, 36, 36, 17, 100],
	},
	{
		discipline: 'Методы исследования операций',
		faculty: 'ИС',
		hours: [216, 104, 52, 35, 17, 112],
	},
]);
</script>

<template>
	<main class="flex flex-col items-center">
		<h2 class="text-center text-xl font-bold not-md:text-lg">{{ hUniversity }}</h2>
		<h3 class="mb-5 text-center text-lg not-md:text-base">{{ hFaculty }}</h3>
		<table class="m-1 table-auto border-collapse not-md:text-sm">
			<thead>
				<tr v-if="tableHead !== undefined" v-for="(row, ind) in tableHead" :key="ind">
					<th
						v-for="(elem, el_ind) in row"
						:key="el_ind"
						:rowspan="elem.rowspan"
						:colspan="elem.colspan"
						:class="cellClasses"
					>
						{{ elem.text }}
					</th>
				</tr>
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
