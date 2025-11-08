<script setup>
import { RouterLink, useRoute } from 'vue-router';
import { ref } from 'vue';

const route = useRoute();

function isCurrentPage() {
	return this.route == route.path;
}

const navigation_buttons = ref([
	{ route: '/', text: 'Главная', currentPage: isCurrentPage },
	{ route: '/aboutme', text: 'Обо мне', currentPage: isCurrentPage },
	{ route: '/myinterests', text: 'Мои интересы', currentPage: isCurrentPage },
	{ route: '/study', text: 'Учеба', currentPage: isCurrentPage },
	{ route: '/photoalbum', text: 'Фотоальбом', currentPage: isCurrentPage },
	{ route: '/contact', text: 'Контакт', currentPage: isCurrentPage },
	{ route: '/test', text: 'Тест по дисциплине', currentPage: isCurrentPage },
]);

const isBurgerMenu = ref(false);
const isBurgerMenuOpened = ref(false);

function checkBurgerMenu(event) {
	isBurgerMenuOpened.value = false;
	isBurgerMenu.value = window.innerWidth <= 600; // px
}

window.addEventListener('resize', checkBurgerMenu, { passive: true });
checkBurgerMenu();

const time = ref({
	sec: 0,
	min: 0,
	hour: 0,
	month: '',
	year: 2025,
});

function updateTime() {
	let now = new Date(Date.now());

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

	time.value.sec = now.getSeconds();
	time.value.min = now.getMinutes();
	time.value.hour = now.getHours();
	time.value.month = months[now.getMonth()];
	time.value.year = now.getFullYear();
}

setInterval(updateTime.bind(this), 1000);
updateTime();
</script>

<template>
	<header
		:class="{ 'flex-col': isBurgerMenu }"
		class="m-1 mb-9 flex items-center justify-evenly bg-black"
	>
		<img
			src="/src/assets/images/menu_button.jpg"
			alt="menu"
			class="m-1 max-w-10 rounded-sm transition-all duration-500 ease-in-out"
			v-if="isBurgerMenu"
			:class="{
				'm-3 rotate-90 invert': isBurgerMenu && isBurgerMenuOpened,
			}"
			@click="isBurgerMenuOpened = !isBurgerMenuOpened"
		/>
		<h1
			v-if="!isBurgerMenu"
			class="mx-2 grow-0 font-serif text-3xl font-bold text-white transition-all duration-1000 ease-in-out hover:rotate-30"
		>
			LW3
		</h1>
		<ul
			v-if="!isBurgerMenu || isBurgerMenuOpened"
			:class="{ 'flex-col': isBurgerMenu }"
			class="my-2.5 flex grow list-none flex-wrap items-center justify-evenly"
		>
			<li
				v-for="(button, ind) in navigation_buttons"
				:key="ind"
				:class="{ 'my-0.5': isBurgerMenu }"
				class="mx-0.5 my-1 p-0.5 text-white"
			>
				<RouterLink
					:to="button.route"
					:class="{ 'border-4': button.currentPage() }"
					class="rounded-md border-emerald-700 bg-neutral-300 p-1 whitespace-nowrap text-black transition-all duration-200 ease-linear hover:bg-neutral-500"
				>
					{{ button.text }}
				</RouterLink>
			</li>
		</ul>
		<div v-if="!isBurgerMenu" class="p-1 font-serif whitespace-break-spaces text-white">
			{{ time.hour }}:{{ time.min }}:{{ time.sec }} {{ time.month }} {{ time.year }}
		</div>
	</header>
</template>
