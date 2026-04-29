<script setup>
import { storeToRefs } from 'pinia';
import { useMathTestStore } from '@/stores/mathTest';
import Form from '@/components/FormBlock.vue';

const mathTestStore = useMathTestStore();

const { formdata, formfields, messages, testResults } = storeToRefs(mathTestStore);
const { checkTest, resetTest } = mathTestStore;
</script>

<template>
	<main class="flex flex-col items-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">Тест по высшей математике</h2>
		<Form
			id="form"
			:fields="formfields"
			:formdata="formdata"
			@submit="checkTest"
			@reset="resetTest"
		/>
		<div
			v-for="(message, ind) in messages"
			:key="ind"
			v-show="message.show"
			:class="{
				'border-green-500/30 bg-green-400': message.good,
				'border-red-500/30 bg-red-400': !message.good,
			}"
			class="rounded-sm border-2 p-0.5 text-center"
		>
			<p>{{ message.text }}</p>
		</div>
		<div class="mt-6 mb-6">
			<div
				v-for="(result, ind) in testResults"
				:key="ind"
				class="mx-1 flex justify-center"
				:class="{ 'text-center font-bold': ind == 0 }"
			>
				<div
					v-for="(elem, elem_ind) in result"
					:key="elem_ind"
					class="flex w-30 min-w-25 items-center justify-center border border-neutral-400 text-center whitespace-normal not-sm:text-sm"
				>
					{{ elem }}
				</div>
			</div>
		</div>
	</main>
</template>
