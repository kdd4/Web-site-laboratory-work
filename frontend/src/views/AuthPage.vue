<script setup>
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/stores/auth';
import Form from '@/components/FormBlock.vue';

const authStore = useAuthStore();

const { form } = storeToRefs(authStore);
</script>

<template>
	<main class="flex h-full flex-col items-center justify-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">
			{{ form.register ? 'Регистрация' : 'Авторизация' }}
		</h2>
		<Form :id="form.id" :fields="form.fields" :formdata="form.formdata" @submit="form.submit" />
		<div
			v-show="form.showError"
			class="rounded-sm border-2 p-0.5 text-left"
			:class="{
				'border-red-500/30 bg-red-400': !form.errorHTML.includes('Ok'),
				'border-green-500/30 bg-green-400': form.errorHTML.includes('Ok'),
			}"
			v-html="form.errorHTML"
		></div>
		<div class="cursor-pointer text-xs select-none" @click="form.register = !form.register">
			{{ form.register ? 'Уже есть аккаунт' : 'Нет аккаунта' }}
		</div>
	</main>
</template>
