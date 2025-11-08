<script setup>
import { ref, watch, watchEffect } from 'vue';
import Form from '@/components/Form.vue';
import Calendar from '@/components/Calendar.vue';

const showError = ref(false);
const allowSubmit = ref(false);

// form fields
const fio = ref('');
const gender = ref('');
const age = ref('');
const email = ref('');
const number = ref('');

// Error on screen
const fioWrong = ref(false);
const genderWrong = ref(false);
const ageWrong = ref(false);
const emailWrong = ref(false);
const numberWrong = ref(false);

// Error for checking
const IsFIOWrong = ref(true);
const IsGenderWrong = ref(true);
const IsAgeWrong = ref(true);
const IsEmailWrong = ref(true);
const IsNumberWrong = ref(true);

function checkFIO() {
	let fio_re = /^[а-яёА-ЯЁa-zA-Z]+ [а-яёА-ЯЁa-zA-Z]+ [а-яёА-ЯЁa-zA-Z]+$/;

	fioWrong.value = !fio_re.test(fio.value); // Update on screen
	IsFIOWrong.value = fioWrong.value; // Update for checking
}

function checkGender() {
	genderWrong.value = !gender.value; // Update on screen
	IsGenderWrong.value = genderWrong.value; // Update for checking
}

function checkAge() {
	ageWrong.value = !age.value; // Update on screen
	IsAgeWrong.value = ageWrong.value; // Update for checking
}

function checkEmail() {
	let email_re = /^\w+@\w+.\w{2,}$/;

	emailWrong.value = !email_re.test(email.value); // Update on screen
	IsEmailWrong.value = emailWrong.value; // Update for checking
}

function checkNumber() {
	let number_re = /^\+7|3\d{8,10}$/;

	numberWrong.value = !number_re.test(number.value); // Update on screen
	IsNumberWrong.value = numberWrong.value; // Update for checking
}

function updateAllowSubmit() {
	allowSubmit.value = !(
		IsFIOWrong.value ||
		IsGenderWrong.value ||
		IsAgeWrong.value ||
		IsEmailWrong.value ||
		IsNumberWrong.value
	);
}

function updateShowError() {
	showError.value =
		fioWrong.value || genderWrong.value || ageWrong.value || emailWrong.value || numberWrong.value;
}

watch(fio, checkFIO);
watch(gender, checkGender);
watch(age, checkAge);
watch(email, checkEmail);
watch(number, checkNumber);
watchEffect(updateAllowSubmit);
watchEffect(updateShowError);

function formSubmit(event) {
	let form = document.getElementById('form');

	fetch('/api', {
		method: 'POST',
		body: new FormData(form),
	});
}

const formdata = {
	allowSubmit: allowSubmit,
};

const formfields = ref([
	{
		label: 'ФИО',
		type: 'text',
		name: 'FIO',
		placeholder: 'Введите ФИО',
		var_ref: fio,
		wrongValue_ref: fioWrong,
	},
	{
		label: 'Пол',
		type: 'radio',
		name: 'gender',
		options: [
			{ text: 'M', value: 'Male' },
			{ text: 'Ж', value: 'Female' },
		],
		var_ref: gender,
		wrongValue_ref: genderWrong,
	},
	{
		label: 'Возраст',
		type: 'select',
		name: 'age',
		options: [
			{ value: '', text: 'Выберите', disabled: true },
			{ value: 'less16', text: 'До 16', disabled: false },
			{ value: '16-18', text: '16-18', disabled: false },
			{ value: 'more18', text: 'Старше 18', disabled: false },
		],
		var_ref: age,
		wrongValue_ref: ageWrong,
	},
	{
		label: 'E-mail',
		type: 'text',
		name: 'email',
		placeholder: 'Введите E-mail',
		var_ref: email,
		wrongValue_ref: emailWrong,
	},
	{
		label: 'Номер',
		type: 'text',
		name: 'number',
		placeholder: 'Введите номер',
		var_ref: number,
		wrongValue_ref: numberWrong,
	},
]);
</script>

<template>
	<main class="flex flex-col items-center justify-center space-y-3">
		<h2 class="mb-8 text-center text-2xl not-md:text-xl">Контакт</h2>
		<Form id="form" :fields="formfields" :formdata="formdata" @submit="formSubmit" />
		<div
			v-show="showError"
			class="rounded-sm border-2 border-red-500/30 bg-red-400 p-0.5 text-center"
		>
			<p>Неправильно введены данные</p>
		</div>
		<Calendar />
	</main>
</template>
