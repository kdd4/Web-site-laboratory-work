<script setup>
import { ref } from 'vue';

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

let id = 1;

const tableBody = ref([
	{
		number: id++,
		discipline: 'Экология',
		faculty: 'БЖ',
		hours: [54, 27, 18, 0, 9, 27],
	},
	{
		number: id++,
		discipline: 'Высшая математика',
		anchor: {
			text: 'Тест',
			route: '/test',
		},
		faculty: 'ВМ',
		hours: [540, 282, 141, 0, 141, 258],
	},
	{
		number: id++,
		discipline: 'Русский язык и культура речи',
		faculty: 'НГиГ',
		hours: [108, 54, 18, 0, 36, 54],
	},
	{
		number: id++,
		discipline: 'Основы дискретной математики',
		faculty: 'ИС',
		hours: [216, 139, 87, 0, 52, 77],
	},
	{
		number: id++,
		discipline: 'Основы программирования и алгоритмические языки',
		faculty: 'ИС',
		hours: [405, 210, 105, 87, 18, 195],
	},
	{
		number: id++,
		discipline: 'Основы экологии',
		faculty: 'ПЭОП',
		hours: [54, 27, 18, 0, 9, 27],
	},
	{
		number: id++,
		discipline: 'Теория вероятностей и математическая статистика',
		faculty: 'ИС',
		hours: [162, 72, 54, 18, 0, 90],
	},
	{
		number: id++,
		discipline: 'Физика',
		faculty: 'Физики',
		hours: [324, 194, 106, 88, 0, 130],
	},
	{
		number: id++,
		discipline: 'Основы электротехники и электроники',
		faculty: 'ИС',
		hours: [108, 72, 36, 18, 18, 36],
	},
	{
		number: id++,
		discipline: 'Численные методы в информатике',
		faculty: 'ИС',
		hours: [189, 89, 36, 36, 17, 100],
	},
	{
		number: id++,
		discipline: 'Методы исследования операций',
		faculty: 'ИС',
		hours: [216, 104, 52, 35, 17, 112],
	},
]);
</script>

<template>
	<main>
		<h2>{{ hUniversity }}</h2>
		<h3>{{ hFaculty }}</h3>
		<table class="m-1 table-auto">
			<thead>
				<tr v-if="tableHead !== undefined" v-for="row in tableHead">
					<th v-for="elem in row" :rowspan="elem.rowspan" :colspan="elem.colspan">
						{{ elem.text }}
					</th>
				</tr>
			</thead>
			<tbody v-if="tableBody !== undefined">
				<tr v-for="elem in tableBody">
					<td>{{ elem.number }}</td>
					<td class="discipline">
						{{ elem.discipline }}
						<RouterLink v-if="elem.anchor !== undefined" :to="elem.anchor.route">
							{{ elem.anchor.text }}
						</RouterLink>
					</td>
					<td>{{ elem.faculty }}</td>
					<td v-for="hour in elem.hours">{{ hour }}</td>
				</tr>
			</tbody>
		</table>
	</main>
</template>

<style scoped>
main {
	display: flex;
	flex-direction: column;
	align-items: center;
}

table {
	font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
	border-collapse: collapse;
}

td a {
	margin: 0em 1em 0em 1em;
	padding: 0em 0.2em 0em 0.2em;
	background-color: goldenrod;
	border-radius: 10%;
	text-decoration: none;
	color: black;
}

table th,
table td {
	border: 1px solid black;
}

.discipline {
	padding-right: 1em;
}

table td:nth-child(1) {
	text-align: center;
}

table td:nth-child(3) {
	text-align: center;
}

table td:nth-child(n + 4) {
	text-align: right;
}
</style>
