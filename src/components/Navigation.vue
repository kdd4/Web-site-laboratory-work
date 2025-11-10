<script setup>
import { RouterLink } from 'vue-router';
import { ref, onMounted, onBeforeUnmount } from 'vue';

import { usePagesStore } from '@/stores/pages';
import { storeToRefs } from 'pinia';

const pagesStore = usePagesStore();
const { pages: navigation_buttons } = storeToRefs(pagesStore);

const isBurgerMenu = ref(false);
const isBurgerMenuOpened = ref(false);

function checkBurgerMenu(event) {
	isBurgerMenuOpened.value = false;
	isBurgerMenu.value = window.innerWidth <= 650; // px
}

window.addEventListener('resize', checkBurgerMenu, { passive: true });
checkBurgerMenu();

const time = ref({
	sec: '',
	min: '',
	hour: '',
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

	time.value.sec = (now.getSeconds() + '').padStart(2, '0');
	time.value.min = (now.getMinutes() + '').padStart(2, '0');
	time.value.hour = (now.getHours() + '').padStart(2, '0');
	time.value.month = months[now.getMonth()];
	time.value.year = now.getFullYear();
}
updateTime();

let timerId;

onMounted(() => {
	timerId = setInterval(updateTime.bind(this), 1000);
});

onBeforeUnmount(() => {
	clearInterval(timerId);
});
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
			class="mx-2 grow-0 font-serif text-3xl font-bold text-white transition-all duration-1000 ease-in-out select-none hover:rotate-30"
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
					:class="{
						'border-4': button.isCurrentPage(),
						'hover:bg-neutral-500': !button.isCurrentPage(),
					}"
					class="rounded-md border-emerald-700 bg-neutral-300 p-1 whitespace-nowrap text-black transition-all duration-200 ease-linear select-none"
				>
					{{ button.text }}
				</RouterLink>
			</li>
		</ul>
		<div v-if="!isBurgerMenu" class="mr-1 p-1 font-serif whitespace-break-spaces text-white">
			{{ time.hour }}:{{ time.min }}:{{ time.sec }} {{ time.month }} {{ time.year }}
		</div>
	</header>
</template>
