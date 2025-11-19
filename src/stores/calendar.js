import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useCalendarStore = defineStore('calendar', () => {
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

	const weeks = ref(new Array(day_in_week * week_cnt));

	function getDate(day, week) {
		return weeks.value[day - 1 + (week - 1) * day_in_week];
	}

	return {
		day_in_week,
		week_cnt,
		day_of_week,
		months,
		weeks,
		getDate,
	};
});
