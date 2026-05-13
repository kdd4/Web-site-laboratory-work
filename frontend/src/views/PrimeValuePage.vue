<script setup>
import { useRouter } from 'vue-router';
import Form from '@/components/FormBlock.vue';
import { useAuthStore } from '@/stores/auth';
import { usePrimeValueStore } from '@/stores/primeValue';
import { onMounted } from 'vue';

const prime = usePrimeValueStore();
const auth = useAuthStore();
const router = useRouter();

onMounted(() => {
	if (!auth.isAuth) {
		router.push({ name: 'Main' });
		return;
	}
});
</script>

<template>
	<main class="flex flex-col items-center justify-center space-y-3">
		<h2 class="mb-8 text-center text-2xl font-bold not-md:text-xl">
			Генератор простых чисел (ВЕРОЯТНОСТНЫЙ)
		</h2>
		<Form id="form" :fields="prime.fields" :formdata="prime.formdata" @submit="prime.generate" />
		<div
			v-show="prime.showError"
			class="max-w-8/10 rounded-sm border-2 p-0.5 text-left wrap-break-word"
			:class="{
				'border-red-500/30 bg-red-400': prime.status === 'error',
				'border-gray-500/30 bg-gray-400': prime.status === 'waiting',
				'border-green-500/30 bg-green-400': prime.status === 'good',
			}"
			v-html="prime.errorHTML"
		></div>
	</main>
</template>
