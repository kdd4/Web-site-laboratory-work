import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useDatesStore } from '@/stores/dates';

export const useCalendarStore = defineStore('calendar', () => {
	const datesState = useDatesStore();
	const { day_in_week, week_cnt } = datesState;

	const weeks = ref(new Array(day_in_week * week_cnt));

	function updateWeeks(date) {
		let copy_date = new Date(date);

		copy_date.setDate(1);
		let dayOfWeek = ((copy_date.getDay() + 6) % 7) + 1;

		copy_date.setMonth((copy_date.getMonth() + 1) % 12);
		copy_date.setDate(0);
		let daysInMonth = copy_date.getDate();

		// fill array with 0
		weeks.value.fill(0);

		for (let day = 0; day < daysInMonth; day++) {
			weeks.value[day - 1 + dayOfWeek] = day + 1;
		}
	}

	function getDate(day, week) {
		return weeks.value[day - 1 + (week - 1) * day_in_week];
	}

	function addMonth(date, val) {
		let new_date = new Date(date);

		let month = new_date.getMonth() + val;

		let year = new_date.getFullYear();
		if (month > 11) {
			new_date.setFullYear(year + 1);
		} else if (month < 0) {
			new_date.setFullYear(year - 1);
		}
		month = (month + 12) % 12;
		new_date.setMonth(month);

		return new_date;
	}

	function addYear(date, val) {
		let new_date = new Date(date);

		let year = new_date.getFullYear() + val;
		new_date.setFullYear(year);

		return new_date;
	}

	function setDate(date, day, week) {
		let cur_date = getDate(day, week);

		if (!cur_date) return;

		let new_date = new Date(date);
		new_date.setDate(cur_date);

		return new_date;
	}

	return {
		updateWeeks,
		getDate,
		addMonth,
		addYear,
		setDate,
	};
});
