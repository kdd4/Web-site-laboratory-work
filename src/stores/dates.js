import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useDatesStore = defineStore('dates', () => {
	const day_in_week = ref(7);
	const week_cnt = ref(6);
	const day_of_week = ref(['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс']);
	const months = ref([
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
	]);

	return { day_in_week, week_cnt, day_of_week, months };
});
