import { defineStore } from 'pinia';
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';

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

	let route = useRoute();
	watch(route, closeCalendar);

	return { calendarDate, useCalendar, closeCalendar };
});
