import { defineStore } from 'pinia';
import { ref } from 'vue';

export const usePhotoAlbumStore = defineStore('photoAlbum', () => {
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

	return { fotosRows, fullscreenImgShow, fullscreenImgSrc, showImg, hideImg };
});
