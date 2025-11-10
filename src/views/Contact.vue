<script setup>
import { ref, toRefs, watch, watchEffect } from 'vue';
import Form from '@/components/Form.vue';
import { useContactStore } from '@/stores/contact';
import { storeToRefs } from 'pinia';

const showError = ref(false);
const allowSubmit = ref(false);

const contactStore = useContactStore();

const { fields } = storeToRefs(contactStore);

const { fio, gender, age, email, number, birthday } = toRefs(contactStore.fields);

function checkFIO() {
	let fio_re = /^[а-яёА-ЯЁa-zA-Z]+ [а-яёА-ЯЁa-zA-Z]+ [а-яёА-ЯЁa-zA-Z]+$/;

	fio.value.hasError = !fio_re.test(fio.value.fieldValue);
	fio.value.isCorrect = !fio.value.hasError;
}

function checkGender() {
	gender.value.hasError = !gender.value.fieldValue;
	gender.value.isCorrect = !gender.value.hasError;
}

function checkAge() {
	age.value.hasError = !age.value.fieldValue;
	age.value.isCorrect = !age.value.hasError;
}

function checkEmail() {
	console.log('checkEmail');
	let email_re = /^\w+@\w+.\w{2,}$/;

	email.value.hasError = !email_re.test(email.value.fieldValue);
	email.value.isCorrect = !email.value.hasError;
}

function checkNumber() {
	console.log('checkNumber');
	let number_re = /^\+7|3\d{8,10}$/;

	number.value.hasError = !number_re.test(number.value.fieldValue);
	number.value.isCorrect = !number.value.hasError;
}

function checkBirthday() {
	birthday.value.hasError = birthday.value.fieldValue.getTime() > Date.now();
	birthday.value.isCorrect = !birthday.value.hasError;
}

function updateAllowSubmit() {
	allowSubmit.value =
		fio.value.isCorrect &&
		gender.value.isCorrect &&
		age.value.isCorrect &&
		email.value.isCorrect &&
		number.value.isCorrect &&
		birthday.value.isCorrect;
}

function updateShowError() {
	showError.value =
		fio.value.hasError ||
		gender.value.hasError ||
		age.value.hasError ||
		email.value.hasError ||
		number.value.hasError ||
		birthday.value.hasError;
}

watch(() => fio.value.fieldValue, checkFIO);
watch(() => gender.value.fieldValue, checkGender);
watch(() => age.value.fieldValue, checkAge);
watch(() => email.value.fieldValue, checkEmail);
watch(() => number.value.fieldValue, checkNumber);
watch(() => birthday.value.fieldValue, checkBirthday);
watchEffect(updateAllowSubmit);
watchEffect(updateShowError);

function formSubmit() {
	let form = document.getElementById('form');

	fetch('/api', {
		method: 'POST',
		body: new FormData(form),
	});
}

const formdata = {
	allowSubmit: allowSubmit,
};
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
