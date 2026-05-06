import { defineStore } from 'pinia';
import { computed, ref, watch } from 'vue';
import { useAuthStore } from './auth';
import { usePagesStore } from './pages';

export const useUserActivitiesStore = defineStore('user activities', () => {
	const auth = useAuthStore();
	const pages = usePagesStore();

	const activities = ref([]);

	const pageSize = ref(10);
	const page = ref(0);

	async function updateActivities() {
		if (!auth.isAuth) {
			activities.value = [];
			return;
		}

		let response = await fetch('/api/visits', {
			headers: {
				Accept: 'application/json',
			},
		});

		let list = await response.json();

		if (!list.length) {
			activities.value = [];
			return;
		}

		activities.value = list.map(function (act) {
			let page = pages.pages.find((page) => page.name === act.page);

			if (page !== undefined) act.page = page.text;
			return act;
		});

		activities.value.sort((a, b) => new Date(b.time) - new Date(a.time));
	}

	updateActivities();
	watch(() => auth.isAuth, updateActivities);

	const pageCount = computed(() => Math.ceil(activities.value.length / pageSize.value));
	const activitiesPage = computed(() => [
		['Дата', 'Страница', 'IP', 'Host', 'Браузер'],
		...activities.value.slice(page.value * pageSize.value, (page.value + 1) * pageSize.value),
	]);

	const pageListSize = ref(5);
	const pageList = computed(function () {
		let lowLimit = Math.max(page.value - Math.floor(pageListSize.value / 2), 0);
		let highLimit = Math.max(pageCount.value - pageListSize.value, 0);
		let length = Math.min(pageCount.value, pageListSize.value);

		return Array.from({ length }, (_, k) => Math.min(lowLimit, highLimit) + k);
	});

	const firstPageShow = computed(() => !pageList.value.includes(0) && pageList.value.length != 0);
	const lastPageShow = computed(
		() => !pageList.value.includes(pageCount.value - 1) && pageList.value.length != 0,
	);

	function goToFirstPage() {
		page.value = 0;
	}

	function goToPage(newPage) {
		page.value = newPage;
	}

	function goToLastPage() {
		page.value = pageCount.value - 1;
	}

	return {
		activitiesPage,
		page,
		pageList,
		firstPageShow,
		lastPageShow,
		goToFirstPage,
		goToPage,
		goToLastPage,
		updateActivities,
	};
});
