import { defineStore, storeToRefs } from 'pinia';
import { computed } from 'vue';
import { useVisitsStore } from '@/stores/visits';
import { usePagesStore } from '@/stores/pages';

export const useHistoryStore = defineStore('history', () => {
	const visitStore = useVisitsStore();

	const pagesStore = usePagesStore();
	const { pages } = storeToRefs(pagesStore);

	const visitsTable = computed(() => {
		const table = [
			{
				elements: ['Страница', 'Посещения', 'Посещения за сессию'],
				style: 'font-bold text-center',
			},
		];

		for (let page of pages.value) {
			table.push({
				elements: [
					page.text,
					visitStore.getVisits(page.route),
					visitStore.getVisitsSession(page.route),
				],
				style: 'nth-[n+1]:text-center',
			});
		}
		return table;
	});

	return { visitsTable };
});
