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

const fullscreenImgShow = ref(false);
const fullscreenImgSrc = ref('');

function showImg(src) {
	fullscreenImgSrc.value = src;
	fullscreenImgShow.value = true;
}

function hideImg() {
	fullscreenImgShow.value = false;
}
</script>

<template>
	<main class="flex flex-col justify-center">
		<div
			v-for="(row, ind) in fotosRows"
			:key="ind"
			class="flex items-center justify-evenly not-md:flex-col even:**:even:**:first:rotate-180 **:nth-[3n+1]:**:first:rotate-180 nth-[n+3]:**:nth-[2n+2]:**:first:rotate-180"
		>
			<figure class="m-3" v-for="(img, img_ind) in row" :key="img_ind">
				<img
					class="w-full max-w-52 p-1"
					:alt="img.title"
					:src="img.src"
					@click="(e) => showImg(img.src)"
				/>
				<figcaption class="text-center text-sm">{{ img.title }}</figcaption>
			</figure>
		</div>
	</main>
	<div
		v-if="fullscreenImgShow"
		class="fixed top-0 left-0 h-dvh w-dvw bg-black/70 p-10"
		@click="hideImg"
	>
		<div class="flex h-full w-full justify-center">
			<img :src="fullscreenImgSrc" class="max-h-full max-w-full select-none" />
		</div>
	</div>
</template>
