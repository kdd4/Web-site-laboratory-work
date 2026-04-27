<script setup>
import { storeToRefs } from 'pinia';

import Form from '@/components/FormBlock.vue';
import { useGuestBookStore } from '@/stores/guestBook';

const guestBookStore = useGuestBookStore();

const { forms, feedbackList } = storeToRefs(guestBookStore);
</script>

<template>
	<main class="flex flex-col items-center justify-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">Гостевая книга</h2>
		<div class="flex w-full justify-center space-x-5">
			<div
				v-for="(form, form_ind) in forms"
				:key="form_ind"
				class="flex flex-col items-center space-y-3"
			>
				<Form
					:id="form.id"
					:fields="form.fields"
					:formdata="form.formdata"
					class="w-fit"
					@submit="form.submit"
				/>
				<div
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
		<a
			href="/api/guest-book/file"
			download="messages.inc"
			class="rounded-sm border border-neutral-400 bg-neutral-400/30"
		>
			Скачать книгу
		</a>
		<div class="mt-6">
			<div
				v-for="(feedback, feedback_ind) in feedbackList"
				:key="feedback_ind"
				class="mx-1 flex justify-center"
				:class="{ 'text-center font-bold': feedback_ind == 0 }"
			>
				<div
					v-for="(elem, elem_ind) in feedback"
					:key="elem_ind"
					class="w-30 min-w-25 border border-neutral-400 whitespace-normal not-sm:text-sm nth-3:w-60"
				>
					{{ elem }}
				</div>
			</div>
		</div>
	</main>
</template>
