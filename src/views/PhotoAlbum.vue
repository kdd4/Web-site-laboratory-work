<script setup>
import { usePhotoAlbumStore } from '@/stores/photoAlbum';
import { storeToRefs } from 'pinia';

const photoAlbumStore = usePhotoAlbumStore();
const { hideImg, showImg } = photoAlbumStore;
const { fotosRows, fullscreenImgShow, fullscreenImgSrc } = storeToRefs(photoAlbumStore);
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
					@click="showImg(img.src)"
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
