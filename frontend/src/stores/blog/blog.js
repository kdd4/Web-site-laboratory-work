import { defineStore } from 'pinia';
import { computed, ref } from 'vue';

export const useBlogStore = defineStore('blog', () => {
	async function getBlogPosts() {
		let response = await fetch('/api/blog/posts', {
			headers: {
				Accept: 'application/json',
			},
		});

		let list = await response.json();

		if (!list.length) {
			blogPosts.value = [];
			return;
		}

		blogPosts.value = list;

		blogPosts.value.sort((a, b) => new Date(b.time) - new Date(a.time));
	}

	getBlogPosts();

	const blogPosts = ref([]);

	const pageSize = ref(5);
	const page = ref(0);

	const pageCount = computed(() => Math.ceil(blogPosts.value.length / pageSize.value));
	const blogPage = computed(() =>
		blogPosts.value.slice(page.value * pageSize.value, (page.value + 1) * pageSize.value),
	);

	const pageListSize = ref(5);
	const pageList = computed(function () {
		let lowLimit = Math.max(page.value - Math.floor(pageListSize.value / 2), 0);
		let highLimit = Math.max(pageCount.value - pageListSize.value, 0);
		let length = Math.min(pageCount.value, pageListSize.value);

		return Array.from({ length }, (_, k) => Math.min(lowLimit, highLimit) + k);
	});

	const firstPageShow = computed(() => !pageList.value.includes(0) && pageList.value.length != 0);
	const lastPageShow = computed(
		() => !pageList.value.includes(pageCount.value - 1) && pageList.value.length != 0,
	);

	function goToFirstPage() {
		page.value = 0;
	}

	function goToPage(newPage) {
		page.value = newPage;
	}

	function goToLastPage() {
		page.value = pageCount.value - 1;
	}

	return {
		blogPage,
		page,
		pageList,
		firstPageShow,
		lastPageShow,
		goToFirstPage,
		goToPage,
		goToLastPage,
		getBlogPosts,
	};
});
