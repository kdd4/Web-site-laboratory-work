import { defineStore } from 'pinia';

export const useDatesStore = defineStore('dates', () => {
	const day_in_week = 7;
	const week_cnt = 6;
	const day_of_week = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
	const months = [
		'Январь',
		'Февраль',
		'Март',
		'Апрель',
		'Май',
		'Июнь',
		'Июль',
		'Август',
		'Сентябрь',
		'Октябрь',
		'Ноябрь',
		'Декабрь',
	];

	return { day_in_week, week_cnt, day_of_week, months };
});
