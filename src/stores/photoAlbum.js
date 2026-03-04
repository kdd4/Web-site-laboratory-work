import { defineStore } from 'pinia';
import { ref } from 'vue';

export const usePhotoAlbumStore = defineStore('photoAlbum', () => {
	const fotosRows = ref([
		[
			{ title: 'me 1', src: 'me.jpg' },
			{ title: 'me 2', src: 'me.jpg' },
			{ title: 'me 3', src: 'me.jpg' },
			{ title: 'me 4', src: 'me.jpg' },
		],
		[
			{ title: 'me 5', src: 'me.jpg' },
			{ title: 'me 6', src: 'me.jpg' },
			{ title: 'me 7', src: 'me.jpg' },
			{ title: 'me 8', src: 'me.jpg' },
		],
		[
			{ title: 'not me 9', src: 'menu_button.jpg' },
			{ title: 'me 10', src: 'me.jpg' },
			{ title: 'me 11', src: 'me.jpg' },
			{ title: 'me 12', src: 'me.jpg' },
		],
		[
			{ title: 'me 13', src: 'me.jpg' },
			{ title: 'me 14', src: 'me.jpg' },
			{ title: 'me 15', src: 'me.jpg' },
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

	// it is using of vite's dinamic urls
	function updateSrc() {
		fotosRows.value = fotosRows.value.map((arr) =>
			arr.map((img) => {
				img.src = new URL(`../assets/images/${img.src}`, import.meta.url).href;
				return img;
			}),
		);
	}
	updateSrc();

	return { fotosRows, fullscreenImgShow, fullscreenImgSrc, showImg, hideImg };
});
