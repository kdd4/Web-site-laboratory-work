<script setup>
import Form from '@/components/FormBlock.vue';
import { useAuthStore } from '@/stores/auth';
import { useBlogStore } from '@/stores/blog/blog';
import { useBlogCommentsStore } from '@/stores/blog/blogComments';
import { useBlogEditStore } from '@/stores/blog/blogEdit';
import { useBlogFormsStore } from '@/stores/blog/blogForms';

const auth = useAuthStore();
const blog = useBlogStore();
const blogForms = useBlogFormsStore();
const blogEdit = useBlogEditStore();
const blogComments = useBlogCommentsStore();
</script>

<template>
	<main class="flex flex-col items-center justify-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">Блог</h2>
		<div class="flex w-full justify-center space-x-5">
			<div
				v-for="(form, form_ind) in blogForms.forms"
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
					v-html="form.errorHTML"
					class="w-3/4 rounded-sm border-2 p-0.5 text-left"
					:class="{
						'border-red-500/30 bg-red-400': !form.errorHTML.includes('Ok'),
						'border-green-500/30 bg-green-400': form.errorHTML.includes('Ok'),
					}"
				></div>
			</div>
		</div>
		<div class="mt-6 flex flex-col items-center space-y-8">
			<div v-for="(post, ind) in blog.blogPage" :key="ind" class="m-2 w-4/5">
				<!--post-->
				<div class="flex w-full flex-col items-start rounded-lg bg-neutral-300 p-2">
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
							v-if="auth.isAdmin"
							src="../assets/svg/edit.svg"
							alt="edit"
							class="w-4 cursor-pointer self-start pl-1 select-none sm:w-5"
							@click="blogEdit.open(post.id, post.text)"
						/>
					</div>
					<div class="flex w-full justify-between pt-2 text-xs">
						<div
							v-show="auth.isAuth"
							class="cursor-pointer select-none"
							@click="blogComments.open(post.id)"
						>
							Коментарии
						</div>
						<div>{{ post.time }}</div>
					</div>
				</div>

				<!--comments-->
				<div v-if="post.id === blogComments.id" class="mt-1 space-y-1 text-sm">
					<form
						id="commentForm"
						class="flex space-x-2 rounded-lg bg-neutral-300 p-0.5"
						@submit.prevent="blogComments.post"
					>
						<input type="text" name="text" class="w-full rounded-lg border bg-white px-0.5" />
						<input type="submit" class="rounded-lg border bg-white px-0.5" />
					</form>
					<div
						v-for="(comment, com_ind) in blogComments.comments"
						:key="com_ind"
						class="rounded-lg bg-neutral-300 p-0.5"
					>
						({{ comment.time }}) {{ comment.fio }}: {{ comment.text }}
					</div>
					<div v-if="!blogComments.comments.length" class="text-center">Нет комментариев</div>
				</div>
			</div>
		</div>
		<div class="m-3 flex space-x-2 select-none">
			<div v-if="blog.firstPageShow" @click="goToFirstPage" class="cursor-pointer">Начало</div>
			<div
				v-for="(cur_page, ind) in pageList"
				:key="ind"
				:class="{ 'text-green-500': cur_page == page }"
				class="cursor-pointer"
				@click="goToPage(cur_page)"
			>
				{{ cur_page + 1 }}
			</div>
			<div v-if="blog.lastPageShow" class="cursor-pointer" @click="goToLastPage">Конец</div>
		</div>
	</main>

	<!--edit-->
	<div
		v-if="blogEdit.show"
		class="fixed bottom-0 left-0 flex h-full w-full items-center justify-center bg-black/30"
		@click.self="blogEdit.close()"
	>
		<div
			v-for="(form, form_ind) in blogEdit.forms"
			:key="form_ind"
			class="flex h-fit w-fit flex-col items-center space-y-3"
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
				class="w-3/4 rounded-sm border-2 border-red-500/30 bg-red-400 p-0.5 text-left"
				v-html="form.errorHTML"
			></div>
		</div>
	</div>
</template>
