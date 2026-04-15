<script setup>
import { storeToRefs } from 'pinia';

import Form from '@/components/FormBlock.vue';
import { useGuestBookStore } from '@/stores/guestBook';

const guestBookStore = useGuestBookStore();

const { fields, showError, formdata, errorHTML, feedbackList } = storeToRefs(guestBookStore);
const { formSubmit } = guestBookStore;
</script>

<template>
	<main class="flex flex-col items-center justify-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">Гостевая книга</h2>
		<Form id="form" :fields="fields" :formdata="formdata" @submit="formSubmit" />
		<div
			v-show="showError"
			class="rounded-sm border-2  p-0.5 text-left"
            :class="{
                'border-red-500/30 bg-red-400': !errorHTML.includes('Ok'),
                'border-green-500/30 bg-green-400': errorHTML.includes('Ok'),
            }"
			v-html="errorHTML"
		></div>
        <div class="mt-6">
			<div
				v-for="(feedback, feedback_ind) in feedbackList"
				:key="feedback_ind"
				class="mx-1 flex justify-center"
				:class="{'font-bold text-center': feedback_ind == 0}"
			>
				<div
					v-for="(elem, elem_ind) in feedback"
					:key="elem_ind"
					class="nth-3:w-60 w-30 min-w-25 border border-neutral-400 not-sm:text-sm"
				>
					{{ elem }}
				</div>
			</div>
		</div>
	</main>
</template>