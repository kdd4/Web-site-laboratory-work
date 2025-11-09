<script setup>
import { useVisitsStore } from '@/stores/visits';
import { ref } from 'vue';

let visitStore = useVisitsStore();

const pages = [
	{ route: '/', text: 'Главная' },
	{ route: '/aboutme', text: 'Обо мне' },
	{ route: '/myinterests', text: 'Мои интересы' },
	{ route: '/study', text: 'Учеба' },
	{ route: '/photoalbum', text: 'Фотоальбом' },
	{ route: '/contact', text: 'Контакт' },
	{ route: '/test', text: 'Тест по дисциплине' },
	{ route: '/history', text: 'История просмотра' },
];

const table = ref([
	{
		elements: ['Страница', 'Посещения', 'Посещения за сессию'],
		style: 'font-bold text-center',
	},
]);

for (let page of pages) {
	table.value.push({
		elements: [
			page.text,
			visitStore.getVisits(page.route),
			visitStore.getVisitsSession(page.route),
		],
		style: 'nth-[n+1]:text-center',
	});
}
</script>

<template>
	<main>
		<h2 class="mb-10 text-center text-2xl font-bold">История просмотра</h2>
		<div>
			<div
				v-for="(row, row_ind) in table"
				:key="row_ind"
				class="mx-1 flex justify-center"
				:class="row.style"
			>
				<div
					v-for="elem in row.elements"
					class="w-30 min-w-25 border border-neutral-400 not-sm:text-sm"
				>
					{{ elem }}
				</div>
			</div>
		</div>
	</main>
</template>
