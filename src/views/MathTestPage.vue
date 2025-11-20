<script setup>
import Form from '@/components/FormBlock.vue';
import { useMathTestStore } from '@/stores/mathTest';
import { storeToRefs } from 'pinia';

const mathTestState = useMathTestStore();

const { formdata, formfields, messages } = storeToRefs(mathTestState);
const { checkTest, resetTest } = mathTestState;
</script>

<template>
	<main class="flex flex-col items-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">Тест по высшей математике</h2>
		<Form :fields="formfields" :formdata="formdata" @submit="checkTest" @reset="resetTest" />
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
	</main>
</template>
