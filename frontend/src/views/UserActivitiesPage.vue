<script setup>
import { storeToRefs } from 'pinia';
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';

import { useAuthStore } from '@/stores/auth';
import { useUserActivitiesStore } from '@/stores/userActivities';

const auth = useAuthStore();
const router = useRouter();
const userActivities = useUserActivitiesStore();

onMounted(() => {
	if (!auth.isAdmin) {
		router.push({ name: 'Main' });
		return;
	}

	userActivities.updateActivities();
});

const { activitiesPage, page, pageList, firstPageShow, lastPageShow } = storeToRefs(userActivities);
const { goToFirstPage, goToPage, goToLastPage } = userActivities;
</script>

<template>
	<main class="flex flex-col items-center justify-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">Активность пользователей</h2>
		<div class="mt-6">
			<div
				v-for="(activity, ind) in activitiesPage"
				:key="ind"
				class="mx-1 flex justify-center"
				:class="{ 'text-center font-bold': ind == 0 }"
			>
				<div
					v-for="(elem, elem_ind) in activity"
					:key="elem_ind"
					class="w-30 min-w-25 border border-neutral-400 whitespace-normal not-sm:text-sm"
				>
					{{ elem }}
				</div>
			</div>
		</div>
		<div class="m-3 flex space-x-2 select-none">
			<div v-if="firstPageShow" @click="goToFirstPage" class="cursor-pointer">Начало</div>
			<div
				v-for="(cur_page, ind) in pageList"
				:key="ind"
				class="cursor-pointer"
				:class="{ 'text-green-500': cur_page == page }"
				@click="goToPage(cur_page)"
			>
				{{ cur_page + 1 }}
			</div>
			<div v-if="lastPageShow" class="cursor-pointer" @click="goToLastPage">Конец</div>
		</div>
	</main>
</template>
