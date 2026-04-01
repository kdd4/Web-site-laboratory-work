<script setup>
import { storeToRefs } from 'pinia';
import { useContactStore } from '@/stores/contact';
import Form from '@/components/FormBlock.vue';

const contactStore = useContactStore();

const { fields, showError, formdata, errorHTML } = storeToRefs(contactStore);
const { formSubmit } = contactStore;
</script>

<template>
	<main class="flex flex-col items-center justify-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">Контакт</h2>
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
	</main>
</template>
