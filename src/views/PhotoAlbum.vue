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
	<main>
		<div v-for="row in fotosRows" class="albumRow">
			<figure v-for="img in row">
				<img :src="img.src" :alt="img.title" />
				<figcaption>{{ img.title }}</figcaption>
			</figure>
		</div>
	</main>
</template>

<style scoped>
main {
	display: flex;
	flex-direction: column;
	justify-content: center;
}

.albumRow {
	display: flex;
	flex-direction: row;
	justify-content: space-evenly;
}

figure img {
	width: 100%;
	max-width: 13em;
}

figcaption {
	text-align: center;
}

.albumRow figure:nth-child(3n + 1) img {
	rotate: 180deg;
}

.albumRow:nth-child(even) figure:nth-child(3n + 2) img {
	rotate: 90deg;
}

.albumRow:nth-child(odd) figure:nth-child(3n + 2) img {
	rotate: -90deg;
}

@media (max-width: 500px) {
	.albumRow {
		flex-wrap: wrap;
	}
}
</style>
