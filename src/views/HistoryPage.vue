<script setup>
import { storeToRefs } from 'pinia';
import { useHistoryStore } from '@/stores/history';

const historyStore = useHistoryStore();
const { visitsTable } = storeToRefs(historyStore);
</script>

<template>
	<main>
		<h2 class="mb-10 text-center text-2xl font-bold">История просмотра</h2>
		<div>
			<div
				v-for="(row, row_ind) in visitsTable"
				:key="row_ind"
				class="mx-1 flex justify-center"
				:class="row.style"
			>
				<div
					v-for="(elem, elem_ind) in row.elements"
					:key="elem_ind"
					class="w-30 min-w-25 border border-neutral-400 not-sm:text-sm"
				>
					{{ elem }}
				</div>
			</div>
		</div>
	</main>
</template>
