import { defineStore } from 'pinia';
import { ref } from 'vue';

export const usePhotoAlbumStore = defineStore('photoAlbum', () => {
	const fotosRows = ref([]);

	fetch('/api/photo-album/album', {
        headers: {
                'Accept': 'application/json'
            },
    })
		.then(response => response.json())
		.then(response => fotosRows.value = response)
		.then(updateSrc);

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
	};

	return { fotosRows, fullscreenImgShow, fullscreenImgSrc, showImg, hideImg };
});
