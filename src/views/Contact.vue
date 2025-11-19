<script setup>
import Form from '@/components/Form.vue';
import { useContactStore } from '@/stores/contact';
import { storeToRefs } from 'pinia';

const contactStore = useContactStore();

const { fields, showError, formdata } = storeToRefs(contactStore);
const { formSubmit } = contactStore;
</script>

<template>
	<main class="flex flex-col items-center justify-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">Контакт</h2>
		<Form id="form" :fields="fields" :formdata="formdata" @submit="formSubmit" />
		<div
			v-show="showError"
			class="rounded-sm border-2 border-red-500/30 bg-red-400 p-0.5 text-center"
		>
			<p>Неправильно введены данные</p>
		</div>
	</main>
</template>
