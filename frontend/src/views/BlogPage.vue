<script setup>
import { storeToRefs } from 'pinia';

import Form from '@/components/FormBlock.vue';
import { useBlogStore } from '@/stores/blog';

const blogStore = useBlogStore();

const { forms, blogPage, page, pageList, firstPageShow, lastPageShow } = storeToRefs(blogStore);

const { goToFirstPage, goToPage, goToLastPage } = blogStore;
</script>

<template>
	<main class="flex flex-col items-center justify-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">Блог</h2>
		<div class="flex w-full justify-center space-x-5">
			<div
				v-for="(form, form_ind) in forms"
				:key="form_ind"
				class="flex flex-col items-center space-y-3"
			>
				<Form
					v-if="form.show !== false"
					:id="form.id"
					:fields="form.fields"
					:formdata="form.formdata"
					class="w-fit"
					@submit="form.submit"
				/>
				<div
					v-if="form.show !== false"
					v-show="form.showError"
					class="w-3/4 rounded-sm border-2 p-0.5 text-left"
					:class="{
						'border-red-500/30 bg-red-400': !form.errorHTML.includes('Ok'),
						'border-green-500/30 bg-green-400': form.errorHTML.includes('Ok'),
					}"
					v-html="form.errorHTML"
				></div>
			</div>
		</div>
		<div class="mt-6 flex flex-col items-center space-y-8">
			<div
				v-for="(post, ind) in blogPage"
				:key="ind"
				class="m-2 flex w-4/5 flex-col items-start rounded-lg bg-neutral-300 p-2"
			>
				<div class="flex w-full justify-between overflow-hidden not-sm:text-sm">
					<div class="flex min-w-0 grow flex-col">
						<div class="font-bold">ФИО: {{ post.fio }}</div>
						<div class="font-bold">Тема: {{ post.theme }}</div>
						<div class="max-w-full pt-3 pr-3 wrap-break-word">{{ post.text }}</div>
					</div>
					<img
						v-if="post.imgtype !== null"
						:src="'/api/blog/image?id=' + post.id"
						class="w-1/5 flex-none self-center rounded-lg"
					/>
					<img
						src="../assets/svg/edit.svg"
						alt="edit"
						class="w-4 cursor-pointer self-start pl-1 select-none sm:w-5"
					/>
				</div>
				<div class="flex w-full justify-between pt-2 text-xs">
					<div class="cursor-pointer select-none">Коментарии</div>
					<div>{{ post.time }}</div>
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
