<script setup>
import { ref } from 'vue';

const fotosRows = ref([
	[
		{ title: 'me 1', src: '/src/assets/images/me.jpg' },
		{ title: 'me 2', src: '/src/assets/images/me.jpg' },
		{ title: 'me 3', src: '/src/assets/images/me.jpg' },
		{ title: 'me 4', src: '/src/assets/images/me.jpg' },
	],
	[
		{ title: 'me 5', src: '/src/assets/images/me.jpg' },
		{ title: 'me 6', src: '/src/assets/images/me.jpg' },
		{ title: 'me 7', src: '/src/assets/images/me.jpg' },
		{ title: 'me 8', src: '/src/assets/images/me.jpg' },
	],
	[
		{ title: 'not me 9', src: '/src/assets/images/menu_button.jpg' },
		{ title: 'me 10', src: '/src/assets/images/me.jpg' },
		{ title: 'me 11', src: '/src/assets/images/me.jpg' },
		{ title: 'me 12', src: '/src/assets/images/me.jpg' },
	],
	[
		{ title: 'me 13', src: '/src/assets/images/me.jpg' },
		{ title: 'me 14', src: '/src/assets/images/me.jpg' },
		{ title: 'me 15', src: '/src/assets/images/me.jpg' },
	],
]);
</script>

<template>
	<main class="flex flex-col justify-center">
		<div
			v-for="(row, ind) in fotosRows"
			:key="ind"
			class="flex items-center justify-evenly not-md:flex-col even:**:even:**:first:rotate-180 **:nth-[3n+1]:**:first:rotate-180 nth-[n+3]:**:nth-[2n+2]:**:first:rotate-180"
		>
			<figure class="m-3" v-for="(img, img_ind) in row" :key="img_ind">
				<img class="w-full max-w-52 p-1" :alt="img.title" :src="img.src" />
				<figcaption class="text-center text-sm">{{ img.title }}</figcaption>
			</figure>
		</div>
	</main>
</template>
