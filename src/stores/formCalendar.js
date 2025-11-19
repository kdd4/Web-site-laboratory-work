import { defineStore } from 'pinia';
import { ref, watch } from 'vue';

export const useFormCalendar = defineStore('formCalendar', () => {
	const showCalendar = ref(false);
	const dateCalendar = ref(new Date(Date.now()));
	let watchCalendar = null;

	function useCalendar(field) {
		if (watchCalendar) {
			watchCalendar.stop();
			watchCalendar = null;
		}

		if (showCalendar.value) {
			showCalendar.value = false;
			return;
		}

		dateCalendar.value = field.fieldValue;
		watchCalendar = watch(dateCalendar, () => (field.fieldValue = dateCalendar.value));

		showCalendar.value = true;
	}

	function closeCalendar() {
		if (watchCalendar) {
			watchCalendar.stop();
			watchCalendar = null;
		}

		if (showCalendar.value) showCalendar.value = false;
	}

	const calendarDate = ref({
		show: showCalendar,
		date: dateCalendar,
	});

	return { calendarDate, useCalendar, closeCalendar };
});
