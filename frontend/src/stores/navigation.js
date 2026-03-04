import { defineStore, storeToRefs } from 'pinia';
import { ref } from 'vue';
import { usePagesStore } from '@/stores/pages';
import { useDatesStore } from '@/stores/dates';

export const useNavigationStore = defineStore('navigation', () => {
	const pagesStore = usePagesStore();
	const datesStore = useDatesStore();

	const { pages: navigation_buttons } = storeToRefs(pagesStore);
	const { months } = datesStore;

	const isBurgerMenu = ref(false);
	const isBurgerMenuOpened = ref(false);

	function checkBurgerMenu() {
		isBurgerMenuOpened.value = false;
		isBurgerMenu.value = window.innerWidth <= 650; // px
	}
	checkBurgerMenu();

	window.addEventListener('resize', checkBurgerMenu, { passive: true });

	const time = ref({
		sec: '',
		min: '',
		hour: '',
		month: '',
		year: 0,
	});

	function updateTime() {
		let now = new Date(Date.now());

		time.value.sec = (now.getSeconds() + '').padStart(2, '0');
		time.value.min = (now.getMinutes() + '').padStart(2, '0');
		time.value.hour = (now.getHours() + '').padStart(2, '0');
		time.value.month = months[now.getMonth()];
		time.value.year = now.getFullYear();
	}
	updateTime();

	let timerId;

	function runTime() {
		timerId = setInterval(updateTime.bind(this), 1000);
	}

	function stopTime() {
		clearInterval(timerId);
	}

	return {
		navigation_buttons,
		isBurgerMenu,
		isBurgerMenuOpened,
		time,
		runTime,
		stopTime,
	};
});
