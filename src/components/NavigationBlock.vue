<script setup>
import { storeToRefs } from 'pinia';
import { onMounted, onBeforeUnmount } from 'vue';
import { useNavigationStore } from '@/stores/navigation';

const navigationStore = useNavigationStore();

const { navigation_buttons, isBurgerMenu, isBurgerMenuOpened, time } = storeToRefs(navigationStore);
const { runTime, stopTime } = navigationStore;

onMounted(runTime);
onBeforeUnmount(stopTime);
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
					:to="{ name: button.name }"
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
