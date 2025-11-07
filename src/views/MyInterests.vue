<script setup>
import { ref } from 'vue';

const lists = ref([
	{
		id: 'myinterests',
		head: 'Мои интересы',
		text: 'Есть много заинтересовавших меня сфер, которые я начал изучать:',
		list: [
			'Поиск простых чисел и способы проверки больших чисел на простоту',
			'Написание своей игры',
			'Пайка, электроника и программирование под микроконтроллеры',
			'3D моделирование и печать моделей на 3D принтере',
			'Вычисления на видеокартах (использовал OpenCL)',
			'Автомобили и как они работают',
			'и т.д.',
		],
	},
	{
		id: 'myhobby',
		head: 'Мои хобби',
		list: [
			'3D моделирование и печать моделей на 3D принтере',
			'Программирование шахмат (скорее как способ улучшить умения проектировать программы)',
			'Сборка кубика-рубика',
		],
	},
	{
		id: 'favoutitefilms',
		head: 'Мои любимые фильмы',
		list: ['Первому игроку приготовиться', 'Притяжение', 'Игра энедера'],
	},
	{
		id: 'favoutiteanime',
		head: 'Мои любимые аниме',
		list: [
			'Психопаспорт',
			'Эксперименты лейн',
			'Токийское восьми-бальное',
			'Союз серокрылых',
			'Астра, затерянная в космосе',
			'Выжывание на необитаемой планете',
			'Нет игры - нет жизни',
			'86',
			'Дом теней',
			'Акудама Драйв',
		],
	},
]);
</script>

<template>
	<main class="flex">
		<div class="flex grow-3 flex-col items-stretch">
			<h2 class="mb-10 text-center text-2xl font-bold">Мои интересы</h2>
			<div
				v-for="(block, ind) in lists"
				:key="ind"
				:id="block.id"
				class="mx-3 mb-4 rounded-lg bg-neutral-300 p-5"
			>
				<h3 v-if="block.head !== undefined" class="mb-3 text-xl font-bold">{{ block.head }}</h3>
				<p v-if="block.text !== undefined" class="mb-2 text-base/relaxed">{{ block.text }}</p>
				<ul v-if="block.list !== undefined" class="list-inside list-disc">
					<li v-for="elem in block.list" class="text-base/loose">{{ elem }}</li>
				</ul>
			</div>
		</div>
		<div class="max-w-70 min-w-50 grow-2 not-sm:hidden">
			<ul class="sticky top-2 space-y-2.5 rounded-l-lg bg-neutral-300 p-3">
				<li v-for="(list, ind) in lists" :key="ind">
					<a
						:href="'#' + list.id"
						class="rounded-md border border-neutral-400 bg-neutral-200 p-0.5 whitespace-nowrap"
					>
						{{ list.head }}
					</a>
				</li>
			</ul>
		</div>
	</main>
</template>
