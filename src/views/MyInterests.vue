<script setup>
import { ref } from 'vue'

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
])
</script>

<template>
	<main>
		<div class="info">
			<h2>Мои интересы</h2>
			<div v-for="block in lists" :id="block.id" class="textblock">
				<h3 v-if="block.head !== undefined">{{ block.head }}</h3>
				<p v-if="block.text !== undefined">{{ block.text }}</p>
				<ul v-if="block.list !== undefined">
					<li v-for="elem in block.list">{{ elem }}</li>
				</ul>
			</div>
		</div>
		<div class="navigation">
			<ul>
				<li v-for="list in lists">
					<a :href="'#' + list.id">
						{{ list.head }}
					</a>
				</li>
			</ul>
		</div>
	</main>
</template>

<style scoped>
main {
	--nav_color: black;
	--nav_button_color: gainsboro;
	--nav_button_text_color: black;
}

main {
	display: flex;
	flex-direction: row;
}

.info {
	flex-grow: 3;

	display: flex;
	flex-direction: column;
	align-items: center;
}

.navigation {
	flex-grow: 2;
	min-width: 14em;
	max-width: 16em;
	margin: 1em 0em 1em 1em;
}

.navigation ul {
	position: sticky;
	top: 1em;

	list-style: none;

	background-color: var(--nav_color);

	padding: 0.2em 0em 0.2em 0em;
}

.navigation li {
	margin: 1em;
}

.navigation li a {
	text-decoration: none;

	color: var(--nav_color);
	background-color: var(--nav_button_color);
	border-radius: 5%;
	text-align: center;

	white-space: nowrap;
	padding: 0.2em;
}

.textblock {
	font-size: large;

	width: 90%;
	min-width: 10em;

	margin: 20px auto;
	padding: 20px;
	text-align: justify;
	background: #f9f9f9;
	line-height: 1.6;
}

@media (max-width: 700px) {
	.navigation {
		display: none;
	}
}
</style>
