<script setup>
import { storeToRefs } from 'pinia';
import { useMyInterestsStore } from '@/stores/myInterests';

const myInterestsStore = useMyInterestsStore();
const { blocks } = storeToRefs(myInterestsStore);
</script>

<template>
	<main class="flex">
		<div class="flex grow-3 flex-col items-stretch">
			<h2 class="mb-10 text-center text-2xl font-bold">Мои интересы</h2>
			<div
				v-for="(block, ind) in blocks"
				:key="ind"
				:id="block.id"
				class="mx-3 mb-4 rounded-lg bg-neutral-300 p-5"
				@click="block.opened = !block.opened"
			>
				<h3 v-if="block.head !== undefined" class="mb-3 text-xl font-bold">{{ block.head }}</h3>
				<p v-if="block.text !== undefined" v-show="block.opened" class="mb-2 text-base/relaxed">
					{{ block.text }}
				</p>
				<p v-if="!block.opened" class="text-center select-none">&#9660;</p>
				<ul v-if="block.list !== undefined" v-show="block.opened" class="list-inside list-disc">
					<li v-for="(elem, ind) in block.list" :key="ind" class="text-base/loose">{{ elem }}</li>
				</ul>
			</div>
		</div>
		<div class="max-w-70 min-w-50 grow-2 not-sm:hidden">
			<ul class="sticky top-2 space-y-2.5 rounded-l-lg bg-neutral-300 p-3">
				<li v-for="(list, ind) in blocks" :key="ind">
					<a
						:href="'#' + list.id"
						class="rounded-md border border-neutral-400 bg-neutral-200 p-0.5 whitespace-nowrap"
					>
						{{ list.head }}
					</a>
				</li>
			</ul>
		</div>
	</main>
</template>
