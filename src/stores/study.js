import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useStudyStore = defineStore('study', () => {
	const hUniversity = ref('ФГАОУ Севастопольский государственный университет');
	const hFaculty = ref('ВТШ "СПИ". Факультет информационных технологий');

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

	const cellClasses = ref('border md:p-0.5 border-gray-600');

	return { hUniversity, hFaculty, tableHead, tableBody, cellClasses };
});
